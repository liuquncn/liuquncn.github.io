<?
	require( "functions.php" );
	session_start();
	if( session_is_registered( "name" ) && session_is_registered( "passwd" ) &&
	$name == $adminName && $passwd == $adminPasswd ):
		$dbLink = mysql_connect( $dbHost, $dbUser, $dbPasswd );
		mysql_create_db( $dbName, $dbLink );
		mysql_select_db( $dbName );
	
		$query1 = "CREATE TABLE forum
		(
			rootID SMALLINT UNSIGNED NOT NULL auto_increment,
			parentID SMALLINT UNSIGNED NOT NULL DEFAULT '',
			name TEXT NOT NULL,
			email VARCHAR(40) NOT NULL,
			topic TEXT NOT NULL,
			msg TEXT NOT NULL,
			time INT NOT NULL,
			ip VARCHAR(15) NOT NULL,
			getmail VARCHAR(1) NOT NULL,
			PRIMARY KEY(rootID)
		)";
		$query2 = "CREATE TABLE badwords
		(
			id SMALLINT UNSIGNED NOT NULL auto_increment,
			word TEXT NOT NULL,
			PRIMARY KEY(id)
		)";
		$query3 = "CREATE TABLE bannedip
		(
			id SMALLINT UNSIGNED NOT NULL auto_increment,
			ip VARCHAR(15) NOT NULL,
			PRIMARY KEY(id)
		)";
		
		mysql_query( $query1 ) or error( mysql_error() );
		mysql_query( $query2 ) or error( mysql_error() );
		mysql_query( $query3 ) or error( mysql_error() );
		
		displayHeader( "Database created" );
		echo "<center><h4>Database has been created</h4></center>";
		echo "<p align=center><a href=admin.php>Back to admin</a></center></p>";
		mysql_close( $dbLink );
		displayFooter();
	else:
		error( "Fatal error, you don't have permission to perform this action" );
	endif;
?>