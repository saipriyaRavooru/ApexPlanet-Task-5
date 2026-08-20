<?php
session_start();
include '../dp.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

/* Dashboard Statistics */
$students_result = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'student'");
$total_students = $students_result ? $students_result->fetch_assoc()['total'] : 0;

$jobs_result = $conn->query("SELECT COUNT(*) AS total FROM jobs");
$total_jobs = $jobs_result ? $jobs_result->fetch_assoc()['total'] : 0;

$applications_result = $conn->query("SELECT COUNT(*) AS total FROM applications");
$total_applications = $applications_result ? $applications_result->fetch_assoc()['total'] : 0;

$selected_result = $conn->query("SELECT COUNT(*) AS total FROM applications WHERE status = 'Selected'");
$total_selected = $selected_result ? $selected_result->fetch_assoc()['total'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../style.css">
</head>

<body class="admin-body">

<div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-logo">
            <div class="logo-icon">🎓</div>
            <div>
                <h2>PlaceHub</h2>
                <p>Admin Portal</p>
            </div>
        </div>

        <div class="sidebar-menu">

            <a href="dashboard.php" class="active">
                <span>🏠</span> Dashboard
            </a>

            <a href="jobs.php">
                <span>💼</span> Manage Jobs
            </a>

            <a href="add_job.php">
                <span>➕</span> Add Job
            </a>

            <a href="applications.php">
                <span>📋</span> Applications
            </a>

        </div>

        <div class="sidebar-bottom">

            <a href="../index.php">
                <span>🌐</span> View Website
            </a>

            <a href="../logout.php" class="logout-btn">
                <span>🚪</span> Logout
            </a>

        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="admin-main">

        <!-- TOP SECTION -->
        <div class="dashboard-top">

            <div>
                <p class="welcome-small">ADMIN CONTROL PANEL</p>

                <h1>
                    Welcome back,
                    <span><?php echo htmlspecialchars($_SESSION['name']); ?></span> 👋
                </h1>

                <p class="dashboard-subtitle">
                    Manage campus placements and track all activities from one place.
                </p>
            </div>

            <div class="admin-profile">
                <div class="admin-avatar">
                    <?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?>
                </div>

                <div>
                    <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong>
                    <p>Administrator</p>
                </div>
            </div>

        </div>


        <!-- STATISTICS -->
        <section class="stats-grid">

            <div class="stat-card students-stat">
                <div class="stat-icon">🎓</div>

                <div>
                    <p>Total Students</p>
                    <h2><?php echo $total_students; ?></h2>
                    <span>Registered students</span>
                </div>
            </div>


            <div class="stat-card jobs-stat">
                <div class="stat-icon">💼</div>

                <div>
                    <p>Active Jobs</p>
                    <h2><?php echo $total_jobs; ?></h2>
                    <span>Available opportunities</span>
                </div>
            </div>


            <div class="stat-card applications-stat">
                <div class="stat-icon">📄</div>

                <div>
                    <p>Applications</p>
                    <h2><?php echo $total_applications; ?></h2>
                    <span>Total applications</span>
                </div>
            </div>


            <div class="stat-card selected-stat">
                <div class="stat-icon">🏆</div>

                <div>
                    <p>Selected</p>
                    <h2><?php echo $total_selected; ?></h2>
                    <span>Successful placements</span>
                </div>
            </div>

        </section>


        <!-- QUICK ACTIONS -->
        <section class="dashboard-section">

            <div class="section-heading">

                <div>
                    <p class="section-label">MANAGEMENT</p>
                    <h2>Quick Actions</h2>
                </div>

            </div>


            <div class="quick-actions">

                <a href="add_job.php" class="action-card">

                    <div class="action-icon">➕</div>

                    <div>
                        <h3>Add New Job</h3>
                        <p>Create a new placement opportunity.</p>
                    </div>

                    <span class="arrow">→</span>

                </a>


                <a href="jobs.php" class="action-card">

                    <div class="action-icon">💼</div>

                    <div>
                        <h3>Manage Jobs</h3>
                        <p>View, edit and delete job postings.</p>
                    </div>

                    <span class="arrow">→</span>

                </a>


                <a href="applications.php" class="action-card">

                    <div class="action-icon">📋</div>

                    <div>
                        <h3>Applications</h3>
                        <p>Review student applications.</p>
                    </div>

                    <span class="arrow">→</span>

                </a>

            </div>

        </section>


        <!-- DASHBOARD FOOTER -->
        <div class="dashboard-footer">

            <div>
                <span class="status-dot"></span>
                System is running normally
            </div>

            <p>Campus Placement Portal © 2026</p>

        </div>

    </main>

</div>

</body>
</html>