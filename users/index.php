<?php

include "../includes/admin_check.php";
include "../includes/csrf.php";
include "../config/db_connect.php";

$sql = "
    SELECT
        id,
        username,
        role
    FROM users
    ORDER BY id ASC
";

$result = mysqli_query($conn, $sql);

$pageTitle = "User Management";

include "../includes/header.php";

?>

<div class="container mt-4 mb-5">

    <div class="user-page-header">

        <div>
            <h1>User Management</h1>

            <p class="text-muted">
                Manage system users and their access roles.
            </p>
        </div>

        <a
            href="add.php"
            class="btn btn-primary"
        >
            Add User
        </a>

    </div>

    <?php
    if (isset($_SESSION["success"]))
    {
    ?>

        <div class="alert alert-success">
            <?php
            echo htmlspecialchars($_SESSION["success"]);
            unset($_SESSION["success"]);
            ?>
        </div>

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["error"]))
    {
    ?>

        <div class="alert alert-danger">
            <?php
            echo htmlspecialchars($_SESSION["error"]);
            unset($_SESSION["error"]);
            ?>
        </div>

    <?php
    }
    ?>

    <div class="user-list-card card shadow-sm">

        <div class="card-body p-0">

            <div class="user-list-header d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-1">
                        System Users
                    </h5>

                    <p class="text-muted mb-0">
                        <?php echo mysqli_num_rows($result); ?> user(s) registered
                    </p>

                </div>

            </div>

            <?php
            if (mysqli_num_rows($result) > 0)
            {
            ?>

                <div class="table-responsive">

                    <table class="table user-table align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>
                                    #
                                </th>

                                <th>
                                    Username
                                </th>

                                <th>
                                    Role
                                </th>

                                <th class="text-end">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            while ($user = mysqli_fetch_assoc($result))
                            {
                            ?>

                                <tr>

                                    <td>
                                        <?php echo htmlspecialchars($user["id"]); ?>
                                    </td>

                                    <td>

                                        <div class="user-name-cell">

                                            <div class="user-avatar">
                                                <?php
                                                echo strtoupper(
                                                    substr($user["username"], 0, 1)
                                                );
                                                ?>
                                            </div>

                                            <span>
                                                <?php
                                                echo htmlspecialchars($user["username"]);
                                                ?>
                                            </span>

                                            <?php
                                            if (
                                                $user["id"] == $_SESSION["user_id"]
                                            )
                                            {
                                            ?>

                                                <span class="user-current-badge">
                                                    Current User
                                                </span>

                                            <?php
                                            }
                                            ?>

                                        </div>

                                    </td>

                                    <td>

                                        <?php
                                        if ($user["role"] === "Admin")
                                        {
                                        ?>

                                            <span class="badge bg-danger">
                                                Admin
                                            </span>

                                        <?php
                                        }
                                        elseif ($user["role"] === "HR Manager")
                                        {
                                        ?>

                                            <span class="badge bg-primary">
                                                HR Manager
                                            </span>

                                        <?php
                                        }
                                        else
                                        {
                                        ?>

                                            <span class="badge bg-secondary">
                                                HR Staff
                                            </span>

                                        <?php
                                        }
                                        ?>

                                    </td>

                                    <td class="text-end">

                                        <?php
                                        if ($user["id"] != $_SESSION["user_id"])
                                        {
                                        ?>

                                            <form
                                                action="delete.php"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');"
                                            >

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?php echo $user["id"]; ?>"
                                                >

                                                <input
                                                    type="hidden"
                                                    name="csrf_token"
                                                    value="<?php echo htmlspecialchars(csrf_token()); ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        <?php
                                        }
                                        else
                                        {
                                        ?>

                                            <span class="text-muted small">
                                                Protected
                                            </span>

                                        <?php
                                        }
                                        ?>

                                    </td>

                                </tr>

                            <?php
                            }
                            ?>

                        </tbody>

                    </table>

                </div>

            <?php
            }
            else
            {
            ?>

                <div class="user-empty-state">

                    <h5>
                        No users found
                    </h5>

                    <p class="text-muted mb-3">
                        There are currently no system users.
                    </p>

                    <a
                        href="add.php"
                        class="btn btn-primary"
                    >
                        Add First User
                    </a>

                </div>

            <?php
            }
            ?>

        </div>

    </div>

</div>

<?php

include "../includes/footer.php";

?>