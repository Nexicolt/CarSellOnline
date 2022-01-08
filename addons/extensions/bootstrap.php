<?php

$ini = parse_ini_file(__DIR__ . "/../../environment.ini");
define("BASE_URL", $ini["BASE_URL"]);

@session_start();

function AddSuccessMessage(string $message){
    $messageDto = ["message" => $message, "type" => "success"];
    if($_SESSION["flash_messages"] == null || !is_array($_SESSION["flash_messages"])){
        $_SESSION["flash_messages"] = [$messageDto];
    }else
        array_push($_SESSION["flash_messages"], $messageDto);
}

function AddErrorMessage(string $message){
    $messageDto = ["message" => $message, "type" => "error"];
    if($_SESSION["flash_messages"] == null || !is_array($_SESSION["flash_messages"])){
        $_SESSION["flash_messages"] = [$messageDto];
    }else
        array_push($_SESSION["flash_messages"], $messageDto);
}

function PrintFlashMessages(){
    if(isset($_SESSION["flash_messages"]) && is_array($_SESSION["flash_messages"]) ){
        foreach($_SESSION["flash_messages"] as $message){
            echo '<div class="flash-message '.$message["type"].'">
                    <span> </span>
                    '.$message["message"].'
                    <button onclick="this.parentElement.style.display = \'none\'">X</button>
                    </div>';
        }
        unset($_SESSION["flash_messages"]);
    }
}
function Render(string $filePath){
    PrintFlashMessages();
    include $filePath;
}

function GetLoggedUserId(){
    return $_SESSION['user_id']  ?? - 1;
}

function IsDealerVerified(){
    return (isset($_SESSION['verified']) && $_SESSION['verified'] != 0 && $_SESSION['account_type'] == "C");
}

function IsDealer(){
    return (isset($_SESSION['account_type']) && strtolower($_SESSION['account_type']) == "c");
}

function IsAdmin(){
    return (isset($_SESSION['user'])  && $_SESSION['account_type'] == "A");
}

function GoHomePageIfNotVerified(){
    if(!IsDealerVerified()){
        AddErrorMessage("Nie zostałeś zwefyfikowany. Uzupełnij dane kontaktowe (jeśli tego nie zrobiłeś) i oczekuj na weryfikację administracji");
        header("Location: ".BASE_URL);
        die();
    }
}

function GoHomePage(){
    header("Location: ".BASE_URL);
    die();
}

function GoAdminDealerVeryficationPage(){
    header("Location: ".BASE_URL."/admin/dealer_veryfication");
    die();
}

function GoHomePageIfNotAdmin(){
    if(!IsAdmin()){
        AddErrorMessage("Brak uprawnień");
        GoHomePage();
    }
}

function InputValue($postName){
    if(isset($_POST[$postName])){
        echo "value='$_POST[$postName]'";
    }elseif(isset($_GET[$postName])){
        echo "value='$_GET[$postName]'";
    }
    else{
        global $valuesForInputs;
        if(is_array($valuesForInputs) && isset($valuesForInputs[$postName])){
            echo "value='$valuesForInputs[$postName]'";
        }
    }
}
function TextAreaValue($postName){
    if(isset($_POST[$postName])){
        echo "$_POST[$postName]";
    }else{
        global $valuesForInputs;
        if(is_array($valuesForInputs) && isset($valuesForInputs[$postName])){
            echo "$valuesForInputs[$postName]";
        }
    }
}

function ValidateError(string $fieldName){
    global $validateErrors;
    if($validateErrors != null && isset($validateErrors[$fieldName]) && !empty($validateErrors[$fieldName])){
        echo "<span class='text-danger'>$validateErrors[$fieldName]</span>";
    }
}

function MainValidateError(){
    global $validateErrors;
    if($validateErrors != null && count($validateErrors) > 0){
        echo "<span class='text-danger text-center d-block w-100 fw-bold'>Błąd walidacji danych. Sprawdź pola</span>";
    }
}

function PrintNavBar(): void
{
    echo '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav mr-auto">
        <div id="navCenter" style="grid-column: 2">
            <li class="nav-item">
                <a class="nav-link" href="./dashboard/advertisements">Ogłoszenia</a>
            </li>
      ';
    if (isset($_SESSION['user']) && $_SESSION['account_type'] == "C")
        echo '
                <li class="nav-item">
                    <a class="nav-link" href="./dealer/advertisement">Moje ogłoszenia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./dealer/opinion">Opinie o mnie</a>
                </li>
                ';

    else if (isset($_SESSION['user']) && $_SESSION['account_type'] == "A")
        echo '
             
                <li class="nav-item">
                    <a class="nav-link" href="./admin/dealer_veryfication">Weryfikacja komisów </a>
                </li>
    ';
    echo '</div>';

    if (isset($_SESSION['user'])) {
        echo
            '
            <div id="AboutAccount">
    <div>
        <img src="addons/assets/icons/user.png" alt="">
           <span> ' . $_SESSION["user"] . '</span>
    </div>
    <div class="account-actions">
    ';
        if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == "C" && !$_SESSION['verified'])
            echo '
                        <a class="dropdown-item" href="./dealer/additional_data">Dane kontatkowe</a>
                        ';
        echo '
        <a class="dropdown-item" href="./logout">Wyloguj</a>
    </div>
</div>
             
    ';
    }
    else
        echo '
            <div id="MenuActionButtons">
                <li class="nav-item">
                    <a class="nav-link" href="login">
                        <button class="btn btn-sm btn-outline-secondary" type="button">Logowanie</button>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register">
                     <button class="btn btn-sm btn-outline-secondary" type="button">Rejestracja</button>
                    </a>
                </li>
                        </div>
         ';
    echo '

    </ul>
</nav>
';
}