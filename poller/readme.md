Poller v0.1 - Robert Marin - 08/19/2016
props to Ricesurrenders for a quick and dirty app idea.

Poller is a script which loads questions to a front-end website, then saves the questions on two different back-end databases.  If you were interested in using this script in any capacity, it's worth noting that the DB's have to be setup exactly as in the poller.php file.

It reads information from a large text file containing the questions/answers line by line.  The questions and answers are pipe delimited.  The first field is the question and all other fields are answers.  It's done this way as to be automated, so questions can easily be added to the text file and removed, however since I already have two databases going I'm eventually going to make a simple admin tool which allows you to manually add questions/answers on the back end via the DB.  However the way it works now is it reads the question from a text file, then prints them to a main page (an amount of your chosing), then they are replicated from there into the database.  It isn't clean, but it works enough to get the project of the ground.

Poller tallies votes, and contains a function to print them to a nice neat little table.  The DB takes six votes but the current table printing only prints 3 to accomodate our test cases.  Also, Poller currently prints out the whole database instead of just today's.  This will all be fixed and variabled in the future, but it was done just for testing purposes/prove of concept/mvp.  I've put a ton of To Do around the code, but expect to have a fully functional and self-maintaining thing over the next few days.

Poller currently uses an env.php file for SQL db info, an included functions file, and a header file (just an echo of some basic HTML/CSS, an include but not a require).  All should be included in this repo.

A working demo of this can be seen here:
http://designeragents.com/poll/
