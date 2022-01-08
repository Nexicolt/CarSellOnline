<?php
@session_start();

include __DIR__ . "/../../../addons/extensions/bootstrap.php";
include __DIR__ . "/../../../addons/extensions/db.php";

if(!IsDealer()) GoHomePage(); //Wyrzuca na strone główną, jeśli nie jest dealerem

GoHomePageIfNotVerified(); //Wyrzuca na strone główną, jeśli dealer nie jest zweryfikowany

if (isset($_POST['submit'])) {
    //Renderuj widok, jeśli walidacja niepoprawna
    if (!validatePost()) goto RENDER_VIEW;

    extract($_POST);

    $db = GetMysqliConnection();
    $db->begin_transaction();

    //Wpisz dane podstawowe
    $db->query("INSERT INTO advertisement (Title, Description, CreateBy, Price)  VALUES ('$title', '$description', " . GetLoggedUserId() . ", $price)")
    or PrintDbError("Błąd dodawania ogłoszenia -> " . $db->error, $db);

    $insertedId = $db->query("SELECT LAST_INSERT_ID() as Id") or PrintDbError($db->error, $db);
    $insertedId = $insertedId->fetch_object()->Id;

    //Wpisz dane dodatkowe
    $db->query("INSERT INTO advertisement_detail (advertisementId, carBrandId, model, engine_size, engine_power, distance)  
                        VALUES ($insertedId, $car_brand, '$model', $engine_size, $engine_power, $distance)")
    or PrintDbError("Błąd dodawania danych dodatkowych ogłoszenia -> " . $db->error, $db);


    uploadImagesFromPost($insertedId);
    $db->commit();

    AddSuccessMessage("Poprawnie opublikowano ogłoszenie");
    header("Location: ".BASE_URL."/dealer/advertisement");
    exit();
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

function uploadImagesFromPost(int $advertId)
{

    $path = __DIR__ . "/../../../car_images/" . $advertId;
    mkdir($path);
    foreach ($_FILES as $file) {
        for($key=0; $key < count($file["name"]); $key++) {

            $fileType = $file["type"][$key];

            if ($fileType != "image/jpeg" && $fileType != "image/png") continue; //Omijaj pliki, które nie sa zdjęciami

            UPLOAD_FILE:
            $newFileName = randomString(10);
            $fileExtension = explode('.', $file["name"][$key]);
            $fileExtension = "." . $fileExtension[count($fileExtension) - 1];

            if (file_exists($path . $newFileName . $fileExtension)) goto UPLOAD_FILE;
            move_uploaded_file($file['tmp_name'][$key], $path . "/" . $newFileName . $fileExtension);
        }
    }
}

function RenderCarBrandDropDown($selectName = "car_brand"): void
{
    $db = GetMysqliConnection();
    $brands = $db->query("SELECT * FROM carbrand");

    $dropdownHtml = "<select name='$selectName' class='form-control'>";
    while (($row = $brands->fetch_object()) != null) {
        $dropdownHtml .= "<option value='$row->Id'>$row->Name</option>";
    }
    $dropdownHtml .= "</select>";

    echo $dropdownHtml;
}

function randomString(int $length): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

RENDER_VIEW:
include "view.php";