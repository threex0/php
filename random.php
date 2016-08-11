<?php

require("curl.php");
//require("errors.php");
require("scrape.php");

//Creates Nonsense from Wikipedia
function create_nonsense() {
	$url = "https://en.wikipedia.org/wiki/Special:Random";
	$r = "";
	//echo("entering loop");
	
	$i = rand(1,3);
	for($j = 0; $j < $i; $j++) {
		$content = url_get_contents($url);
		$clean = filter_var($content, FILTER_SANITIZE_STRING);
		
		$scrape = scrape_between($clean,"nomin","Not logged in");
		
		$margin = 500;
		$sLength = strlen($scrape);
		$randLength1 = (rand($margin,$sLength) / 3);
		$randLength2 = (rand($randLength1,$sLength) / 3);
		
		$scrape = substr($scrape,$randLength1,$randLength2);
		$scrape = wiki_sanitize($scrape);

		$r .= purge_parenth($scrape);
		echo($r);
	}
	
		//echo("exiting loop");
	
	return $r;
}

function wiki_sanitize($s) {
	$r = str_replace("Wikipedia","",$s);
	$r = str_replace("Wiki","",$r);
	$r = str_replace("wiki","",$s);
	$r = str_replace("wiki","",$r);
	$r = str_replace("1.","",$r);
	return $r;
}

function create_title() {
		$url = "https://en.wikipedia.org/wiki/Special:Random";
	
		$content = url_get_contents($url);
		$clean = filter_var($content, FILTER_SANITIZE_STRING);
		
		$scrape = scrape_between($clean,"nomin","Not logged in");
		$scrape = scrape_between($scrape,"and",".");
		$scrape = purge_parenth($scrape);
		$title = substr($scrape,0,100);
		
		return $title;
}
?>
