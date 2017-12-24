<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
</head>
<body>
	<?php
		require_once('../db_conn.php');
		global $DB_NAME, $CONN;


		$pwd_length_limit = 8; // 密碼長度限制

		$account = $_POST['account'];
		$pwd = $_POST['pwd'];
		$confirm_pwd = $_POST['confirm_pwd'];

		$arr = array($account, $pwd, $confirm_pwd);
		//print_r($account . " / " . $pwd . " / ". $confirm_pwd ." / ");
		//exit();

		/*
		// test - 過濾非法字元
		global $AVOID_CHARS;
		$a = str_replace($AVOID_CHARS, '', $account);
		print_r($a);
		exit();
		*/

		if(is_field_illegal($arr))
		{
			showMsg("輸入的欄位不應包含非法字元!");
			redirectToLogin();
			exit();
		}

		if($account != null && $pwd != null && $confirm_pwd != null && $pwd == $confirm_pwd)
		{
			// 先檢查此帳號是否已存在
			$sql = "SELECT * FROM user WHERE account = '$account'";
			if(!($result = mysql_db_query($DB_NAME, $sql)))
			{
				print_r("資料庫讀取錯誤!");
				exit();
			}
			else
			{
				if(mysql_num_rows($result) == 0)
				{
					// add a new user
					$q1 = "insert into user (account, pwd) values ('$account', '$pwd')";
					if($result = mysql_db_query($DB_NAME, $q1)){
						showMsg("Registered successfully!");
					}
					else
					{
						print_r("新增資料失敗!");
						exit();
					}
				}
				else
				{
					showMsg("此帳號已存在! 請改用別組帳號!");
				}
			}
		}
		else
		{
			if($account == null || $account == "")
			{
				showMsg("請輸入帳號！");
			}
			else if($pwd == null || $pwd == "")
			{
				showMsg("請輸入密碼！");
			}
			else if($confirm_pwd == "")
			{
				showMsg("請輸入確認密碼！");
			}
			else if($pwd != $confirm_pwd){
					showMsg("兩次輸入的密碼不相同，請重新輸入!");
			}
		}

		redirectToLogin();
		mysql_close($CONN);


	?>


</body>
</html>


