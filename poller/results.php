<?php
// Poller v0.3 by Robert Marin
// results.php
// Example implementation of dumping poll by date.
// Today's date in this example.
// Links back to previous date and takes date as a URL post.

// Includes
require("env.php");
require("functions.php");

if(isset($_GET['date'])) {
	$today = $_GET['date']; //If a date is passed to this page, change the "Today" reference.
	$headerS = $_GET['date']; // headerS = getDate.
	$footerS = "the day before!";
}
else {
	$today = todays_date(); // Otherwise today is today, uses a function from my library
	$headerS = "Today!";
	$footerS = "Yesterday";
}

// Get the string for yesterday
// Todo:  Optimize.
$date = date_create( $today );
date_sub($date, date_interval_create_from_date_string('1 day'));
$yesterday = date_format($date, 'Y-m-d');
//echo $yesterday;

include("header.php");

echo '<div id="cell2"><h1>Results for ' . $headerS . '</h1></div><br/>';

// Performs the dump poll function as defined in the functions.php.
// You can dump the entire db by adding a third variable.
dump_poll($today,$dbr);

echo '<br/><div id="cell2"><h1><a href="?date=' . $yesterday . '">Results for ' . $footerS . '</a></h1></div>';
?>