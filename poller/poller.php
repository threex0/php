<?php
// Poller v0.3 by Robert Marin
// poller.php
// Creates a customizable set of questions read from a Questions/Answers DB
// Stores votes in a votes DB.
// Todo:  Probably add a user login option to front page to prevent duplicate votes
// Will probably use Oauth2.

// Includes
require("env.php"); //Question and Answer Count now stored in ENV
require("functions.php");

// Throw this switch for debugging
// Will make site ugly.
$devMode = false;
$todaysDate = todays_date();
// Only set the test variable if you have to.
if($devMode == true) { $testDate = (todays_date()); }


// Include the beginning HTML
// of this page to make this code cleaner.
include("header.php");

$questions = return_questions($dbr,$todaysDate); // Load $questions with Q and A's 
	// from text file using function above
	// lines are pipe-delimited with the first item being the question and every other item being the answer.
	
// Echo the form tag to encapsulate all the form content for submission
echo '<form method="post">';
// 2 or more, use a for.
for($i = 0; $i < $questionCount; $i++) { //Up until question count do this thing
	// This allows chosing how many items to print out
	// Do some HTML to print the questions
	// notice the $i in the HTML to id the cells differently, cell0 etc...
	echo('<div class="poll" id="cell' . $i . '"><h1>' . $questions['q'][$i] . '</h1><div class="answers">');
	// Then the answers in their own Div
	$count = 0; // Count which answer it is, relevant in determining which radio button will submit for the post
	foreach($questions['a'][$i] as $answer) {
		// This code used to be a bitch.  But it was solved by using a database of questions and a database of votes
		// Now only the actual "count" of which radio button that's checked is sent to the submit process and vote db.
		echo '<input type="radio" name ="rad' . $i .  '" value="' . $count . '">' . $answer . '</input> '; 
		$count++;
	} 
	echo '</div></div>'; // Close it out
}

echo '<div class="submit">
	<input id="button" type="submit" name="submit" value="Submit"/>
	</form></div>
	</body>'; //Close out our little question table, including a submit button.

// If data has been submitted
if(isset($_POST['submit'])) {
	if(isset($_POST['rad0']) && isset($_POST['rad1']) && isset($_POST['rad2']) && isset($_POST['rad3']) && isset($_POST['rad4'])) 
		{
			// Create connection
			// Variables set in env.php
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			// Loop $questionCount amount of times.
			for($i = 0; $i < $questionCount; $i++) {
				// Build a SQL string which pulls question ID's from today's date
				$sql = "SELECT qid FROM POLLS WHERE Date = '" . $todaysDate . "'";
				// Execute
				$result = $conn->query($sql);
				// if any rows come back get results.
				if($result->num_rows > 0) {
					// Get vote from post and add 1 to it to make it header-friendly
					$vote = $_POST['rad' . $i] + 1;
					// Create a string based off that number
					$answerString = "A".$vote."Votes";
					// Create a SQL query string based off THAT string.
					$sql = "UPDATE POLLS SET " . $answerString . " = " . $answerString . 
					" + 1 WHERE Date = '" . $todaysDate . "' AND qid = " . $i;
					
					// Execute the Query
					$conn->query($sql);
				}
				else { //If the question id does not exist, create tose rows, then increment the vode
						// Some negligible code re-use occurs below.
						
					// Loop $questionCount amount of times	
					for($i = 0; $i < $questionCount; $i++) {	
							// Build a row and populate it as null.
							$sql = "INSERT INTO POLLS (Date,qid,A1Votes,A2Votes,A3Votes,A4Votes,A5Votes,A6Votes) VALUES 
								('" . $todaysDate . "','" . $i . "','0','0','0','0','0','0')";
							// Execute
							$result = $conn->query($sql);
						
						// assemble the same shit I said in the if, god dammit.
						$vote = $_POST['rad' . $i] + 1;
						$answerString = "A".$vote."Votes";
						$sql = "UPDATE POLLS SET " . $answerString . " = " . $answerString . 
						" + 1 WHERE Date = '" . $todaysDate . "' AND qid = " . $i;
						// Execute the Query
						$conn->query($sql);
						// Code re-use ends here.  Todo:  Turn into a function
					}
				}
			}
			
		// Div ID for voted string.
		echo "<div id='voted'>You have Voted!</div>";

		}	
	else {
		// You should only see this if you are a failure.
		echo "You didn't select every answer!";
	}
}

echo "<div id='view_results'><h1><a href='results.php' target='someOtherWindow'>View Results</a></h1></div>";
?>
</html>
