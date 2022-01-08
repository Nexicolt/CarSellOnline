<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="<?php echo BASE_URL ?>">
    <link rel="stylesheet" href="./addons/css/admin/dealer_veryfication.css">
    <link rel="stylesheet" href="./addons/css/reset.css">
    <link rel="stylesheet" href="./addons/css/bootstrap.min.css">
    <script src="./addons/js/bootstrap.bundle.min.js"></script>
    <title>Moje ogłoszenia</title>
</head>
<body>
<?php PrintNavBar(); global $requestObject; ?>

<form action="" method="post" id="request_details">

    <h1>Weryfikacja komisu</h1>
    <div class="row">
        <label>Login:</label>
        <input type="text" value="<?php echo $requestObject->Login?>" disabled>
    </div>
    <div class="row">
        <label>Email:</label>
        <input type="text" value="<?php echo $requestObject->Email?>" disabled>
    </div>
    <div class="row">
        <label>Nazwa firmy:</label>
        <input type="text" value="<?php echo $requestObject->company_name?>" disabled>
    </div>
    <div class="row">
        <label>NIP:</label>
        <input type="text" value="<?php echo $requestObject->nip?>" disabled>
    </div>
    <div class="row">
        <label>REGON:</label>
        <input type="text" value="<?php echo $requestObject->regon?>" disabled>
    </div>
    <div class="row">
        <label>Miasto:</label>
        <input type="text" value="<?php echo $requestObject->city?>" disabled>
    </div>
    <div class="row">
        <label>Kod pocztowy:</label>
        <input type="text" value="<?php echo $requestObject->postal?>" disabled>
    </div>
    <div class="row">
        <label>Ulica:</label>
        <input type="text" value="<?php echo $requestObject->street?>" disabled>
    </div>
    <div class="row">
        <label>Telefon:</label>
        <input type="text" value="<?php echo $requestObject->phone?>" disabled>
    </div>
    <div id="buttons">
        <input type="submit" value="Akceptuj"  name="accept" class="btn btn-success">
        <input type="submit" value="Odrzuć" name="dismiss" class="btn btn-danger">
        <a href="./admin/dealer_veryfication"><input type="button" value="Anuluj" class="btn btn-info"></a>
    </div>
</form>


</body>
</html>