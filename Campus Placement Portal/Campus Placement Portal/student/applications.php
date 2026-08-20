<?php
session_start();
include '../dp.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* GET STUDENT APPLICATIONS */

$stmt = $conn->prepare(
    "SELECT applications.*, 
            jobs.company_name, 
            jobs.job_title,
            jobs.location, 
            jobs.salary
     FROM applications
     INNER JOIN jobs 
        ON applications.job_id = jobs.job_id
     WHERE applications.student_id = ?
     ORDER BY applications.application_id DESC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$applications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Applications | PlaceHub</title>

    <link rel="stylesheet" href="../style.css">

</head>

<body class="student-body">

<div class="student-layout">

    <!-- SIDEBAR -->

    <aside class="student-sidebar">

        <div class="student-logo">

            <div class="student-logo-icon">
                🎓
            </div>

            <div>
                <h2>PlaceHub</h2>
                <p>Student Portal</p>
            </div>

        </div>


        <!-- MENU -->

        <div class="student-menu">

            <a href="dashboard.php">
                <span>🏠</span>
                Dashboard
            </a>

            <a href="jobs.php">
                <span>💼</span>
                Available Jobs
            </a>

            <a href="applications.php" class="active">
                <span>📋</span>
                My Applications
            </a>

        </div>


        <!-- BOTTOM MENU -->

        <div class="student-bottom">

            <a href="../index.php">
                <span>🌐</span>
                View Website
            </a>

            <a href="../logout.php" class="student-logout">
                <span>🚪</span>
                Logout
            </a>

        </div>

    </aside>


    <!-- MAIN CONTENT -->

    <main class="student-main">


        <!-- PAGE HEADER -->

        <div class="page-top">

            <div>

                <p class="student-small-title">
                    APPLICATION TRACKER
                </p>

                <h1>
                    My Applications 📋
                </h1>

                <p class="student-subtitle">
                    Track the status of all your job applications.
                </p>

            </div>

        </div>


        <!-- APPLICATIONS -->

        <div class="jobs-container">


            <?php if ($applications && $applications->num_rows > 0) { ?>


                <?php while ($application = $applications->fetch_assoc()) { ?>


                    <div class="job-card">


                        <!-- JOB HEADER -->

                        <div class="job-card-top">

                            <div class="company-icon">
                                💼
                            </div>


                            <div class="job-title-area">

                                <h2>
                                    <?php
                                    echo htmlspecialchars(
                                        $application['job_title']
                                    );
                                    ?>
                                </h2>


                                <p>
                                    <?php
                                    echo htmlspecialchars(
                                        $application['company_name']
                                    );
                                    ?>
                                </p>

                            </div>

                        </div>


                        <!-- JOB DETAILS -->

                        <div class="job-details">

                            <span>

                                📍

                                <?php
                                echo htmlspecialchars(
                                    $application['location']
                                );
                                ?>

                            </span>


                            <span>

                                💰

                                <?php
                                echo htmlspecialchars(
                                    $application['salary']
                                );
                                ?>

                            </span>

                        </div>


                        <!-- APPLICATION DATE -->

                        <?php if (isset($application['applied_at'])) { ?>

                            <div class="job-details">

                                <span>

                                    📅 Applied:

                                    <?php
                                    echo htmlspecialchars(
                                        $application['applied_at']
                                    );
                                    ?>

                                </span>

                            </div>

                        <?php } ?>


                        <!-- APPLICATION STATUS -->

                        <div class="application-status">

                            <strong>
                                Application Status:
                            </strong>


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
                        You haven't applied for any jobs yet.
                        Start exploring available opportunities.
                    </p>


                    <a href="jobs.php">
                        Explore Jobs →
                    </a>

                </div>


            <?php } ?>


        </div>


    </main>


</div>

</body>

</html>