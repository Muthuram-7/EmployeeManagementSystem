<?php

include "../includes/employee_manage_check.php";

include "../includes/csrf.php";

include "../config/db_connect.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("Location: view_employees.php");
    exit;
}


if (
    !isset($_POST["csrf_token"]) ||
    !verify_csrf_token($_POST["csrf_token"])
)
{
    $_SESSION["error"] = "Invalid security token.";
    header("Location: view_employees.php");
    exit;
}


$id = (int) ($_POST["id"] ?? 0);


if ($id <= 0)
{
    $_SESSION["error"] = "Invalid employee ID.";
    header("Location: view_employees.php");
    exit;
}


$sql = "DELETE FROM employees WHERE id = ?";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


if (mysqli_stmt_execute($stmt))
{
    $_SESSION["success"] = "Employee deleted successfully.";
}
else
{
    $_SESSION["error"] = "Failed to delete employee.";
}


header("Location: view_employees.php");

exit;

?>