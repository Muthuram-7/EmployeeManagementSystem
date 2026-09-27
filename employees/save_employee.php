<?php

include "../includes/employee_manage_check.php";

include "../includes/csrf.php";

include "../config/db_connect.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("Location: add_employee.php");
    exit;
}


if (
    !isset($_POST["csrf_token"]) ||
    !verify_csrf_token($_POST["csrf_token"])
)
{
    $_SESSION["error"] = "Invalid security token.";

    header("Location: add_employee.php");

    exit;
}


$name = trim($_POST["name"] ?? "");

$email = trim($_POST["email"] ?? "");

$phone_number = trim($_POST["phone_number"] ?? "");

$department = trim($_POST["department"] ?? "");

$designation = trim($_POST["designation"] ?? "");

$salary = trim($_POST["salary"] ?? "");

$joining_date = trim($_POST["joining_date"] ?? "");

$status = trim($_POST["status"] ?? "");


if (
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
    $_SESSION["error"] = "Please fill in all fields.";

    header("Location: add_employee.php");

    exit;
}


if (strlen($name) > 100)
{
    $_SESSION["error"] = "Name is too long.";

    header("Location: add_employee.php");

    exit;
}


if (strlen($email) > 100)
{
    $_SESSION["error"] = "Email address is too long.";

    header("Location: add_employee.php");

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $_SESSION["error"] = "Please enter a valid email address.";

    header("Location: add_employee.php");

    exit;
}


if (!preg_match("/^[0-9+\-\s()]{7,20}$/", $phone_number))
{
    $_SESSION["error"] = "Please enter a valid phone number.";

    header("Location: add_employee.php");

    exit;
}


if (strlen($department) > 50)
{
    $_SESSION["error"] = "Department name is too long.";

    header("Location: add_employee.php");

    exit;
}


if (strlen($designation) > 100)
{
    $_SESSION["error"] = "Designation is too long.";

    header("Location: add_employee.php");

    exit;
}


if (!is_numeric($salary) || $salary < 0)
{
    $_SESSION["error"] = "Please enter a valid salary.";

    header("Location: add_employee.php");

    exit;
}


if (!is_numeric($salary) || strlen($salary) > 10)
{
    $_SESSION["error"] = "Invalid salary value.";

    header("Location: add_employee.php");

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

    header("Location: add_employee.php");

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

    header("Location: add_employee.php");

    exit;
}


$checkSql = "
    SELECT id
    FROM employees
    WHERE email = ?
";


$checkStmt = mysqli_prepare(
    $conn,
    $checkSql
);


mysqli_stmt_bind_param(
    $checkStmt,
    "s",
    $email
);


mysqli_stmt_execute($checkStmt);


$checkResult = mysqli_stmt_get_result(
    $checkStmt
);


if (mysqli_num_rows($checkResult) > 0)
{
    $_SESSION["error"] = "An employee with this email already exists.";

    header("Location: add_employee.php");

    exit;
}


$sql = "
    INSERT INTO employees
    (
        name,
        email,
        phone_number,
        department,
        designation,
        salary,
        joining_date,
        status
    )
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?)
";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


mysqli_stmt_bind_param(
    $stmt,
    "sssssdss",
    $name,
    $email,
    $phone_number,
    $department,
    $designation,
    $salary,
    $joining_date,
    $status
);


if (mysqli_stmt_execute($stmt))
{
    $_SESSION["success"] = "Employee added successfully.";

    header("Location: view_employees.php");

    exit;
}
else
{
    $_SESSION["error"] = "Failed to add employee.";

    header("Location: add_employee.php");

    exit;
}

?>