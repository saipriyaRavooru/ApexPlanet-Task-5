<?php
session_start();
include 'dp.php';

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");

    if ($stmt) {

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: student/dashboard.php");
                }

                exit();

            } else {
                $message = "Incorrect password!";
            }

        } else {
            $message = "Email not found!";
        }

        $stmt->close();

    } else {
        $message = "Login system error!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | PlaceHub</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav>
    <h2>PlaceHub</h2>

    <div>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
    </div>
</nav>

<div class="form-container">

    <h2>Welcome Back 👋</h2>

    <?php if ($message != "") { ?>
        <p class="message error">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php } ?>

    <form method="POST">

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <p>
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>

</div>

</body>
</html>