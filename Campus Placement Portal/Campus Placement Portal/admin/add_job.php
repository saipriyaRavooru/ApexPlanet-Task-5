<?php
session_start();
include '../dp.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = "";

if (isset($_POST['add_job'])) {

    $company_name = $_POST['company_name'];
    $job_title = $_POST['job_title'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $eligibility = $_POST['eligibility'];
    $job_type = $_POST['job_type'];
    $description = $_POST['description'];
    $last_date = $_POST['last_date'];

    $stmt = $conn->prepare(
        "INSERT INTO jobs
        (company_name, job_title, description, eligibility, location, salary, job_type, last_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssssssss",
        $company_name,
        $job_title,
        $description,
        $eligibility,
        $location,
        $salary,
        $job_type,
        $last_date
    );

    if ($stmt->execute()) {
        header("Location: jobs.php");
        exit();
    } else {
        $message = "Error adding job: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Job | PlaceHub</title>

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

                <h1>Add New Job ➕</h1>

                <p class="dashboard-subtitle">
                    Create a new placement opportunity for students.
                </p>
            </div>

            <a href="jobs.php" class="back-btn">
                ← Back to Jobs
            </a>

        </div>


        <div class="edit-job-container">

            <div class="edit-job-card">

                <div class="edit-job-header">

                    <div class="edit-job-icon">💼</div>

                    <div>
                        <h2>Create Job Opportunity</h2>
                        <p>Enter the job details below.</p>
                    </div>

                </div>


                <?php if ($message != "") { ?>

                    <p class="error-message">
                        <?php echo $message; ?>
                    </p>

                <?php } ?>


                <form method="POST" class="modern-job-form">

                    <div class="form-row">

                        <div class="form-group">

                            <label>Company Name</label>

                            <input
                                type="text"
                                name="company_name"
                                placeholder="Enter company name"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>Job Title</label>

                            <input
                                type="text"
                                name="job_title"
                                placeholder="Enter job title"
                                required
                            >

                        </div>

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label>Location</label>

                            <input
                                type="text"
                                name="location"
                                placeholder="Enter job location"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>Salary Package</label>

                            <input
                                type="text"
                                name="salary"
                                placeholder="Example: 6 LPA"
                                required
                            >

                        </div>

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label>Eligibility</label>

                            <input
                                type="text"
                                name="eligibility"
                                placeholder="Example: B.Tech, 60%"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>Job Type</label>

                            <select name="job_type" required>

                                <option value="">Select Job Type</option>

                                <option value="Full Time">
                                    Full Time
                                </option>

                                <option value="Internship">
                                    Internship
                                </option>

                                <option value="Part Time">
                                    Part Time
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="form-group">

                        <label>Job Description</label>

                        <textarea
                            name="description"
                            placeholder="Enter job description"
                            required
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label>Application Last Date</label>

                        <input
                            type="date"
                            name="last_date"
                            required
                        >

                    </div>


                    <div class="edit-job-actions">

                        <a href="jobs.php" class="cancel-job-btn">
                            Cancel
                        </a>

                        <button type="submit" name="add_job">
                            ➕ Add Job
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>

</div>

</body>
</html>