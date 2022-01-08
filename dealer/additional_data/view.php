<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="<?php echo BASE_URL ?>">
    <link rel="stylesheet" href="./addons/css/dealer/additional_data.css">
    <link rel="stylesheet" href="./addons/css/reset.css">
    <link rel="stylesheet" href="./addons/css/bootstrap.min.css">
    <script src="./addons/js/bootstrap.bundle.min.js"></script>
    <title>Dane komisu</title>
</head>
<body>
<?php PrintNavBar();  ?>

<form action="" method="post">
    <span id="fomrHeader">
        DANE KOMISU
    </span>
    <div class="row">
        <label for="company_name">Nazwa firmy:</label>
        <input class="form-control" type="text" name="company_name" id="company_name" required autocomplete="off" <?php InputValue("company_name"); ?>>
        <?php ValidateError("company_name"); ?>
    </div>
    <div class="row">
        <label for="nip">NIP:</label>
        <input class="form-control" type="number" name="nip" id="nip" required autocomplete="off" <?php InputValue("nip"); ?>>
        <?php ValidateError("nip"); ?>
    </div>
    <div class="row">
        <label for="regon">REGON:</label>
        <input class="form-control" type="number" name="regon" id="regon" required autocomplete="off" <?php InputValue("regon"); ?>>
        <?php ValidateError("regon"); ?>
    </div>
    <div class="row">
        <label for="postal">Kod pocztowy:</label>
        <input class="form-control" type="text" name="postal" id="postal" required autocomplete="off" <?php InputValue("postal"); ?>>
        <?php ValidateError("postal"); ?>
    </div>
    <div class="row">
        <label for="city">Miasto:</label>
        <input class="form-control" type="text" name="city" id="city" required autocomplete="off" <?php InputValue("city"); ?>>
        <?php ValidateError("city"); ?>
    </div>
    <div class="row">
        <label for="street">Ulica:</label>
        <input class="form-control" type="text" name="street" id="street" required autocomplete="off" <?php InputValue("street"); ?>>
        <?php ValidateError("street"); ?>
    </div>
    <div class="row">
        <label for="phone">Telefon:</label>
        <input class="form-control" type="text" name="phone" id="phone" required autocomplete="off" <?php InputValue("phone"); ?>>
        <?php ValidateError("phone"); ?>
    </div>

    <div class="btn-group">
        <input type="submit" name="submit" class="btn btn-secondary" value="Wyślij" >
    </div>
    <div class="row">
            <span>
                <br>
                UWAGA!
                <br>
            Jeśli wysyłasz dane, nie po raz pierwszy. To poprzednio zapisane dane adresowe, zostaną nadpisane
            </span>
    </div>
</form>

</body>
</html>