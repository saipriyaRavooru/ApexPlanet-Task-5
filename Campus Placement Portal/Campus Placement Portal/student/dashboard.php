<?php
session_start();
include '../dp.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

/* Total Jobs */
$jobs_result = $conn->query("SELECT COUNT(*) AS total FROM jobs");
$total_jobs = $jobs_result ? $jobs_result->fetch_assoc()['total'] : 0;

/* My Applications */
$app_result = $conn->query(
    "SELECT COUNT(*) AS total FROM applications WHERE student_id = $student_id"
);
$total_applications = $app_result ? $app_result->fetch_assoc()['total'] : 0;

/* Selected Applications */
$selected_result = $conn->query(
    "SELECT COUNT(*) AS total FROM applications 
     WHERE student_id = $student_id AND status = 'Selected'"
);
$total_selected = $selected_result ? $selected_result->fetch_assoc()['total'] : 0;

/* Pending Applications */
$pending_result = $conn->query(
    "SELECT COUNT(*) AS total FROM applications 
     WHERE student_id = $student_id AND status = 'Pending'"
);
$total_pending = $pending_result ? $pending_result->fetch_assoc()['total'] : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard</title>

    <link rel="stylesheet" href="../style.css">
</head>

<body class="student-body">

<div class="student-layout">

    <!-- SIDEBAR -->

    <aside class="student-sidebar">

        <div class="student-logo">

            <div class="student-logo-icon">🎓</div>

            <div>
                <h2>PlaceHub</h2>
                <p>Student Portal</p>
            </div>

        </div>


        <div class="student-menu">

            <a href="dashboard.php" class="active">
                <span>🏠</span> Dashboard
            </a>

            <a href="jobs.php">
                <span>💼</span> Available Jobs
            </a>

            <a href="applications.php">
                <span>📋</span> My Applications
            </a>

        </div>


        <div class="student-bottom">

            <a href="../index.php">
                <span>🌐</span> Home
            </a>

            <a href="../logout.php" class="student-logout">
                <span>🚪</span> Logout
            </a>

        </div>

    </aside>


    <!-- MAIN CONTENT -->

    <main class="student-main">

        <!-- WELCOME -->

        <div class="student-top">

            <div>

                <p class="student-small-title">
                    STUDENT DASHBOARD
                </p>

                <h1>
                    Hello,
                    <span>
                        <?php echo htmlspecialchars($_SESSION['name']); ?>
                    </span> 👋
                </h1>

                <p class="student-subtitle">
                    Discover opportunities and track your placement journey.
                </p>

            </div>


            <div class="student-profile">

                <div class="student-avatar">
                    <?php
                    echo strtoupper(substr($_SESSION['name'], 0, 1));
                    ?>
                </div>

                <div>
                    <strong>
                        <?php echo htmlspecialchars($_SESSION['name']); ?>
                    </strong>

                    <p>Student</p>
                </div>

            </div>

        </div>


        <!-- STATS -->

        <section class="student-stats">

            <div class="student-stat-card">

                <div class="student-stat-icon">💼</div>

                <div>
                    <p>Available Jobs</p>

                    <h2>
                        <?php echo $total_jobs; ?>
                    </h2>

                    <span>Explore opportunities</span>
                </div>

            </div>


            <div class="student-stat-card">

                <div class="student-stat-icon">📄</div>

                <div>
                    <p>My Applications</p>

                    <h2>
                        <?php echo $total_applications; ?>
                    </h2>

                    <span>Jobs applied</span>
                </div>

            </div>


            <div class="student-stat-card">

                <div class="student-stat-icon">⏳</div>

                <div>
                    <p>Pending</p>

                    <h2>
                        <?php echo $total_pending; ?>
                    </h2>

                    <span>Applications under review</span>
                </div>

            </div>


            <div class="student-stat-card">

                <div class="student-stat-icon">🏆</div>

                <div>
                    <p>Selected</p>

                    <h2>
                        <?php echo $total_selected; ?>
                    </h2>

                    <span>Successful applications</span>
                </div>

            </div>

        </section>


        <!-- PLACEMENT JOURNEY -->

        <section class="journey-section">

            <div class="journey-heading">

                <p>YOUR PLACEMENT JOURNEY</p>

                <h2>Take the next step 🚀</h2>

            </div>


            <div class="journey-grid">

                <div class="journey-card">

                    <div class="journey-number">01</div>

                    <div class="journey-icon">🔍</div>

                    <h3>Explore Jobs</h3>

                    <p>
                        Browse available placement opportunities.
                    </p>

                    <a href="jobs.php">
                        View Jobs →
                    </a>

                </div>


                <div class="journey-card">

                    <div class="journey-number">02</div>

                    <div class="journey-icon">📝</div>

                    <h3>Apply</h3>

                    <p>
                        Submit your application for your preferred job.
                    </p>

                    <a href="jobs.php">
                        Apply Now →
                    </a>

                </div>


                <div class="journey-card">

                    <div class="journey-number">03</div>

                    <div class="journey-icon">📊</div>

                    <h3>Track Status</h3>

                    <p>
                        Check the status of all your applications.
                    </p>

                    <a href="applications.php">
                        View Applications →
                    </a>

                </div>

            </div>

        </section>


        <!-- FOOTER -->

        <div class="student-footer">

            <div>
                <span class="student-status-dot"></span>
                Placement portal is active
            </div>

            <p>Campus Placement Portal © 2026</p>

        </div>

    </main>

</div>

</body>
</html>