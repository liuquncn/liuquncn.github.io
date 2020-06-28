<?
require( "vars.php" );
function dbConnect()
{
	global $dbHost, $dbUser, $dbPasswd, $dbName;
	@mysql_connect( $dbHost, $dbUser, $dbPasswd ) or error( mysql_error() );
	mysql_select_db( $dbName );
}
function displayHeader( $title )
{
	global $fontFamily, $fontSize, $visitedColor, $hoverColor, $linkColor, $forumTitle, $bgColor, $bgImage;
	echo "<!--Adopted from the work by Alan Zhao.  Thank U!!-->
	<html>
	<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html;charset=gb2312\">
	<title>$title</title>
	<style type=\"text/css\">
	<!--
		body, table { font-family: $fontFamily; font-size: $fontSize; line-height: 1.5 }
		A:link { color: $linkColor; text-decoration: underline }
		A:visited { color: $visitedColor; text-decoration: underline }
		A:hover { color: $hoverColor; text-decoration: none }
		A:active { color: $linkColor; text-decoration: underline }
	-->
	</style>
	</head>
	<body bgcolor=$bgColor background=$bgImage>
	<center><h3>$forumTitle</h3></center>";
}
function displayFooter()
{
	/* Please do not remove or change the code below */
	echo "
	<p align=center><small>All Rights Reserved by <a href=http://www.xgra.com>XGRA.COM</a> 2001.</small></p>
	<p>&nbsp;</p>
	</body>
	</html>";
	/* Please do not remove or change the code above */
	return;
}
function error( $error )
{
	global $forumTitle;
	displayHeader( "Error Page" );
	echo "
	<center><h4>&lt;Error Page&gt;</h4></center>
	<center><h4><font color=#FF0000>Error: $error</font></h4></center>
	<p align=center><a href=javascript:history.back();>Back</a>&nbsp; |&nbsp; <a href=forum.php>$forumTitle</a></p>";
	displayFooter();
	exit();
//	return;
}
?>
