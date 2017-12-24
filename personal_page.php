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

        mysql_close($CONN);
    }
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>Personal page</title>
    <link rel="stylesheet" href="/css/menu.css">
    <link rel="stylesheet" href="/css/panel.css">
    <link rel="stylesheet" href="/css/btn.css">
    <link rel="stylesheet" href="/bootstrap-3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        .btn-submit{
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="topnav">
      <a href="/php/logout.php" style=" float: right;">logout</a>
      <p class="navbar-text navbar-right" style="float: right; font-weight: bold;">Hi, <?php print_r($_SESSION['account']); ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
    </div>
        <div  style="text-align:center;">

            <div class="main"  style="display: inline-block;">
                <h3>團隊選擇</h3>

                <form id="form" method="post" action="php/select_team.php">
                    <select name="team_id">
                        <option value="">-- 請選擇團隊 --</option>
                        <?php
                            gen_team_opts();
                        ?>
                    </select>
                    <input type="submit" class="btn btn-info btn-submit" value="確定">
                </form>
            </div>

            <div class="main" style="display: inline-block;">
                <h3>團隊成員</h3>

            </div>
        </div>

</body>
</html>