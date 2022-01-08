<?php
@session_start();

include __DIR__ . "/../../../addons/extensions/bootstrap.php";
include __DIR__ . "/../../../addons/extensions/db.php";

if(!IsDealer()) GoHomePage(); //Wyrzuca na strone główną, jeśli nie jest dealerem

GoHomePageIfNotVerified(); //Wyrzuca na strone główną, jeśli dealer nie jest zweryfikowany

$db = GetMysqliConnection();

//Sprawdź id i czy ogłoszenie jest zalogowanego użytkownika
$advertId = $_GET["id"] ?? -1;

//Pobierz Id ogłoszenia
$advertIdFromDB = $db->query("SELECT Id FROM advertisement  as Id WHERE Id=$advertId AND CreateBy=".GetLoggedUserId())
or PrintDbError("Błąd edycji ogłoszenia -> " . $db->error, $db);

//Jesli nie ma takiego rekordu, to przekieruj na stronę główną
if($advertIdFromDB->num_rows  == 0) header("Location: ".BASE_URL."/");;

if (isset($_POST['submit'])) {
    //Renderuj widok, jeśli walidacja niepoprawna
    if (!validatePost()) goto RENDER_VIEW;

    extract($_POST);


    $db->begin_transaction();

    $advertId=$advertIdFromDB->fetch_object()->Id;

    //Aktualizuj dane podstawowe
    $db->query("UPDATE advertisement SET Title='$title', Description='$description', CreateBy= " . GetLoggedUserId() . ", Price='$price' 
                    WHERE Id=$advertId")
                    or PrintDbError("Błąd edycji ogłoszenia -> " . $db->error, $db);

    //Wpisz dane dodatkowe
    $db->query("UPDATE advertisement_detail SET  carBrandId=$car_brand, model='$model', engine_size=$engine_size, 
                                                        engine_power=$engine_power, distance=$distance
                        WHERE advertisementId=$advertId")
    or PrintDbError("Błąd edycji danych dodatkowych ogłoszenia -> " . $db->error, $db);

    $db->commit();

    AddSuccessMessage("Poprawnie edytowano ogłoszenie");
    header("Location: ".BASE_URL."/dealer/advertisement");
}

function validatePost(): bool
{
    global $validateErrors;

    $requiredFields = [
        "title" => "string",
        "price" => "number",
        "description" => "string",
        "car_brand" => "number",
        "model" => "string",
        "engine_size" => "number",
        "engine_power" => "number",
        "distance" => "number",
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

function RenderCarBrandDropDown(string $selectName = "car_brand", int $selectedBrandId): void
{
    $db = GetMysqliConnection();
    $brands = $db->query("SELECT * FROM carbrand");

    $dropdownHtml = "<select name='$selectName' class='form-control'>";
    while (($row = $brands->fetch_object()) != null) {
        $selected = ($selectedBrandId == $row->Id) ? "selected" : "";
        $dropdownHtml .= "<option value='$row->Id' $selected>$row->Name</option>";
    }
    $dropdownHtml .= "</select>";

    echo $dropdownHtml;
}


RENDER_VIEW:
global $valuesForInputs;

//Pobierz dane o ogłoszeniu, z bazy
$mainAdvertData = $db->query("SELECt * FROM advertisement WHERE Id=$advertId");
$mainAdvertData = $mainAdvertData->fetch_object();

$valuesForInputs["title"] = $mainAdvertData->Title;
$valuesForInputs["price"] = $mainAdvertData->Price;
$valuesForInputs["description"] = $mainAdvertData->Description;

//Dane szczegółowe
$additionalAdvertData = $db->query("SELECt * FROM advertisement_detail WHERE advertisementId=$advertId");
$additionalAdvertData = $additionalAdvertData->fetch_object();

$valuesForInputs["model"] = $additionalAdvertData->model;
$valuesForInputs["car_brand"] = $additionalAdvertData->carBrandId;
$valuesForInputs["engine_size"] = $additionalAdvertData->engine_size;
$valuesForInputs["engine_power"] = $additionalAdvertData->engine_power;
$valuesForInputs["distance"] = $additionalAdvertData->distance;

include "view.php";