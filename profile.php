<?php
session_start();
include "db.php";

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

$id=$_SESSION['id'];

$stmt=$conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$user=$stmt->get_result()->fetch_assoc();

if(isset($_POST['update']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];

    $image=$user['profile_pic'];

    if($_FILES['image']['name']!="")
    {
        $filename=time()."_".$_FILES['image']['name'];
        $target="uploads/".$filename;

        $ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));

        if(in_array($ext,['jpg','jpeg','png']))
        {
            if($_FILES['image']['size']<=2097152)
            {
                move_uploaded_file($_FILES['image']['tmp_name'],$target);
                $image=$filename;
            }
            else
            {
                echo "<script>alert('Image size should be below 2MB');</script>";
            }
        }
        else
        {
            echo "<script>alert('Only JPG, JPEG and PNG allowed');</script>";
        }
    }

    $stmt=$conn->prepare("UPDATE users SET name=?,email=?,profile_pic=? WHERE id=?");
    $stmt->bind_param("sssi",$name,$email,$image,$id);

    if($stmt->execute())
    {
        $_SESSION['name']=$name;

        echo "<script>
        alert('Profile Updated Successfully');
        window.location='profile.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Profile</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container">

<h2>My Profile</h2>

<img src="uploads/<?php echo $user['profile_pic'];?>"
width="120"
height="120"
style="border-radius:50%;"><br><br>

<form method="POST" enctype="multipart/form-data">

<input
type="text"
name="name"
value="<?php echo $user['name'];?>"
required>

<input
type="email"
name="email"
value="<?php echo $user['email'];?>"
required>

<input
type="file"
name="image">

<br><br>

<button
type="submit"
name="update">

Update Profile

</button>

</form>

<br>

<a href="dashboard.php">
<button>Dashboard</button>
</a>

</div>

</body>

</html>