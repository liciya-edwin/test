<?php

/**
 * @throws Exception
 */

function insertHiddenToken()
{
    echo "<input type=\"hidden\"" . " name=\"csrf-token\"" . " value=\"" . getCSRFToken() . "\"" . " />";
}

function getCSRFToken() {
        if (empty($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = bin2hex(openssl_random_pseudo_bytes(32));
        }
        return $_SESSION["csrf_token"];
}

function validateRequest($session_token, $form_token)
{
    if (! isset($session_token)) {
        return false;
    }

    if (! empty($form_token)) {
        $token = $form_token;
    } else {
        return false;
    }

    if (!is_string($token)) {
        return false;
    }

    return hash_equals($token, $session_token);
}

