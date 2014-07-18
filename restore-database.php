<?php
/**
 * PHP Restore MySQL Database
 */

$key = 'yourpassword';

$credential['host']	= "localhost";
$credential['user']	= "root";
$credential['passwd'] 	= "root";
$credential['dbName'] 	= "wordpress-tutorial";
$credential['dumpdir'] 	= "/home/haris/Downloads/wordpress-tutorial.sql";

$mysqli = new mysqli($credential['host'],$credential['user'],$credential['passwd'],$credential['dbName']);

if($mysqli->connect_errno)
{
	echo "Connection failed: %s\n".$mysqli->connect_errno;
	exit();
}
else
{
	if(isset($_GET['key']) && $_GET['key'] == $key)
	{
		restore_now();
	}
}

/**
 * Functions
 */
function restore_now()
{
	drop_all_tables();
	restore_database();

	echo "Restore database finished!";
}

function drop_all_tables()
{	
	global $mysqli;

	$mysqli->query('SET foreign_key_checks = 0') or die($mysqli->error);

	if ($result = $mysqli->query("SHOW TABLES"))
	{
	    while($row = $result->fetch_array(MYSQLI_NUM))
	    {
	        $mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
	    }
	}

	$mysqli->query('SET foreign_key_checks = 1');
}

function restore_database()
{
	global $credential;
	
	system("mysql -u{$credential['user']} -p{$credential['passwd']} {$credential['dbName']} < {$credential['dumpdir']}");
}
