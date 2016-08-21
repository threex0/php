<html>
<?php
// Poller v0.3 by Robert Marin
// Edit.php
// Basic admin interface for Poller.
// Todo add session/user/login variables.
// Especially to prevent auto-delete bug
// Will probably start by integrating with other logins on my site.


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

	<form method = "post">
	  <input type="text" id="questionField" name="editor0" placeholder="Question"/>
	  <?php
		  for($i = 0; $i < $answerCount; $i++) { // Provide as many answer fields as set in config.
			echo '<input class="answerField" type="text" name="editor' . ($i + 1) . '" placeholder="Answer ' . ($i + 1) . '" />';
		  }
	  ?>
	  <input type="submit" name="submit" value="Submit" />
	</form> 

<?php

if(isset($_POST['submit'])) { // If data has been submitted.
	$date = date_create( todays_date() ); // Create a date-time object from today's Date.
	if($_POST['editor0'] !== "" && $_POST['editor1'] !== "" && $_POST['editor2'] !== "") { // Only proceed
		// if one question and two answers have been filled in.
		do { // do
			$sDate = date_format($date, 'Y-m-d'); // Formate date/time object as a string for SQL query
			$conn = new mysqli($servername, $username, $password, $dbname); // Open DB Connection
			$query = $conn->query("SELECT * FROM QUESTIONS WHERE Date = '" . $sDate . "'"); // Query the date
			$idCount = $query->num_rows; // Store the number of rows 
			date_add($date, date_interval_create_from_date_string('1 day')); // Add one day onto date object
		} while ($idCount >= $questionCount); // Continue until no questions are selected from a date.
		echo $sDate . " is the next date where questions will be placed."; // Debug
		
		
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
		//echo $sql; 
		$query = $conn->query($sql);
	}
	else {
		echo "You didn't submit a question and at least two answers."; // Error Message if not enough fields submitted.
	}
}

if(isset($_GET['ddate']) && isset($_GET['id'])) {
	delete_question($dbr,$_GET['ddate'],$_GET['id']);
	echo "You deleted something, motherfucker!";
}

dump_questions($dbr,$answerCount); // v0.3 Dump questions function dumps only questions.
?>

</body>

</html>