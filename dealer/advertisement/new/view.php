<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="<?php echo BASE_URL ?>">
    <link rel="stylesheet" href="./addons/css/dealer/new_advertisement.css">
    <link rel="stylesheet" href="./addons/css/reset.css">
    <link rel="stylesheet" href="./addons/css/bootstrap.min.css">
    <script src="./addons/js/bootstrap.bundle.min.js"></script>
    <title>Nowe ogłoszenie</title>
</head>
<body>
<?php PrintNavBar(); ?>



<form action=""  enctype="multipart/form-data" method="post" id="NewAdvertisementForm">
    <div class="row" style="margin-bottom: 20px;">
        <div id="formHeader">Nowe ogłoszenie</div>
    </div>
    <?php MainValidateError(); ?>
    <br>
    <a class="form-header" data-bs-toggle="collapse" href="#basicData" role="button" aria-expanded="false"
       aria-controls="basicData">
        Dane podstawowe
    </a>
    <div class="collapse show" id="basicData">
        <div class="row">
            <label for="title">Tytuł</label>
            <input type="text" class="form-control" name="title" required <?php InputValue("title"); ?>>
            <?php ValidateError("title"); ?>
        </div>
        <div class="row">
            <label for="price">Cena</label>
            <input type="number" class="form-control" name="price" required <?php InputValue("price"); ?>>
            <?php ValidateError("price"); ?>
        </div>
        <div class="row">
            <label for="description">Opis</label>
            <textarea class="form-control" name="description" required > <?php TextAreaValue("description"); ?> </textarea>
            <?php ValidateError("description"); ?>
        </div>
        <div class="row" id="ImagesRow">
            <div>
                <span>Zdjęcia</span>
                <button class="btn small btn-secondary" onclick="SelectFilesFromPc()">Dodaj</button>
            </div>

            <input type="file" hidden id="imagesUploadInput" accept=".jpg, .jpeg, .png" multiple name="images[]">

            <div id="thumbnails">
            </div>
        </div>
    </div>
    <a class="form-header" data-bs-toggle="collapse" href="#carData" role="button" aria-expanded="false" aria-controls="carData">
        Dane samochodu
    </a>
    <div id="carData"  class="collapse show">
        <div class="row">
            <label for="car_brand">Marka</label>
            <?php RenderCarBrandDropDown("car_brand"); ?>
            <?php ValidateError("car_brand"); ?>
        </div>
        <div class="row">
            <label for="model">Model</label>
            <input type="text" class="form-control" name="model" required <?php InputValue("model"); ?>>
            <?php ValidateError("Model"); ?>
        </div>

        <div class="row">
            <label for="engine_size">Pojemność</label>
            <input type="number" class="form-control" name="engine_size"  step="0.01" required <?php InputValue("engine_size"); ?>>
            <?php ValidateError("engine_size"); ?>
        </div>
        <div class="row">
            <label for="engine_power">Moc (KM)</label>
            <input type="number" class="form-control" name="engine_power" required <?php InputValue("engine_power"); ?>>
            <?php ValidateError("engine_power"); ?>
        </div>
        <div class="row">
            <label for="distance">Przebieg</label>
            <input type="text" class="form-control" name="distance" required <?php InputValue("distance"); ?>>
            <?php ValidateError("distance"); ?>
        </div>
    </div>
    <input type="submit" class="btn btn-success" style="margin-top: 25px;" value="Publikuj" name="submit">
</form>

</body>

<script>
    function SelectFilesFromPc() {
        event.preventDefault();
        document.querySelector("#imagesUploadInput").click();
    }

    let imagesInput = document.querySelector("#imagesUploadInput");
    imagesInput.addEventListener("change", handleFiles, false);

    function handleFiles() {
        let preview = document.querySelector("#thumbnails");

        preview.innerHTML = "";

        let files = imagesInput.files;
        console.log(files);
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!file.type.startsWith('image/')) {
                continue
            }

            const htmlObject = document.createElement("div");
            htmlObject.classList.add("ImagesRowSquareThumbnail");

            const img = document.createElement("img");
            img.classList.add("obj");
            img.file = file;
            htmlObject.appendChild(img);

            // const removeButton = document.createElement("div")
            // removeButton.classList.add("removeThumbnailButton");
            // removeButton.innerHTML = "x";
            // removeButton.setAttribute("ImgIndex", "" + i);
            // htmlObject.appendChild(removeButton);

            preview.appendChild(htmlObject);
            const reader = new FileReader();
            reader.onload = (function (aImg) {
                return function (e) {
                    aImg.src = e.target.result;
                };
            })(img);
            reader.readAsDataURL(file);
        }
    }


</script>
</html>