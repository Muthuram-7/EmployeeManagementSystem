<?php

include __DIR__ . "/session.php";


if (!isset($_SESSION["csrf_token"]))
{
    $_SESSION["csrf_token"] = bin2hex(
        random_bytes(32)
    );
}


function csrf_token()
{
    return $_SESSION["csrf_token"];
}


function verify_csrf_token($token)
{
    return isset($_SESSION["csrf_token"]) &&
           hash_equals(
               $_SESSION["csrf_token"],
               $token
           );
}

?>