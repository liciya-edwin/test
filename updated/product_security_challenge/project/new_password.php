<?php
session_start();

include 'server-side/csrf_service.php';

if (isset($_GET['token'])) {
    $_SESSION["reset_token"] = $_GET['token'];
} else {
    header('Location: index.php?');
}

if (isset($_GET['reset'])) {
    if ($_GET['reset'] == 3) {
        echo '<div class="custom_margin alert alert-danger" role="alert">Password Error : ' . $_GET['message'] . '</div>';
    } else if ($_GET['reset'] == 5) {
        echo '<div class="custom_margin alert alert-danger" role="alert">This password has been compromised before!</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset</title>
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
    <form action="server-side/new_password.php" method="post">
        <h2 class="text-center">Reset</h2>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="New Password" required="required" name="password">
        </div>
        <?php
        insertHiddenToken();
        ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="reset" value="reset">Reset</button>
        </div>
    </form>
</div>
</body>

</html>
