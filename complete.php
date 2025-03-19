<!DOCTYPE html>
<?php
session_start();
if($_SESSION['logged'] != 1){
    header('Location: ./index.php');
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Account</title>
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
                <li><a href="index.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Complete Account Section -->
    <div class="complete-container">
        <div class="complete-box">
            <h2>Complete your account</h2>
            <p>Hi, Mohamed. Enter your information, create your password, and log in to your account.</p>

            <form action="dashboard.html" method="POST">
                <label for="language">Preferred Language</label>
                <select id="language" name="language">
                    <option value="PHP">PHP</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="Python">Python</option>
                </select>

                <label for="role">Role (I am a...)</label>
                <select id="role" name="role">
                    <option value="developer">Developer</option>
                    <option value="student">Student</option>
                    <option value="other">Other</option>
                </select>

                <label for="job">Job Title</label>
                <input type="text" id="job" name="job" placeholder="Job title" required>

             

                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="New password" required>

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>

                <div class="password-requirements">
                    <p><span class="error">❌</span> Password is at least 15 characters</p>
                    <p><span class="error">❌</span> Contains uppercase, lowercase, number, or symbol</p>
                    <p><span class="error">❌</span> Passwords match</p>
                </div>

               
                <a href="login.php" class="btn">Continue</a>
            </form>
        </div>
    </div>

</body>
</html>
