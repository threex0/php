<html>
<?php
// Poller v0.33 by Robert Marin
// Edit.php
// Basic admin interface for Poller.
// Todo add session/user/login variables.
// Especially to prevent auto-delete bug on non-HTML 5 platforms
// Fixed bug which causes new questions to auto-add to end.
// Now re-add to middle of stack.
// Todo fix javascript prompt menu

// Includes
require("env.php");
require("functions.php");
// Print the header HTML
include("header.php");

// Turn questions into array from functions file
echo '<div id="cell2"><h1>Add Questions to DB</h1></div><br/>'; // Heading to page
echo '<div id="questions" style="text-align: center;">';

?>

<script> 
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>

<?php
if(!isset($_GET['edate'])) { // If Edit date is not set, in other words always print this unless editing
	echo '<form method = "post">
		  <input type="text" id="questionField" name="editor0" placeholder="Question"/>'; // HTML header for form
	for($i = 0; $i < $answerCount; $i++) { // Provide as many answer fields as set in config.
		echo '<input class="answerField" type="text" name="editor' . ($i + 1) . '" placeholder="Answer ' . ($i + 1) . '" />';
		// Do this for every answer.
	}
	echo '<input type="submit" name="submit" value="Submit" />
		</form>'; // Etc.
}

// Todo:  Merge with function below
if(isset($_POST['submit'])) { // If data has been submitted.
	$date = date_create( todays_date() ); // Create a date-time object from today's Date.
	if($_POST['editor0'] !== "" && $_POST['editor1'] !== "" && $_POST['editor2'] !== "") { // Only proceed
		// if one question and two answers have been filled in.
		
		$youDone = false;// Initialize 
		$idCount = 0; // Which ID to write to the database.
		do { // do
			$sDate = date_format($date, 'Y-m-d'); // Formate date/time object as a string for SQL query
			$conn = new mysqli($servername, $username, $password, $dbname); // Open DB Connection
			$query = $conn->query("SELECT * FROM QUESTIONS WHERE Date = '" . $sDate . "'"); // Query the db
				// for everything from one date
			//var_dump($query); // debug
			
			if($query->num_rows < $questionCount) { // Only perform if the number of rows queried is less than the config
					// overall question count - This is meant to be a rare circumstance to optimize.
				for($i = 0; $i < $questionCount; $i++) { // For each question 
					$query2 = $conn->query("SELECT * FROM QUESTIONS WHERE Date = '" . $sDate . "' AND questionId = '" 
					. $i . "'"); // Check if the question ID exists.  Should return at least one result
					//var_dump($query2); // Debug
					//echo "Added question to " . $sDate . "<br/>"; // Debug
					//echo $i . "<br/>"; // ditto
					//echo $query2->num_rows . "<br/>"; // ditto
					
					if($query2->num_rows == 0) { // If the number of rows returned is zero
						$idCount = $i;  // Set the id to current iterator
						$youDone = true; // Break both loops if this case comes up and run the SQL query.
						break; // Then break out of loop
					}
				}
			}
			if($youDone == true){ break; } 
			date_add($date, date_interval_create_from_date_string('1 day')); // Add one day onto date object
		} while ($idCount < $questionCount); // Continue until no questions are selected from a date.
		//echo $sDate . " is the next date where questions will be placed."; // Debug
		
		$sql = "INSERT INTO QUESTIONS(Date,questionId,Question"; // First three columns created.
		for($j = 0; $j < $answerCount; $j++) { // For every answer in config
			$sql .= ",Answer". ($j + 1); // Create this many columns in sql query
		}
		$sql .= ") VALUES('"; // Continue building query
		$sql .= $sDate . "','"; // Insert last string date as date (first available date to insert under
			// max answer count.
		$sql .= $idCount . "','"; // Add all submitted items to query
		$sql .= mysqli_real_escape_string($conn,$_POST['editor0']) . "','"; // Insert Question into SQL string.
			// Gotta sql escape these strings so as to not break things or be vulnerable
			// To injection.
		for($j = 0; $j < $answerCount; $j++) { // For every answer in config
			$sql .= mysqli_real_escape_string($conn,$_POST['editor'.($j+1)]); // Continue building query
			if($j + 1 < $answerCount) { // Add until last item
				$sql .= "','"; // Add separators
			}
		}
		$sql .= "')"; // Close the query (finally).
		//echo $sql . "<br/>";  // Debug
		
		$query = $conn->query($sql); // Execute SQL Query
		echo "Added question to " . $sDate . "<br/>";
		//var_dump($query); // Debug
	}
	else {
		echo "You didn't submit a question and at least two answers."; // Error Message if not enough fields submitted.
	}
}

// v0.4 Shit, Killer Edit.
// Todo merge with the function above somehow.
// A copy/paste of the function above
if(isset($_POST['edit'])) { // If data has been submitted.
	$conn = new mysqli($servername, $username, $password, $dbname);

	if($_POST['editor0'] !== "" && $_POST['editor1'] !== "" && $_POST['editor2'] !== ""
		&& $_POST['editor3'] !== "" && $_POST['editor4'] !== "") { // Only proceed
			// if all necessary fields have been put in.
			$sDate = $_POST['editor0'];
			$idCount = $_POST['editor1'];
			$question = $_POST['editor2'];
			
			$sql = "UPDATE QUESTIONS SET Question = '" . mysqli_real_escape_string($conn,$question) . "'"; 
				// Start SQL statement by setting question
			for($j = 0; $j < $answerCount; $j++) { // For every answer in config
				$sql .= ",Answer". ($j + 1) . " = '"; // Create this many columns in sql query
				$sql .= mysqli_real_escape_string($conn,$_POST['editor'.($j+3)]); // Set all answers	
				if($j + 1 < $answerCount) { $sql .= "'"; }
			}
			$sql .= "' WHERE Date = '" . $sDate . "' AND questionId = '" . $idCount . "'"; // Only for the original question
				// You're editing.  Very important
			// echo $sql . "<br/>";  // Debug
			
			$query = $conn->query($sql); // Execute SQL Query
			// echo $conn->error;
			echo "Updated " . $sDate . " Question ID: " . $idCount . "<br/>";
			// var_dump($query); // Debug
	}
	else {
		echo "Date, Question ID, Question, or answers 1 and 2 are blank."; // Error Message if not enough fields submitted.
	}
}

if(isset($_GET['ddate']) && isset($_GET['id'])) {
	delete_question($dbr,$_GET['ddate'],$_GET['id']);
	echo "You deleted something, motherfucker!";
}

if(isset($_GET['edate']) && isset($_GET['id'])) { // v 0.4 edit function
	echo "You want to edit something, fuck!";
	edit_question($dbr,$_GET['edate'],$_GET['id'],$answerCount);
}

if(!isset($_GET['edate'])) { // v0.4 for edit function - prevents this from printing when editing.
	dump_questions($dbr,$answerCount); // v0.3 Dump questions function dumps only questions.
}
?>

</body>

</html>