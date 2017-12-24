<?php 
	session_start();
	$AVOID_CHARS = array(" ", "<", "/", ">", "|","\"", "\\", "+", "-", "%", "^", "&", "*", "(", ")", "=", ",", "$"); // 要被移除掉的一些字元 (避免遭受攻擊)

	/*
	function reload()
	{
		echo '<script type="text/javascript">window.location.reload();</script>';
	}*/

	function redirect($url){
		echo '<script type="text/javascript">window.location.href = "'. $url .'";</script>';
	}

	function redirectToLogin()
	{
		redirect("/index.php");
	}

	function showMsg($msg)
	{
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}

	// 檢查字串值是否包含不合法字元 
	function is_field_illegal($array)
	{
		global $AVOID_CHARS;
		//print_r($AVOID_CHARS);
		//exit();

		foreach ($array as $value) {
			$new_val = str_replace($AVOID_CHARS, '', $value);
			//print_r("$value / $new_val<br>");

			if($value != str_replace($AVOID_CHARS, '', $new_val))
			{
				return true;
			}

		}
		return false;
	}

	// 檢查使用者是否為登入狀態
	// home, post, and others  未登入 => index.php  ,  已登入 => 不做事
	// index　　　　　　　     已登入 => home.php   ,　未登入 => 不做事
	function checkIsLogin($URL = "index.php", $is_index_page = false)
	{
		$has_session = isset($_SESSION['account']);
		/*
		print_r($URL);
		print_r(" / ");
		var_dump($is_index_page);
		print_r("<br>");
		print_r(" / ");
		var_dump($has_session);
		print_r("<br>");*/

		// 已登入，且在index頁面           or 　未登入，且不在index頁面
		if(($has_session && $is_index_page) || (!$has_session && !$is_index_page)) 
		{
				redirect($URL);
		}
	}
?>
	


