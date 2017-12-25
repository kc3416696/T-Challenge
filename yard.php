<?php
    session_start();
    require_once('common.php');
    checkIsLogin();
    require_once('db_conn.php');

?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
	<meta charset="UTF-8">
	<title>My Scrum yard</title>

    <link rel="stylesheet" href="/css/menu.css">
    <link rel="stylesheet" href="/css/background.css">
    <style type="text/css">
    	.center-screen {
		    margin: 0;
		    position: absolute;
		    top: 50%;
		    left: 50%;
		    margin-right: -50%;
		    transform: translate(-50%, -50%)
		}

		button{
            cursor: pointer;
			font-size: 25px;
		}

		button.ground{
			width: 150px;
			height: 150px;
		}

		.body-content{
		  margin-top: 50px;
		}

        #user{
            cursor: pointer;
        }

    </style>
</head>
<body>
    <div class="topnav">
      <a href="/php/logout.php" style=" float: right;">logout</a>
      <p class="navbar-text navbar-right" style="float: right; font-weight: bold;">Hi, <?php print_r($_SESSION['account']); ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
    </div>
    <div class="body-content">
    	<table class="center-screen">
			<tr>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
			</tr>
			<tr>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
			</tr>
			<tr>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
				<td><button class="ground">Put item</button><br></td>
			</tr>
		</table>
		<div align="right" style="margin-right: 10px;">
			<b style=" display:inline;">可使用的點數:</b>
			<input type="text" value="0" style="width:20px;">
			<img id="user" src="./imgs/user.png" width="100px" height="100px">
			<br>
			<button><img src="./imgs/soil.png" width="100px" height="100px"></button><br>
			<button><img src="./imgs/seed.png" width="100px" height="100px"></button><br>
			<button><img src="./imgs/kitten.png" width="100px" height="100px"></button><br>
			<button><img src="./imgs/puppy.png" width="100px" height="100px"></button><br>
			<button><img src="./imgs/1157fc84df19d69.png" width="100px" height="100px"></button><br>
			<button style="width:115px; height:100px;">Grow</button><br>


		</div>
    </div>
    <script type="text/javascript">
        document.getElementById("user").onclick = function(){
            document.location.href = "personal_page.php";
        }
    </script>
</body>
</html>
