<?php

@session_start();
include_once "../addons/extensions/db.php";
include_once "../addons/extensions/bootstrap.php";

global $error;
if(isset($_POST['login']) && isset($_POST['password'])){
    $username = $_POST['login'];
    $password = $_POST['password'];

    $db = GetMysqliConnection();

    $query = "SELECT * FROM User WHERE Login='$username' ";
    $result = $db->query($query) or PrintDbError($db->error);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_object($result);

        if(password_verify($password, $row->Password )) {
            @session_start();
            $_SESSION['user'] = $row->Login;
            $_SESSION['is_logged'] = true;
            $_SESSION['account_type'] = $row->Type;
            $_SESSION['user_id'] = $row->Id;
            $_SESSION['verified'] = $row->Enabled; //Ustawiane na 0, tylko jeśli przy rejestracji wskazał, że jest komisem -> musi zostac zweryfikowany
            header("Location: ../index.php");
            exit;
        }
    }
    $error = "Niepoprawne dane logowania";
}

if(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true){
    header("Location: ../index.php");
    exit;
}
include "view.php";

?>


