<?
	require( "functions.php" );
	session_start();
	dbConnect();
	if( session_is_registered( "name" ) && session_is_registered( "passwd" ) && $name == $adminName && $passwd == $adminPasswd ):
	if( isset( $action ) && $badWordFilter == 1 ):
		if( $action == "add" ):
		if( isset( $words ) )
		{
			$words = trim( $words );
			if( $words != "" )
			{
				$wordsArr = explode( ",", $words );
				for( $i = 0; $i < sizeof( $wordsArr ); $i++ )
					mysql_query( "INSERT INTO badwords ( word ) values ( '{$wordsArr[$i]}' )" ) or error( mysql_error() );
			}
		}
		header( "Location: ./filter.php" );
		elseif( $action == "unselect" ):
			mysql_query( "DELETE FROM badwords WHERE id=$id" ) or error( mysql_error() );
			header( "Location: ./filter.php" );
		endif;
	else:
	$result = mysql_query( "SELECT id, word FROM badwords" ) or error( mysql_error() );
	$num = mysql_num_rows( $result );
	displayHeader( "Bad Words Filter" );
	echo "
	<center><h4>Bad Words Filter<font color=#FF0000><small>";
	echo $badWordFilter == 1 ? "(on)" : "(off)";
	echo "</small></font></h4></center>
	<div align=center>
	<center>
	  <table border=0 cellpadding=1 cellspacing=0 width=350>
	  <form method=post action=filter.php?action=add>
	    <tr>
	      <td width=100% height=40 align=center><small>(Use comma to separate multiple words)</small><br><input type=text name=words size=50 maxlength=100><input type=submit value=\"  Add  \"></td>
	    </tr>
	  </form>
	  <table>
	</center>
	</div>
	<div align=center>
	<center>
	  <table border=0 cellpadding=1 cellspacing=0 width=350>
	    <tr>
	      <td width=100% height=25 align=center><b>BAD WORDS LIST($num)</b><br><small>(click to delete)</small></td>
	    </tr>
	    <tr>
	      <td width=100%>";
	while( $row = mysql_fetch_array( $result ) )
		echo "<a href=filter.php?action=unselect&id={$row['id']}>{$row['word']}</a>&nbsp; ";
	echo "  </td>
	      </tr>
	    </table>
	  </center>
	</div>
	<p align=center><a href=./admin.php>Admin</a>&nbsp; |&nbsp; <a href=forum.php>Thread Index</a></p>";	      
	displayFooter();	
	endif;
	else:
		error( "Fatal error, you don't have permission to perform this action" );
	endif;
?>