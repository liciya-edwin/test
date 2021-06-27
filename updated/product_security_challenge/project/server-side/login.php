<?php
/**
 * @var PDO $connection
 */

include 'config.php';
include 'csrf_service.php';

session_start();

if (isset($_POST['login'])) {

    if (!validateRequest($_SESSION["csrf_token"], $_POST["csrf-token"])) {
        header('Location: ../index.php?signup=4');
        exit(0);
    }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $connection -> prepare("SELECT * FROM users where username=:username");
        $query -> bindParam("username", $username, PDO::PARAM_STR);
        $query -> execute();

        $result = $query -> fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            header('Location: ../index.php?login=1');
            exit(0);
        } else {
        $login_attempt = $result["login_attempt"];
        $lockedDate = new DateTime( $result["lock_date"] );
        $now = new DateTime();
        $interval= $now->diff($lockedDate);
        $hours = $interval ->h;

        if ($login_attempt >= 3 && $hours < 2) {
            header('Location: ../index.php?login=2');
            exit(0);
        }

        if ($login_attempt >= 3 && $hours >= 2) {
            $query = $connection->prepare("UPDATE users set login_attempt= 0 where username = :username");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $updated = $query->execute();
        }

        if (password_verify($password, $result['password'])) {
            error_log($now->format('Y-m-d H:i:s')." ".$username. " -> Logged In\n", 3, 'log.txt');
            $_SESSION['user_id'] = $result['username'];
            if ($login_attempt > 0) {
                $query = $connection->prepare("UPDATE users set login_attempt= 0 where username = :username");
                $query->bindParam("username", $username, PDO::PARAM_STR);
                $updated = $query->execute();
            }
            header('Location: ../multi_factor_verify.php');
            exit(0);
        } else {
                $now = new DateTime();
                $now_string = $now->format('Y-m-d H:i:s');
                $query = $connection->prepare("UPDATE users set login_attempt=login_attempt + 1, lock_date = :lock_date where username = :username");
                $query->bindParam("username", $username, PDO::PARAM_STR);
                $query->bindParam("lock_date", $now_string, PDO::PARAM_STR);
                $updated = $query->execute();
            header('Location: ../index.php?login=1');
            exit(0);
        }
    }
}


