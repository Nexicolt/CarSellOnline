<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zaloguj się do systemu</title>
    <base href="<?php echo BASE_URL ?>">
    <link rel="stylesheet" href="./addons/css/reset.css">
    <link rel="stylesheet" href="./addons/css/home/login.css">
    <link rel="stylesheet" href="./addons/css/bootstrap.min.css">
    <script src="./addons/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav mr-auto">
        <div id="navCenter" style="grid-column: 2">
            <li class="nav-item">
                <a class="nav-link" href="./">Strona główna</a>
            </li>
        </div>

        <div id="MenuActionButtons">
                <li class="nav-item">
                    <a class="nav-link">
                        <button class="btn btn-sm btn-outline-secondary" type="button">Logowanie</button>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./register">
                        <button class="btn btn-sm btn-outline-secondary" type="button">Rejestracja</button>
                    </a>
                </li>
        </div>
    </ul>
</nav>

<form method="post">
    <span id="fomrHeader">
        LOGOWANIE
    </span>
    <div class="row">
        <label for="login">Login:</label>
        <input class="form-control" type="text" name="login" id="login" required autocomplete="off">
    </div>
    <div class="row">
        <label class="col-form-label" for="password">Hasło:</label>
        <input class="form-control" type="password" name="password" id="password" required>
    </div>
    <div class="row">
        <button id="submitButton" class="btn btn-secondary">Zaloguj się</button>
    </div>

    <div id="errorMessage" class="link-danger text-center ">
        <?php
        global $error;
        if(isset($error) && !empty($error)){
            echo $error;
        }
        ?>
    </div>
</form>
</body>
</html>