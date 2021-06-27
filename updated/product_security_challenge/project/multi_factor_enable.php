<?php

include '../googleAuthenticator/GoogleAuthenticator.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['user_id'];

    $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
    $secret = $g->generateSecret();
    $_SESSION["mfa_secret"] = $secret;
    echo '
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <center><h1>Enable Multi Factor Authentication</h1></center>
    <center><img src="'.\Sonata\GoogleAuthenticator\GoogleQrUrl::generate($username, $secret, 'Zendesk').'" /></center>
    <center><h3>Scan this QR Code on your Google Authenticator</h3></center>
            <form action="server-side/mfa_service.php" method="post">
            <div class="form-group">
                <center><button type="submit" class="btn btn-primary" name="enable_mfa" value="enable_mfa">Enable MFA</button></center>
            </div>
        </form>
        </body>';

} else {
    header('Location: index.php');
}