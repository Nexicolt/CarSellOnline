<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="<?php echo BASE_URL ?>">
    <link rel="stylesheet" href="./addons/css/dashboard/adverts.css">
    <link rel="stylesheet" href="./addons/css/reset.css">
    <link rel="stylesheet" href="./addons/css/bootstrap.min.css">
    <script src="./addons/js/bootstrap.bundle.min.js"></script>
    <title>Ogłoszenia</title>
</head>
<body>
<?php PrintNavBar(); ?>

<!--Kryteria selekcji-->
<div id="search_criteria">
    <form action="" method="get">
        <details>
            <summary>Kryteria selekcji</summary>
            <div class="row">
                <div>
                    <label for="search_brand">Marka:</label>
                    <?php RenderCarBrandDropDownToSearchCriteria()?>
                </div>
                <div>
                    <label for="search_model">Model:</label>
                    <input name="search_model" type="text" class="form-control" <?php InputValue("search_model"); ?>>
                </div>
            </div>
            <div class="row">
                <div>
                    <label for="search_engine_size">Pojemność (od):</label>
                    <input name="search_engine_size" type="number" class="form-control" step="0.01" <?php InputValue("search_engine_size"); ?>>
                </div>
                <div>
                    <label for="search_engine_power">Moc (KM) (od):</label>
                    <input name="search_engine_power" type="number" class="form-control" step="0.01" <?php InputValue("search_engine_power"); ?>>
                </div>
            </div>
            <div class="row">
                <div>
                    <label for="search_price">Cena (do):</label>
                    <input name="search_price" type="number" class="form-control" step="0.01" <?php InputValue("search_price"); ?>>
                </div>
                <div>
                    <input name="search_criteria_submit" type="submit" class="btn btn-secondary" value="Szukaj">
                    <a href="./dashboard/advertisements"> <input name="search_criteria_clear" type="button" class="btn btn-danger" value="Wyczyść"></a>
                </div>
            </div>
        </details>
    </form>
</div>

<?php PrintPaginationAndAdverts(); ?>
</body>
</html>