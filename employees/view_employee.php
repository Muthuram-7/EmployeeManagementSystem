<?php

include "../includes/auth_check.php";
include "../config/db_connect.php";

$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0)
{
    $_SESSION["error"] = "Invalid employee ID.";
    header("Location: view_employees.php");
    exit;
}

$sql = "
    SELECT
        id,
        name,
        email,
        phone_number,
        department,
        designation,
        salary,
        joining_date,
        status
    FROM employees
    WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt)
{
    $_SESSION["error"] = "Unable to load employee details.";
    header("Location: view_employees.php");
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$employee = mysqli_fetch_assoc($result);

if (!$employee)
{
    $_SESSION["error"] = "Employee not found.";
    header("Location: view_employees.php");
    exit;
}

$pageTitle = "Employee Details";

include "../includes/header.php";

?>

<div class="container mt-4 mb-5">

    <div class="employee-page-header">

        <div>
            <h1>Employee Details</h1>

            <p class="text-muted">
                View complete information about this employee.
            </p>
        </div>

        <a
            href="view_employees.php"
            class="btn btn-outline-secondary"
        >
            Back to Employees
        </a>

    </div>

    <div class="employee-details-card card shadow-sm">

        <div class="card-body p-4">

            <div class="employee-details-header">

                <div>
                    <h2 class="employee-details-name">
                        <?php echo htmlspecialchars($employee["name"]); ?>
                    </h2>

                    <p class="text-muted mb-0">
                        <?php echo htmlspecialchars($employee["designation"]); ?>
                    </p>
                </div>

                <div>
                    <?php
                    if ($employee["status"] === "Active")
                    {
                    ?>
                        <span class="badge bg-success">
                            Active
                        </span>
                    <?php
                    }
                    elseif ($employee["status"] === "Inactive")
                    {
                    ?>
                        <span class="badge bg-secondary">
                            Inactive
                        </span>
                    <?php
                    }
                    else
                    {
                    ?>
                        <span class="badge bg-warning text-dark">
                            On Leave
                        </span>
                    <?php
                    }
                    ?>
                </div>

            </div>

            <hr>

            <div class="employee-details-grid">

                <div class="employee-detail-item">

                    <span class="employee-detail-label">
                        Employee ID
                    </span>

                    <span class="employee-detail-value">
                        #<?php echo htmlspecialchars($employee["id"]); ?>
                    </span>

                </div>

                <div class="employee-detail-item">

                    <span class="employee-detail-label">
                        Department
                    </span>

                    <span class="employee-detail-value">
                        <?php echo htmlspecialchars($employee["department"]); ?>
                    </span>

                </div>

                <div class="employee-detail-item">

                    <span class="employee-detail-label">
                        Email
                    </span>

                    <span class="employee-detail-value">
                        <?php echo htmlspecialchars($employee["email"]); ?>
                    </span>

                </div>

                <div class="employee-detail-item">

                    <span class="employee-detail-label">
                        Phone Number
                    </span>

                    <span class="employee-detail-value">
                        <?php echo htmlspecialchars($employee["phone_number"]); ?>
                    </span>

                </div>

                <div class="employee-detail-item">

                    <span class="employee-detail-label">
                        Designation
                    </span>

                    <span class="employee-detail-value">
                        <?php echo htmlspecialchars($employee["designation"]); ?>
                    </span>

                </div>

                <div class="employee-detail-item">

                    <span class="employee-detail-label">
                        Salary
                    </span>

                    <span class="employee-detail-value">
                        ₹<?php echo number_format((float) $employee["salary"], 2); ?>
                    </span>

                </div>

                <div class="employee-detail-item">

                    <span class="employee-detail-label">
                        Joining Date
                    </span>

                    <span class="employee-detail-value">
                        <?php
                        echo date(
                            "d M Y",
                            strtotime($employee["joining_date"])
                        );
                        ?>
                    </span>

                </div>

                <div class="employee-detail-item">

                    <span class="employee-detail-label">
                        Status
                    </span>

                    <span class="employee-detail-value">
                        <?php echo htmlspecialchars($employee["status"]); ?>
                    </span>

                </div>

            </div>

            <hr>

            <div class="employee-details-actions">

                <?php
                if (
                    $_SESSION["role"] === "Admin" ||
                    $_SESSION["role"] === "HR Manager"
                )
                {
                ?>

                    <a
                        href="edit_employee.php?id=<?php echo $employee["id"]; ?>"
                        class="btn btn-primary"
                    >
                        Edit Employee
                    </a>

                <?php
                }
                ?>

                <a
                    href="view_employees.php"
                    class="btn btn-outline-secondary"
                >
                    Back to Employee List
                </a>

            </div>

        </div>

    </div>

</div>

<?php

include "../includes/footer.php";

?>