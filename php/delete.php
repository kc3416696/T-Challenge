<?php  
	session_start();
	require_once('../common.php');
	require_once('../db_conn.php');
    global $DB_NAME, $CONN;

	$account = $_SESSION['account'];
	$post_id = $_POST['post_id'];

	$q1 = "delete from posts where id = '$post_id'";

	if($result = mysql_db_query($DB_NAME, $q1))
	{
		showMsg('This post was deleted successfully!');
	}
    else
    {
    	showMsg('寫入資料時發生錯誤! 28');
    }

	mysql_close($CONN);
	redirect('/home.php');
?>