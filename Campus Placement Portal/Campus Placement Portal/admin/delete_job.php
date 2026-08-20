<?php
session_start();
include '../dp.php';

/* Check Admin Login */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

/* Check Job ID */
if (!isset($_GET['id'])) {
    header("Location: jobs.php");
    exit();
}

$id = (int)$_GET['id'];

/* Delete related applications first */
$stmt = $conn->prepare("DELETE FROM applications WHERE job_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

/* Delete Job */
$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: jobs.php");
    exit();
} else {
    echo "Failed to delete job!";
}
?>