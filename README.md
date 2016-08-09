# My PHP Projects
Various Code, mostly used around Designer Agents and Find That Price.

autoblogger.php - Uses Google OAuth2 to authenticate to Blogger network, then uses random.php (which also calls scrape and curl) to pull random entries from Wikipedia and put random sentences together then automatically post it on the Blog network.  Used mostly as a test case to see if more posts translates into more hits (it does).  Now looking ot see how that translates into hits into my network, if it all.

curl.php - A generic GET I found myself using frequently for Find That Price that I reduced into a function "url_get_contents($url)" to make my life easier.

errors.php - A copy paste job of something I found on Stack Exchange that I use as verbose logging in my PHP projects, and also to prevent my having to open my error_log.  It's a life saver for that alone.

email.php - A script I generated to send email using PHPMailer.

random.php - Has two functions - one creates a line of random text from Wikipedia, the other creats a paragraph of up to four randomly pulled sentences.

scrape.php - Scrapes between any two patterns.  Also contains a function that removes bracketed lines like this [] in use with my autoblogger.

stats.php - Is various PHP implementations of the Google Analytics API code.  Mostly for use in my personal blogging network.  Frankly I was proud I got it to work.  Mostly requires the $VIEW_ID of your website and a JSON keyfile to operate and can be used with various metrics.  I wanted to use my Analytics also as a public counter and found a good end to acheive it.

I need to compress the code into something clenaer.
