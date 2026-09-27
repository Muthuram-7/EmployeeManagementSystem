<?php

include "../includes/employee_manage_check.php";

include "../includes/csrf.php";

$pageTitle = "Add Employee";

include "../includes/header.php";

?>

<div class="container mt-5 mb-5">

    <div class="row justify-content-center">

        <div class="col-lg-7 col-md-9">

            <div class="mb-4">

                <h1 class="mb-1">
                    Add New Employee
                </h1>

                <p class="text-muted">
                    Enter the employee details below.
                </p>

            </div>


            <?php

            if (isset($_SESSION["error"]))
            {
                echo '<div class="alert alert-danger">';
                echo htmlspecialchars($_SESSION["error"]);
                echo '</div>';

                unset($_SESSION["error"]);
            }

            ?>


            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <form action="save_employee.php" method="POST">


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
                                placeholder="Enter employee name"
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
                                placeholder="Enter employee email"
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
                                placeholder="Enter phone number"
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
                                placeholder="Example: IT, HR, Finance"
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
                                placeholder="Example: Software Developer"
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
                                    placeholder="Enter salary"
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

                                <option value="Active">
                                    Active
                                </option>

                                <option value="Inactive">
                                    Inactive
                                </option>

                                <option value="On Leave">
                                    On Leave
                                </option>

                            </select>

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Add Employee
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