<?php

include "../includes/auth_check.php";

include "../includes/csrf.php";

include "../config/db_connect.php";


$search = trim($_GET["search"] ?? "");

$department = trim($_GET["department"] ?? "");

$status = trim($_GET["status"] ?? "");

$page = (int) ($_GET["page"] ?? 1);


if ($page < 1)
{
    $page = 1;
}


$recordsPerPage = 5;

$offset = ($page - 1) * $recordsPerPage;


$departmentQuery = "
    SELECT DISTINCT department
    FROM employees
    WHERE department != ''
    ORDER BY department
";


$departmentResult = mysqli_query(
    $conn,
    $departmentQuery
);


$statuses = [
    "Active",
    "Inactive",
    "On Leave"
];


$countSql = "
    SELECT COUNT(*) AS total
    FROM employees
    WHERE
        (
            name LIKE ?
            OR email LIKE ?
            OR phone_number LIKE ?
            OR department LIKE ?
            OR designation LIKE ?
        )
        AND (? = '' OR department = ?)
        AND (? = '' OR status = ?)
";


$countStmt = mysqli_prepare(
    $conn,
    $countSql
);


$searchValue = "%" . $search . "%";


mysqli_stmt_bind_param(
    $countStmt,
    "sssssssss",
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $department,
    $department,
    $status,
    $status
);


mysqli_stmt_execute($countStmt);


$countResult = mysqli_stmt_get_result(
    $countStmt
);


$countRow = mysqli_fetch_assoc(
    $countResult
);


$totalEmployees = $countRow["total"];


$totalPages = ceil(
    $totalEmployees / $recordsPerPage
);


$sql = "
    SELECT *
    FROM employees
    WHERE
        (
            name LIKE ?
            OR email LIKE ?
            OR phone_number LIKE ?
            OR department LIKE ?
            OR designation LIKE ?
        )
        AND (? = '' OR department = ?)
        AND (? = '' OR status = ?)
    ORDER BY id DESC
    LIMIT ? OFFSET ?
";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


mysqli_stmt_bind_param(
    $stmt,
    "sssssssssii",
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $department,
    $department,
    $status,
    $status,
    $recordsPerPage,
    $offset
);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result(
    $stmt
);


$pageTitle = "Employee Records";

include "../includes/header.php";

?>


<div class="container mt-5 mb-5">


    <?php

    if (isset($_SESSION["success"]))
    {
        echo '<div class="alert alert-success">';
        echo htmlspecialchars($_SESSION["success"]);
        echo '</div>';

        unset($_SESSION["success"]);
    }


    if (isset($_SESSION["error"]))
    {
        echo '<div class="alert alert-danger">';
        echo htmlspecialchars($_SESSION["error"]);
        echo '</div>';

        unset($_SESSION["error"]);
    }

    ?>


    <div class="d-flex justify-content-between employee-page-header">


        <div>

            <h1>
                Employee Records
            </h1>

            <p class="text-muted">
                View and manage all employees.
            </p>

        </div>


        <?php

        if (
            $_SESSION["role"] === "Admin" ||
            $_SESSION["role"] === "HR Manager"
        )
        {

        ?>

            <a
                href="add_employee.php"
                class="btn btn-primary align-self-start"
            >
                + Add Employee
            </a>

        <?php

        }

        ?>


    </div>


    <div class="card shadow-sm mb-4 employee-filter-card">


        <div class="card-body p-4">


            <form method="GET">


                <div class="row g-3">


                    <div class="col-lg-5">

                        <label
                            for="search"
                            class="form-label"
                        >
                            Search Employees
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="search"
                            name="search"
                            placeholder="Name, email, phone, department or designation"
                            value="<?php echo htmlspecialchars($search); ?>"
                        >

                    </div>


                    <div class="col-lg-3">

                        <label
                            for="department"
                            class="form-label"
                        >
                            Department
                        </label>

                        <select
                            class="form-select"
                            id="department"
                            name="department"
                        >

                            <option value="">
                                All Departments
                            </option>


                            <?php

                            while (
                                $departmentRow =
                                mysqli_fetch_assoc(
                                    $departmentResult
                                )
                            )
                            {

                            ?>

                                <option
                                    value="<?php echo htmlspecialchars($departmentRow["department"]); ?>"
                                    <?php

                                    if (
                                        $department ===
                                        $departmentRow["department"]
                                    )
                                    {
                                        echo "selected";
                                    }

                                    ?>
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        $departmentRow["department"]
                                    );
                                    ?>

                                </option>

                            <?php

                            }

                            ?>

                        </select>

                    </div>


                    <div class="col-lg-2">

                        <label
                            for="status"
                            class="form-label"
                        >
                            Status
                        </label>

                        <select
                            class="form-select"
                            id="status"
                            name="status"
                        >

                            <option value="">
                                All Status
                            </option>


                            <?php

                            foreach ($statuses as $statusOption)
                            {

                            ?>

                                <option
                                    value="<?php echo htmlspecialchars($statusOption); ?>"
                                    <?php

                                    if (
                                        $status ===
                                        $statusOption
                                    )
                                    {
                                        echo "selected";
                                    }

                                    ?>
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        $statusOption
                                    );
                                    ?>

                                </option>

                            <?php

                            }

                            ?>

                        </select>

                    </div>


                    <div class="col-lg-2 d-flex align-items-end">


                        <div class="d-flex gap-2 w-100">


                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                Search
                            </button>


                            <a
                                href="view_employees.php"
                                class="btn btn-outline-secondary"
                            >
                                Reset
                            </a>


                        </div>


                    </div>


                </div>


            </form>


        </div>


    </div>


    <div class="card shadow-sm employee-list-card">


        <div class="card-body p-4">


            <div
                class="d-flex justify-content-between align-items-center employee-list-header mb-3"
            >


                <div>

                    <h5 class="mb-1">
                        Employee List
                    </h5>

                    <small class="text-muted">
                        Manage employee records and information.
                    </small>

                </div>


                <span class="employee-count">

                    <?php echo $totalEmployees; ?>

                    employee<?php echo ($totalEmployees == 1) ? "" : "s"; ?>

                </span>


            </div>


            <div class="table-responsive">


                <table class="table table-hover align-middle employee-table">


                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Salary</th>
                            <th>Joining Date</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php

                    if (mysqli_num_rows($result) > 0)
                    {

                        while ($row = mysqli_fetch_assoc($result))
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
                                        $row["email"]
                                    );
                                    ?>

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

                                    ₹<?php
                                    echo number_format(
                                        $row["salary"],
                                        2
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
                                        $row["status"] ===
                                        "Active"
                                    )
                                    {
                                        echo '<span class="badge bg-success">Active</span>';
                                    }
                                    elseif (
                                        $row["status"] ===
                                        "Inactive"
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


                                <td class="employee-actions">


                                    <a
                                        href="view_employee.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-sm btn-info"
                                    >
                                        View
                                    </a>


                                    <?php

                                    if (
                                        $_SESSION["role"] === "Admin" ||
                                        $_SESSION["role"] === "HR Manager"
                                    )
                                    {

                                    ?>


                                        <a
                                            href="edit_employee.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </a>


                                        <form
                                            action="delete_employee.php"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this employee?');"
                                        >


                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?php echo htmlspecialchars($row['id']); ?>"
                                            >


                                            <input
                                                type="hidden"
                                                name="csrf_token"
                                                value="<?php echo htmlspecialchars(csrf_token()); ?>"
                                            >


                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                            >
                                                Delete
                                            </button>


                                        </form>


                                    <?php

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
                                colspan="9"
                                class="text-center text-muted py-5"
                            >

                                <h5 class="mb-2">
                                    No employees found
                                </h5>

                                <p class="mb-0">
                                    Try changing your search or filters.
                                </p>

                            </td>

                        </tr>


                    <?php

                    }

                    ?>


                    </tbody>


                </table>


            </div>


            <?php

            if ($totalPages > 1)
            {

            ?>


                <nav class="mt-4">

                    <ul class="pagination justify-content-center">


                        <li
                            class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>"
                        >

                            <a
                                class="page-link"
                                href="?search=<?php echo urlencode($search); ?>&department=<?php echo urlencode($department); ?>&status=<?php echo urlencode($status); ?>&page=<?php echo $page - 1; ?>"
                            >
                                Previous
                            </a>

                        </li>


                        <?php

                        for (
                            $i = 1;
                            $i <= $totalPages;
                            $i++
                        )
                        {

                        ?>


                            <li
                                class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>"
                            >

                                <a
                                    class="page-link"
                                    href="?search=<?php echo urlencode($search); ?>&department=<?php echo urlencode($department); ?>&status=<?php echo urlencode($status); ?>&page=<?php echo $i; ?>"
                                >

                                    <?php echo $i; ?>

                                </a>

                            </li>


                        <?php

                        }

                        ?>


                        <li
                            class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>"
                        >

                            <a
                                class="page-link"
                                href="?search=<?php echo urlencode($search); ?>&department=<?php echo urlencode($department); ?>&status=<?php echo urlencode($status); ?>&page=<?php echo $page + 1; ?>"
                            >
                                Next
                            </a>

                        </li>


                    </ul>

                </nav>


            <?php

            }

            ?>


        </div>


    </div>


</div>


<?php

include "../includes/footer.php";

?>