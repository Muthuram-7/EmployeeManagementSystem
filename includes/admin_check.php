<?php

include __DIR__ . "/auth_check.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "Admin")
{
    header("Location: /EmployeeManagementSystem/dashboard/index.php");
    exit;
}

?>