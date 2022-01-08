<?php

include_once __DIR__ . "/db.php";
include_once __DIR__ . "/dto/CarAdvertDto.php";

/**
 * Pobiera ogłoszenia z bazy
 */
function GetAdverts(bool $forDealer = false): void
{
    $db = GetMysqliConnection();

    //kryteria selekcji (przesyłąne GET'em, a z niego jest budowane tablica poniżej)
    global $searchCritieria;
    global $whereString;
    $whereString = "";
    $firstElement = true;
    if (is_array($searchCritieria) || !empty($searchCritieria)) {
        foreach ($searchCritieria as $index => $item) {
            $likeOrHigher = (is_numeric($item) && $index != "model") ? " >= " : " LIKE "; //Dla liczb, sotsuje znacznik większości
            $likeOrHigher = ($likeOrHigher == " >= " && $index == "price") ? " <= " : $likeOrHigher; //Dla ceny obowiązuje "do", dla reszty "od"
            $whereString .= ($firstElement) ? ($forDealer) ? "WHERE CreateBy=" . GetLoggedUserId() . " AND $index $likeOrHigher '$item' "
                : "WHERE $index $likeOrHigher '$item'" : " AND $index $likeOrHigher '$item' ";
            $firstElement = false;
        }
    }

    //Jeśli nie ma kryteriów selekcji, to pamiętaj o obsłużeniu "czy dealer czy nie"
    if ($whereString == "") {
        if ($forDealer)
            $whereString = "WHERE CreateBy=" . GetLoggedUserId();
        else
            $whereString = "";
    }

    $rows = $db->query("SELECT Id, Title, Description, Price, CreateDate, brand, model, distance FROm vadvertisement ".$whereString)
    or PrintDbError("Błąd wyświetlania ogłoszeń dealera -> " . $db->error, $db);

//Lista z ogłoszeniami
    global $listWithAdverts;
    $listWithAdverts = [];

//Uzupełnia listę, o ogłoszenia
    while (($row = $rows->fetch_object()) != null) {
        $advertDto = new CarAdvertDto();
        $advertDto->Title = $row->Title;
        $advertDto->Description = $row->Description;
        $advertDto->Price = $row->Price;
        $advertDto->Id = $row->Id;
        $advertDto->PostDate = $row->CreateDate;
        $advertDto->Model = $row->brand  ." ". $row->model ;
        $advertDto->Distance = $row->distance;
        $images = scandir(__DIR__ . "/../../car_images/" . $row->Id);
        $images = array_diff($images, array('.', '..'));
        if ($images != false) {
            $scanned_directory = array_diff($images, array('..', '.'));
            $advertDto->ImageUrl = "./car_images/" . $row->Id . "/" . GetFirstImageFromDir($scanned_directory);
        } else {
            $advertDto->ImageUrl = "./car_images/blank/no-image.png"; //Zdjęcie z napisem "Brak zdjęcia"
        }
        array_push($listWithAdverts, $advertDto);
    }
}


function PrintSingleAdvertModal(CarAdvertDto $carAdvertDto, bool $forDealer = false): string
{
    $htmlString = "";
    $htmlString .= " <form action='' method='post'> 
                <input type='hidden' name='advertId' value='$carAdvertDto->Id'>";
    if(!$forDealer)
        $htmlString .= "<a href='./dashboard/advertisements/show?advertId=".$carAdvertDto->Id."'> ";

    $htmlString .= "<div class='single_advert'> <img src='$carAdvertDto->ImageUrl'/> ";
    $htmlString .= "<div class='info'> <div class='title'>$carAdvertDto->Title</div>";
    $htmlString .= "<div class='description'> " . substr($carAdvertDto->Description, 0, 150) . " </div>";
    $htmlString .= "<div class='bottom-data'>";
    $htmlString .= "<div class='flex_did'>";
    $htmlString .= "<div class='price'> Model: $carAdvertDto->Model </div>";
    $htmlString .= "<div class='date'> Przebieg: $carAdvertDto->Distance  </div>";
    $htmlString .= "</div> <div class='flex_did'>";
    $htmlString .= "<div class='price'> Cena: $carAdvertDto->Price zł</div>";
    $htmlString .= "<div class='date'> Wystawiono: $carAdvertDto->PostDate</div>";

    $htmlString .= "</div> </div> </div> ";
    //Jeśli ogłoszenia dla dealera, to pokaż przycisk od edycji i usuwania
    if ($forDealer) {
        $htmlString .= "<div class='action-icons'> 
            <input type='submit' value='' name='delete_submit' style='background: url(./addons/assets/icons/remove-icon.png)  no-repeat top left;'> </input> 
            <a href='./dealer/advertisement/edit?id=$carAdvertDto->Id'><input type='button' name='delete_submit' style='background: url(./addons/assets/icons/edit-icon.png)  no-repeat top left;'/>  </a> 
          </div>";
    }

    $htmlString .= "  </div>";
        if(!$forDealer) $htmlString .= "</a>";
    $htmlString .= "</form> ";

    return $htmlString;
}

/**
 * Drukuje wszystkie, przekazane w liście ogłoszenia
 */
function GetAdvertsHTML(array $listWithAdverts, bool $forDealer = false): string
{
    $html = "";
    $html .= "<div class='adverts_container'>";
    foreach ($listWithAdverts as $advert) {
        $html .=  PrintSingleAdvertModal($advert, $forDealer);
    }
    $html .=  "</div>";
    return $html;
}

/**
 * Zwraca stringa, do URL, z kryteriów selekcji.
 * W momencie przechodzenia na inną stronę, te kryteria się gubią, więc trzeba je doklejać
 */
function GetSearchCriteriaAsUrlQueryString(){
    $returnString = "";
    foreach ($_GET as $key=>$item) {
        if (str_starts_with($key, "search_")) {
            $returnString .= "&$key=$item";
        }
    }

    return $returnString;
}
/**
 * Jeśli "forDealer" zostało ustawione na true, to wyświetla tylko ogłoszenia dla danego dealera (zalogowanego)
 * Jest to wtedy zakładka "Moje ogłoszenia"
 */
function PrintPaginationAndAdverts(bool $forDealer = false): void
{
    GetAdverts($forDealer);
    global $whereString; //Inicjalizowany w "GetAdverts"

    $totalPages = GetMysqliConnection()->query("SELECT COUNT(*) FROM vadvertisement ".$whereString);

    if($totalPages->num_rows > 0){
        $totalPages = $totalPages->fetch_row()[0];
    }else{
        $totalPages = 0;
    }
    global $listWithAdverts;
    $page = $_GET["page"] ?? 1;
    $page = intval($page);
    $page = $page > 0 ? $page : 1;
    $pageSize = 5;
    $totalPages = ceil($totalPages / $pageSize);
    $page = min($page, $totalPages);
    $offset = ($page - 1) * $pageSize;
    $listWithAdverts = array_slice($listWithAdverts, $offset, $pageSize);

    //Ogłoszenia sa durkowane tutaj, bo linijke wyżej oobramiam liste z ogłoszeniami - chodzi o wydajność
    $advertsHtml = GetAdvertsHTML($listWithAdverts, $forDealer);

    $serachCritieriaUrlString = GetSearchCriteriaAsUrlQueryString();

    //Info o braku ogłoszeń
    if(count($listWithAdverts) == 0){
        echo " <i><span style='display: block; text-align: center'> Brak ogłoszeń... </span></i>";
    }

    $paginationstring =  "<div class='pagination'>";
    if ($page > 1) {
        if ($forDealer) {
            $paginationstring .= "<a href='./dealer/advertisement?page=" . ($page - 1) . "$serachCritieriaUrlString'>Poprzednia</a>";
        } else {
            $paginationstring .= "<a href='./dashboard/advertisements//?page=" . ($page - 1) . "$serachCritieriaUrlString'>Poprzednia</a>";
        }
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        $currentPage = $i == $page ? "current_page" : "";
        $hrefMiddlePart = ($forDealer) ? "./dealer/advertisement/?page=" . $i : "./dashboard/advertisements/?page=" . $i;
        $href = ($i == $page) ? "" : "$hrefMiddlePart".$serachCritieriaUrlString;
        $paginationstring .= "<a class='$currentPage' href='$href'>$i</a>";
    }
    if ($page < $totalPages) {
        if ($forDealer) {
            $paginationstring .= "<a href='./dealer/advertisement?page=" . ($page + 1) . "$serachCritieriaUrlString'>Następna</a>";
        } else {
            $paginationstring .= "<a href='./dashboard/advertisements//?page=" . ($page + 1) . "$serachCritieriaUrlString'>Następna</a>";

        }
    }
    $paginationstring .= "</div>";

    //Zdjęcia się skalują i jest taki głupi efekt przeskoku. odczekanie pól sekudn, niweluje chociaż częsciowo ten skok
    echo $advertsHtml;
    sleep(0.5);
    echo $paginationstring;
}

/**
 * Zwraca pierwsze zdjęcie, które znajdzie w podanej liście
 */
function GetFirstImageFromDir(array $filesInDir): string
{

    //Szukaj pliku z konkretnym rozzerzeniem. Jesli je znajdzie, to zwróc nazwe pliku
    foreach ($filesInDir as $file) {
        $splittedFIleName = explode(".", $file);
        $isImage = strtolower($splittedFIleName[count($splittedFIleName) - 1]) == "jpeg" ||
            strtolower($splittedFIleName[count($splittedFIleName) - 1]) == "jpg" ||
            strtolower($splittedFIleName[count($splittedFIleName) - 1]) == "png";
        if ($isImage) {
            return $file;
        }
    }

    //Jeśli nie znalazł zdjęcia w folderze, to zwróć url, do zdjęcia z napisem "brak zdjęcia"
    global $noImageUrl;
    return $noImageUrl;
}