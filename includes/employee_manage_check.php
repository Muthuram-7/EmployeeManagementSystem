<?php

include __DIR__ . "/auth_check.php";

$allowedRoles = ["Admin", "HR Manager"];

if (!in_array($_SESSION["role"], $allowedRoles, true))
{
    $_SESSION["error"] = "You do not have permission to perform this action.";

    header("Location: /EmployeeManagementSystem/dashboard/index.php");

    exit;
}

?>