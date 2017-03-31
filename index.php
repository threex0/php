<style>
    body {
        font-family: verdana;
        font-size: 10px;
    }
    td {
        border: solid 1px black;
    }
</style>

<?php
require_once("env.php");
require_once("functions.php");
require_once("classes.php");
$conn = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]); // New DB Connection
echo $conn->error; // Echo error if necessary.

$url = "http://www.investors.com/category/market-trend/stock-market-today/";
$html = url_get_contents($url);
//var_dump($test);

$dom = new DOMDocument;
$dom->loadHTML($html);

$tag_array = array();
$test = show_dom_node($dom,$tag_array);

?>
