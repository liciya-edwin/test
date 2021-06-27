<?php
/**
 * @var PDO $connection
 */

session_start();

include 'config.php';
include "../../pwned-check/Pwned.php";

if (isset($_POST['reset'])) {

    $password = $_POST['password'];

    $query = $connection -> prepare("SELECT * FROM password_reset where token=:token");
    $query -> bindParam("token", $_SESSION["reset_token"], PDO::PARAM_STR);
    $query -> execute();

    $result = $query -> fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        header('Location: ../index.php?login=6');
        exit(0);
    } else {

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

        $pwned = new \Square1\Pwned\Pwned();
        $compromised = $pwned->hasBeenPwned($password);
        if ($compromised == 1) {
            header('Location: ../new_password.php?reset=5');
            exit(0);
        }


        if (!empty($passwordErr)) {
            header('Location: ../new_password.php?reset=3&message='.$passwordErr.'&token='.$_SESSION["reset_token"]);
            exit(0);
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = $connection->prepare("UPDATE users set password= :password where email = :email");
        $query->bindParam("password", $hashedPassword, PDO::PARAM_STR);
        $query->bindParam("email", $result["email"], PDO::PARAM_STR);
        $updated = $query->execute();
        header('Location: ../index.php?login=5');
    }


}