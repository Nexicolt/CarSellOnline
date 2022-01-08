<?php
include_once "../addons/extensions/db.php";
include_once "../addons/extensions/bootstrap.php";

global $error;
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
    $username = $_POST['login'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'] ?? "";
    $email = $_POST['email'];
    $isComis = isset($_POST['IsComis']);

    $db = GetMysqliConnection();

    if ($password != $password2) {
        $error = "Hasła nie są takie same";
    }

    $query = "SELECT * FROM User WHERE Login='$username' OR Email='$email'";
    $result = $db->query($query) or PrintDbError($db->error);

    if (mysqli_num_rows($result) > 0) {
        $error = "Użytkownik o takim loginie lub emailu już istnieje";
    }

    if (empty($error)) {
        mysqli_begin_transaction($db);
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $isCOm = (($isComis == 'on') ? 'C' : 'U');
        $IsEnabled = ($isComis == 'on') ? '0' : '1';
        $query = "INSERT INTO User (Login, Password, Email, Type, Enabled) VALUES ('$username', '$passHash', '$email', '$isCOm', $IsEnabled)";

        //jeśli jest komisem, do dopisz rekord to tabeli z zapytaniami o weryfikację
        if($isCOm){
            $result = $db->query($query) or PrintDbError($db->error, $db);
            $insertedUserID = $db->query("SELECT LAST_INSERT_ID() as Id") or PrintDbError($db->error, $db);;
            $insertedUserID = $insertedUserID->fetch_object()->Id;
            $db->query("INSERT INTO comisrequest(UserId) VALUES ($insertedUserID)") or PrintDbError($db->error, $db);
        }
        mysqli_commit($db);
        AddSuccessMessage("Rejestracja poprawna. Możesz się zalogować");
        header("Location: ".BASE_URL);
        exit();
    }
}

include "view.php";


