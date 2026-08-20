<?php

session_start();
include '../dp.php';


/* CHECK LOGIN */

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {

    header("Location: ../login.php");
    exit();

}


$user_id = $_SESSION['user_id'];


/* CHECK JOB ID */

if (!isset($_GET['apply'])) {

    $_SESSION['application_message'] =
        "Invalid job selection.";

    header("Location: jobs.php");
    exit();

}


$job_id = (int)$_GET['apply'];


/* GET STUDENT ID FROM STUDENTS TABLE */

$student_query = $conn->prepare(

    "SELECT student_id
     FROM students
     WHERE user_id = ?"

);


if (!$student_query) {

    $_SESSION['application_message'] =
        "Student database error: " . $conn->error;

    header("Location: jobs.php");
    exit();

}


$student_query->bind_param(
    "i",
    $user_id
);


$student_query->execute();


$student_result =
    $student_query->get_result();


/* CHECK STUDENT PROFILE */

if ($student_result->num_rows == 0) {

    $_SESSION['application_message'] =
        "Student profile not found.";

    header("Location: jobs.php");
    exit();

}


$student =
    $student_result->fetch_assoc();


$student_id =
    $student['student_id'];


/* CHECK IF JOB EXISTS */

$job_check = $conn->prepare(

    "SELECT job_id
     FROM jobs
     WHERE job_id = ?"

);


if (!$job_check) {

    $_SESSION['application_message'] =
        "Job database error: " . $conn->error;

    header("Location: jobs.php");
    exit();

}


$job_check->bind_param(
    "i",
    $job_id
);


$job_check->execute();


$job_result =
    $job_check->get_result();


if ($job_result->num_rows == 0) {

    $_SESSION['application_message'] =
        "Selected job does not exist.";

    header("Location: jobs.php");
    exit();

}


/* CHECK IF ALREADY APPLIED */

$check = $conn->prepare(

    "SELECT application_id
     FROM applications
     WHERE student_id = ?
     AND job_id = ?"

);


if (!$check) {

    $_SESSION['application_message'] =
        "Database error: " . $conn->error;

    header("Location: jobs.php");
    exit();

}


$check->bind_param(
    "ii",
    $student_id,
    $job_id
);


$check->execute();


$result =
    $check->get_result();


/* ALREADY APPLIED */

if ($result->num_rows > 0) {

    $_SESSION['application_message'] =
        "You have already applied for this job!";

} else {


    /* INSERT APPLICATION */

    $apply = $conn->prepare(

        "INSERT INTO applications
        (student_id, job_id, status)
        VALUES (?, ?, 'Pending')"

    );


    if (!$apply) {

        $_SESSION['application_message'] =
            "Application database error: " . $conn->error;

    } else {


        $apply->bind_param(

            "ii",
            $student_id,
            $job_id

        );


        if ($apply->execute()) {

            $_SESSION['application_message'] =
                "Application submitted successfully!";

        } else {

            $_SESSION['application_message'] =
                "Failed to submit application: " . $apply->error;

        }

    }

}


/* REDIRECT BACK TO JOBS PAGE */

header("Location: jobs.php");

exit();

?>