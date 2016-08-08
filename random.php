<?php

require("curl.php");
require("scrape.php");

//Creates Nonsense from Wikipedia
function create_nonsense() {
	$url = "https://en.wikipedia.org/wiki/Special:Random";

	echo("entering loop");
	
	$i = rand(1,5);
	for($j = 0; $j < $i; $j++) {
		$content = url_get_contents($url);
		$clean = filter_var($content, FILTER_SANITIZE_STRING);
		
		$scrape = scrape_between($clean,"nomin","Not logged in");
		$scrape = scrape_between($scrape,"and",".");
		$r .= purge_parenth($scrape);
	}
	
		echo("exiting loop");
	
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
