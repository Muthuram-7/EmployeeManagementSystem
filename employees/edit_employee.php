<?php

include "../includes/employee_manage_check.php";

include "../includes/csrf.php";

include "../config/db_connect.php";


if (!isset($_GET["id"]))
{
    $_SESSION["error"] = "Invalid employee ID.";
    header("Location: view_employees.php");
    exit;
}


$id = (int) $_GET["id"];


if ($id <= 0)
{
    $_SESSION["error"] = "Invalid employee ID.";
    header("Location: view_employees.php");
    exit;
}


$sql = "SELECT * FROM employees WHERE id = ?";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


$row = mysqli_fetch_assoc($result);


if (!$row)
{
    $_SESSION["error"] = "Employee not found.";
    header("Location: view_employees.php");
    exit;
}


$pageTitle = "Edit Employee";

include "../includes/header.php";

?>


<div class="container mt-5 mb-5">


    <?php

    if (isset($_SESSION["error"]))
    {
        echo '<div class="alert alert-danger">';
        echo htmlspecialchars($_SESSION["error"]);
        echo '</div>';

        unset($_SESSION["error"]);
    }

    ?>


    <div class="row justify-content-center">

        <div class="col-lg-7 col-md-9">


            <div class="mb-4">

                <h1 class="mb-1">
                    Edit Employee
                </h1>

                <p class="text-muted">
                    Update the employee information below.
                </p>

            </div>


            <div class="card shadow-sm">

                <div class="card-body p-4">


                    <form
                        action="update_employee.php"
                        method="POST"
                    >


                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo htmlspecialchars($row["id"]); ?>"
                        >


                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?php echo htmlspecialchars(csrf_token()); ?>"
                        >


                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >
                                Full Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="<?php echo htmlspecialchars($row["name"]); ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?php echo htmlspecialchars($row["email"]); ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="phone_number"
                                class="form-label"
                            >
                                Phone Number
                            </label>

                            <input
                                type="tel"
                                class="form-control"
                                id="phone_number"
                                name="phone_number"
                                value="<?php echo htmlspecialchars($row["phone_number"]); ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="department"
                                class="form-label"
                            >
                                Department
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="department"
                                name="department"
                                value="<?php echo htmlspecialchars($row["department"]); ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="designation"
                                class="form-label"
                            >
                                Designation
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="designation"
                                name="designation"
                                value="<?php echo htmlspecialchars($row["designation"]); ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="salary"
                                class="form-label"
                            >
                                Salary
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₹
                                </span>

                                <input
                                    type="number"
                                    class="form-control"
                                    id="salary"
                                    name="salary"
                                    value="<?php echo htmlspecialchars($row["salary"]); ?>"
                                    min="0"
                                    step="0.01"
                                    required
                                >

                            </div>

                        </div>


                        <div class="mb-3">

                            <label
                                for="joining_date"
                                class="form-label"
                            >
                                Joining Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="joining_date"
                                name="joining_date"
                                value="<?php echo htmlspecialchars($row["joining_date"]); ?>"
                                required
                            >

                        </div>


                        <div class="mb-4">

                            <label
                                for="status"
                                class="form-label"
                            >
                                Employment Status
                            </label>

                            <select
                                class="form-select"
                                id="status"
                                name="status"
                                required
                            >


                                <option
                                    value="Active"
                                    <?php

                                    if ($row["status"] === "Active")
                                    {
                                        echo "selected";
                                    }

                                    ?>
                                >
                                    Active
                                </option>


                                <option
                                    value="Inactive"
                                    <?php

                                    if ($row["status"] === "Inactive")
                                    {
                                        echo "selected";
                                    }

                                    ?>
                                >
                                    Inactive
                                </option>


                                <option
                                    value="On Leave"
                                    <?php

                                    if ($row["status"] === "On Leave")
                                    {
                                        echo "selected";
                                    }

                                    ?>
                                >
                                    On Leave
                                </option>


                            </select>

                        </div>


                        <div class="d-flex gap-2">


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Update Employee
                            </button>


                            <a
                                href="view_employees.php"
                                class="btn btn-outline-secondary"
                            >
                                Cancel
                            </a>


                        </div>


                    </form>


                </div>

            </div>


        </div>

    </div>


</div>


<?php

include "../includes/footer.php";

?>