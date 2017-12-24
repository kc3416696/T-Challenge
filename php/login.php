<?php
	session_start();
    $cookie_name = 'account';
    $cookie_val = $_POST[$cookie_name];
    setcookie($cookie_name, $cookie_val, time() + 86400 * 30, "/");
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
</head>
<body>
	<?php
		require_once('../db_conn.php');
		require_once('../common.php');
		global $DB_NAME, $CONN;

		$account = $_POST['account'];
		$pwd = $_POST['pwd'];
		$arr = array($account, $pwd);

		if(is_field_illegal($arr))
		{
			showMsg("輸入的欄位不應包含非法字元!");
			redirectToLogin();
			exit();
		}

		if($account != null && $pwd != null)
		{
			$q1 = "select * from user where account='$account'";
			if(!($result = mysql_db_query($DB_NAME, $q1)))
			{
				print_r("資料庫讀取錯誤!");
				exit();
			}
			else
			{
				if(!($row = mysql_fetch_array($result)))
				{
					showMsg("此帳號不存在!");
				}
				else
				{
					$correct_pwd = $row['pwd'];
					if($pwd != $correct_pwd)
					{
						showMsg("密碼錯誤，請重新輸入!");
					}
					else // login successfully
					{
						//showMsg("登入成功!");
						save_login_info($account);
						$_SESSION['account'] = $account;// 註冊 Session
						redirect("../personal_page.php");
					}
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
		}

		// save login information (include ip and login time)
		function save_login_info($account){
			global $DB_NAME, $CONN;
    		date_default_timezone_set('Asia/Taipei');
    		$login_time = date("Y-m-d H:i:s");

			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			   $client_ip = $_SERVER['HTTP_CLIENT_IP'];
			}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			   $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
			   $client_ip= $_SERVER['REMOTE_ADDR'];
			}

			$q_save = "update user set ip = '$client_ip', login_time = '$login_time' where account = '$account';";
			if(!($res = mysql_db_query($DB_NAME, $q_save)))
			{
				showMsg('登入時發生問題! 95');
    			redirect('/php/error.php');
    			exit();
			}
		}

		redirectToLogin();
		mysql_close($CONN);
	?>
</body>
</html>