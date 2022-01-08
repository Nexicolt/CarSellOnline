<?php
@session_start();


include_once __DIR__ . "/../../addons/extensions/bootstrap.php";
include_once __DIR__ . "/../../addons/extensions/advertsHelper.php";
include_once __DIR__ . "/../../addons/extensions/db.php";
include_once __DIR__ . "/../../addons/extensions/dto/CarAdvertDto.php";

$db = GetMysqliConnection();

if(!IsDealer()) GoHomePage(); //Wyrzuca na strone główną, jeśli nie jest dealerem

GoHomePageIfNotVerified(); //Wyrzuca na strone główną, jeśli dealer nie jest zweryfikowany

//Usuwanie ogłoszenia
if(isset($_POST["delete_submit"])){
    $advertId = $_POST["advertId"] ?? -1;
    //Sprawdź, czy ogłoszenie jest autorstwa zalogowanego użytkownika, bo każdy może podmienić ID w inpucie i kasować cudze ogłoszenia
    $results = $db->query("SELECT Id FROM advertisement WHERE Id=$advertId AND CreateBy =".GetLoggedUserId())
            or PrintDbError("Błąd usuwania ogłoszenia -> " . $db->error, $db);

    if($results->num_rows > 0){

        $db->begin_transaction();

        $db->query("DELETE FROM advertisement_detail WHERE advertisementId=$advertId ")
        or PrintDbError("Błąd usuwania ogłoszenia -> " . $db->error, $db);

        $db->query("DELETE FROM advertisement WHERE Id=$advertId ")
        or PrintDbError("Błąd usuwania ogłoszenia -> " . $db->error, $db);
        AddSuccessMessage("Pomyślnie usunięto ogłoszenie");

        $db->commit();
    }
}




Render(__DIR__ . "/view.php");
