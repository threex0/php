// Function to open whole file and dump the contents to a string.
function open_file($filename) { 
	// file handle to open passed string parameter
	$fh = fopen($filename,"r");
	
	//Initialize some variables
	$file = ""; // Empty string
	$i = 0; // iterator_apply
	// Run until the end of the file/file handle
	while (!feof($fh)) {
		$line = fgets($fh);
		$file .= $line; // Apendd every line of the file to the empty string
	}
	
	  if ($line === false) { // If no lines are read pitch a fit
		throw new Exception("File read error");
	  }
	return $file; // Return the super string from the file.
}
?>
