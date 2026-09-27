<?php

include __DIR__ . "/session.php";


if (!isset($_SESSION["user_id"]))
{
    header("Location: /EmployeeManagementSystem/login.php");
    exit;
}

?>