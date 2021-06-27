<?php
session_start();

include 'server-side/csrf_service.php';

if (isset($_GET['forgot'])) {
    if ($_GET['forgot'] == 0) {
        echo '<div class="custom_margin alert alert-success" role="alert">Sent a password reset link to your registered mail.</div>';
    } else if ($_GET['forgot'] == 1) {
        echo '<div class="custom_margin alert alert-warning" role="alert">No User Exists</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
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
    <form action="server-side/reset_password.php" method="post">
        <h2 class="text-center">Reset Password</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" required="required" name="username">
        </div>
        <?php
        insertHiddenToken();
        ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="reset-password" value="reset-password">Sent
                Verification Email
            </button>
        </div>
    </form>
    <p class="text-center"><a href="index.php">Login instead</a></p>
</div>
</body>

</html>
