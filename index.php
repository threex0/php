<style>
    td {
        border: solid 1px black;
    }
</style>

<?php
require_once("env.php");
require_once("functions.php");
$conn = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]); // New DB Connection
echo $conn->error; // Echo error if necessary.

$url = "http://www.investors.com/category/market-trend/stock-market-today/";
$test = url_get_contents($url);
//var_dump($test);

$s = "Today’s 20-somethings and even those in their early 30s came of age in what may have been the worst national real estate market on record since their grandparents were born. Now a major real estate ad company wants to persuade them that it’s high time to take a risk; that it’s time to walk away from paying high rents in some costly markets and pay high prices to buy their own homes.";
$word_array = explode(" ", $s);
$sorted_array = array();
foreach( $word_array as $word ) {
    //echo $word . "<br/>";
    $sorted_array[$word]++;
}

arsort($sorted_array);
echo "<table><tr></tr><th>Word</th><th>Count</th><th>Type</th></tr>";
foreach($sorted_array as $word => $count) {
    $results = $conn->query( "SELECT word, wordtype FROM entries WHERE word = '" . $word . "' AND wordtype != ''");
    echo $conn->error; // Echo error if necessary.

    $row = mysqli_fetch_object($results);
    $type = $row->wordtype;
    echo "<td><a href='dictionary.php?word=" . $word . "'>" . $word . "</a></td><td> " . $count . "</td><td>" . $type . "</td><tr/>";
}
echo "</table>";

?>
