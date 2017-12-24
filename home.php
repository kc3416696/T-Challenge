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
    <title>Home page</title>
    <link rel="stylesheet" href="/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/menu.css">
    <link rel="stylesheet" href="/css/panel.css">
    <link rel="stylesheet" href="/css/btn.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
</head>
    <style type="text/css">
        img{
            width: 95%;
            cursor: pointer;
        }

        .txtfield{
            float: left;
            width: 370px;
        }


        .btn-submit{
            margin-left: 10px;
        }

        p{
            word-wrap: break-word;
        }
    </style>
<body>
    <div class="topnav">
      <a href="/php/logout.php" style=" float: right;">logout</a>
      <p class="navbar-text navbar-right" style="float: right; font-weight: bold;">Hi, <?php print_r($_SESSION['account']); ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
    </div>

    <div class="main">
        <!-- Nav tabs -->
        <ul align="center" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active inner"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Homepage</a></li>
            <li role="presentation" class="inner"><a href="#register" aria-controls="register" role="tab" data-toggle="tab">Post</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="home">
                <div id="posts" style="margin-left: 10px; margin-right: 10px;"></div>
                <!-- <iframe id="iframe_home" src="home.php" frameborder="0" width="90%" scrolling="No"></iframe> -->
            </div>
            <div role="tabpanel" class="tab-pane fade" id="register">
                <form id="form_post" action="php/post_page.php" method="post" class="form-group" enctype="multipart/form-data">
                    <br/>
                    <div style="padding-left: 30px;">
                        <input type="file" name="image" id="file_input">
                        <br/>
                        <input type="submit" class="btn btn-primary btn-blur" style="margin-left: 10px;" value="Upload" id="btn_post">
                    </div>
                    <!-- <iframe id="iframe_register" src="register.php" frameborder="0" width="90%" scrolling="No"></iframe> -->
                </form>
            </div>
        </div>
    </div>
</body>
    <script language="javascript">
        var htmls = "";

        function showOnePost(post_id, filepath, content, num_of_likes, post_datetime, author, commenter, comments, comm_time, is_like, is_author)
        {
            var imgId = "img" + post_id;
            var heart_form_id = "heart" + post_id;
            var symbol;
            var heartClass;

            htmls += "<hr>";
            htmls += "<img src=\"" +  filepath +"\" id=" + imgId + " onclick=\"openPic(this);\">";
            if(is_like)
            {
                symbol = "❤";
                heartClass = "like";
            }
            else
            {
                symbol = "♡";
                heartClass = "non-like";
            }

            htmls +="<form id=\""+ heart_form_id + "\" action=" + "/php/click_heart.php" + " name=\"heart_form\" method=\"post\" class=\"form-group\">";
            htmls += '<p class="heart" onclick=clickHeart(\"'+ heart_form_id +'\");><span class=' + heartClass + '>' + symbol + '</span></p>';

            htmls += "<input type=\"hidden\" name=\"post_id\" value=" + post_id + ">";
            htmls += "<input type=\"hidden\" name=\"is_like\" value=\"" + is_like + "\">";
            htmls += "</form>";

            if(is_author){
                htmls +="<form action=" + "/php/delete.php" + " name=\"del_form\" method=\"post\" class=\"form-group\">";
                htmls += "<input type=\"hidden\" name=\"post_id\" value=" + post_id + ">";
                htmls += '<input type="button" value="Delete" class="btn btn-default" style="float: right; background-color:#FF3333; color:white;" onclick=delPost(this.form);>';
                htmls += "</form>";
            }

            htmls += '<br>';

            htmls +="<form action=" + "/php/submit_comment.php" +" method=\"post\" class=\"form-group\">";
            htmls += "<p>♥ " + num_of_likes + " likes<br>";
            htmls += "<span class=\"user\">" + author + "</span>&nbsp" + content + "<br/>"+ post_datetime;

            // show all the comments of this post
            for(var i = 0; i < commenter.length; i++){
                htmls +="<br><span class=\"user\">" + commenter[i] + "</span>&nbsp" + comments[i] + "<br/>"+ comm_time[i];
            }

            htmls += "</span></p>";
            htmls += "<br>";
            htmls += "<input type=\"text\" name=\"reply\" class=\"form-control txtfield\">";
            htmls += "<input type=\"submit\" class=\"btn btn-info btn-submit\"  value=\"Submit\">";
            htmls += "<input type=\"hidden\" name=\"post_id\" value=" + post_id + ">";

            htmls +="</form>"
            document.getElementById("posts").innerHTML = htmls;
        }
    </script>
    <script language="javascript">
        function openPic(obj)
        {
            window.open(obj.src);
        }

        // like   or    Cancel like
        function clickHeart(form)
        {
            document.getElementById(form).submit();
        }


        function delPost(form)
        {
            var isOK = confirm('Are you sure to delete this post?');
            if(isOK)
            {
                form.submit();
            }
        }
    </script>

    <?php
        global $DB_NAME, $CONN;

        $q1 = "SELECT * FROM posts ORDER BY id DESC";
        if(!($result = mysql_db_query($DB_NAME, $q1)))
        {
            print_r("資料庫讀取錯誤! 152");
            exit();
        }
        else
        {
            while($arr = mysql_fetch_array($result))
            {
                $post_id = $arr['id'];
                $filepath = $arr['filepath'];
                $content = $arr['content'];
                $post_datetime = $arr['post_datetime'];
                $author = $arr['author'];
                $likes = 0; // 按讚數
                $commenter = array();
                $comments = array();
                $comm_time = array();
                $is_like = false; // 當前的user是否按讚此篇貼文
                $num_of_likes = 0; // 按讚數
                $is_author = false; // 是否為此篇貼文的擁有者

                if($author == $_SESSION['account']){
                    $is_author = true;
                }

                $q2 = "select * from post_likes where post_id = '$post_id'";
                if(!($res_like = mysql_db_query($DB_NAME, $q2)))
                {
                    print_r("資料庫讀取錯誤! 171");
                    exit();
                }
                else
                {
                    $num_of_likes = mysql_num_rows($res_like);
                    while($arr_likes = mysql_fetch_array($res_like))
                    {
                        if($arr_likes['post_liker'] == $_SESSION['account']){
                            $is_like = true;
                            break;
                        }
                    }
                }

                $q = "select * from post_comments where post_id = $post_id";
                if(!($res_comm = mysql_db_query($DB_NAME, $q)))
                {
                    print_r("資料庫讀取錯誤! 175");
                    exit();
                }
                else
                {
                    while ($arr_comm = mysql_fetch_array($res_comm)) {
                        array_push($commenter, $arr_comm['commenter']);
                        array_push($comments,  $arr_comm['content']);
                        array_push($comm_time, $arr_comm['comm_time']);
                    }
                }

                $commenter = json_encode($commenter);
                $comments = json_encode($comments);
                $comm_time = json_encode($comm_time);
                $is_like = json_encode($is_like);
                $is_author = json_encode($is_author);

                echo '<script language="javascript">',
                'showOnePost("'. $post_id .'","'. $filepath .'","'. $content . '","'. $num_of_likes .'","'.
                        $post_datetime .'","'. $author .'",' . $commenter . ','. $comments .','.
                        $comm_time .','. $is_like .','. $is_author .');</script>';
            }
        }

        mysql_close($CONN);
    ?>

</html>