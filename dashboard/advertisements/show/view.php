<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="<?php echo BASE_URL ?>">
    <link rel="stylesheet" href="./addons/css/dashboard/advert_show.css">
    <link rel="stylesheet" href="./addons/css/reset.css">
    <link rel="stylesheet" href="./addons/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./addons/css/grid-gallery.min.css"/>
    <script src="./addons/js/bootstrap.bundle.min.js"></script>
    <title>Ogłoszenia</title>
</head>
<body>
<?php PrintNavBar();
global $advertDto;
global $sellerDto; ?>


<div id="mainContainer">
    <span> </span>
    <div id="advertDetails">

        <div class="row" style="margin: 20px 0 10px 0; ">
            <div id="formHeader">Szczególy ogłoszenia</div>
        </div>
        <?php MainValidateError(); ?>
        <br>
        <a class="form-header" aria-expanded="false"
           aria-controls="basicData">
            Dane podstawowe
        </a>
        <div class="collapse show" id="basicData">
            <div class="row">
                <label for="title">Tytuł</label>
                <input type="text" class="form-control" name="title" disabled value="<?php echo $advertDto->Title ?>"/>
            </div>
            <div class="row">
                <label for="price">Cena</label>
                <input type="number" class="form-control" name="price" disabled
                       value="<?php echo $advertDto->Price ?>"/>
            </div>
            <div class="row">
                <label for="description">Opis</label>
                <textarea class="form-control" name="description"
                          disabled> <?php echo $advertDto->Description ?> </textarea>
            </div>
            <div class="row" id="ImagesRow">

            </div>
        </div>
        <?php PrintImages(); ?>

        <a class="form-header" aria-expanded="false" aria-controls="carData">
            Dane samochodu
        </a>
        <div id="carData" class="collapse show">
            <div class="row">
                <label for="car_brand">Marka</label>
                <input type="text" class="form-control" name="model" disabled value="<?php echo $advertDto->brand ?>"/>
            </div>
            <div class="row">
                <label for="model">Model</label>
                <input type="text" class="form-control" name="model" disabled value="<?php echo $advertDto->model ?>"/>
            </div>

            <div class="row">
                <label for="engine_size">Pojemność</label>
                <input type="number" class="form-control" name="engine_size" disabled
                       value="<?php echo $advertDto->engine_size ?>"/>
            </div>
            <div class="row">
                <label for="engine_power">Moc (KM)</label>
                <input type="number" class="form-control" name="engine_power" disabled
                       value="<?php echo $advertDto->engine_power ?>"/>
            </div>
            <div class="row">
                <label for="distance">Przebieg</label>
                <input type="text" class="form-control" name="distance" disabled
                       value="<?php echo $advertDto->distance ?>"/>
            </div>
        </div>

    </div>

    <div id="rightColumn">
        <?php if (isset($_SESSION["user_id"]) && strtolower($_SESSION["account_type"]) == "a") { ?>
            <a href="./admin/delete_advert?advertId=<?php  echo $advertDto->Id?>"><button id="sendOpinionButton" class="btn btn-danger">Usuń ogłoszenie</button></a>
        <?php } ?>


        <div id="aboutSeller">
            <h1>Sprzedający</h1>
            <span id="CompanyName"><?php echo $sellerDto->company_name ?></span>
            <?php if (isset($_SESSION["user_id"]) && strtolower($_SESSION["account_type"]) == "u") { ?>
                <button id="sendOpinionButton" class="btn btn-info" onclick="ShowOpinionForm()">Wystaw opinię</button>
            <?php } ?>
            <details id="contactData">
                <summary>Dane kontaktowe</summary>
                <span>Email: <?php echo $sellerDto->email ?></span>
                <span>Numer telefonu: <?php echo $sellerDto->phone ?></span>
            </details>
        </div>
    </div>

</div>

<div id="modal"></div>
<div id="opinionForm">
    <form action="" method="post">
        <h1>Opinia o sprzedającym</h1>
        <div id="feelings">
            <img src="./addons./assets/icons/feeling_ok.png" alt="" id="feeling_ok" onclick="clickedOk()">
            <img src="./addons./assets/icons/feeling_bad.png" alt="" id="feeling_bad" onclick="clickedBad()">
        </div>
        <textarea name="opinion" id="" cols="30" rows="10"></textarea>
        <input type="hidden" name="feeling" id="feeling_input">
        <div id="OpinionButtons">
            <input type="submit" class="btn btn-success" value="Opublikuj" name="submit_opinion">
            <input type="button" class="btn btn-danger" value="Anuluj" onclick="DismissOpinion()"/>
        </div>
    </form>
</div>
<script type="text/javascript" src="./addons/js/grid-gallery.min.js"></script>
</body>
<script>

    let iconFeelingOk = document.getElementById("feeling_ok");
    let iconFeelingBad = document.getElementById("feeling_bad");
    let feelingInput = document.getElementById("feeling_input");

    function clickedOk() {
        iconFeelingOk.classList.add("clicked");
        iconFeelingBad.classList.remove("clicked");
        feelingInput.value = "OK";
    }

    function clickedBad() {
        iconFeelingOk.classList.remove("clicked");
        iconFeelingBad.classList.add("clicked");
        feelingInput.value = "BAD";
    }

    clickedOk();

    let modal = document.getElementById("modal");
    let opinionForm = document.getElementById("opinionForm");

    function DismissOpinion() {
        modal.style.display = "none"
        opinionForm.style.display = "none"
    }

    function ShowOpinionForm() {
        modal.style.display = "block"
        opinionForm.style.display = "block"
    }

    gridGallery({
        selector: "#gallery",
        darkMode: true,
        layout: "horizontal",
        gapLength: 1,
        rowHeight: 180,
        columnWidth: 120
    });
</script>
</html>