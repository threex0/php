# My PHP Projects
Various Code, mostly used around Designer Agents / Find That Price.

curl.php - A generic GET I found myself using frequently for Find That Price that I reduced into a function "url_get_contents($url)" to make my life easier.

errors.php - A copy paste job of something I found on Stack Exchange that I use as verbose logging in my PHP projects, and also to prevent my having to open my error_log.  It's a life saver for that alone.

email.php - A script I generated to send email using PHPMailer.

random.php - Has two functions - one creates a line of random text from Wikipedia, the other creats a paragraph of up to four randomly pulled sentences.

readfile.php - Reads a string used to find a file and run through its contents line by line.  Just copy and pasted here so I can quickly copy and paste it or include it when necessary.

scrape.php - Scrapes between any two patterns.  Also contains a function that removes bracketed lines like this [] in use with my autoblogger.

stats.php - Is various PHP implementations of the Google Analytics API code.  Mostly for use in my personal blogging network.  Frankly I was proud I got it to work.  Mostly requires the $VIEW_ID of your website and a JSON keyfile to operate and can be used with various metrics.  I wanted to use my Analytics also as a public counter and found a good end to acheive it.

I will soon compress much of this code into a functional library of functions or at least in some cases cleaner and more optimized code as I go along.
