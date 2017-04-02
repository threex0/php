<style>
    body {
        font-family: verdana;
        font-size: 10px;
    }
    td {
        border: solid 1px black;
    }
    .link_name {
        width: 15%;
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
    $results = $dom->execute('a');

    $cols = ["Link Text", "Address", "Count"];

    $r = Array();
    foreach ($results as $result) {
        ;
        if (!isset($r[$result->getAttribute('href')]['count'])) {
            $r[$result->getAttribute('href')]['count'] = 0;
        }
        $r[$result->getAttribute('href')]['count']++;
        if (in_array($result->textContent, $r[$result->getAttribute('href')]['text'])) {
            continue;
        }
        $r[$result->getAttribute('href')]['text'][] = $result->textContent;
        //echo print_table_rows( [ $result->getAttribute('href'), $result->textContent ] );
    }
//var_dump($r);

    array_sort_by_column($r, 'count', SORT_DESC);
    echo open_table($cols);
    foreach ($r as $k => $v) {
        echo print_table_rows([$k, $v['text'], $v['count']]);
    }
    echo close_table();
}
?>
