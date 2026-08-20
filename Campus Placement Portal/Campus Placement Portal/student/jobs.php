<?php

session_start();
include '../dp.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

/* SHOW APPLICATION MESSAGE */

$message = "";

if (isset($_SESSION['application_message'])) {

    $message = $_SESSION['application_message'];

    unset($_SESSION['application_message']);
}


/* GET ALL JOBS */

$jobs = $conn->query(
    "SELECT * FROM jobs ORDER BY last_date ASC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Available Jobs | PlaceHub</title>

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


        <div class="student-menu">

            <a href="dashboard.php">

                <span>🏠</span>
                Dashboard

            </a>


            <a href="jobs.php" class="active">

                <span>💼</span>
                Available Jobs

            </a>


            <a href="applications.php">

                <span>📋</span>
                My Applications

            </a>

        </div>


        <div class="student-bottom">

            <a href="../index.php">

                <span>🌐</span>
                View Website

            </a>


            <a href="../logout.php"
               class="student-logout">

                <span>🚪</span>
                Logout

            </a>

        </div>

    </aside>


    <!-- MAIN CONTENT -->

    <main class="student-main">


        <div class="page-top">

            <div>

                <p class="student-small-title">
                    PLACEMENT OPPORTUNITIES
                </p>

                <h1>
                    Available Jobs 💼
                </h1>

                <p class="student-subtitle">
                    Explore opportunities and apply for your dream job.
                </p>

            </div>

        </div>


        <!-- APPLICATION MESSAGE -->

        <?php if ($message != "") { ?>

            <div class="application-message">

                <?php echo htmlspecialchars($message); ?>

            </div>

        <?php } ?>


        <!-- JOBS -->

        <div class="jobs-container">


            <?php if ($jobs && $jobs->num_rows > 0) { ?>


                <?php while ($job = $jobs->fetch_assoc()) { ?>


                    <div class="job-card">


                        <div class="job-card-top">

                            <div class="company-icon">
                                💼
                            </div>


                            <div class="job-title-area">

                                <h2>

                                    <?php
                                    echo htmlspecialchars(
                                        $job['job_title']
                                    );
                                    ?>

                                </h2>


                                <p>

                                    <?php
                                    echo htmlspecialchars(
                                        $job['company_name']
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
                                    $job['location']
                                );
                                ?>

                            </span>


                            <span>

                                💰

                                <?php
                                echo htmlspecialchars(
                                    $job['salary']
                                );
                                ?>

                            </span>


                            <span>

                                📅 Last Date:

                                <?php
                                echo htmlspecialchars(
                                    $job['last_date']
                                );
                                ?>

                            </span>


                        </div>


                        <!-- JOB DESCRIPTION -->

                        <div class="job-description">

                            <?php

                            echo htmlspecialchars(
                                substr(
                                    $job['description'],
                                    0,
                                    150
                                )
                            );

                            ?>

                        </div>


                        <!-- APPLY BUTTON -->

                        <div class="job-actions">

                            <a href="apply.php?apply=<?php echo $job['job_id']; ?>"
                               class="apply-btn"
                               onclick="return confirm('Do you want to apply for this job?')">

                                📝 Apply Now

                            </a>

                        </div>


                    </div>


                <?php } ?>


            <?php } else { ?>


                <div class="no-jobs">


                    <div class="no-job-icon">
                        💼
                    </div>


                    <h2>
                        No Jobs Available
                    </h2>


                    <p>
                        There are currently no placement opportunities available.
                    </p>


                </div>


            <?php } ?>


        </div>


    </main>


</div>


</body>

</html>