<?php

include "includes/auth_check.php";

include "includes/csrf.php";

include "config/db_connect.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("Location: change_password.php");
    exit;
}


if (
    !isset($_POST["csrf_token"]) ||
    !verify_csrf_token($_POST["csrf_token"])
)
{
    $_SESSION["error"] = "Invalid security token.";

    header("Location: change_password.php");

    exit;
}


$currentPassword = $_POST["current_password"] ?? "";

$newPassword = $_POST["new_password"] ?? "";

$confirmPassword = $_POST["confirm_password"] ?? "";


if (
    $currentPassword === "" ||
    $newPassword === "" ||
    $confirmPassword === ""
)
{
    $_SESSION["error"] = "Please fill in all fields.";

    header("Location: change_password.php");

    exit;
}


if (strlen($newPassword) < 6)
{
    $_SESSION["error"] = "New password must contain at least 6 characters.";

    header("Location: change_password.php");

    exit;
}


if ($newPassword !== $confirmPassword)
{
    $_SESSION["error"] = "New passwords do not match.";

    header("Location: change_password.php");

    exit;
}


if ($currentPassword === $newPassword)
{
    $_SESSION["error"] = "New password must be different from the current password.";

    header("Location: change_password.php");

    exit;
}


$userId = (int) $_SESSION["user_id"];


$sql = "SELECT password FROM users WHERE id = ?";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $userId
);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


$user = mysqli_fetch_assoc($result);


if (!$user)
{
    $_SESSION["error"] = "User account not found.";

    header("Location: change_password.php");

    exit;
}


if (!password_verify($currentPassword, $user["password"]))
{
    $_SESSION["error"] = "Current password is incorrect.";

    header("Location: change_password.php");

    exit;
}


$hashedPassword = password_hash(
    $newPassword,
    PASSWORD_DEFAULT
);


$updateSql = "
    UPDATE users
    SET password = ?
    WHERE id = ?
";


$updateStmt = mysqli_prepare(
    $conn,
    $updateSql
);


mysqli_stmt_bind_param(
    $updateStmt,
    "si",
    $hashedPassword,
    $userId
);


if (mysqli_stmt_execute($updateStmt))
{
    $_SESSION["success"] = "Password changed successfully.";
}
else
{
    $_SESSION["error"] = "Failed to change password.";
}


header("Location: change_password.php");

exit;

?>