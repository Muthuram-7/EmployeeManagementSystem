<?php

include __DIR__ . "/session.php";

?>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">

    <div class="container">

        <a
            class="navbar-brand"
            href="/EmployeeManagementSystem/index.php"
        >
            Employee Management System
        </a>


        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <div
            class="collapse navbar-collapse"
            id="navbarNav"
        >

            <ul class="navbar-nav ms-auto align-items-lg-center">


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="/EmployeeManagementSystem/index.php"
                    >
                        Home
                    </a>

                </li>


                <?php

                if (isset($_SESSION["user_id"]))
                {

                ?>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="/EmployeeManagementSystem/dashboard/index.php"
                        >
                            Dashboard
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="/EmployeeManagementSystem/employees/view_employees.php"
                        >
                            Employees
                        </a>

                    </li>


                    <?php

                    if (
                        $_SESSION["role"] === "Admin" ||
                        $_SESSION["role"] === "HR Manager"
                    )
                    {

                    ?>

                        <li class="nav-item">

                            <a
                                class="nav-link"
                                href="/EmployeeManagementSystem/employees/add_employee.php"
                            >
                                Add Employee
                            </a>

                        </li>

                    <?php

                    }


                    if ($_SESSION["role"] === "Admin")
                    {

                    ?>

                        <li class="nav-item">

                            <a
                                class="nav-link"
                                href="/EmployeeManagementSystem/users/index.php"
                            >
                                Users
                            </a>

                        </li>

                    <?php

                    }

                    ?>


                    <li class="nav-item ms-lg-3">

                        <span class="navbar-text text-light">

                            <?php echo htmlspecialchars($_SESSION["username"]); ?>

                            <span class="text-secondary">

                                (<?php echo htmlspecialchars($_SESSION["role"]); ?>)

                            </span>

                        </span>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="/EmployeeManagementSystem/change_password.php"
                        >
                            Change Password
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="/EmployeeManagementSystem/logout.php"
                        >
                            Logout
                        </a>

                    </li>

                <?php

                }
                else
                {

                ?>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="/EmployeeManagementSystem/login.php"
                        >
                            Login
                        </a>

                    </li>

                <?php

                }

                ?>


            </ul>

        </div>

    </div>

</nav>