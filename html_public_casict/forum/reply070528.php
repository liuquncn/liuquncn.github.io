<?
	require( "functions.php" );
	if( !isset( $id ) ) error( "Invaild page 'reply.php' call" );
	$ids = explode( ",", $id );
	dbConnect();
	$result = mysql_query( "SELECT rootID, name, email, topic, msg, time, ip FROM forum WHERE rootID=${ids[ 1 ]}" ) or error( mysql_error() );
	$row = mysql_fetch_array( $result );
	unset( $result );
	$result = mysql_query( "SELECT rootID, topic, name, time, ip FROM forum WHERE rootID>${ids[ 0 ]} && parentID='' && ip !=''  LIMIT 1" ) or error( mysql_error() );
	$previousRow = mysql_fetch_row( $result );
	unset( $result );
	$result = mysql_query( "SELECT rootID, topic, name, time, ip FROM forum WHERE rootID<${ids[ 0 ]} && parentID='' && ip != '' ORDER BY time DESC LIMIT 1" ) or error( mysql_error() );
	$nextRow = mysql_fetch_row( $result );
	unset( $result );
	displayHeader( $forumTitle );
	echo "
	<div align=center>
	  <center>
	  <table border=0 cellpadding=0 cellspacing=0 width=80%>
	    <tr>
	      <td align=right width=100% height=20>
	      [ <a href=forum.php#postnew>New Topic</a> ] [ <a href=forum.php>Thread Index</a> ]
	      [ <a href=search.php>Search</a> ] [ <a href=$homeURL>$homeTitle</a> ]</td>
	    </tr>
	    <tr>
	      <td width=100% height=1 bgcolor=#808080></td>
	    </tr>
	  </table>
	  </center>
	</div>
	<div align=center>
	  <center>
	  <table border=0 cellpadding=0 cellspacing=0 width=80%>
	    <tr>
	      <td><br><b>Topic:</b> {$row[ 'topic' ]}<br>
	      <b>Posted by:</b> <a href=mailto:{$row[ 'email' ]}>{$row[ 'name' ]}</a> at " . strftime( "%c", $row[ 'time' ] ) . "<br>
	      <b>Message:</b>
	      <p>{$row[ 'msg' ]}</p>";
	      echo $row[ 'ip' ] != "" ? "<p align=left>[ <a href=#reply>Reply to this</a> ]</p>" : "";
	displayThread( $ids[ 0 ] );
	if( $previousRow != "" ) echo "
	      &lt;&lt; Previous topic:&nbsp; <a href=$PHP_SELF?id={$previousRow[ 0 ]},{$previousRow[ 0 ]}>{$previousRow[ 1 ]}</a>
	      - {$previousRow[ 2 ]}, <font color=#808080><small>" . strftime( "%c", $previousRow[ 3 ] ) . "</small></font></small><br>";
	if( $nextRow != "" ) echo "
	      &gt;&gt; Next topic:&nbsp; <a href=$PHP_SELF?id={$nextRow[ 0 ]},{$nextRow[ 0 ]}>{$nextRow[ 1 ]}</a>
	      - {$nextRow[ 2 ]}, <font color=#808080><small>" . strftime( "%c", $nextRow[ 3 ] ) . "</small></font></td>";
	echo "
	    </tr>
	  </table>
	  </center>
	</div>
	<hr size=1 color=#808080 width=80%>";
	if( $row[ 'ip' ] == "" ) displayFooter();
	echo "
	<a name=reply>
	<center><h4>Reply to this</h4></center>
	<form method=post action=post.php>
	<input type=hidden name=action value=reply>
	<input type=hidden name=id value=\"${ids[ 0 ]},{$row[ 'rootID' ]}\">
	<div align=center>
	  <center>
	  <table border=0 cellpadding=0 cellspacing=2 width=580>
	    <tr>
	      <td width=80 height=18><b>Topic:</b></td>
	      <td width=500 height=18><input type=text name=topic value=\"RE: {$row[ 'topic' ]}\" size=50 maxlength=50></td>
	    </tr>
	    <tr>
	      <td width=80 height=18><b>Name:</b></td>
	      <td width=500 height=18><input type=text name=name size=20 maxlength=20></td>
	    </tr> 
	    <tr>
	      <td width=80 height=18><b>E-mail:</b></td>
	      <td width=500 height=18><input type=text name=email size=20 maxlength=40></td>
	    </tr>
	    <tr>
	      <td width=80><b>Message:</b><br><small><a href=using_html.php>(using HTML)</a></small><p>&nbsp;<p>&nbsp;<p>&nbsp;</td>
	      <td width=500><textarea name=msg rows=10 cols=50 maxlength=2000></textarea></td>
	    </tr>
           <tr>
              <td width=80 height=18></td>
              <td width=500 height=18><input type=checkbox name=getmail value=yes checked>Sent replies to the e-mail address above</td>
            </tr>	    
	    <tr>
	      <td width=80 height=18></td>
	      <td width=500 height=18><input type=submit value=\"    Post    \"><input type=reset value=\"    Clear    \"></td>
	    </tr>
	  </table>
	  </center>
	</div>
        </form>
        <p align=center><a href=#top>Top</a></p>";
	displayFooter();
	
	function displayThread( $rootID, $parentID="" )
	{
		global $topicID, $ids;
		$query = "SELECT rootID, parentID, name, topic, time FROM forum WHERE ";
		if( $parentID == "" ) $query .= "rootID=$rootID";
		else $query .= "parentID=$rootID ORDER BY time ASC";
		$result = mysql_query( $query ) or error( mysql_error() );
		$time = time();
		echo "              <ul>\n";
		while( $row = mysql_fetch_array( $result ) )
		{
			if( $parentID == "" ) $topicID = $row[ 'rootID' ];
			if( $row[ 'rootID' ] == $ids[ 1 ] ) echo "                <li><b>${row[ 'topic' ]}</b>";
			else echo "                <li><a href=reply.php?id=${topicID},${row[ 'rootID' ]}>${row[ 'topic' ]}</a>";
			echo " - ${row[ 'name' ]}, <font color=#808080><small>" . strftime( "%c", $row[ 'time' ] ) . "</small></font></small></li>\n";
			displayThread( $row['rootID'], $row['parentID'] );
		}
		echo "              </ul>\n";
	}
