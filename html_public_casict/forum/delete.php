<?
	include( "functions.php" );
	session_start();
	dbConnect();
	if( session_is_registered( "name" ) && session_is_registered( "passwd" ) && $name == $adminName && $passwd == $adminPasswd ):
		if( isset( $id ) ):
			deleteThread( $id );
			header( "Location: delete.php" );
		else:
			$result = mysql_query( "SELECT rootID FROM forum WHERE parentID=''" ) or error( mysql_error() );
			$totalThread = mysql_num_rows( $result );
			unset( $result );
			
			$result = mysql_query( "SELECT rootID FROM forum" ) or error( mysql_error() );
			$totalMsg = mysql_num_rows( $result );
			unset( $result );
			
			if( !isset( $page ) ) $page = 1;
			if( $totalThread <= $maxThread ) $totalPages = 1;
			elseif( $totalThread % $maxThread == 0 ) $totalPages = $totalThread / $maxThread;
			else $totalPages = ceil( $totalThread / $maxThread );
			if( $totalThread == 0 ) $threadStart = 0;
			else $threadStart = $maxThread * $page - $maxThread + 1;
			if( $page == $totalPages ) $threadEnd = $totalThread;
			else $threadEnd = $maxThread * $page;
			$initialMsg = $maxThread * $page - $maxThread;
			
			displayHeader( $forumTitle );
			echo "
			<a name=top>
			<div align=center>
			  <center>
			  <table border=0 cellpadding=0 cellspacing=0 width=80%>
			    <tr>
			      <td width=50% height=20></td>
			      <td align=right width=50% height=20>
			      [ <a href=admin.php>Back to admin</a> ] [ <a href=admin.php?action=logout>Logout</a> ]
			      [ <a href=forum.php>Thread Index</a> ]</td>
			    </tr>
			    <tr>
			      <td width=100% height=1 colspan=2 bgcolor=#808080></td>
			    </tr>
			    <tr>
			      <td width=100% height=20 colspan=2><small>Total <b>$totalMsg</b> messages in <b>$totalThread</b> threads,
			      now displaying threads <b>$threadStart</b> - <b>$threadEnd</b></small></td>
			    </tr>
			  </table>
			  </center>
			</div>
			<div align=center>
			  <center>
			  <table border=0 cellpadding=0 cellspacing=0 width=80%>
			    <tr>
			      <td width=100% height=100%>";
			echo "<p align=center><b>Page:</b>&nbsp; ";
			for( $i = 1; $i <= $totalPages; $i++ )
			{
				if( $page == $i ) echo "<b>$i</b>&nbsp; ";
				else echo "<a href=$PHP_SELF?page=$i>$i</a>&nbsp; ";
			}
			echo "</p>\n";
			displayThread();
			echo "<small>*<b>Note:</b> delete a topic will also delete all replies under this topic</small>\n";
			echo "
			<p align=center><b>Page:</b>&nbsp; ";
			for( $i = 1; $i <= $totalPages; $i++ )
			{
				if( $page == $i ) echo "<b>$i</b>&nbsp; ";
				else echo "<a href=$PHP_SELF?page=$i>$i</a>&nbsp; ";
			}
			echo "
			</p>
			      </td>
			    </tr>
			  </table>
			  </center>
			</div>
			<hr size=1 color=#808080 width=80%>
			<p align=center><a href=#top>Top</a>";
			displayFooter();
		endif;
	else:
		error( "Fatal error: your don't have permission to perform this action" );
	endif;
	function displayThread( $rootID="", $parentID="" )
	{
		global $initialMsg, $maxThread, $topicID;
		$query = "SELECT rootID, parentID, name, topic, time, ip FROM forum WHERE ";
		if( $parentID == "" ) $query .= "parentID='' ORDER BY time DESC LIMIT $initialMsg, $maxThread";
		else $query .= "parentID=$rootID ORDER BY time DESC";
		$result = mysql_query( $query ) or error( mysql_error() );
		$time = time();
		echo "              <ul>\n";
		while( $row = mysql_fetch_array( $result ) )
		{
			if( $parentID == "" ) $topicID = $row[ 'rootID' ];
			echo "                <li>";
			echo "{$row[ 'topic' ]} - {$row[ 'name' ]}, " . date( "H:i d-m-y", $row[ 'time' ] );
			echo " IP:{$row[ 'ip' ]} [ <a href=delete.php?id=${row[ 'rootID' ]}>Delete</a> ]";
			echo "</li>\n";
			displayThread( $row['rootID'], $row['parentID'] );
		}
		echo "              </ul>\n";
	}
	function deleteThread( $rootID )
	{
		$result = mysql_query( "SELECT rootID, parentID FROM forum WHERE parentID=$rootID" );
		mysql_query( "DELETE FROM forum WHERE rootID=$rootID" ) or error( mysql_error() );
		while( $row = mysql_fetch_array( $result ) )
		{
			deleteThread( $row[ 'rootID' ] );
			mysql_query( "DELETE FROM forum WHERE rootID={$row[ 'rootID' ]}" ) or error( mysql_error() );
		}
	}
?>