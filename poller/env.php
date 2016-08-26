<?php
// Credentials put in .env file
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";
$dbr = array($servername, $username, $password, $dbname);

//config stuff.
$questionCount = 5;  //How many questions to display and work with
$answerCount = 6;  //Maximum amount of answers
$startDate = "2016-08-20"; // Beginning day of website.  Used to limit how far back DB is traversed in results.php v0.32
?>