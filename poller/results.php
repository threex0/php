<?php
// Poller v0.2 by Robert Marin
// results.php
// Example implementation of dumping poll by date.
// Today's date in this example.

// Includes
require("env.php");
require("functions.php");

$date = todays_date();

include("header.php");
?>
<div id="cell2"><h1>Results for today!</h1></div><br/>
<?php
// Performs the dump poll function as defined in the functions.php.
$dbr = array($servername, $username, $password, $dbname);
dump_poll($date,$dbr);
?>