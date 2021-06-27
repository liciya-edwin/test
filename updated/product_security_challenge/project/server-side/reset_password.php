<?php
/**
 * @var PDO $connection
 */

include 'config.php';

if (isset($_POST['reset-password'])) {

    $username = $_POST['username'];

    $query = $connection->prepare("SELECT * FROM users where username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        header('Location: ../forgot_password.php?forgot=1');
        exit(0);
    } else {
        $email = $result["email"];
        // generate a unique random token of length 100
        $token = bin2hex(random_bytes(50));

        $query = $connection->prepare("INSERT INTO password_reset(email, token) values(:email, :token)");
        $query->bindParam("token", $token, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $inserted = $query->execute();

        // Send email to user with the token in a link they can click on
        $to = $email;
        $from = "info@zendesk.com";
        $subject = "Reset your password on Zendesk";
        $message = '<html><body>';
        $message .= '<h1>Reset Password!</h1>';
        $message .= '<p style="color:#080;font-size:18px;">Please click the below link to reset password</p>';
        $message .= "<a href=\"https://localhost/product_security_challenge/project/new_password.php?token=".$token."\">Click here to continue</a>";
        $message .= '</body></html>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
        header('location: ../forgot_password.php?forgot=0');
    }
}