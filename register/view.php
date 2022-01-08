<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="<?php echo BASE_URL ?>">
    <link rel="stylesheet" href="./addons/css/reset.css">
    <link rel="stylesheet" href="./addons/css/home/register.css">
    <link rel="stylesheet" href="./addons/css/bootstrap.min.css">
    <script src="./addons/js/bootstrap.bundle.min.js"></script>
    <title>Zarejestruj się</title>
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
                <a class="nav-link" href="./login">
                    <button class="btn btn-sm btn-outline-secondary" type="button">Logowanie</button>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link">
                    <button class="btn btn-sm btn-outline-secondary" type="button">Rejestracja</button>
                </a>
            </li>
        </div>
    </ul>
</nav>
<form method="post">
    <span id="fomrHeader">REJESTRACJA</span>
    <div class="row">
        <label for="login">Login:</label>
        <input class="form-control" type="text" name="login" id="login" required value="<?php echo $_POST["login"] ?? "" ?>">
    </div>
    <div class="row">
        <label for="password">Hasło:</label>
        <input class="form-control"  type="password" name="password" id="password" required>
    </div>
    <div class="row">
        <label for="password2">Powtórz hasło:</label>
        <input class="form-control"  type="password" name="password2" id="password2" required>
    </div>
    <div class="row">
        <label for="email">Email:</label>
        <input class="form-control"  type="email" name="email" id="email" required value="<?php echo $_POST["email"] ?? "" ?>">
    </div>
    <div class="row">
        <label for="IsComis">Jestem komisem:</label>
        <input class="form-check"  type="checkbox" name="IsComis" id="IsComis" <?php  echo (isset($_POST["IsComis"]) ? "checked=\"checked\"" : "")  ?>">
    </div>
    <div class="row">
        <button class="btn btn-secondary btn-lg btn-block mt-3">Rejestracja</button>
    </div>

    <div id="errorMessage" class="link-danger text-center ">
        <?php
        global $error;
        if (isset($error) && !empty($error)) {
            echo $error;
        }
        ?>
    </div>
</form>
</body>
</html>
