<?php

include "../includes/auth_check.php";

include "../config/db_connect.php";


$summarySql = "
    SELECT
        COUNT(*) AS total_employees,
        SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) AS active_employees,
        SUM(CASE WHEN status = 'Inactive' THEN 1 ELSE 0 END) AS inactive_employees,
        SUM(CASE WHEN status = 'On Leave' THEN 1 ELSE 0 END) AS on_leave,
        COUNT(DISTINCT department) AS total_departments,
        AVG(salary) AS average_salary,
        SUM(salary) AS total_payroll
    FROM employees
";


$summaryResult = mysqli_query(
    $conn,
    $summarySql
);


$summary = mysqli_fetch_assoc(
    $summaryResult
);


$totalEmployees = $summary["total_employees"] ?? 0;

$activeEmployees = $summary["active_employees"] ?? 0;

$inactiveEmployees = $summary["inactive_employees"] ?? 0;

$onLeaveEmployees = $summary["on_leave"] ?? 0;

$totalDepartments = $summary["total_departments"] ?? 0;

$averageSalary = $summary["average_salary"] ?? 0;

$totalPayroll = $summary["total_payroll"] ?? 0;


$departmentSql = "
    SELECT
        department,
        COUNT(*) AS employee_count,
        AVG(salary) AS average_salary
    FROM employees
    GROUP BY department
    ORDER BY employee_count DESC, department ASC
";


$departmentResult = mysqli_query(
    $conn,
    $departmentSql
);


$recentEmployeesSql = "
    SELECT
        id,
        name,
        email,
        department,
        designation,
        joining_date,
        status
    FROM employees
    ORDER BY joining_date DESC, id DESC
    LIMIT 5
";


$recentEmployeesResult = mysqli_query(
    $conn,
    $recentEmployeesSql
);


$pageTitle = "Dashboard";


include "../includes/header.php";

?>

<div class="container mt-5 mb-5">


    <div class="dashboard-header">

        <h1>
            Dashboard
        </h1>

        <p class="text-muted welcome-text">

            Welcome back,
            <strong>
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </strong>.

            Here's an overview of your workforce.

        </p>

    </div>


    <div class="row g-4 dashboard-section">


        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted dashboard-label">
                        Total Employees
                    </p>

                    <h2 class="dashboard-value">
                        <?php echo $totalEmployees; ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted dashboard-label">
                        Active Employees
                    </p>

                    <h2 class="dashboard-value">
                        <?php echo $activeEmployees; ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted dashboard-label">
                        Inactive Employees
                    </p>

                    <h2 class="dashboard-value">
                        <?php echo $inactiveEmployees; ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted dashboard-label">
                        Employees On Leave
                    </p>

                    <h2 class="dashboard-value">
                        <?php echo $onLeaveEmployees; ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-4 col-md-6">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted dashboard-label">
                        Departments
                    </p>

                    <h2 class="dashboard-value">
                        <?php echo $totalDepartments; ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-4 col-md-6">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted dashboard-label">
                        Average Salary
                    </p>

                    <h2 class="dashboard-value">
                        ₹<?php echo number_format($averageSalary, 2); ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-4 col-md-12">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted dashboard-label">
                        Total Payroll
                    </p>

                    <h2 class="dashboard-value">
                        ₹<?php echo number_format($totalPayroll, 2); ?>
                    </h2>

                </div>

            </div>

        </div>


    </div>


    <div class="card shadow-sm dashboard-section dashboard-table">

        <div class="card-body p-4">


            <h3 class="dashboard-section-title">
                Department Summary
            </h3>

            <p class="text-muted dashboard-section-subtitle">
                Employee distribution and average salary by department.
            </p>


            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>
                                Department
                            </th>

                            <th>
                                Employees
                            </th>

                            <th>
                                Average Salary
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    if (mysqli_num_rows($departmentResult) > 0)
                    {

                        while (
                            $departmentRow =
                            mysqli_fetch_assoc($departmentResult)
                        )
                        {

                    ?>

                            <tr>

                                <td>

                                    <strong>
                                        <?php
                                        echo htmlspecialchars(
                                            $departmentRow["department"]
                                        );
                                        ?>
                                    </strong>

                                </td>


                                <td>

                                    <?php
                                    echo $departmentRow["employee_count"];
                                    ?>

                                </td>


                                <td>

                                    ₹<?php
                                    echo number_format(
                                        $departmentRow["average_salary"],
                                        2
                                    );
                                    ?>

                                </td>

                            </tr>

                    <?php

                        }

                    }
                    else
                    {

                    ?>

                        <tr>

                            <td
                                colspan="3"
                                class="text-center text-muted py-4"
                            >
                                No department data available.
                            </td>

                        </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>


        </div>

    </div>


    <div
        class="d-flex justify-content-between align-items-center mb-3"
    >

        <div>

            <h3 class="dashboard-section-title">
                Recent Employees
            </h3>

            <p class="text-muted dashboard-section-subtitle">
                Most recently joined employees.
            </p>

        </div>


        <a
            href="../employees/view_employees.php"
            class="btn btn-outline-primary"
        >
            View All Employees
        </a>

    </div>


    <div class="card shadow-sm dashboard-table">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Joining Date</th>
                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    if (
                        mysqli_num_rows(
                            $recentEmployeesResult
                        ) > 0
                    )
                    {

                        while (
                            $row =
                            mysqli_fetch_assoc(
                                $recentEmployeesResult
                            )
                        )
                        {

                    ?>

                            <tr>

                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $row["id"]
                                    );
                                    ?>
                                </td>


                                <td>

                                    <strong>
                                        <?php
                                        echo htmlspecialchars(
                                            $row["name"]
                                        );
                                        ?>
                                    </strong>

                                </td>


                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $row["department"]
                                    );
                                    ?>
                                </td>


                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $row["designation"]
                                    );
                                    ?>
                                </td>


                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $row["joining_date"]
                                    );
                                    ?>
                                </td>


                                <td>


                                    <?php

                                    if (
                                        $row["status"] === "Active"
                                    )
                                    {
                                        echo '<span class="badge bg-success">Active</span>';
                                    }
                                    elseif (
                                        $row["status"] === "Inactive"
                                    )
                                    {
                                        echo '<span class="badge bg-secondary">Inactive</span>';
                                    }
                                    else
                                    {
                                        echo '<span class="badge bg-warning text-dark">On Leave</span>';
                                    }

                                    ?>


                                </td>

                            </tr>

                    <?php

                        }

                    }
                    else
                    {

                    ?>

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted py-4"
                            >
                                No employees found.
                            </td>

                        </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


</div>


<?php

include "../includes/footer.php";

?>