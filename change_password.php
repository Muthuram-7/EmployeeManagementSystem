<?php

include "includes/auth_check.php";
include "includes/csrf.php";

$pageTitle = "Change Password";

include "includes/header.php";

?>

<div class="container mt-4 mb-5">

    <div class="password-page-header">

        <div>

            <h1>
                Change Password
            </h1>

            <p class="text-muted">
                Update the password for your current account.
            </p>

        </div>

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

    <div class="password-card card shadow-sm">

        <div class="card-body p-4">

            <form
                action="update_password.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars(csrf_token()); ?>"
                >

                <div class="mb-3">

                    <label
                        for="current_password"
                        class="form-label"
                    >
                        Current Password
                    </label>

                    <input
                        type="password"
                        class="form-control"
                        id="current_password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                    >

                </div>

                <div class="mb-3">

                    <label
                        for="new_password"
                        class="form-label"
                    >
                        New Password
                    </label>

                    <input
                        type="password"
                        class="form-control"
                        id="new_password"
                        name="new_password"
                        required
                        minlength="6"
                        autocomplete="new-password"
                    >

                    <div class="form-text">
                        Password must contain at least 6 characters.
                    </div>

                </div>

                <div class="mb-4">

                    <label
                        for="confirm_password"
                        class="form-label"
                    >
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        class="form-control"
                        id="confirm_password"
                        name="confirm_password"
                        required
                        minlength="6"
                        autocomplete="new-password"
                    >

                </div>

                <div class="password-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Password
                    </button>

                    <a
                        href="dashboard/index.php"
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

include "includes/footer.php";

?>