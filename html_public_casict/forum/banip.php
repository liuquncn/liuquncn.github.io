<?
	require( "functions.php" );
	session_start();
	if( session_is_registered( "name" ) && session_is_registered( "passwd" ) && $name==$adminName && $passwd == $adminPasswd ):
	dbConnect();
	if( isset( $action ) && $banIP == 1 ):
		if( $action == "ban" ):
		if( isset( $ips ) )
		{
			$ips = trim( $ips );
			if( $ips != "" )
			{
				$ipsArr = explode( ",", $ips );
				for( $i = 0; $i < sizeof( $ipsArr ); $i++ )
					mysql_query( "INSERT INTO bannedip ( ip ) VALUES ( '$ipsArr[$i]' )" ) or error( mysql_error() );
			}
		}
		header( "Location: ./banip.php" );
		elseif( $action == "unban" ):
			mysql_query( "DELETE FROM bannedip WHERE id=$id" ) or error( mysql_error() );
			header( "Location: ./banip.php" );
		endif;
	else:
	$result = mysql_query( "SELECT * FROM bannedip" ) or error( mysql_error() );
	$num = mysql_num_rows( $result );
	displayHeader( "Ban IP" );
	echo "
	<center><h4>Ban IP<font color=#FF0000><small>";
	echo $banIP == 1 ? "(on)" : "(off)";
	echo "</small></font></h4></center>
	<div align=center>
	<center>
	  <table border=0 cellpadding=1 cellspacing=0 width=350>
	  <form method=post action=banip.php?action=ban>
	    <tr>
	      <td width=100% height=40 align=center><small>(Use comma to separate multiple IPs)</small><br><input type=text name=ips size=50 maxlength=100><input type=submit value=\"  Ban  \"></td>
	    </tr>
	  </form>
	  </table>
	</center>
	</div>
	<div align=center>
	<center>
	  <table border=0 cellpadding=1 cellspacing=0 width=350>
            <tr>
              <td width=100% height=25 align=center><b>BANNED IP LIST($num)</b><br><small>(click to unban IP)<small></td>
            </tr>
	    <tr>
	      <td width=100%>";
	while( $row = mysql_fetch_array( $result ) )
		echo "<a href=banip.php?action=unban&id={$row['id']}>{$row['ip']}</a>&nbsp ";
	echo "</td>
	    </tr>
	  </table>
	</center>
	<p align=center><a href=./admin.php>Admin</a>&nbsp; |&nbsp; <a href=forum.php>Thread Index</a></p>";	      
	displayFooter();
	endif;
	else:
		error( "Fatal error, you don't have permission to perform this action" );
	endif;
?>