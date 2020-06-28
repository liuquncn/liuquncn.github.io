<? 
	require( "functions.php" );
	
	dbConnect();
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
	if( $page > $totalPages ) $page = 1;
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
	      [ <a href=#postnew>留言</a> ] [ <a href=search.php>搜索</a> ]
	      [ <a href=admin.php>管理</a> ] [ <a href=$homeURL target=_top>主页</a> ]</td>
	    </tr>
	    <tr>
	      <td width=100% height=1 colspan=2 bgcolor=#808080></td>
	    </tr>
	    <tr>
	      <td width=100% height=20 colspan=2>总共有<b>$totalMsg</b>条留言，<b>$totalThread</b>个话题，, 目前显示的是第<b>$threadStart</b> - <b>$threadEnd</b>个话题</td>
	    </tr>
	  </table>
	  </center>
	</div>
	<div align=center>
	  <center>
	  <table border=0 cellpadding=0 cellspacing=0 width=80%>
	    <tr>
	      <td width=100% height=100%>";
	echo "<p align=center><b>第</b>&nbsp; ";
	for( $i = 1; $i <= $totalPages; $i++ )
	{
		if( $page == $i ) echo "<b>$i</b>&nbsp; ";
		else echo "<a href=$PHP_SELF?page=$i>$i</a>&nbsp; ";
	}
	echo "页</p>\n";
	displayThread();
	echo "
	<p align=center><b>第</b>&nbsp; ";
	for( $i = 1; $i <= $totalPages; $i++ )
	{
		if( $page == $i ) echo "<b>$i</b>&nbsp; ";
		else echo "<a href=$PHP_SELF?page=$i>$i</a>&nbsp; ";
	}
	echo "
	页</p>
	      </td>
	    </tr>
	  </table>
	  </center>
	</div>
	<hr size=1 color=#808080 width=80%>
	<center><h4>留言</h4></center>
	<form method=post action=post.php>
	<input type=hidden name=action value=new>
	<a name=postnew>
	<div align=center>
  	  <center>
  	  <table border=0 cellpadding=0 cellspacing=2 width=580>
    	    <tr>
              <td width=80 height=18><b>题目:</b></td>
              <td width=500 height=18><input type=text name=topic size=50 maxlength=50></td>
            </tr>
            <tr>
              <td width=80 height=18><b>姓名:</b></td>
              <td width=500 height=18><input type=text name=name size=20 maxlength=20></td>
            </tr> 
            <tr>
              <td width=80 height=18><b>邮件:</b></td>
              <td width=500 height=18><input type=text name=email size=20 maxlength=40></td>
            </tr>
            <tr>
              <td width=80><b>内容:</b><small><a href=using_html.php><p>(HTML语法)</a></small><p>&nbsp;<p>&nbsp;<p>&nbsp;</td>
              <td width=500><textarea name=msg rows=10 cols=50 maxlength=2000></textarea></td>
            </tr>
            <tr>
              <td width=80 height=18></td>
              <td width=500 height=18><input type=checkbox name=getmail value=no>回复到上述邮件地址</td>
            </tr>
            <tr>
              <td width=80 height=18></td>
              <td width=500 height=18><input type=submit value=\"    张贴    \"><input type=reset value=\"    清除    \"></td>
            </tr>
          </table>
          </center>
        </div>
        </form>
        <p align=center><a href=#top>页首</a></p>";
        displayFooter();

	/* Recursion procedure displays threads */
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
			echo "                <li>";  // add <br> to separte each thread
			echo "<a href=reply.php?id=${topicID},${row[ 'rootID' ]}>${row[ 'topic' ]}</a> 
			- ${row[ 'name' ]}, <font color=#808080><small>" . strftime( "%c", $row[ 'time' ] ) . "</small></font>";
			if( $time < $row[ 'time' ] + 60 * 60 && $row[ 'ip' ] != "" ) echo " <img align=absmiddle height=12 width=23 border=0 src=new.gif>";
			echo "</li>\n";
			displayThread( $row['rootID'], $row['parentID'] );
			//if( $parentID == "" ) echo "<br>\n";
		}
		echo "              </ul>\n";
	}
?>