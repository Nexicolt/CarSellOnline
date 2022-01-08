<?php
include "logs.php";
include_once "bootstrap.php";

error_reporting(E_ERROR | E_PARSE);

/**
 * Zwraca uchwyt do połączenia z baza danych
 */
function GetMysqliConnection() : mysqli
{
    $ini = parse_ini_file(__DIR__ . "/../../environment.ini");

    $db_host = $ini["Host"];
    $db_user = $ini["Username"];
    $db_pass = $ini["Password"];
    $db_name = $ini["Database"];
    $db_port = $ini["Port"];
    $db_charset = "utf8";

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
    if ($mysqli->connect_error) {
        PrintDbError($mysqli->connect_error);
    }
    $mysqli->set_charset($db_charset);
    return $mysqli;
}

function PrintDbError(string $errorMsg, mysqli $DbHangler = null) : void{
    if($DbHangler != null) $DbHangler->rollback();
    echo "Wystapił błąd wewnętrzny, związany z bazą danych";
    WriteLog($errorMsg);
    header("Location: ".BASE_URL."/error_pages/500");
    die();
}

