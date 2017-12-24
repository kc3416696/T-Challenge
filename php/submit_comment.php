<?php  
	session_start();
	require_once('../common.php');
	require_once('../db_conn.php');
    global $DB_NAME, $CONN;

	$account = $_SESSION['account'];
	$reply_msg = $_POST['reply'];
	$post_id = $_POST['post_id'];
	date_default_timezone_set('Asia/Taipei');
    $reply_time = date("Y-m-d H:i:s");

	$q1 = "insert into post_comments (post_id, commenter, content, comm_time) 
	values ('$post_id', '$account', '$reply_msg', '$reply_time')";

	if($result = mysql_db_query($DB_NAME, $q1))
	{
		showMsg('Submit message successfully!');
    	redirect('/home.php');
	}
    else
    {
    	showMsg('寫入資料時發生錯誤! 28');
    }


	mysql_close($CONN);
	redirect('/home.php');

?>