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
		//echo($r);
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
// ----------------------------------------------------------------------------------------------------
// - Display Errors
// ----------------------------------------------------------------------------------------------------
ini_set('display_errors', 'On');
ini_set('html_errors', 0);

// ----------------------------------------------------------------------------------------------------
// - Error Reporting
// ----------------------------------------------------------------------------------------------------
error_reporting(-1);

// ----------------------------------------------------------------------------------------------------
// - Shutdown Handler
// ----------------------------------------------------------------------------------------------------
function ShutdownHandler()
{
    if(@is_array($error = @error_get_last()))
    {
        return(@call_user_func_array('ErrorHandler', $error));
    };

    return(TRUE);
};

register_shutdown_function('ShutdownHandler');

// ----------------------------------------------------------------------------------------------------
// - Error Handler
// ----------------------------------------------------------------------------------------------------
function ErrorHandler($type, $message, $file, $line)
{
    $_ERRORS = Array(
        0x0001 => 'E_ERROR',
        0x0002 => 'E_WARNING',
        0x0004 => 'E_PARSE',
        0x0008 => 'E_NOTICE',
        0x0010 => 'E_CORE_ERROR',
        0x0020 => 'E_CORE_WARNING',
        0x0040 => 'E_COMPILE_ERROR',
        0x0080 => 'E_COMPILE_WARNING',
        0x0100 => 'E_USER_ERROR',
        0x0200 => 'E_USER_WARNING',
        0x0400 => 'E_USER_NOTICE',
        0x0800 => 'E_STRICT',
        0x1000 => 'E_RECOVERABLE_ERROR',
        0x2000 => 'E_DEPRECATED',
        0x4000 => 'E_USER_DEPRECATED'
    );

    if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
    {
        $name = 'E_UNKNOWN';
    };

    return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
};

$old_error_handler = set_error_handler("ErrorHandler");

// other php code

?>
