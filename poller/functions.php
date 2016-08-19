<?php
// Function to open "Questions.txt" file to automatically update questions every day.
function open_questions($filename,$questionCount = 5) { //This defaults the amount of questions to pull to 5.
	// file handle to open passed string parameter
	$fh = fopen($filename,"r");
	
	$i = 0;
	// Run until the end of the file/file handle
	while (!feof($fh)) {
		$line = fgets($fh); // $line is current line, similar to a foreach but for each specific line
		$parsedLine = explode("|",$line); // Questions text file uses pipe separated values, kaboom them.
		$question['q'][$i] = $parsedLine[0]; // Questions array is made up of the first part of the exploded array
			// Each first element in the array is a question as formatted by the text document
		$question['a'][$i] = array_slice($parsedLine,1); // The answers array is everything else from the explosion
			// consider it everything AFTER the question (which has already been exploded into a second array)
		// var_dump($question['a']);
			// debug shit above
		if ($i < $questionCount) {
				$i++; // Because I couldn't find a way to directly reference an index as a line for a file handle
				// I resorted to increasing an integer until it met the questionCount variable, and then breaking
				// The while loop
		}
		else { break; } // As so
	}
	
	  if ($line === false) { //If no lines are read pitch a fit
		throw new Exception("File read error");
	  }
	return $question; //return the array of questions from index 0 up until the $questionCount limitation.
}

// This function just creates today's date in a naturally SQL friendly format.
// But it will also take a string parameter to format date and time if you want to do that.
// This tends to save me some time though.
function todays_date($s = "Y-m-d") {
	return date($s);
}

// Todo:  Fix this shit up for sure.
function dump_poll($date,$dbr) { //This function takes the entire SQL credentials and passes them as an array
									//I should probably do it this way in the future TODO
									
	// Open two sql connections, one for votes and one for questions.
	// GET THE ENTIRE DB FORE SOME REASON TODO
	$conn1 = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]);
	$conn2 = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]);
	// Todo, razor by date plz
	$questions = $conn1->query("SELECT * FROM QUESTIONS");
	$votes = $conn2->query("SELECT * FROM POLLS");
	
	// Initiate a blank array for the uninitiated
	$answers = array();
	
	// If connection2/votes was successful.
	if($votes) {
		$j = 0; //jiterator
		while($row = mysqli_fetch_object($votes)) { // Loop through the SQL object
			$i = 0; //iterator
			foreach($row as $item) { //Each object comes back as an array
				// Set each individual item as a new "Answers Array" of 
				// $j index.
				if ($i == 0) { $answers[$j]['date'] = $item; }
				if ($i == 1) { $answers[$j]['qid'] = $item; }
				if ($i == 2) { $answers[$j]['answ1'] = $item; }
				if ($i == 3) { $answers[$j]['answ2'] = $item; }
				if ($i == 4) { $answers[$j]['answ3'] = $item; }
				if ($i == 5) { $answers[$j]['answ4'] = $item; }
				if ($i == 6) { $answers[$j]['answ5'] = $item; }
				if ($i == 7) { $answers[$j]['answ6'] = $item; }
				$i++; // This loops through the second index of an array/matrix
				// Essentially checks column numbers
			}	
			$j++; // This loops through the first.
		}
	}
	
	//var_dump($answers);
	
	// Start printing the storage above into a table
	echo "<div id='results'><table style='width: 100%'>";
    if ($questions) { // If connection to Questions DB was successful.
	  echo "<tr colspan='100%'><td>Poll for " . $date . "</td><td colspan='6'>Answers</td></tr><tr>";
	  // This print happens by date, the load of the DB should be limited in a similar way.
	  $j = 0; //iterator
      while($row = mysqli_fetch_object($questions)) { //Go through SQL object
			$i = 0; //iterator
			foreach($row as $item) { // For each question row.
				if($i == 1) {echo "<td>Question" . $item . ": "; } // Echo question
				if($i == 2) {echo $item . "</td>"; } // Question #, notice this is in one table def
				if($i == 3) {echo "<td>".$item."</td>";} // Answer 1
				if($i == 4) {echo "<td>".$item."</td>";} // Answer 2
				if($i == 5) {echo "<td>".$item."</td></tr>";} // Answer 3
				// Todo, print a variable number of answers.
				$i++; // iterate through items and check for column number
			}
			
			// Here we echo the actual votes.  Pulled from the first loop in this function
			echo "<tr><td>votes</td>";	// Just says 'votes'.  What?
			echo "<td>" . $answers[$j]['answ1'] . "</td>"; // Number of votes for Answer 1
			echo "<td>" . $answers[$j]['answ2'] . "</td>"; // Number of votes for Answer 2
			echo "<td>" . $answers[$j]['answ3'] . "</td></tr>";	// Number of votes for Answer 3
			$j++; // Go to the next Question.
		}
	}
	echo "</table></div>"; // Close out the table.
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