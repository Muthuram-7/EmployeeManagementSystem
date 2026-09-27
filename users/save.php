<?php

include "../includes/admin_check.php";

include "../includes/csrf.php";

include "../config/db_connect.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("Location: add.php");
    exit;
}


if (
    !isset($_POST["csrf_token"]) ||
    !verify_csrf_token($_POST["csrf_token"])
)
{
    $_SESSION["error"] = "Invalid security token.";

    header("Location: add.php");

    exit;
}


$username = trim($_POST["username"] ?? "");

$password = $_POST["password"] ?? "";

$role = trim($_POST["role"] ?? "");


if (
    $username === "" ||
    $password === "" ||
    $role === ""
)
{
    $_SESSION["error"] = "Please fill in all fields.";

    header("Location: add.php");

    exit;
}


if (strlen($username) < 3 || strlen($username) > 50)
{
    $_SESSION["error"] = "Username must contain between 3 and 50 characters.";

    header("Location: add.php");

    exit;
}


if (!preg_match("/^[A-Za-z0-9._-]+$/", $username))
{
    $_SESSION["error"] = "Username can contain only letters, numbers, dots, underscores, and hyphens.";

    header("Location: add.php");

    exit;
}


if (strlen($password) < 6)
{
    $_SESSION["error"] = "Password must contain at least 6 characters.";

    header("Location: add.php");

    exit;
}


$allowedRoles = [
    "Admin",
    "HR Manager",
    "HR Staff"
];


if (!in_array($role, $allowedRoles, true))
{
    $_SESSION["error"] = "Invalid user role.";

    header("Location: add.php");

    exit;
}


$checkSql = "
    SELECT id
    FROM users
    WHERE username = ?
";


$checkStmt = mysqli_prepare(
    $conn,
    $checkSql
);


mysqli_stmt_bind_param(
    $checkStmt,
    "s",
    $username
);


mysqli_stmt_execute($checkStmt);


$checkResult = mysqli_stmt_get_result(
    $checkStmt
);


if (mysqli_num_rows($checkResult) > 0)
{
    $_SESSION["error"] = "Username already exists.";

    header("Location: add.php");

    exit;
}


$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);


$sql = "
    INSERT INTO users
    (
        username,
        password,
        role
    )
    VALUES
    (?, ?, ?)
";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $username,
    $hashedPassword,
    $role
);


if (mysqli_stmt_execute($stmt))
{
    $_SESSION["success"] = "User created successfully.";

    header("Location: index.php");

    exit;
}
else
{
    $_SESSION["error"] = "Failed to create user.";

    header("Location: add.php");

    exit;
}

?>