# My PHP functions often re-used
Various Code, mostly used around Designer Agents / Find That Price.

curl.php - A generic GET I found myself using frequently for Find That Price that I reduced into a function "url_get_contents($url)"

errors.php - A copy paste job of something I found on Stack Exchange that I use as verbose logging in my PHP projects, and also to prevent my having to open my error_log.  

email.php - A script I generated to send email using PHPMailer.

random.php - Has two functions - one creates a line of random text from Wikipedia, the other creats a paragraph of up to four randomly pulled sentences.

readfile.php - Reads a string used to find a file and run through its contents line by line.  

scrape.php - Scrapes between any two patterns.  Also contains a function that removes bracketed lines like this [] in use with my autoblogger. Also used heavily in Find That Price

todaysDate.php - Used to set a SQL friendly date automatically but also takes a string argument to format date/time differently if needed.
