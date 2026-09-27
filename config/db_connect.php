<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "employee_management_system";

$conn = mysqli_connect(
    $server,
    $username,
    $password,
    $database
);

if (!$conn)
{
    error_log(
        "Database connection failed: " . mysqli_connect_error()
    );

    die(
        "Unable to connect to the database. Please try again later."
    );
}


if (!mysqli_set_charset($conn, "utf8mb4"))
{
    error_log(
        "Failed to set database character set: " . mysqli_error($conn)
    );

    die(
        "Unable to initialize the database connection."
    );
}

?>