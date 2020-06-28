<?
	require( "functions.php" );
	session_start();
	if( isset( $action ) ):
		if( $action == "logout" ):
			session_unregister( "name" );
			session_unregister( "passwd" );
			displayHeader( "Logout" );
			echo "
			<center><h4>You have logout successfully!</h4></center>
			<p align=center><a href=forum.php>$forumTitle</a>&nbsp; |&nbsp;
			<a href=$homeURL>$homeTitle</a>";
			displayFooter();
		endif;
	endif;
	if( isset( $name ) && isset( $passwd ) ):
		if( $name != $adminName || $passwd != $adminPasswd || $name == "" || $passwd == "" ):
			error( "Invalid username and password" );
		elseif( !session_is_registered( "name" ) && !session_is_registered( "passwd" )
		&& $name == $adminName && $passwd == $adminPasswd ):
			session_register( "name" );
			session_register( "passwd" );
			displayAdmin();
		elseif( session_is_registered( "name" ) && session_is_registered( "passwd" )
		&& $name == $adminName && $passwd == $adminPasswd ):
			displayAdmin();
		else:
			error( "Fatal error, please close your browser and try again!" );
		endif;
	else:
		displayForm();
	endif;
	
	function displayForm()
	{
		displayHeader( "Login in" );
		echo "
		<center><h4>Login in</h4></center>
		<div align=center>
		  <center>
		  <form method=post action=admin.php>
		  <table border=0 cellpadding=0 cellspacing=0 width=230>
		    <tr>
		      <td width=70 height=20>User:</td>
		      <td width=130 height=20><input type=text name=name size=20 maxlength=10></td>
		    </tr>
		    <tr>
		      <td width=70 height=20>Password:</td>
		      <td width=130 height=20><input type=password name=passwd size=20 maxlength=10></td>
		    </tr>
		    <tr>
		      <td width=70 height=20></td>
		      <td width=130 height=20><input type=submit value=\"  Login  \"></td>
		    </tr>
		  </table>
		  </form>
		  </center>
		</div>
		<p align=center><a href=javascript:history.back()>Back</a></p>";
		displayFooter();
	}
	function displayAdmin()
	{
		global $badWordFilter, $banIP;
		displayHeader( "Admin Area" );
		echo "
		<center><h4>Admin Area</h4></center>
		<p align=center><a href=delete.php>Delete Message</a></p>
		<p align=center><a href=filter.php>Bad Words Filter";
		echo $badWordFilter == 1 ? "(on)" : "(off)";
		echo"</a></p><p align=center><a href=banip.php>Ban IP";
		echo $banIP == 1 ? "(on)" : "(off)";
		echo "</a></p>
		<p align=center><a href=createdb.php>Create Database</a></p>
		<p align=center><a href=dropdb.php>Drop Database</a></p>
		<p align=center><a href=admin.php?action=logout>Logout</a></p>
		<p align=center><a href=forum.php>Thread Index</a></p>";
		displayFooter();
	}
?>	