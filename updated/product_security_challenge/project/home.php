<?php

session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['mfa_done'])) {

} else {
    header('Location: index.php');
}


?>
<!DOCTYPE html>
<html>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }

    .bgimg {
        background-image: url('assets/bg.jpg');
        height: 100%;
        background-position: center;
        background-size: cover;
        position: relative;
        color: white;
        font-family: "Courier New", Courier, monospace;
        font-size: 25px;
    }

    .topleft {
        position: absolute;
        top: 0;
        left: 16px;
        padding: 20px;
    }

    .topRight {
        position: absolute;
        top: 0;
        right: 16px;
        padding: 20px;
    }


    .middle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    hr {
        margin: auto;
        width: 40%;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="bgimg">
    <div class="topleft">
        <p>Zendesk Home</p>
    </div>
    <div class="middle">
        <?php
        echo '<h1> Welcome ' . $_SESSION["user_id"] . '</h1>';
        ?>
        <hr>
        <p>Thank you</p>
    </div>
    <div class="topRight">
        <form action="server-side/logout.php" method="post">
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="logout" value="logout">Logout</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
