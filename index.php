<!DOCTYPE HTML>
<style>
    body, table {
        font-family: verdana;
        font-size: 12px;
    }
    table {
        background-color: #DDDDDD;
        border: solid 1px black;
        border-radius: 15px;
        padding-bottom: 10px;
    }
    td {
        background-color: white;
        border: solid 1px black;
    }
    .link_name {
        width: 15%;
    }
    .line-graph {
        background-color: aqua;
    }
    .line_graph {
        background-color: black;
        width: 100px;
    }
    #search{
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
        position: static;
        width: 400px;
    }
    #search_form {
        width: 100%;
    }
</style>

<?php
require_once("env.php");
require_once("functions.php");
require_once("library/Zend/Dom/Query.php");
require_once("library/Zend/Dom/DOMXPath.php");
require_once("library/Zend/Dom/NodeList.php");
require_once("library/Zend/Dom/Document/Query.php");
//$conn = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]); // New DB Connection
//echo $conn->error; // Echo error if necessary.
use Zend\Dom\Query;


?>

<div id="search">
    <form method="get">
        <input id="search_form" type="search" name="url" placeholder=" <?= ( isset( $_GET['url'] ) ? "Address: " .  $_GET['url'] : 'Enter A URL' ) ?> "/>
    </form>
</div>

<?php
if(isset($_GET['url'])) {
    //$url = ['g' => 'http://www.google.com', 't' => 'http://www.investors.com/category/market-trend/stock-market-today/'];
    $html = url_get_contents($_GET['url']);
    $dom = new Query($html);
    $link_results = $dom->execute('a');

    print_links($link_results);
}
?>
