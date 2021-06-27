<?php

session_start();

include 'server-side/csrf_service.php';


if (isset($_SESSION['user_id']) && isset($_SESSION['mfa_done'])) {
    header('Location: home.php');
}

if (isset($_GET['login'])) {
    if ($_GET['login'] == 1) {
        echo '<div class="custom_margin alert alert-danger" role="alert">Username password combination is wrong!</div>';
    } else if ($_GET['login'] == 4) {
        echo '<div class="custom_margin alert alert-danger" role="alert">CSRF Exploit Alert</div>';
    } else if ($_GET['login'] == 2) {
        echo '<div class="custom_margin alert alert-danger" role="alert">Account Locked, please wait for 2 hours to try again.</div>';
    } else if ($_GET['login'] == 5) {
        echo '<div class="custom_margin alert alert-success" role="alert">Password Reset Successful.</div>';
    } else if ($_GET['login'] == 6) {
        echo '<div class="custom_margin alert alert-danger" role="alert">Invalid Reset URL.</div>';
    }
}

if (isset($_GET['signup'])) {
    if ($_GET['signup'] == 0) {
        echo '<div class="custom_margin alert alert-success" role="alert">Signed Up Successfully!</div>';
    } else if ($_GET['signup'] == 1) {
        echo '<div class="custom_margin alert alert-warning" role="alert">Username already taken.</div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/main.css">

    <style>
        .custom_margin {
            margin: 10px;
        }
    </style>
</head>

<body>
<div class="login-form">
    <form action="server-side/login.php" method="post">
        <h2 class="text-center">Log in</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" required="required" name="username">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" required="required" name="password" maxlength="12">
        </div>
        <?php
        insertHiddenToken();
        ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="login" value="login">Log in</button>
        </div>
        <div class="clearfix">
            <a href="forgot_password.php" class="pull-right">Forgot Password?</a>
        </div>
    </form>
    <p class="text-center"><a href="signup.php">Create an Account</a></p>
</div>
</body>

</html>
