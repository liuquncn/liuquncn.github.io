<?
	require( "functions.php" );
	displayHeader( "Keyword Search" );
	echo "
	<center><h4>Keyword Search</h4></center>
	<center>
	<form method=post action=search.php>
	<table border=0 cellpadding=0 cellspacing=0>
	  <tr>
	    <td>Enter Keyword:
	    <input type=text name=keyword size=20 maxlength=20>
	    <input type=submit value=Search></td>
	  </tr>
	</table>
	</form>
	</center>";
	if( isset( $keyword ) )
	{
		$keyword = trim( $keyword );
		if( strlen( $keyword ) == 1 ) $keyword = "";
		if( $keyword != "" )
		{
			dbConnect();
			$result = mysql_query( "SELECT rootID, parentID, topic, name, time, msg FROM forum WHERE
			topic LIKE '%$keyword%' || msg LIKE '%$keyword%' || name LIKE '%$keyword%' ORDER BY time DESC" );
			$foundNum = mysql_num_rows( $result );
			$keyword = stripslashes( $keyword );
			echo "
			<center>
			<table border=0 cellpadding=0 cellspacing=0 width=80%>
			  <tr>
			    <td width=100% height=20 colspan=2><small>Found <b>$foundNum</b> match keyword '$keyword'</small></td>
			  </tr>
			  <tr>
			    <td width=100% height=1 bgcolor=#808080 colspan=2></td>
			  </tr>";
			$i = 1;
			while( $row = mysql_fetch_array( $result ) )
			{
				if( $row[ 'parentID' ] == 0 ) $id = "{$row[ 'rootID' ]},{$row[ 'rootID' ]}";
				else $id = findRootID( $row[ 'parentID' ] ) . ",{$row[ 'rootID' ]}";
				$row[ 'topic' ] = eregi_replace( $keyword, "<b>$keyword</b>", $row[ 'topic' ] );
				$row[ 'msg' ] = eregi_replace( $keyword, "<b>$keyword</b>", $row[ 'msg' ] );
				$row[ 'name' ] = eregi_replace( $keyword, "<b>$keyword</b>", $row[ 'name' ] );
				echo "
				<tr>
				  <td width=3% height=20><b>$i.</b></td>
				  <td width=97% height=20><a href=reply.php?id=$id>{$row[ 'topic' ]}</a> by {$row[ 'name' ]} <font color=#808080><small>- " .
				  strftime( "%c", $row[ 'time' ] ) . "</small></font></td>
				</tr>
				<tr>
				  <td width=3% height=20></td>
				  <td width=97% height=20>{$row[ 'msg' ]}</td>
				</tr>";
				$i++;
			}
			echo "
			  <tr>
			    <td width=100% height=1 bgcolor=#808080 colspan=2>
			  </tr>
			  </tr>
			</table>
			</center>";
		}
	}
	echo "
	<p align=center><a href=forum.php>Thread Index</a>&nbsp; |&nbsp; <a href=javascript:history.back()>Back</a></p>";
	displayFooter();
	function findRootID( $parentID )
	{
		$result = mysql_query( "SELECT rootID, parentID FROM forum WHERE rootID=$parentID" );
		if( !$result ) {
			return $parentID;
			exit;
		}
		$row = mysql_fetch_row( $result );
		findRootID( $row[ 1 ] );
		return $row[ 0 ];
	}	
?>