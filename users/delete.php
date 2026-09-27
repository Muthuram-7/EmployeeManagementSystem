<?php

include "../includes/admin_check.php";

include "../includes/csrf.php";

include "../config/db_connect.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    header("Location: index.php");
    exit;
}


if (
    !isset($_POST["csrf_token"]) ||
    !verify_csrf_token($_POST["csrf_token"])
)
{
    $_SESSION["error"] = "Invalid security token.";

    header("Location: index.php");

    exit;
}


$id = (int) ($_POST["id"] ?? 0);


if ($id <= 0)
{
    $_SESSION["error"] = "Invalid user ID.";

    header("Location: index.php");

    exit;
}


if ($id === (int) $_SESSION["user_id"])
{
    $_SESSION["error"] = "You cannot delete your own account.";

    header("Location: index.php");

    exit;
}


$checkSql = "
    SELECT
        id,
        username,
        role
    FROM users
    WHERE id = ?
";


$checkStmt = mysqli_prepare(
    $conn,
    $checkSql
);


mysqli_stmt_bind_param(
    $checkStmt,
    "i",
    $id
);


mysqli_stmt_execute($checkStmt);


$checkResult = mysqli_stmt_get_result(
    $checkStmt
);


$user = mysqli_fetch_assoc(
    $checkResult
);


if (!$user)
{
    $_SESSION["error"] = "User not found.";

    header("Location: index.php");

    exit;
}


if ($user["role"] === "Admin")
{

    $adminCountSql = "
        SELECT COUNT(*) AS total
        FROM users
        WHERE role = 'Admin'
    ";


    $adminCountResult = mysqli_query(
        $conn,
        $adminCountSql
    );


    $adminCountRow = mysqli_fetch_assoc(
        $adminCountResult
    );


    $adminCount = $adminCountRow["total"];


    if ($adminCount <= 1)
    {
        $_SESSION["error"] = "The last Admin account cannot be deleted.";

        header("Location: index.php");

        exit;
    }

}


$sql = "
    DELETE FROM users
    WHERE id = ?
";


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
    $_SESSION["success"] = "User deleted successfully.";
}
else
{
    $_SESSION["error"] = "Failed to delete user.";
}


header("Location: index.php");

exit;

?>