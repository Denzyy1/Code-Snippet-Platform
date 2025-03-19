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
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

    <nav class="navbar">
        <div class="logo">Snippet Share</div>
        <ul class="nav-links">
            <li><a href="snippets.php" class="paste-btn">+ Paste</a></li>
            <li><a href="profile.php" class="active">Profile</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </nav>

    
    <div class="profile-container">
        <h2>My Profile</h2>

        <div class="profile-content">
           
            <div class="profile-form">
                <label>Username:</label>
                <input type="text" id="username" >

                <label>Email Address:</label>
                <input type="email" id="email" >

                <label>Email Status:</label>
                <input type="text" value="Verified!" disabled>

                <label>Website URL:</label>
                <input type="url" placeholder="Enter a valid URL starting with http://">

                <label>Location:</label>
                <input type="text" placeholder="Where are you from?">

                <label>Account Type:</label>
                <input type="text" value="Free" disabled>

                <button class="profile-btn">Update Profile</button>
            </div>

           
            
        </div>
    </div>


</body>
</html>
