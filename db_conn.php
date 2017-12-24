<?php
require_once('common.php');

$DB_NAME = 'scrum_yard';
$ACCOUNT = 'root';
$PWD = 'qaz85231';

if(!($CONN = mysql_connect('localhost:3306', $ACCOUNT, $PWD)))
{
	redirect("../error.php");
	die();
	//die('<br>Connected to db failed: ' . mysql_error());
}

/*
// error testing
if(!($CONN = mysql_connect('localhost:3306', 'notExistAccount', $PWD)))
{
	redirect("../error.php");
	die('<br>Connected to db failed: ' . mysql_error());
}
*/


//mysql_close($conn);


?>