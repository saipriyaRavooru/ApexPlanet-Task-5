<?php
session_start();
include '../dp.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

/* GET ALL JOBS */

$result = $conn->query(
    "SELECT * FROM jobs ORDER BY job_id DESC"
);

if (!$result) {
    die("Database Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Jobs</title>

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

            <a href="dashboard.php">
                <span>🏠</span> Dashboard
            </a>

            <a href="jobs.php" class="active">
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

        <div class="page-top">

            <div>
                <p class="welcome-small">JOB MANAGEMENT</p>
                <h1>Manage Jobs 💼</h1>
                <p class="dashboard-subtitle">
                    View, edit and manage all placement opportunities.
                </p>
            </div>

            <a href="add_job.php" class="add-job-btn">
                ➕ Add New Job
            </a>

        </div>


        <!-- JOBS LIST -->

        <div class="jobs-container">

            <?php if ($result && $result->num_rows > 0) { ?>

                <?php while ($job = $result->fetch_assoc()) { ?>

                    <div class="job-card">

                        <div class="job-card-top">

                            <div class="company-icon">
                                💼
                            </div>

                            <div class="job-title-area">

                                <h2>
                                    <?php echo htmlspecialchars($job['job_title']); ?>
                                </h2>

                                <p>
                                    <?php echo htmlspecialchars($job['company_name']); ?>
                                </p>

                            </div>

                        </div>


                        <div class="job-details">

                            <span>📍 <?php echo htmlspecialchars($job['location']); ?></span>

                            <span>💰 <?php echo htmlspecialchars($job['salary']); ?></span>

                            <span>📅 Deadline:
                                <?php echo htmlspecialchars($job['last_date']); ?>
                            </span>

                        </div>


                        <div class="job-description">

                            <?php
                            echo htmlspecialchars(
                                substr($job['description'], 0, 120)
                            );
                            ?>...

                        </div>


                        <div class="job-actions">

                            <a href="edit_job.php?id=<?php echo $job['job_id']; ?>"
                               class="edit-btn">
                                ✏️ Edit
                            </a>

                            <a href="delete_job.php?id=<?php echo $job['job_id']; ?>"class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this job and its related applications?')">
                            🗑 Delete
                            </a>
                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="no-jobs">

                    <div class="no-job-icon">💼</div>

                    <h2>No Jobs Available</h2>

                    <p>
                        You haven't added any placement opportunities yet.
                    </p>

                    <a href="add_job.php">
                        Add Your First Job →
                    </a>

                </div>

            <?php } ?>

        </div>

    </main>

</div>

</body>
</html>