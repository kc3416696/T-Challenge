<?php 
    session_start();
    require_once('../common.php');
    checkIsLogin("../index.php");
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
	<meta charset="UTF-8">
	<title>Post</title>
    <link rel="stylesheet" href="/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/menu.css">
    <link rel="stylesheet" href="/css/panel.css">
    <link rel="stylesheet" href="/css/btn.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/img_interface.js"></script>
    <style type="text/css">
		span.font-setting
		{
			color: gray;
			font-size: 20px;
			font-weight: bold;
			font-family: cursive;
			display: inline-block;
			height: 10px;
			cursor: default;
		}
    </style>
</head>
<body>
    <div class="topnav">
      <a href="/php/logout.php" style=" float: right;">logout</a>
      <p class="navbar-text navbar-right" style="float: right; font-weight: bold;">Hi, <?php print_r($_SESSION['account']); ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
    </div>
    
	<form method="post" action="/php/post.php">
		<div align="center" id="postBlock" class="main" style="display: none">
			<div align="left" style="margin-top: 10px; width: 95%;">
				<p id="msg"></p>
				<img id="img" src="">
				<div class="write-panel">
					<span class="font-setting"><p>Write a post</p></span>
				</div>
				<input type="text" name="content" class="form-control"><!-- 該篇動態內文 -->
				<br/>
				<input type="submit" class="btn btn-blur btn-post" value="Post">
				<input type="button" class="btn btn-blur btn-cancel" id="cancel" value="Cancel">
				<input type="hidden" name="filepath"> <!-- 該篇動態的 圖片來源路徑 -->
			</div>
		</div>
	</form>
	

	<?php 
		// 上傳的檔案有可能檔名會相同，所以要想辦法解決!   ex: myImg_2017_05_11.jpg (用日期區分後再存入db)

		// 如果一直"重新整理"此頁面，檔案名稱會一樣，導致存入db會有問題產生!

		// 如果沒有選擇任何檔案就按下upload，要做相關判斷

        require_once('../db_conn.php');
        require_once('../common.php');
        upload_file();

        function upload_file()
        {
        	$max_img_size = 85 * 1024; // 檔案容量限制最大為 85KB
			/*$arr_permit_types = array('.jpg', '.png', '.bmp', '.gif', '.tif', '.pcx', '.psd');
			$res = in_array($img_type, $arr_permit_types);*/

			if(isset($_FILES['image'])){
				//$errors= array();
				$img_name = $_FILES['image']['name'];
				$img_size = $_FILES['image']['size'];
				$img_tmp_name = $_FILES['image']['tmp_name']; // 檔案的暫存檔名
				$file_type = $_FILES['image']['type'];
				$is_image = strstr($file_type, "image");
				$extension = "." . pathinfo($img_name, PATHINFO_EXTENSION); // 副檔名

				//print_r($img_tmp_name);
				//exit();

				//print_r("$img_name @ $img_size @ $img_tmp_name @ $img_type");
				
				if($img_size > $max_img_size)
				{
					showMsg("檔案容量限制最大為85KB!");
					redirect("../error.php");
				}
				else if(!$is_image) // 傳入的檔案不是影像檔
				{
					showMsg("只允許上傳圖片檔!");
					redirect("../error.php");
				}
				else
				{
					//date_default_timezone_set('America/Los_Angeles');
					date_default_timezone_set('Asia/Taipei');  // 設定時區
					$today = date("(Y-m-d H_i_s)");
					$target_dir = "../uploads/";
					$target_file = $target_dir . basename($_FILES["image"]["name"], $extension) . $today . $extension; // 存入的檔名為: 原始檔名(y-m-d H:i:s).副檔名
					
					//print_r($target_file);
					//exit();

					if(!is_dir($target_dir)) // 若該資料夾不存在則 新建一個
					{
						mkdir($target_dir, 0777, true);
						//print_r("created! <br>");
					}

					// Check if file already exists
					if (file_exists($target_file)) {
					    echo "Sorry, the file already exists!";
						redirect("../error.php");
					}
					else
					{
						if (move_uploaded_file($img_tmp_name, $target_file)) {
							showPanel($img_name, $target_file);
					    } else {
							showMsg("上傳檔案時發生原因不明的錯誤!");
							//redirect("../error.php");
					    }
					}
				}
			}
			else
			{
				showMsg("上傳檔案時發生原因不明的錯誤!");
				redirect("../error.php");
			}
        }

		function showPanel($img_name, $target_file)
        {
        	$divId = "postBlock";
        	$msgId = "msg";
        	$file_id = $_POST["file_id"];
        	$img_id = "img";
        	$replace_time = 1; // only replace once
        	$filepath = str_replace("../", "/", $target_file, $replace_time);
        	//print_r("The \"filepath\" be saved to DB is: ". $filepath);

			$upload_suc_msg = "您所上傳的檔案已儲存進入資料庫<br>檔案名稱: " . $img_name;
        	echo '<script type="text/javascript">';
			echo 'document.getElementById("'. $divId .'").style.display="block";';
			echo 'document.getElementById("'. $msgId .'").innerHTML="' . $upload_suc_msg . '";';
			echo 'document.getElementById("'. $img_id .'").src = "' . $target_file . '";';
            echo 'document.getElementsByName("filepath")[0].value = "'. $filepath .'";';
			echo '</script>';

        	echo $str;
        }
	?>

	<script type="text/javascript">
		var cancel = document.getElementById("cancel");
		var img = document.getElementById("img");
		cancel.onclick = function(){
			history.back();
		}

		img.onclick = function(){
			window.open(this.src);
		}
	</script>
	</body>
</html>