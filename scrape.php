<?php
//Basic web scraping function
function scrape_between($data, $start, $end){
    $data = stristr($data, $start); // Stripping all data from before $start
    $data = substr($data, strlen($start));  // Stripping $start
    $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
    $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
    return $data;   // Returning the scraped data from the function
}

//This function removes brackets and anything inside of them with a regular expression
//Currently being used for brackets from a Wikipedia scrape.
function purge_parenth($content) {
	$pattern = "/\[.*\]/";
	$r = preg_replace($pattern, '', $content);
	
	return $r;
}
?>
