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
           <li><a href="home.php">Home</a></li>
           <li><a href="mysnippets.php">Mysnippets</a></li>  
            <li><a href="snippets.php" class="paste-btn">+ Paste</a></li>
            <li><a href="profile.php" class="active">Profile</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </nav>

    
    <div class="profile-container">
        <h2>My Profile</h2>
        
        <div class="profile-content">
           <form action="phpfunc/User-control.php" method="POST" >
            <div class="profile-form">
                <h3>change your current password </h3>
                <label>Current password </label>
                <input type="password" name="current_password" placeholder="Enter current password ..." >
                <label>New password </label>
                <input type="password" name="new_password" placeholder="Enter new password ..." >

                <input type= "submit" class="profile-btn"></button>
            </div>
           </form>
           
            
        </div>
    </div>


</body>
</html>
