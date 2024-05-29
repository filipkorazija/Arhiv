<?php
include('db.php');
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Invalid password";
            }
        } else {
            $error_message = "No user found with that email";
        }

        $conn->close();
    } else {
        $error_message = "Please enter both email and password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Login</h1>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="input-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                    </label>
                    <input type="email" name="email" placeholder="E-mail" id="email" required>
                </div>
                <div class="input-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                    </label>
                    <input type="password" name="password" placeholder="Password" id="password" required>
                </div>
                <input type="submit" value="Login" class="btn btn-primary">
                <button onclick="window.location.href='register.php'; return false;" class="btn btn-secondary">Create Account</button>
            </form>
            <button onclick="window.location.href='outlook_login.php'; return false;" class="btn btn-outlook">Sign in with Outlook</button>
        </div>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>
