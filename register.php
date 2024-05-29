<?php
include('db.php');
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Check if the user already exists
        $check_sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            $error_message = "User with this email already exists.";
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            
            if ($conn->query($sql) === TRUE) {
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Register</h1>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="register.php" method="post">
                <div class="input-group">
                    <label for="username">
                        <i class="fas fa-user"></i>
                    </label>
                    <input type="text" name="username" placeholder="Username" id="username" required>
                </div>
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
                <input type="submit" value="Register" class="btn btn-primary">
                <button onclick="window.location.href='login.php'; return false;" class="btn btn-secondary">Already registered?</button>
            </form>
            <button onclick="window.location.href='outlook_login.php'; return false;" class="btn btn-outlook">Sign in with Outlook</button>
        </div>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>
