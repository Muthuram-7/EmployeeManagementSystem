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

$name = trim($_POST["name"] ?? "");

$email = trim($_POST["email"] ?? "");

$phone_number = trim($_POST["phone_number"] ?? "");

$department = trim($_POST["department"] ?? "");

$designation = trim($_POST["designation"] ?? "");

$salary = trim($_POST["salary"] ?? "");

$joining_date = trim($_POST["joining_date"] ?? "");

$status = trim($_POST["status"] ?? "");


if (
    $id <= 0 ||
    $name === "" ||
    $email === "" ||
    $phone_number === "" ||
    $department === "" ||
    $designation === "" ||
    $salary === "" ||
    $joining_date === "" ||
    $status === ""
)
{
    $_SESSION["error"] = "Please provide valid employee details.";

    header("Location: view_employees.php");

    exit;
}


if (strlen($name) > 100)
{
    $_SESSION["error"] = "Name is too long.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


if (strlen($email) > 100)
{
    $_SESSION["error"] = "Email address is too long.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $_SESSION["error"] = "Please enter a valid email address.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


if (!preg_match("/^[0-9+\-\s()]{7,20}$/", $phone_number))
{
    $_SESSION["error"] = "Please enter a valid phone number.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


if (strlen($department) > 50)
{
    $_SESSION["error"] = "Department name is too long.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


if (strlen($designation) > 100)
{
    $_SESSION["error"] = "Designation is too long.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


if (!is_numeric($salary) || $salary < 0)
{
    $_SESSION["error"] = "Please enter a valid salary.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


$date = DateTime::createFromFormat(
    "Y-m-d",
    $joining_date
);


if (
    !$date ||
    $date->format("Y-m-d") !== $joining_date
)
{
    $_SESSION["error"] = "Please enter a valid joining date.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


$allowedStatuses = [
    "Active",
    "Inactive",
    "On Leave"
];


if (!in_array($status, $allowedStatuses, true))
{
    $_SESSION["error"] = "Invalid employment status.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


$checkSql = "
    SELECT id
    FROM employees
    WHERE email = ?
    AND id != ?
";


$checkStmt = mysqli_prepare(
    $conn,
    $checkSql
);


mysqli_stmt_bind_param(
    $checkStmt,
    "si",
    $email,
    $id
);


mysqli_stmt_execute($checkStmt);


$checkResult = mysqli_stmt_get_result(
    $checkStmt
);


if (mysqli_num_rows($checkResult) > 0)
{
    $_SESSION["error"] = "Another employee already uses this email address.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}


$sql = "
    UPDATE employees
    SET
        name = ?,
        email = ?,
        phone_number = ?,
        department = ?,
        designation = ?,
        salary = ?,
        joining_date = ?,
        status = ?
    WHERE id = ?
";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


mysqli_stmt_bind_param(
    $stmt,
    "sssssdssi",
    $name,
    $email,
    $phone_number,
    $department,
    $designation,
    $salary,
    $joining_date,
    $status,
    $id
);


if (mysqli_stmt_execute($stmt))
{
    $_SESSION["success"] = "Employee updated successfully.";

    header("Location: view_employees.php");

    exit;
}
else
{
    $_SESSION["error"] = "Failed to update employee.";

    header("Location: edit_employee.php?id=" . $id);

    exit;
}

?>