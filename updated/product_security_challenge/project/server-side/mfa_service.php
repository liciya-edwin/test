<?php

/**
 * @var PDO $connection
 */

session_start();

include '../../googleAuthenticator/GoogleAuthenticator.php';
include "config.php";

$username = $_SESSION['user_id'];

if (isset($_POST['enable_mfa'])) {

    $query = $connection->prepare("UPDATE users set mfa_code=:mfa_code where username = :username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->bindParam("mfa_code", $_SESSION["mfa_secret"], PDO::PARAM_STR);
    $updated = $query->execute();
    header('Location: ../index.php?signup=0');
}

if (isset($_POST['verify'])) {

    $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

    $check_this_code = $_POST['mfa-code'];

    $query = $connection -> prepare("SELECT mfa_code FROM users where username=:username");
    $query -> bindParam("username", $username, PDO::PARAM_STR);
    $query -> execute();

    $result = $query -> fetch(PDO::FETCH_COLUMN);

    echo $result;

    if ($g->checkCode($result, $check_this_code)) {
        $_SESSION['mfa_done'] = "set";
        header('Location: ../home.php');
        exit(0);
    } else {
        header('Location: ../multi_factor_verify.php?verify=1');
        exit(0);
    }
}
