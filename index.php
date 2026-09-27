<?php

$pageTitle = "Home";

include "includes/header.php";

?>

<div class="container mt-5 mb-5">


    <div class="row align-items-center py-5">


        <div class="col-lg-7">


            <h1 class="display-4 fw-bold mb-3">
                Employee Management Made Simple
            </h1>


            <p class="lead text-muted mb-4">
                Manage employee records, track workforce information,
                and access important HR data from one place.
            </p>


            <div class="d-flex gap-2 flex-wrap">


                <?php

                if (isset($_SESSION["user_id"]))
                {

                ?>

                    <a
                        href="dashboard/index.php"
                        class="btn btn-primary btn-lg"
                    >
                        Go to Dashboard
                    </a>

                <?php

                }
                else
                {

                ?>

                    <a
                        href="login.php"
                        class="btn btn-primary btn-lg"
                    >
                        Login
                    </a>

                <?php

                }

                ?>


                <a
                    href="employees/view_employees.php"
                    class="btn btn-outline-secondary btn-lg"
                >
                    View Employees
                </a>


            </div>


        </div>


        <div class="col-lg-5 mt-5 mt-lg-0">


            <div class="card shadow-sm border-0">


                <div class="card-body p-4">


                    <h4 class="mb-4">
                        Employee Management System
                    </h4>


                    <div class="mb-3">

                        <h6 class="mb-1">
                            Centralized Employee Records
                        </h6>

                        <p class="text-muted mb-0">
                            Store and manage employee information
                            efficiently.
                        </p>

                    </div>


                    <div class="mb-3">

                        <h6 class="mb-1">
                            Role-Based Access
                        </h6>

                        <p class="text-muted mb-0">
                            Control access based on user roles
                            and permissions.
                        </p>

                    </div>


                    <div>

                        <h6 class="mb-1">
                            Workforce Insights
                        </h6>

                        <p class="text-muted mb-0">
                            Monitor employee statistics through
                            the dashboard.
                        </p>

                    </div>


                </div>


            </div>


        </div>


    </div>


    <div class="row g-4 mt-4">


        <div class="col-md-4">


            <div class="card shadow-sm h-100 border-0">


                <div class="card-body p-4">


                    <h4 class="mb-3">
                        Employee Management
                    </h4>


                    <p class="text-muted mb-0">
                        Add, view, update, search, and manage
                        employee records from a centralized system.
                    </p>


                </div>


            </div>


        </div>


        <div class="col-md-4">


            <div class="card shadow-sm h-100 border-0">


                <div class="card-body p-4">


                    <h4 class="mb-3">
                        Secure Access
                    </h4>


                    <p class="text-muted mb-0">
                        Authentication, sessions, password hashing,
                        and role-based authorization protect the system.
                    </p>


                </div>


            </div>


        </div>


        <div class="col-md-4">


            <div class="card shadow-sm h-100 border-0">


                <div class="card-body p-4">


                    <h4 class="mb-3">
                        Dashboard Insights
                    </h4>


                    <p class="text-muted mb-0">
                        View employee counts, department statistics,
                        salary information, and recent employees.
                    </p>


                </div>


            </div>


        </div>


    </div>


</div>


<?php

include "includes/footer.php";

?>