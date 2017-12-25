<?php
    session_start();
    require_once('common.php');
    checkIsLogin();
    require_once('db_conn.php');

?>


<!DOCTYPE html>
<html>
<head>
	<title>Team scrum board</title>
    <link rel="stylesheet" href="/css/menu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
	.task{
		display: inline-block;
		border :2px solid black;
		width  : 100px;
		height :50px;
		background: yellow;
		position: relative;
	}
	.time{
		position: absolute;
		bottom: 0;
		right: 0;
	}

	.body-content{
	  margin-top: 50px;
	}

</style>

<body>
    <div class="topnav">
		<a href="/php/logout.php" style=" float: right;">logout</a>
		<p class="navbar-text navbar-right" style="float: right; font-weight: bold;">Hi, <?php print_r($_SESSION['account']); ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
    </div>

    <div class="body-content">
	    <table border="1" style="background: lightgray">
			<tr>
				<th>Stories</th>
				<th>To Do</th>
				<th>In Progress</th>
				<th>Verify</th>
				<th>Done</th>
			</tr>
			<tr>
				<td id="td1" style="width: 500px;height: 150px;"  ondrop="Drop(event)" ondragover="AllowDrop(event)"></td>
				<td id="td1" style="width: 500px;height: 150px;"  ondrop="Drop(event)" ondragover="AllowDrop(event)"></td>
				<td id="td1" style="width: 500px;height: 150px;"  ondrop="Drop(event)" ondragover="AllowDrop(event)"></td>
				<td id="td2" style="width: 500px;height: 150px;"  ondrop="Drop(event)" ondragover="AllowDrop(event)"></td>
				<td id="td3" style="width: 500px;height: 150px;"  ondrop="Drop(event)" ondragover="AllowDrop(event)"></td>
			</tr>
		</table>


		<div id="pool" style="width: 100%;height: 250px; border:1px solid black;" ondrop="Drop(event)" ondragover="AllowDrop(event)">

		</div>
		<div>
			<h1>New Task</h1>
			<textarea id="taskText" rows="4" cols="20"></textarea><br>
			時數:<input type="number" min="1" max="10" value="2" id="taskTime" width="3px">hr
		</div>
		<button onclick="addtest()">add task</button>

    </div>


<script src="/js/number_setting.js"></script>
<script type="text/javascript">

var id = 0;

function AllowDrop(event){
    event.preventDefault();
}
function Drag(event){
    event.dataTransfer.setData("text",event.currentTarget.id);
}
function Drop(event){
    event.preventDefault();
    var data=event.dataTransfer.getData("text");
    event.currentTarget.appendChild(document.getElementById(data));
}
function addtest(){
	var newElement = document.createElement('div');
	var newText = document.createTextNode(document.getElementById("taskText").value);
	//alert(document.getElementById("task").value);
	id+=1;
	newElement.id = 'img'+id;
	newElement.draggable="true";
	newElement.className = 'task';
	newElement.setAttribute('ondragstart','Drag(event)');
	newElement.appendChild(newText);
	document.getElementById("pool").appendChild(newElement);

	var newElementTime = document.createElement('div');
	var newTextTime = document.createTextNode(document.getElementById("taskTime").value+"hr");
	newElementTime.className = 'time';
	newElementTime.style.color="red";

	newElementTime.appendChild(newTextTime);
	newElement.appendChild(newElementTime);


}



</script>

</body>
</html>