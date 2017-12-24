<?php  
    session_start();
    require_once('../common.php');
    require_once('../db_conn.php');
    checkIsLogin("../index.php");

    $post_liker = $_SESSION['account']; // current user
    $post_id = $_POST['post_id'];
    $is_like = $_POST['is_like'];
/*
    print_r("is like :");
    var_dump($is_like);
    exit();*/

	global $DB_NAME, $CONN;


	if($is_like == "true")
	{
		// 取消讚
		$q = "delete from post_likes where post_id = '$post_id' and post_liker = '$post_liker'";
		if($res_del = mysql_db_query($DB_NAME, $q))
		{
	    	showMsg('You cancel the like for this post!');
		}
	    else
	    {
	    	showMsg('寫入資料時發生錯誤!');
	    }
	}
	else
	{
		// 按讚
		$q_like = "insert into post_likes (post_id, post_liker) values ('$post_id', '$post_liker')";
		if($res_insert = mysql_db_query($DB_NAME, $q_like))
		{
			showMsg('You like this post!');
		}
	    else
	    {
	    	showMsg('寫入資料時發生錯誤!');
	    	
	    }
	}
	
    mysql_close($CONN);
    redirect('/home.php');
?>