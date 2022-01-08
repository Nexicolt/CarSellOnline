<?php

include_once __DIR__ . "/../../addons/extensions/bootstrap.php";
include_once __DIR__ . "/../../addons/extensions/db.php";

$advertId = $_GET["advertId"] ?? -1;

GoHomePageIfNotAdmin(); //Wyrzuć, jeśli nie jest adminem

$db=GetMysqliConnection();

 //Sprawdź czy ogłoszenie, o podanym Id istnieje
$advertExists = $db->query("SELECT Id FROM advertisement WHERE Id=".$advertId)
or PrintDbError("Błąd pobierania ogłoszenia, przy próbie jego usunięcia (id: $advertId) -> " . $db->error, $db);

if($advertExists->num_rows == 0){
    AddErrorMessage("brak ogłoszenia, o podanym identyfikatorze");
    header("Location: ".BASE_URL."/dashboard/advertisements");
    die();
}

//Usuwanie ogłoszenia
$db->begin_transaction();

$db->query("DELETE FROM advertisement_detail WHERE advertisementId=$advertId ")
or PrintDbError("Błąd usuwania ogłoszenia (dane auta) -> " . $db->error, $db);

$db->query("DELETE FROM advertisement WHERE Id=$advertId ")
or PrintDbError("Błąd usuwania ogłoszenia -> " . $db->error, $db);
AddSuccessMessage("Pomyślnie usunięto ogłoszenie");

$db->commit();
AddSuccessMessage("Pomyslnie usunięto ogłoszenie");
header("Location: ".BASE_URL."/dashboard/advertisements");
die();
