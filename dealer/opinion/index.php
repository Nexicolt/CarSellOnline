<?php
@session_start();


include_once __DIR__ . "/../../addons/extensions/bootstrap.php";
include_once __DIR__ . "/../../addons/extensions/db.php";

$db = GetMysqliConnection();

if(!IsDealer()) GoHomePage(); //Wyrzuca na strone główną, jeśli nie jest dealerem


GoHomePageIfNotVerified(); //Wyrzuca na strone główną, jeśli dealer nie jest zweryfikowany

function PrintSingleOpinion(object $rowFromDb){
    echo
    "
        <div class='single_opinion'>
        <span class='author'>Autor: $rowFromDb->CreateBy</span>
        <textarea class='opinion' disabled>$rowFromDb->opinion</textarea>
        </div>
    ";
}

function PrintOpinions(){
    $db = GetMysqliConnection();

    $opinions = $db->query("SELECT * FROM vopinion WHERE dealerId=".GetLoggedUserId());

    if($opinions->num_rows == 0){
        die( " <i><span style='display: block; text-align: center'> Brak opinii... </span></i>");

    }

    echo "<div id='opinions'>";
    echo "<div id='header'>Opinie o mnie</div>";
    while(($row = $opinions->fetch_object()) != null){
        PrintSingleOpinion($row);
    }
    echo "</div>";


}

Render(__DIR__ . "/view.php");
