<?php

session_start();

include "config/db_connect.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("Location: login.php");
    exit;
}


$username = trim($_POST["username"] ?? "");

$password = $_POST["password"] ?? "";


if ($username === "" || $password === "")
{
    $_SESSION["error"] = "Please enter username and password.";

    header("Location: login.php");

    exit;
}


$sql = "
    SELECT
        id,
        username,
        password,
        role
    FROM users
    WHERE username = ?
";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


if (!$stmt)
{
    error_log(
        "Login statement preparation failed: " . mysqli_error($conn)
    );

    $_SESSION["error"] = "Unable to process login right now.";

    header("Location: login.php");

    exit;
}


mysqli_stmt_bind_param(
    $stmt,
    "s",
    $username
);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


$user = mysqli_fetch_assoc($result);


if (
    $user &&
    password_verify(
        $password,
        $user["password"]
    )
)
{
    session_regenerate_id(true);


    $_SESSION["user_id"] = $user["id"];

    $_SESSION["username"] = $user["username"];

    $_SESSION["role"] = $user["role"];


    header("Location: dashboard/index.php");

    exit;
}


$_SESSION["error"] = "Invalid username or password.";

header("Location: login.php");

exit;

?>