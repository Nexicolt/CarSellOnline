<?php

@session_start();

include __DIR__ . "/../../addons/extensions/bootstrap.php";
include __DIR__ . "/../../addons/extensions/advertsHelper.php";

//Obsługa kryteriów selekcji
if(isset($_GET["search_criteria_submit"])){
    //wyciągnij wszystkie niepuste zmienne, zaczynające sie od "search_"
    global $searchCritieria;
    $searchCritieria = [];
    foreach ($_GET as $key=>$item) {
        if(str_starts_with($key, "search_") && !empty($item) && $key != "search_criteria_submit"){
           $searchCritieria[substr($key, 7)] = $item;
        }
    }
}

/**
 * Lista wyboru marki samochodu
 */
function RenderCarBrandDropDownToSearchCriteria(string $selectName = "search_brand"): void
{
    $db = GetMysqliConnection();
    $brands = $db->query("SELECT * FROM carbrand");

    $selectedBrand = $_GET["search_brand"] ?? "";

    $dropdownHtml = "<select name='$selectName' class='form-control'>";
    while (($row = $brands->fetch_object()) != null) {
        $selected = ($selectedBrand == $row->Name) ? "selected" : "";
        $dropdownHtml .= "<option value='$row->Name' $selected>$row->Name</option>";
    }
    $dropdownHtml .= "<option value='' selected></option>";
    $dropdownHtml .= "</select>";

    echo $dropdownHtml;
}

Render("view.php");