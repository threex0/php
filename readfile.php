//Copied here for convenience do to my frequent use.
<?php
// Function to open file passed as a string to automatically update questions every day.
function read_file($filename) {
	// file handle to open passed string parameter
	$fh = fopen($filename,"r"); //Specifically opens file name for reading

  // Loop through and echo each individual line
  // Can be re-used to assign to an array
	while (!feof($fh)) {
	  echo $line;
	  
	  if ($line === false) {
		throw new Exception("File read error");
	  }
	}
}?>
