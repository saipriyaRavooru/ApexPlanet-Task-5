<?php
include 'dp.php';

$message = "";
$messageType = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");

    if ($check) {

        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "Email already registered!";
            $messageType = "error";

        } else {

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, role)
                 VALUES (?, ?, ?, 'student')"
            );

            if ($stmt) {

                $stmt->bind_param("sss", $name, $email, $password);

                if ($stmt->execute()) {
                    $message = "Registration successful! You can now login.";
                    $messageType = "success";
                } else {
                    $message = "Registration failed!";
                    $messageType = "error";
                }

                $stmt->close();

            } else {
                $message = "Registration system error!";
                $messageType = "error";
            }
        }

        $check->close();

    } else {
        $message = "Database query error!";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration | PlaceHub</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav>
    <h2>PlaceHub</h2>

    <div>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
    </div>
</nav>

<div class="form-container">

    <h2>Create Student Account 🎓</h2>

    <?php if ($message != "") { ?>

        <p class="message <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>

    <form method="POST">

        <input
            type="text"
            name="name"
            placeholder="Enter your full name"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Create a password"
            required
        >

        <button type="submit" name="register">
            Create Account
        </button>

    </form>

    <p>
        Already have an account?
        <a href="login.php">Login here</a>
    </p>

</div>

</body>
</html>