<?php 
	session_start();
	require_once('../common.php');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
	<meta charset="UTF-8">
	<title>logout</title>
    </style>
</head>
<body>
	<?php  
		$has_session = isset($_SESSION['account']);
		/*print_r("Session status: ");
		var_dump($has_session);
		print_r("<br>");*/
		if($has_session) // logout
		{
			//print_r("has session<br>");
			unset($_SESSION['account']);
			//print_r("session be cleared now!<br>");
			
		}

		redirectToLogin();

		/*
		unset($_SESSION['變數名稱']); // 單獨刪除某一個session
		session_destroy(); //刪除全部的session  // 銷毀現有的 Session連線紀錄
		session_unset(); // 清除所有已登記的 Session 變數
		*/
		
	?>
</body>
</html>