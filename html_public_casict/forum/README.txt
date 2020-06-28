*************************************************************
*               zForum v1.4                                 *
*               by Alan Zhao                                *
*               JAN 1, 2002                                 *
*                                                           *
*               http://www.xgra.com                         *
*                                                           *
*************************************************************

To run this program, you must have PHP and MySql run on your web server.

How to set up:
==============
variables in 'vars.php':
	$forumTitle               // no need to explain
	$homeTitle                // name of your home page
	$homeURL                  // your home page URL
	$replyURL                 // URL to 'reply.php' file
	
	$dbHost                   // MySql database host
	$dbName                   // name of your MySql database
	$dbUser                   // database user name
	$dbPasswd                 // database password
		
	$badWordFilter            // allow bad word checking? 1=yes, 0=no
	$banIP			  // ban ip? 1=yes, 0=no
	$emailAdmin               // sent new posting to admin 1=yes, 0=no
	$adminEmail               // e-mail address where new posting sent to
		
	$maxThread                // number of threads display on a page
	$fontFamily               // font type
	$fontSize                 // font size
	$linkColor                // Hyperlink color
	$visitedColor
	$hoverColor
	
	$adminName	          // you admin name
	$adminPasswd              // admin password

step 1. Upload all files into one directory.
step 2. Change variables in 'vars.php' file, be sure to change the user name
        and password.
step 3. Run 'admin.php' and login.
step 4. Create database. (please create database first, otherwise you get errors)
step 5. Run 'forum.php'.

If you know nothing about PHP, please don't try to modify scripts, otherwise you
will mess up with the code.  Even sometimes I found out myself can't understand the 
code I wrote.  If you have experience with PHP, you can modify the code in purpose
of changing the layout only.

Copyrights
==========
I have to say that I am not responsible for the damages you made by using my scripts.
By using my scripts you are agreed to this statement.  You can distribute my scripts
as long as you keep all my copyrights notices.  However you can't use them for commerical
purposes unless you pay me some money.