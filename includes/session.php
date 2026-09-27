<?php

if (session_status() === PHP_SESSION_NONE)
{
    $isHttps = (
        isset($_SERVER["HTTPS"]) &&
        $_SERVER["HTTPS"] !== "off"
    );

    session_set_cookie_params([
        "httponly" => true,
        "secure" => $isHttps,
        "samesite" => "Lax"
    ]);

    session_start();
}

?>