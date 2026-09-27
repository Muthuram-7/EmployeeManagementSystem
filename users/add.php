<?php

include "../includes/admin_check.php";
include "../includes/csrf.php";

$pageTitle = "Add User";

include "../includes/header.php";

?>

<div class="container mt-4 mb-5">

    <div class="user-form-page-header">

        <div>

            <h1>Add User</h1>

            <p class="text-muted">
                Create a new system account and assign an access role.
            </p>

        </div>

        <a
            href="index.php"
            class="btn btn-outline-secondary"
        >
            Back to Users
        </a>

    </div>

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

    <div class="user-form-card card shadow-sm">

        <div class="card-body p-4">

            <form
                action="save.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars(csrf_token()); ?>"
                >

                <div class="row g-4">

                    <div class="col-md-6">

                        <label
                            for="username"
                            class="form-label"
                        >
                            Username
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            required
                            minlength="3"
                            maxlength="50"
                            autocomplete="username"
                        >

                        <div class="form-text">
                            Use 3–50 letters, numbers, dots, underscores or hyphens.
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            required
                            minlength="6"
                            autocomplete="new-password"
                        >

                        <div class="form-text">
                            Password must contain at least 6 characters.
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label
                            for="role"
                            class="form-label"
                        >
                            Role
                        </label>

                        <select
                            class="form-select"
                            id="role"
                            name="role"
                            required
                        >

                            <option value="HR Staff">
                                HR Staff
                            </option>

                            <option value="HR Manager">
                                HR Manager
                            </option>

                            <option value="Admin">
                                Admin
                            </option>

                        </select>

                    </div>

                </div>

                <div class="user-role-info mt-4">

                    <h6>
                        Access Roles
                    </h6>

                    <p>
                        <strong>Admin:</strong>
                        Full system access including user management.
                    </p>

                    <p>
                        <strong>HR Manager:</strong>
                        Can manage employee records but cannot manage system users.
                    </p>

                    <p class="mb-0">
                        <strong>HR Staff:</strong>
                        Can view employee records and dashboard information.
                    </p>

                </div>

                <div class="user-form-actions mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Create User
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-outline-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<?php

include "../includes/footer.php";

?>