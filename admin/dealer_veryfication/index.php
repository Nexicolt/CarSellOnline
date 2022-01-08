<?php
@session_start();


include_once __DIR__ . "/../../addons/extensions/bootstrap.php";
include_once __DIR__ . "/../../addons/extensions/db.php";

$db = GetMysqliConnection();

GoHomePageIfNotAdmin(); //Wyrzuca na strone główną, jeśli nie ma uprawnień admina

function PrintSingleRequest(object $rowFromDb){
    echo
    "
        <div class='single_request'>
        <span> $rowFromDb->company_name</span>
        <a href='./admin/dealer_veryfication/verify?requestId=$rowFromDb->Id'><button class='btn btn-secondary'>Weryfikuj</button></a>
        </div>
    ";
}

function PrintRequests(){
    $db = GetMysqliConnection();

    $requests = $db->query("SELECT c.Id, u.Login, ad.company_name FROM additional_dealer_data ad
                                    JOIN comisrequest c on ad.userId = c.UserId
                                    JOIN user u on u.Id = ad.userId");

    if($requests->num_rows == 0){
        die( " <i><span style='display: block; text-align: center'> Brak zapytań... </span></i>");

    }

    echo "<div id='requests'>";
    while(($row = $requests->fetch_object()) != null){
        PrintSingleRequest($row);
    }
    echo "</div>";


}

Render(__DIR__ . "/view.php");
