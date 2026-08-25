<?php
session_start();
include "db.php";

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

$id=$_GET['id'];

$stmt=$conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i",$id);

if($stmt->execute())
{
    echo "<script>
    alert('User Deleted Successfully');
    window.location='users.php';
    </script>";
}
?>