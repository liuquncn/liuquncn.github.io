<?
	require( "functions.php" );
	dbConnect();
	$bUpdate=true;
	$ip = $REMOTE_ADDR;
	if( $banIP == 1 )
	{
		$result = mysql_query( "SELECT ip FROM bannedip WHERE ip='$ip'" ) or error( mysql_error() );
		if( mysql_num_rows( $result ) >= 1 ) error( "Sorry, Our message board is currently being updated, please come back later" );
	}
	if( !isset( $action ) ) error( "Invaild page 'post.php' call" );
	$topic = trim( $topic );
	$name = trim( $name );
	$email = trim( $email );
	$msg = trim( $msg );
	if( $topic == "" ) 
	{
		error( "Topic required" );
		$bUpdate=false;
	}
	else $topic = textFilter( $topic );
	if( $topic == "" ) 
	{
		error( "Invalid topic" );
		$bUpdate=false;
	}
	if( $name == "" ) 
	{
		error( "Name required" );
		$bUpdate=false;
	}
//	elseif( !eregi( "[a-z0-9].", $name ) ) 
//	{
//		error( "Invaild name" );
//		$bUpdate=false;
//	}
	else $name = textFilter( $name );
	if( $name == "" ) 
	{
		error( "Invalid name" );
		$bUpdate=false;
	}
	if( $email == "" ) 
	{
		error( "E-mail required" );
		$bUpdate=false;
	}
	elseif( !eregi( "^([._a-z0-9-]+[._a-z0-9-]*)@(([a-z0-9-]+\.)*([a-z0-9-]+)(\.[a-z]{2,3})?)$", $email ) )
	{
		error( "Invaild E-mail" );
		$bUpdate=false;
	}
	else $email = textFilter( $email );
	if( $msg == "" ) 
	{
		error( "Message content required" );
		$bUpdate=false;
	}
	else $msg = enableHTML( textFilter( $msg ) );
	if( $msg == "" ) 
	{
		error( "Invalid message content" );
		$bUpdate=false;
	}
	$msg = wordwrap( $msg, 75, "<br>" );
	function textFilter( $str )
	{
		global $badWordFilter;
		$str = htmlspecialchars( $str );
		if( $badWordFilter == "1" ) {
			$result = mysql_query( "SELECT word FROM badwords" ) or error( mysql_error() );
			while( $row = mysql_fetch_array( $result ) )
				$str = eregi_replace( $row['word'], "", $str );
		}
		return $str;
	}
	function enableHTML( $str )
	{
		$str = eregi_replace( "\\[b\\]([^\\[]*)\\[/b\\]", "<b>\\1</b>", $str );
		$str = eregi_replace( "\\[u\\]([^\\[]*)\\[/u\\]", "<u>\\1</u>", $str );
		$str = eregi_replace( "\\[i\\]([^\\[]*)\\[/i\\]", "<i>\\1</i>", $str );
		$str = eregi_replace( "\\[code\\]([^\\[]*)\\[/code\\]", "<code>\\1</code>", $str );
		$str = eregi_replace( "\\[color=([^\\[]*)\\]([^\\[]*)\\[/color\\]", "<font color=\\1>\\2</font>", $str );
		$str = eregi_replace( "\\[url=([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"\\1\" target=\"_blank\">\\2</a>", $str );
		$str = eregi_replace( "\\[img\\]([^\\[]*)\\[/img\\]", "<img src=\"\\1\" border=0>", $str );
		$str = eregi_replace( "\\[email\\]([^\\[]*)\\[/email\\]", "<a href=\"mailto:\\1\">\\1</a>", $str );
		$str = eregi_replace( "\\[marquee\\]([^\\[]*)\\[/marquee\\]", "<marquee>\\1</marquee>", $str );

		return $str;
	}
	$time = time();
	$query = "INSERT INTO forum ( name, email, ip, time, topic, msg, getmail";
	if( isset( $action ) && $bUpdate)
	{
		if( isset( $getmail ) ) $getmail = "y";
		else $getmail = "n";
		if( $action == "new" )
			$query .= " ) VALUES ( '$name', '$email', '$ip', '$time', '$topic', '$msg', '$getmail' )";
		elseif( $action == "reply" && isset( $id ) ) {
			$ids = explode( ",", $id );
			$query .= ", parentID ) VALUES ( '$name', '$email', '$ip', '$time', '$topic', '$msg', '$getmail', '${ids[ 1 ]}' )";
		}
		$result = mysql_query( $query ) or error( mysql_error() );
		$newID = mysql_insert_id();
		if( $action == "new" ) $backID = "$newID,$newID";
		elseif( $action == "reply" ) {
			$backID = "${ids[ 0 ]},$newID";
			$mail = mysql_query( "SELECT getmail, email FROM forum WHERE rootID='${ids[ 1 ]}'" ) or error( mysql_error() );
			$mailResult = mysql_fetch_row( $mail );
			$name = stripslashes( $name );
			$topic = stripslashes( $topic );
			$msg = stripslashes( $msg );
			if( $mailResult[ 0 ] == 'y' )
			{
			        $header = "MIME-Version: 1.0\r\n";
			        $header .= "Content-Type: text/html; charset=iso-8859-1\r\n";
			        $header .= "From: $name<$email>\r\n";
				$subject = "From: $forumTitle - $topic";
				$body = "<font face=$fontFamily size=2><b>Topic:</b> $topic - <a href=mailto:$email>$name</a> " . strftime( "%c", $time ) . "<br><br>";
				$body .= "$msg<br><br>";
				$body .= "____________________________________________________________<br>";
				$body .= "Response here: <a href=${replyURL}?id=$backID target=_blank>${replyURL}?id=$backID</a></font>";
				@mail( $mailResult[ 1 ], $subject, $body, $header );
			}
			if( $emailAdmin == 1 )
			{
				$header = "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$header .= "From: $name<$email>\r\n";
				$subject = "You have a new posting in your $forumTitle";
				$body = "<font face=$fontFamily size=2><b>Topic:</b> $topic - <a href=mailto:$email>$name</a> " . strftime( "%c", $time ) . "<br><br>";
				$body .= "$msg<br><br>";
				$body .= "____________________________________________________________<br>";
				$body .= "Response here: <a href=${replyURL}?id=$backID target=_blank>${replyURL}?id=$backID</a></font>";
				@mail( $adminEmail, $subject, $body, $header );
			}
		}

	}
	if( $result )
	{
		$name = stripslashes( $name );
		$topic = stripslashes( $topic );
		$email = stripslashes( $email );
		$msg = stripslashes( $msg );
		displayHeader( "Your message has been posted successfully!" );
		echo "
		<hr size=1 color=#808080 width=80%>
		<center><h4><font color=#FF0000>Thank you! Your message has been posted successfully!</font></h4></center>";
		echo "
		<div align=center>
		  <center>
	  	  <table border=0 cellpadding=0 cellspacing=0 width=80%>
	  	    <tr>
	  	      <td><b>Topic:</b> $topic<br>
	  	      <b>Posted by:</b> $name&nbsp; &nbsp; <b>E-mail:</b> $email&nbsp &nbsp; <b>Date:</b> " .
	  	      strftime( "%c", $time ) . "&nbsp &nbsp; <b>IP:</b> $ip <small>*won't be shown</small><br>
	  	      <b>Message:</b>
	  	      <p>$msg</p></td>
	  	    </tr>
	  	  </table>
	  	  </center>
	  	</div>
	  	<p>&nbsp;</p>
		<p align=center><a href=reply.php?id=$backID>View</a>&nbsp; | &nbsp;<a href=forum.php>Thread Index</a></p>";
		displayFooter();
	}
?>
