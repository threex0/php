<?php
//Use a curl (Especially useful if get_file_contents disabled on web host)
//to pull all data from a URL
function url_get_contents ($url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!'); //Curl will return a false bool and die here if CURL is not enabled.
    }
    $ch = curl_init(); //Return curl handle
    curl_setopt($ch, CURLOPT_URL, $url); //The URL to fetch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Return curl contents as opposed to dumping
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate,sdch'); //set encoding
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); //follow redirects
	curl_setopt($ch, CURLOPT_VERBOSE, 0);  //I don't know some shit
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0");

    $output = curl_exec($ch);
	
	if (FALSE === $output)
        throw new Exception(curl_error($ch), curl_errno($ch));
	
    curl_close($ch); //Close handle
    return $output; //Return contents
}

//Curl a URL, JSON decode as array, return Array
function json_parse($url) {
 $fileContents = url_get_contents($url);
 $data = json_decode($fileContents,true);
 return $data;
}
?>
