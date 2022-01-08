<?php
@session_start();


include_once __DIR__ . "/../../addons/extensions/bootstrap.php";
include_once __DIR__ . "/../../addons/extensions/db.php";

//SPrawdź, czy nie zostął już werfyikowany
if(sAlreadyVerified()){
    AddSuccessMessage("Zostałeś juz zweryfikowany");
    $_SESSION["verified"] = 1;
    GoHomePage();
}

//Obsługa formularza
if(isset($_POST["submit"])){
    if(!validatePost()) goto VIEW; //Wyświetl widok, jeśli nie zwalidował danych poprawnie



    $db=GetMysqliConnection();

    $additionalDataAlreadyExists = $db->query("SELECT COUNT(Id) FROM additional_dealer_data WHERE userId = ".$_SESSION["user_id"])
                or PrintDbError("Błąd podczas sprawdzania wpisu o danych kontaktowych dealera -> " . $db->error, $db);

    extract($_POST);
    //Aktualizuj albo dodaj nowe
    if($additionalDataAlreadyExists->fetch_row()[0] > 0){
        $db->query("UPDATE additional_dealer_data SET  `company_name`='$company_name',`nip`='$nip',`regon`='$regon',
                                    `postal`='$postal',`street`='$street',`city`='$city', phone=$phone WHERE  userId=".$_SESSION['user_id'])
        or PrintDbError("Błąd podczas aktualizacji danych kontaktowych dealera -> " . $db->error, $db);
    }else{
        $db->query("INSERT INTO `additional_dealer_data`(`userId`, `company_name`, `nip`, `regon`, `postal`, `street`, `city`, phone) 
                    VALUES (".$_SESSION['user_id'].",'$company_name','$nip','$regon','$postal','$street','$city', '$phone')")
        or PrintDbError("Błąd podczas wprowadzania danych kontaktowych dealera -> " . $db->error, $db);
    }

    AddSuccessMessage("Dane zaktualizowane prawidłowo. Oczekuj na weryfikacje administracji");
    header("Location: ".BASE_URL);
    die();
}

/**
 * Waliduje dane, wysłane w formularzu
 * @return bool
 */
function validatePost(): bool
{
    global $validateErrors;

    $requiredFields = [
        "company_name" => "string",
        "nip" => "number",
        "regon" => "number",
        "postal" => "string",
        "city" => "string",
        "street" => "string",
        "phone" => "number"
    ];

    foreach ($requiredFields as $field_name => $fieldType) {
        if (!isset($_POST[$field_name])) {
            $validateErrors[$field_name] = "To pole jest wymagane";
        } else {
            if (empty($_POST[$field_name])) {
                $validateErrors[$field_name] = "To pole jest wymagane";
            } else {
                if ($fieldType == "number" && !is_numeric($_POST[$field_name])) {
                    $validateErrors[$field_name] = "Wartośc musi być liczbą";
                }
            }
        }
    }

    return ($validateErrors == null);
}


/**
 * Sprawdza, czy w międzyczasie, komis nie został juz werfyikowany
 */
function sAlreadyVerified(): bool
{
    $db=GetMysqliConnection();
    $is_verified = $db->query("SELECt Enabled FROm user WHERE Id=".$_SESSION["user_id"])->fetch_row()[0] == 1;

    return $is_verified;
}
VIEW:
Render(__DIR__ . "/view.php");
