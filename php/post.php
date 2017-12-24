<?php 
    session_start();
    require_once('../common.php');
    require_once('../db_conn.php');
    checkIsLogin("../index.php");

	global $DB_NAME, $CONN;
    date_default_timezone_set('Asia/Taipei');
    $filepath = $_POST['filepath'];
    $content = $_POST['content'];
    $datetime = date("Y-m-d H:i:s");
    $author = $_SESSION['account'];
    
    $q1 = "insert into posts (filepath, content, post_datetime, author) values ('$filepath', '$content','$datetime', '$author')";
    if($result = mysql_db_query($DB_NAME, $q1))
    {
    	showMsg('Post successfully!');
    	redirect('/home.php');
    }
    else
    {
    	showMsg('寫入資料時發生錯誤! 22');
    	redirect('/php/post_page.php');
    }

    mysql_close($conn);
?>