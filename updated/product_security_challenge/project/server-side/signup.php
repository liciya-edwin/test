<?php
/**
 * @var PDO $connection
 */

session_start();

include 'config.php';
include 'csrf_service.php';
include "../../pwned-check/Pwned.php";

if (isset($_POST['signup'])) {

    $email = $_POST['email'];
    $username = $_POST['username'];

    if (!validateRequest($_SESSION["csrf_token"], $_POST["csrf-token"])) {
        header('Location: ../signup.php?signup=4');
        exit(0);
    }

    if (empty($_POST["password"]) || empty($_POST["email"]) || empty($_POST["username"])) {
        header('Location: ../index.php?signup=2');
        exit(0);
    }

    $password = $_POST["password"];

    if (strlen($_POST["password"]) <= '8' || strlen($_POST["password"]) > '12') {
        $passwordErr = "Your Password length should be between 8 and 12!";
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Number!";
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
    } elseif (!preg_match("/[^a-zA-Z\d]/", $password)) {
        $passwordErr = "Your Password Must Contain At Least one special Character";
    }

    if (!empty($passwordErr)) {
        header('Location: ../signup.php?signup=3&message='.$passwordErr);
        exit(0);
    }

    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        header('Location: ../signup.php?signup=2');
        exit(0);
    }


    $pwned = new \Square1\Pwned\Pwned();
    $compromised = $pwned->hasBeenPwned($password);
    if ($compromised == 1) {
        header('Location: ../signup.php?signup=5');
        exit(0);
    }

    try {
        $query = $connection->prepare("INSERT INTO users(email, username, password) values(:email, :username, :password)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password", $hashedPassword, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $inserted = $query->execute();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            header('Location: ../index.php?signup=1');
            exit(0);
        }
    }
    //header('Location: ../index.php?signup=0');
    $_SESSION['user_id'] = $username;
    header('Location: ../multi_factor_enable.php?user_id='.$username);
    exit(0);
}


