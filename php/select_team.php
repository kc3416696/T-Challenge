<?php
    session_start();
    require_once('../common.php');
    checkIsLogin('../index.php');
    require_once('../db_conn.php');


    global $DB_NAME, $CONN;
    $occur_post = isset($_POST['team_id']);

    if($occur_post)
    {
        $team_id = $_POST['team_id'];
        $account = $_SESSION['account'];

        global $DB_NAME, $CONN;

        $q1 = "select id from user where account = '$account' LIMIT 1";
        if(!($res1 = mysql_db_query($DB_NAME, $q1)))
        {
            print_r("資料庫讀取錯誤!");
            exit();
        }
        else
        {
            $row = mysql_fetch_array($res1);
            $user_id = $row['id'];
            /*
            echo $user_id;
            die();*/
        }



        // 如果不存在才 INSERT，存在就 skip
        $q2 =  "INSERT INTO team_member (team_id, $user_id)
                SELECT * FROM (SELECT '$team_id', '$user_id')
                WHERE NOT EXISTS (
                    SELECT team_id, user_id FROM team_member WHERE team_id = '$team_id' AND user_id = '$user_id'
                ) LIMIT 1";
        if(!($res2 = mysql_db_query($DB_NAME, $q2)))
        {
            print_r("資料庫讀取錯誤!");
            exit();
        }
        else
        {

            //$row = mysql_fetch_array($res2);
            //$user_id = $row['id'];
            /*
            echo $user_id;
            die();*/

            echo '<script>alert(\'加入成功!\')</script>';
            redirect("../personal_page.php");
        }


        mysql_close($CONN);
    }
    else
    {
        redirect("../personal_page.php");
    }

    mysql_close($CONN);


?>


