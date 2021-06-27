<?php

session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['mfa_done'])) {
    header('Location: home.php');
} else if (!isset($_SESSION['user_id']) && !isset($_SESSION['mfa_done'])) {
    header('Location: index.php');
}

if (isset($_GET['verify'])) {
    if ($_GET['verify'] == 1) {
        echo '<div class="custom_margin alert alert-danger" role="alert">Wrong MFA code!</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>2FA</title>
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
    <form action="server-side/mfa_service.php" method="post">
        <h2 class="text-center">2FA</h2>
        <div class="form-group">
            <input type="number" class="form-control" placeholder="MFA Code" required="required" name="mfa-code">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="verify" value="verify">Verify</button>
        </div>
    </form>
</div>
</body>

</html>

