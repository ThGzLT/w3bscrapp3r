<?php
require_once "vendor/autoload.php";


$curl = curl_init($_GET['q']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

$page = curl_exec($curl);

if (curl_errno($curl)) // check for execution errors
{
    echo 'Scraper error: ' . curl_error($curl);
    exit;
}

curl_close($curl);

//////////////////////////////////////////////PARSING

$ch = curl_init($_GET['q']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$html = curl_exec($ch);
curl_close($ch);
// xprint($html);

phpQuery::newDocument($html);
$title = pq('#vs_classified_192788795 > a > div.clad__summary > div.clad__title')->text();
$description = pq('#vs_classified_192788795 > a > div.clad__summary > div.clad__shortdesc > div.clad__desc-text.not-tablet-mobile')->text();
$Images = pq('#vs_classified_192788795 > a > div.clad__summary > div.clad__title')->text();
$Price = pq('#vs_classified_192788795 > a > div.clad__summary > div.clad__shortdesc > div.clad__price')->text();
$CarYear = pq('#vs_classified_192788795 > a > div.clad__summary > div.clad__title')->text();
$MIleage = pq('#vs_classified_192788795 > a > div.clad__summary > div.clad__title')->text();
$Phone = pq('#vs_classified_192788795 > a > div.clad__summary > div.clad__title')->text();
$Linktowebpage = pq('#vs_classified_192788795 > a > div.clad__summary > div.clad__title')->text();
phpQuery::unloadDocuments();


$db = new Mysqli("localhost", "", "", "scrapperdata");

$query = "INSERT INTO Scrap (title, Description, Images, Price, CarYear, MIleage, Phone, Linktowebpage)
 VALUES ('" . $title . "', '" . $description . "', '" . $Images . "', '" . $Price . "', '" . $CarYear . "', '" . $MIleage . "', '" . $Phone . "', '" . $Linktowebpage . "')";


$db->query($query);


/////isvedimas i lista /////

$sql = "SELECT title, Description, Images, Price, CarYear, MIleage, Phone, Linktowebpage FROM Scrap";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<br> title: " . $row["title"] . " <br> - Description: " . $row["Description"] . " <br> - Images" . $row["Images"] . " <br> - Price" . $row["Price"] . "<br> - CarYear" . $row["CarYear"]
            . " <br> - Mileage" . $row["Mileage"] . "<br> - Phone" . $row["Phone"] . "<br> - Linktowebpage" . $row["Linktowebpage"];
    }

} else {
    echo "0 results";
}








//////////////////////////////////////////////FUNKCIJOS////////////////////

function xprint( $param, $title = 'Debugging info' )
{
    ini_set( 'xdebug.var_display_max_depth', 50 );
    ini_set( 'xdebug.var_display_max_children', 25600 );
    ini_set( 'xdebug.var_display_max_data', 9999999999 );
    if ( PHP_SAPI == 'cli' )
    {
        echo "\n---------------[ $title ]---------------\n";
        echo print_r( $param, true );
        echo "\n-------------------------------------------\n";
    }
    else
    {
        ?>
        <style>
            .xprint-wrapper {
                padding: 10px;
                margin-bottom: 25px;
                color: black;
                background: #f6f6f6;
                position: relative;
                top: 18px;
                border: 1px solid gray;
                font-size: 11px;
                font-family: InputMono, Monospace;
                width: 80%;
            }

            .xprint-title {
                padding-top: 1px;
                color: #000;
                background: #ddd;
                position: relative;
                top: -18px;
                width: 170px;
                height: 15px;
                text-align: center;
                border: 1px solid gray;
                font-family: InputMono, Monospace;
            }
        </style>
        <div class="xprint-wrapper">
        <div class="xprint-title"><?= $title ?></div>
        <pre style="color:#000;"><?= htmlspecialchars( print_r( $param, true ) ) ?></pre>
        </div><?php
    }
}

function xd( $val, $title = null )
{
    xprint( $val, $title );
    die();
}


?>