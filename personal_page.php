<?php
    session_start();
    require_once('common.php');
    checkIsLogin();
    require_once('db_conn.php');

    function gen_team_opts()
    {
        global $DB_NAME, $CONN;

        $q1 = "select * from team";
        if(!($result = mysql_db_query($DB_NAME, $q1)))
        {
            print_r("資料庫讀取錯誤!");
            exit();
        }
        else
        {
            while($rows = mysql_fetch_array($result))
            {
                echo('<option value='. $rows['id'] .'>'. $rows['team_name'] .'</option>');
            }
        }


        //mysql_close($CONN);
    }

    function show_team_member()
    {
        global $DB_NAME, $CONN;

        $team_id = get_user_team_id();
        if(isset($team_id))  // already belong to one team
        {
            //echo('user id = '.$row_get_team_id['user_id'] . ', team id =' . $row_get_team_id['team_id']);

            $q2 = "select a.account from user as a, team_member as b
                   where b.team_id = '$team_id' and a.id = b.user_id order by b.join_date ASC";
            $res2 = mysql_db_query($DB_NAME, $q2);
            while($rows = mysql_fetch_array($res2))
            {
                echo "<p class=\"team-member\">" . $rows['account'] . "</p>";
            }
        }
        else // doesn't belong to any team
        {
            echo "<p class=\"no-team\">You have no team!</p>";
        }


        //mysql_close($CONN);
    }

    // get the team id what this user belong to
    function get_user_team_id()
    {
        global $DB_NAME, $CONN;

        $account =  $_SESSION['account'];
        $q1 = "SELECT B.* FROM user AS A, team_member AS B
               WHERE A.id = B.user_id AND A.account = '$account'";

        if(!($result = mysql_db_query($DB_NAME, $q1)))
        {
            print_r("資料庫讀取錯誤!");
            exit();
        }

        $row_get_team_id = mysql_fetch_array($result);
        $team_id = $row_get_team_id['team_id'];

        return $team_id;
    }

    function get_team_name($team_id)
    {
        global $DB_NAME, $CONN;

        $q1 = "SELECT team_name FROM team AS A, team_member AS B
               WHERE A.id = B.team_id AND B.team_id = '$team_id'";

        if(!($result = mysql_db_query($DB_NAME, $q1)))
        {
            print_r("資料庫讀取錯誤!");
            exit();
        }

        $row = mysql_fetch_array($result);
        $team_name = $row['team_name'];

        return $team_name;

    }
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>Personal page</title>
    <link rel="stylesheet" href="/css/panel.css">
    <link rel="stylesheet" href="/css/menu.css">
    <link rel="stylesheet" href="/css/btn.css">
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/bootstrap-3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        .btn-submit{
            margin-left: 10px;
        }

        .block-title{
            font-weight: bold;
            font-size: 30px;
            font-family: 標楷體;
        }


        .mybtn{
            background-color: #4CAF50;
            color: white;
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .btnyard {
            font-size: 25px;
            width: 30%;
            height: 50px;
            color: white;
            background-color: #4CAF50;
            border: 2px solid #4CAF50;
        }

        .btnyard:hover {
            color: black;
        }

        .btnboard {
            font-size: 18px;
            width: 30%;
            height: 50px;
            margin-right: 2px;
            position: relative;
            border: 2px solid #008CBA;
            background-color: #008CBA;
            color: white;
        }

        .btnboard:hover {
            color: black;
        }

    </style>
</head>
<body>
    <div class="topnav">
      <a href="/php/logout.php" style=" float: right;">logout</a>
      <p class="navbar-text navbar-right" style="float: right; font-weight: bold;">Hi, <?php print_r($_SESSION['account']); ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
    </div>
    <div style="text-align:center;">
        <div class="main"  style="display: inline-block;">
            <p class="block-title">團隊選擇</p>
            <?php
                $team_id = get_user_team_id();
                if(!isset($team_id)) // have no team , then choose a team
                {
            ?>

                <form id="form" method="post" action="php/select_team.php">
                    <select name="team_id">
                        <option value="">-- 請選擇團隊 --</option>
                        <?php
                            gen_team_opts();
                        ?>
                    </select>
                    <input type="submit" class="btn btn-info btn-submit" value="確定">
                </form>
            <?php

                }
                else
                {
                    $team_name = get_team_name($team_id);
                    echo "<p class=\"team-name\">" . $team_name . "</p>";
                }
            ?>
        </div>

        <div class="main" style="display: inline-block;">
            <p class="block-title">團隊成員</p>
            <?php
                show_team_member();
            ?>

            <button id="btnBoard"class="btn mybtn btnboard">Scrum board</button>
        </div>

        <div>
            <button id="btnYard" class="btn mybtn btnyard">Scrum Yard</button>
        </div>

        <div class="main" style="display: inline-block; width: 50%; height: 200px;">
            <p class="block-title">In progress</p>
        </div>
    </div>

    <script>
        $("#btnYard").click(function(){
            document.location.href = "yard.php";
        });

        $("#btnBoard").click(function(){
            document.location.href = "board.php";
        });
    </script>
</body>
</html>