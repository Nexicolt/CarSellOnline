<?php

@session_start();

include __DIR__ . "/../../../addons/extensions/bootstrap.php";
include __DIR__ . "/../../../addons/extensions/advertsHelper.php";

global $advertDto; global $sellerDto;

$advertId = $_GET["advertId"] ?? -1;

$db = GetMysqliConnection();

$row = $db->query("SELECT * FROm vadvertisement WHERE advertisementId=".$advertId)
        or PrintDbError("Błąd pobierania danych ogłoszenia -> " . $db->error, $db);

if($row->num_rows == 0){
    AddErrorMessage("Brak podanego ogłoszenia");
    GoHomePage();
}

$advertDto=$row->fetch_object();

$row2 = $db->query("SELECT * FROm vseller WHERE Id=".$advertDto->Id)
or PrintDbError("Błąd pobierania danych sprzedawcy -> " . $db->error, $db);

if($row2->num_rows == 0){
    AddErrorMessage("Błąd wyświetlania ogłoszenia");
    GoHomePage();
}

$sellerDto=$row2->fetch_object();

if(!isset($_SESSION["user_id"])){
    $sellerDto->email = "Widoczne dla zalogowanych";
    $sellerDto->phone = "Widoczne dla zalogowanych";
}

/**
 * Wyświetla galerie zdjęc samochodu
 */
function PrintImages(){
    global $advertDto;
    $files = scandir(__DIR__."/../../../car_images/".$advertDto->Id);
    $files = array_diff($files, [".", ".."]);

    if(count($files) > 0){
        echo
        '
         <div class="gg-container" id="gallery">
        <div class="gg-box">
        ';
        foreach($files as $image)
            echo '<img src="./car_images/'.$advertDto->Id.'/'.$image.'">';

         echo '   
        </div>
    </div>
        ';
    }
}


if(isset($_POST["submit_opinion"])){

    if(!isset($_SESSION["account_type"]) || strtolower($_SESSION["account_type"]) != "u" ){
        AddErrorMessage("Nie możesz dodawać opinii");
        goto VIEW_BY_HEADER;
    }

    extract($_POST);

    if(empty($feeling)){
        AddErrorMessage("Nie wskazano odczucia, co do sprzedawcy");
        goto VIEW_BY_HEADER;
    }

    if(!isset($opinion) || strlen($opinion) < 30){
        AddErrorMessage("Opinia musi zawierać conajmniej 30 znaków");
        goto VIEW_BY_HEADER;
    }


    //Wszystko ok, można dodac opinię
    $db = GetMysqliConnection();

    $authorOfAdvert = $db->query("SELECt CreateBy FROm advertisement where Id = $advertId")->fetch_row()[0]
    or PrintDbError("Błąd pobierania danych sprzedawcy, przy wystawianiu opini -> " . $db->error, $db);

    //Sprawdź, czy ten użytkownik, nie dodał już temu dealerowi opini
    $query = "SELECT COUNT(Id) FROm opinion WHERE opinionAuthor=".GetLoggedUserId()." AND dealerId=".$authorOfAdvert;
    $alreadyOpinied = $db->query($query)
    or PrintDbError("Błąd dodawania opini (sprawdzam, czy użytkownik już nie ocenił sprzedwcy)-> " . $db->error, $db);

    $alreadyOpinied = $alreadyOpinied->fetch_row()[0];

    if($alreadyOpinied){
        AddErrorMessage("Już opiniowałeś tego sprzedawcę");
        goto VIEW_BY_HEADER;
    }

    //usuń znaki typu "/" i "/r" ...
    $opinion = $db->real_escape_string($opinion);
    $feeling = $db->real_escape_string($feeling);

    $db->query("insert into opinion (dealerId, opinionAuthor, feeling, opinion) VALUES ($authorOfAdvert, ".GetLoggedUserId().",  '$feeling','$opinion')")
    or PrintDbError("Błąd dodawania opini -> " . $db->error, $db);

    AddSuccessMessage("Dziękujemy za wystawienie opinii");
   goto VIEW_BY_HEADER;

}

VIEW:
Render("view.php");

VIEW_BY_HEADER:
header("Location: ".BASE_URL."/dashboard/advertisements/show/?advertId=".$advertId);
