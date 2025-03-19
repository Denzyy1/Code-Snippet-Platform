<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

 
    <nav class="navbar">
        <div class="logo">Snippet Share</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <!-- <li><a href="about.php">About</a></li> -->
            <!-- <li><a href="contact.php">Contact</a></li> -->
            <li><a href="index.php" class="login-btn">Login</a></li>
        </ul>
    </nav>

    <div class="register-container">
        <h2>Create an Account</h2>

        <form action="phpfunc/login-control.php" method="POST">
            <div class="input-group">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>

            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="username" placeholder="Username" required>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>

            <button type="submit" class="btn">Create New Account</button>
        </form>

        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>

</body>
</html>
