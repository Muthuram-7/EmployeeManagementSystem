<?php

include "includes/session.php";

if (isset($_SESSION["user_id"]))
{
    header("Location: dashboard/index.php");
    exit;
}

$pageTitle = "Login";

include "includes/header.php";

?>

<div class="auth-page">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

                <div class="auth-card card shadow-sm">

                    <div class="card-body p-4 p-md-5">

                        <div class="auth-header text-center">

                            <div class="auth-icon">
                                🔐
                            </div>

                            <h1>
                                Welcome Back
                            </h1>

                            <p class="text-muted">
                                Sign in to your employee management account.
                            </p>

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

                        <form
                            action="authenticate.php"
                            method="POST"
                        >

                            <div class="mb-3">

                                <label
                                    for="username"
                                    class="form-label"
                                >
                                    Username
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    id="username"
                                    name="username"
                                    required
                                    autocomplete="username"
                                    autofocus
                                >

                            </div>

                            <div class="mb-4">

                                <label
                                    for="password"
                                    class="form-label"
                                >
                                    Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control form-control-lg"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                >

                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary btn-lg w-100"
                            >
                                Sign In
                            </button>

                        </form>

                        <div class="auth-footer text-center">

                            <a
                                href="index.php"
                                class="text-decoration-none"
                            >
                                Back to Home
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

include "includes/footer.php";

?>