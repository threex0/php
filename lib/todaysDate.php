<?php
// This function just creates today's date in a naturally SQL friendly format.
// But it will also take a string parameter to format date and time if you want to do that.
// This tends to save me some time though.
function todays_date($s = "Y-m-d") [
	return date($s);
}
?>
