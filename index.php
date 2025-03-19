<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION['logged'])) {
        if($_SESSION['logged'] == 1){
            header('Location: ./home.php');
        }
    }
    ?>
    
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Snippet Share</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">Snippet Share</div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="snippets.php">Snippets</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="index.php" class="active">Login</a></li>
                <li><a href="register.php" class="signup">Sign Up</a></li>
            </ul>
        </div>
    </nav>

    <!-- Login Form Section -->
    <div class="login-container">
        <div class="login-box">
            <h2>Log in to your account</h2>
            <form action="phpfunc/login-control.php"  method="post">
                <label for="email">Email address</label>
                <div class="input-group">
                    <span class="icon">📧</span>
                    <input type="email" id="email" name="login-email" placeholder="Email address" required>
                </div>

                <label for="password">Password</label>
                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" id="password" name="login-password" placeholder="Password" required>
                </div>
                <input  hidden type="text" name="action" value="checklogin">
                <!-- <button type="button" class="btn" onclick="window.location.href='profile.php'">LogIn</button> -->
                <button type="submit" class="btn">Log In</button>

            </form>

            <p class="signup-link">New to Snippet Share? <a href="register.php">Sign Up</a></p>
        </div>
    </div>

</body>
</html>
