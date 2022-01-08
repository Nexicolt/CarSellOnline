<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="<?php echo BASE_URL ?>">
    <link rel="stylesheet" href="./addons/css/dealer/dashboard.css">
    <link rel="stylesheet" href="./addons/css/reset.css">
    <link rel="stylesheet" href="./addons/css/bootstrap.min.css">
    <script src="./addons/js/bootstrap.bundle.min.js"></script>
    <title>Moje ogłoszenia</title>
</head>
<body>
<?php PrintNavBar();  ?>
<div class="btn-group" id="topButtons">
    <a href="./dealer/advertisement/new"> <button class="btn btn-secondary">Dodaj ogłoszenie</button> </a>
<!--    <button class="btn btn-secondary">Usuń zaznaczone</button>-->
</div>
<?php PrintPaginationAndAdverts(true); ?>

</body>
</html>