<?php
@session_start();


include_once __DIR__ . "/../../../addons/extensions/bootstrap.php";
include_once __DIR__ . "/../../../addons/extensions/db.php";

$db = GetMysqliConnection();

GoHomePageIfNotAdmin(); //Wyrzuca na strone główną, jeśli nie ma uprawnień admina



//Obsłuż id requestu
$requestId = $_GET["requestId"] ?? -1;
$requestDto = $db->query("SELECT * FROm vDealerRequest WHERE ComisRequest = $requestId");


if($requestDto->num_rows == 0){
    AddErrorMessage("Brak zapytania weryfikacyjnego, o podanym identyfikatorze");
    GoAdminDealerVeryficationPage();
}

//Dane requsta
global $requestObject;
$requestObject=$requestDto->fetch_object();

//Admin zaakcpetował komis
if(isset($_POST["accept"])){
    $db->begin_transaction();

    $db-> query("DELETE FROM comisrequest WHERE Id=$requestId")
    or PrintDbError("Błąd podczas akceptacji komisu (usuwanie requestu) -> " . $db->error, $db);

    $db-> query("UPDATE user SET Enabled=1 WHERE Id=".$requestObject->userId)
    or PrintDbError("Błąd podczas akceptacji komisu (enabled dla użytkownika) -> " . $db->error, $db);

    $db->commit();

    AddSuccessMessage("Komis został zweryfikowany");
    GoAdminDealerVeryficationPage();
}

if(isset($_POST["dismiss"])){
    $db->begin_transaction();

    $db-> query("DELETE FROM comisrequest WHERE Id=$requestId")
    or PrintDbError("Błąd podczas odmowy weryfikacji komisu (usuwanie requestu) -> " . $db->error, $db);

    $db->query("DELETE FROM additional_dealer_data WHERE userId=".$requestObject->userId)
    or PrintDbError("Błąd podczas odmowy weryfikacji komisu  (usuwanie danych kontaktowych) -> " . $db->error, $db);

    $db-> query("DELETE FROM user WHERE Id=".$requestObject->userId)
    or PrintDbError("Błąd podczas odmowy weryfikacji komisu  (usuwanie użytkownika) -> " . $db->error, $db);

    $db->commit();

    AddSuccessMessage("Komis został usunięty");
    GoAdminDealerVeryficationPage();
}


Render(__DIR__ . "/view.php");
