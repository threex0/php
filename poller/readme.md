Poller v0.4 - Robert Marin - 08/27/2016
================================================================================
v0.4 changelog
----------------------------
Feature - Editing Questions.  Questions can now be direclty edited from edit.php.  Some snazzy images have been included.

Fixed bug where items would not add automatically into middle of stack of viewed/displayed ID's.  A logic was created to first check if each date had the right amount of questions, then cycle through to add a missing one where necessary.  This is an optimized version of the code to address a possibly very large database.  Although due to the above feature this should have to happen very rarely.

Future:  
Code optimizations  
Fix bug where submission happens on date submitted instead of date of questions (only happens if the screen is open and the date changes while the questions are still loaded.)  
Fix Javascript confirmation button to only delete on confirmation and to display a message
Enhance Look/Feel with Javascript

v0.32 changelog
---------------------------------
Fixed bug where columns where not lining up with data (due to not printing empty columns)
Fixed bug where zero votes were not being printed where applicable, minor but makes the site more readable and necessary for future theming
Set a date boundary feature so Poller only prints to original date
v0.3 changelog
---------------------------------
Added "edit.php".  Edit.php allows you to have an admin interface.  Allows for deletion and creation of new questions.  Todo:  Questions will automatically populate at the end of the db, but not in the middle.  This is a bug, and coupled with another bug that you'll see unset indexes on your main page if a questionID for a date isn't set, is planned to be fix over the next few days.

Env.php now contains some config variables, they need a home and I will probably end up moving them.  Also considering creating language and string files.

Header.php minor change div class to 'wrapper' as it was serendipitous that everything was wrapped inside a div that set a default style.  I think this div needs to be closed.

Poller.php now reads questions from a pre-populated database (populated from edit.php).  Still saves votes in votes db.  Needing a file to store questions is gone, and so are two functions from v0.2, one of which was pretty bloated and allowed me to compress poller.php into something much more readable.

Results.php - Results now has an ability to dump the entire database (as does the function it calls on).  Also pages through old results.  Issetor to prevent errors, Todo: but needs a bounds set by oldest date.

Closing in on a finished product.
==================================================================================
props to Ricesurrenders for a quick and dirty app idea.

Poller is a script which loads questions to a front-end website, then saves the questions on two different back-end databases. If you were interested in using this script in any capacity, it's worth noting that the DB's have to be setup exactly as in the poller.php file.

It reads and writes information from a database containing the questions/answers line by line. It's automated so that when items are added via edit.php they automatically stack to the end of a file.  A pre-set number of questions is asked a day.

Poller tallies votes, and contains a function to print them to a nice neat little table.  You can post dates manually to it making it configurable.  Automatically links to the previous day as well to see results from other days.

Poller currently uses an env.php file for SQL db, an included functions file, and a header file (just an echo of some basic HTML/CSS, an include but not a require).  Also stores the question/answercount as a config. All should be included in this repo.

A working demo of this can be seen here:
http://designeragents.com/poll/
