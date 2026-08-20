
<?php

session_start();
include '../dp.php';

/* CHECK ADMIN LOGIN */

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = "";


/* UPDATE APPLICATION STATUS */

if (isset($_POST['update_status'])) {

    $application_id = (int)$_POST['application_id'];
    $status = $_POST['status'];

    $allowed_status = ['Pending', 'Selected', 'Rejected'];

    if (in_array($status, $allowed_status)) {

        $stmt = $conn->prepare(
            "UPDATE applications
             SET status = ?
             WHERE application_id = ?"
        );

        if (!$stmt) {
            die("Database error: " . $conn->error);
        }

        $stmt->bind_param(
            "si",
            $status,
            $application_id
        );

        if ($stmt->execute()) {

            $message = "Application status updated successfully!";

        } else {

            $message = "Failed to update application status: " . $stmt->error;

        }

        $stmt->close();

    } else {

        $message = "Invalid application status.";

    }
}


/* GET ALL APPLICATIONS */

$applications = $conn->query(
    "SELECT

        applications.application_id,
        applications.status,

        students.student_id,
        students.roll_no,
        students.department,

        users.name AS student_name,
        users.email AS student_email,

        jobs.job_title,
        jobs.company_name,
        jobs.location,
        jobs.salary

    FROM applications

    INNER JOIN students
        ON applications.student_id = students.student_id

    INNER JOIN users
        ON students.user_id = users.id

    INNER JOIN jobs
        ON applications.job_id = jobs.job_id

    ORDER BY applications.application_id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Applications | PlaceHub</title>

    <link rel="stylesheet" href="../style.css">

</head>


<body class="admin-body">

<div class="admin-layout">


    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="sidebar-logo">

            <div class="logo-icon">
                🎓
            </div>

            <div>

                <h2>PlaceHub</h2>

                <p>Admin Portal</p>

            </div>

        </div>


        <div class="sidebar-menu">

            <a href="dashboard.php">

                <span>🏠</span>
                Dashboard

            </a>


            <a href="jobs.php">

                <span>💼</span>
                Manage Jobs

            </a>


            <a href="add_job.php">

                <span>➕</span>
                Add Job

            </a>


            <a href="applications.php" class="active">

                <span>📋</span>
                Applications

            </a>

        </div>


        <div class="sidebar-bottom">

            <a href="../index.php">

                <span>🌐</span>
                View Website

            </a>


            <a href="../logout.php"
               class="logout-btn">

                <span>🚪</span>
                Logout

            </a>

        </div>

    </aside>



    <!-- MAIN CONTENT -->

    <main class="admin-main">


        <div class="page-top">

            <div>

                <p class="welcome-small">
                    APPLICATION MANAGEMENT
                </p>


                <h1>
                    Student Applications 📋
                </h1>


                <p class="dashboard-subtitle">
                    Review student applications and update their status.
                </p>

            </div>

        </div>



        <!-- MESSAGE -->

        <?php if ($message != "") { ?>

            <div class="application-message">

                <?php
                echo htmlspecialchars($message);
                ?>

            </div>

        <?php } ?>



        <!-- APPLICATION LIST -->

        <div class="applications-list">


            <?php if ($applications && $applications->num_rows > 0) { ?>


                <?php while ($application = $applications->fetch_assoc()) { ?>


                    <div class="application-card">


                        <!-- STUDENT INFORMATION -->

                        <div class="application-header">

                            <div>

                                <p class="application-label">
                                    STUDENT
                                </p>


                                <h2>

                                    <?php
                                    echo htmlspecialchars(
                                        $application['student_name']
                                    );
                                    ?>

                                </h2>


                                <p class="student-email">

                                    <?php
                                    echo htmlspecialchars(
                                        $application['student_email']
                                    );
                                    ?>

                                </p>


                                <p class="student-email">

                                    Roll No:
                                    <?php
                                    echo htmlspecialchars(
                                        $application['roll_no']
                                    );
                                    ?>

                                </p>

                            </div>



                            <!-- STATUS -->

                            <?php

                            $status = $application['status'];

                            if ($status == 'Selected') {

                                $status_class = 'status-selected';

                            } elseif ($status == 'Rejected') {

                                $status_class = 'status-rejected';

                            } else {

                                $status_class = 'status-pending';

                            }

                            ?>


                            <span class="<?php echo $status_class; ?>">

                                <?php
                                echo htmlspecialchars($status);
                                ?>

                            </span>

                        </div>



                        <!-- JOB INFORMATION -->

                        <div class="application-job-info">


                            <div>

                                <p>
                                    JOB POSITION
                                </p>

                                <h3>

                                    <?php
                                    echo htmlspecialchars(
                                        $application['job_title']
                                    );
                                    ?>

                                </h3>

                            </div>



                            <div>

                                <p>
                                    COMPANY
                                </p>

                                <h3>

                                    <?php
                                    echo htmlspecialchars(
                                        $application['company_name']
                                    );
                                    ?>

                                </h3>

                            </div>



                            <div>

                                <p>
                                    LOCATION
                                </p>

                                <h3>

                                    📍

                                    <?php
                                    echo htmlspecialchars(
                                        $application['location']
                                    );
                                    ?>

                                </h3>

                            </div>



                            <div>

                                <p>
                                    SALARY
                                </p>

                                <h3>

                                    💰

                                    <?php
                                    echo htmlspecialchars(
                                        $application['salary']
                                    );
                                    ?>

                                </h3>

                            </div>


                        </div>



                        <!-- UPDATE STATUS -->

                        <form method="POST"
                              class="status-form">


                            <input
                                type="hidden"
                                name="application_id"
                                value="<?php
                                echo $application['application_id'];
                                ?>"
                            >


                            <select name="status">


                                <option value="Pending"

                                    <?php

                                    if ($status == 'Pending') {
                                        echo "selected";
                                    }

                                    ?>

                                >

                                    Pending

                                </option>



                                <option value="Selected"

                                    <?php

                                    if ($status == 'Selected') {
                                        echo "selected";
                                    }

                                    ?>

                                >

                                    Selected

                                </option>



                                <option value="Rejected"

                                    <?php

                                    if ($status == 'Rejected') {
                                        echo "selected";
                                    }

                                    ?>

                                >

                                    Rejected

                                </option>


                            </select>



                            <button
                                type="submit"
                                name="update_status">

                                Update Status

                            </button>


                        </form>


                    </div>


                <?php } ?>


            <?php } else { ?>


                <!-- NO APPLICATIONS -->

                <div class="no-jobs">


                    <div class="no-job-icon">

                        📋

                    </div>


                    <h2>
                        No Applications Yet
                    </h2>


                    <p>
                        Students have not applied for any jobs yet.
                    </p>


                </div>


            <?php } ?>


        </div>


    </main>


</div>


</body>

</html>

