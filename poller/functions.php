<?php
// Poller v0.31 by Robert Marin
// functions.php
// Necessary include for poller.php

// Used to open a text file with the questions here.
// Deprecated af

// This function just creates today's date in a naturally SQL friendly format.
// But it will also take a string parameter to format date and time if you want to do that.
// This tends to save me some time though.
function todays_date($s = "Y-m-d") {
	return date($s);
}

function dump_poll($date,$dbr,$dumpall = false) { //This function takes the entire SQL credentials and passes them as an array
									
	// Open two sql connections, one for votes and one for questions.
	$conn1 = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]);
	$conn2 = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]);
	// Select only the questions and votes where the date matches the input date.
	if($dumpall == false) {
		$questions = $conn1->query("SELECT * FROM QUESTIONS WHERE Date='" . $date . "' ORDER BY questionId ASC");
		$votes = $conn2->query("SELECT * FROM POLLS WHERE Date='" . $date . "' ORDER BY qid ASC");
	}
	else {
		$questions = $conn1->query("SELECT * FROM QUESTIONS ORDER BY questionId ASC ORDER BY questionId ASC");
		$votes = $conn2->query("SELECT * FROM POLLS ORDER BY qid ASC");	
	}
	
	// Initiate a blank array for the uninitiated
	$answers = array();
	
	$maxColumns = 0;
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
				if ($i >= 2) { $answers[$j]['answ'.($i - 1)] = isset($item) ? $item : NULL; } // If it's more than 2 it's an answer.
				//  Assign accordingly
				$i++; // This loops through the second index of an array/matrix
				// Essentially checks column numbers
			}	
			// Set max answers to the amount of columns, not including "date and qid"
			// Then one additional due to the extra iteration.
			$maxColumns = $i;
			$j++; // This loops through the first.
		}
	}
	
	//var_dump($answers);
	
	// Start printing the storage above into a table
	echo "<div id='results'><table style='width: 100%'>";
    if ($questions) { // If connection to Questions DB was successful.
	  echo "<tr colspan='100%'><td>Poll for " . $date . "</td><td colspan='" . ($maxColumns - 2) . "'>Answers</td></tr><tr>";
	  // This print happens by date, the load of the DB should be limited in a similar way.
	  $j = 0; //iterator
      while($row = mysqli_fetch_object($questions)) { //Go through SQL object
			$i = 0; //iterator
			foreach($row as $item) { // For each question row.
				//if($i == 0) {echo $item;} // Echo the date
				if($i == 1) {echo "<td>Question" . $item . ": "; } // Echo question
				if($i == 2) {echo $item . "</td>"; } // Question #, notice this is in one table def
				if($i >= 3) { //If this is a column after 3, or an Answer column
					if( $item != "" ) { //If this shit doesn't exist don't print it.
						$maxAnswers = $i - 2;
						echo "<td>".$item."</td>"; // But if it does.
					}
				} // Echo an answer header if 
					// we're in answer range.
				if($i == $maxColumns) {echo "</tr>";} // If you're at the end of the columns, close out the row.
				// Todo, print a variable number of answers.
				$i++; // iterate through items and check for column number
			}
			
			// Here we echo the actual votes.  Pulled from the first loop in this function
			echo "<tr><td>votes</td>";	// Just says 'votes'.  What?
			$i = 0; // Looping inside a loop TWICE
			while($i < ($maxColumns - 2)) { //Do this for each answer column
				if( $answers[$j]['answ'.($i+1)] > 0 ) { // Print out a table def iff
					// the answers are within the range of answer columns and the
					// vote count is over 0.
					echo "<td>" . $answers[$j]['answ'.($i+1)] . "</td>";
				}
				elseif ( $i >= $maxAnswers ) { echo ""; } // These two lines now make sure cells print for
				else { echo "<td>0</td>"; }					// The right amount of answers.
				$i++; // loop da loop
			}
			echo "</tr>";	// Number of votes for Answer 3
			$j++; // Go to the next Question.
		}
	}
	echo "</table></div>"; // Close out the table.
}

function dump_questions($dbr,$answerCount) { // v0.3 a function to dump questions to HTML table
	$conn = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]); // New DB Connection
	$questions = $conn->query("SELECT * FROM QUESTIONS ORDER BY Date, questionId ASC"); // Select all from the Q DB
	// Dump all questions
	
	echo "<table><tr><td>Date</td><td>QID</td><td>Question</td>";
	for($i = 0; $i < $answerCount; $i++) {
		echo '<td>Answer ' . ($i + 1) . '</td>';
	}
	echo '</tr><tr>';
	while($row = mysqli_fetch_object($questions)) {
		$i = 0; // Iterator
		foreach($row as $item) { // Each object comes back as an array
			if($i == 0) { $ddate = $item; echo '<tr>'; } // Create Date and row on the first item
			if($i == 1) { $qid = $item; } // Set question ID for deletion
			echo "<td>" . $item . "</td>"; // Echo all items
			if($i == $answerCount + 2) { 
			echo '<td><a href="?ddate=' . $ddate . '&id=' . $qid . '" style="color: black;" onclick="confirm()"><img src="images/delete.png" /></a></td>';
			echo '<td><a href="?edate=' . $ddate . '&id=' . $qid . '" style="color: black;" target="edit_window"><img src="images/edit.png" /></a></td>';
				echo '</tr>';
			} // Close row on last item
			$i++; // Iterate
		}
	}
	echo '</table>'; // Close out table
}

function return_questions($dbr,$date) {
// file handle to open passed string parameter
// Todo:  Merge above function with this one.
	$conn = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]); // New DB Connection for Q/A's
	$sql = "SELECT * FROM QUESTIONS WHERE Date='" . $date . "' ORDER BY questionId ASC"; // Get all questions from a
		// Specific Date.
	$results = $conn->query($sql);
	echo $conn->error;

	$questions = array();
	while($row = mysqli_fetch_object($results)) {
		$i = 0;		
		foreach($row as $item) {
			if($i == 0) { $question['date'] = $item; } ; // Set date of question array
			if($i == 1) { $id = $item; } // Set an id variable, saves headache
			if($i == 2) { 
				$questions['q'][$id] = $item; // Set this specific column to the question.
			}
			if($i >= 3 && $item !== "") { // Everything from here should be answers unless blank
				$questions['a'][$id][($i - 3)] = $item; // Asign by iterator minus 3 as a column offset
			}
			$i++; // Increase.
		}
	}
	
	return $questions;
}

// This function deletes questions.
function delete_question($dbr,$date,$id) { // Pass the following variables
	$conn = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]); // New DB Connection
	$sql = "DELETE FROM QUESTIONS WHERE Date = '" . $date . "' AND questionID = '" . $id . "'"; // Construct a SQL query
	$delete = $conn->query($sql); // Delete the first entry which matches this thing.  Should be unique.
	echo $conn->error; // Echo error if there is one.
	echo "ID: " . $id . "Date: " . $date . " DELETED!<br/>";
}

// This function loads a question to edit and submit edit
function edit_question($dbr,$date,$id,$answerCount) { // Pass Database Array, Date, and ID
	$conn = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]); // New DB Connection
	$sql = "SELECT * FROM QUESTIONS WHERE Date = '" . $date . "' AND questionID = '" . $id . "'"; // Construct a SQL query
	$edit = $conn->query($sql); // Delete the first entry which matches this thing.  Should be unique.
	echo $conn->error; // Echo error if there is one.
	//var_dump($edit);
	
	// Print prior fields as placeholders.
	echo '<form method = "post">';
	// Iterate through SQL query and print appropriate fields
	// Todo: Do as many times ans AnswerCount
	// Todo:  Possibly tablefy or find some other way to call out the specific fields
	while($row = mysqli_fetch_object($edit)) {
		$i = 0; // Iterator
		foreach($row as $item) { // Each object comes back as an array
			echo '<input class="editField" type="text" name="editor' . $i  . '" value="' . $item . '" />'; // Echo a field foreach
				// Each field in the DB
			$i++; // Iterate
		}
	}
	echo '<input type="submit" name="edit" value="Edit" />
	</form>';	
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