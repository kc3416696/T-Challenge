<?php
    session_start();
    require_once('common.php');
    checkIsLogin("personal_page.php", true);
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>Scrum yard</title>
    <link rel="stylesheet" href="/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/panel.css">
    <link rel="stylesheet" href="/css/btn.css">
    <link rel="stylesheet" href="/css/background.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</head>


<body>
    <div align="center" class="mypanel">
        <h1>Scrum Yard</h1>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">login</a></li>
            <li role="presentation"><a href="#register" aria-controls="register" role="tab" data-toggle="tab">Register</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="login">
                <form action="php/login.php" method="post" class="form-group">
                    <br/>
                    <div align="center" style=" width:90%;">
                        <input type="text" name="account" class="form-control" placeholder="Username">
                        <br/>
                        <input type="password" name="pwd" class="form-control" placeholder="Passsword">
                        <br/>
                        <input type="submit" class="btn btn-default btn-login" value="LOG IN">
                        <br/>
                    </div>
                    <!-- <iframe id="iframe_login" src="login.php" frameborder="0" width="90%" scrolling="No"></iframe> -->
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="register">
                <form action="php/register.php" method="post" class="form-group">
                    <br/>
                    <div align="center" style=" width:90%;">
                        <input type="text" name="account" class="form-control" placeholder="Username">
                        <br/>
                        <input type="password" name="pwd" class="form-control" placeholder="Passsword">
                        <br/>
                        <input type="password" name="confirm_pwd" class="form-control" placeholder="Confirm Passsword">
                        <br/>
                        <input type="submit" class="btn btn-default btn-register" value="REGISTER NOW">
                    </div>
                    <!-- <iframe id="iframe_register" src="register.php" frameborder="0" width="90%" scrolling="No"></iframe> -->
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_COOKIE["account"])){
            echo '<script type="text/javascript">document.getElementsByName("account")[0].value = "'. $_COOKIE["account"] .'";</script>';
        }
    ?>
</body>

</html>
