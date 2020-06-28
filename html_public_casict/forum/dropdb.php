<?php
	require( "functions.php" );
	session_start();
	if( session_is_registered( "name" ) && session_is_registered( "passwd" ) &&
	$name == $adminName && $passwd == $adminPasswd ):
		if( isset( $action ) ):
			if( $action == "drop" ):
				$dbLink = mysql_connect( $dbHost, $dbUser, $dbPasswd );
				mysql_drop_db( $dbName, $dbLink ) or error( mysql_error() );
				displayHeader( "Database droped" );
				echo "<center><h4>Database has been droped</h4></center>";
				echo "<p align=center><a href=admin.php>Back to admin</a></p>";
				displayFooter();
			endif;
		else:
			displayHeader( "Are you sure" );
			echo "<center><h4>Are you sure want to drop database?</h4></center>\n";
			echo "<p align=center><a href=dropdb.php?action=drop>Yes</a>&nbsp | &nbsp;" .
			"<a href=admin.php>No</a>\n";
			displayFooter();
		endif;
	else:
		error( "Fatal error, you don't have permission to perform this action" );
	endif;
?>