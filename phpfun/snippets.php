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
    <title>New Snippet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <div class="logo">Snippet Share</div>
            <ul class="nav-links">
                  <li><a href="home.php">Home</a></li>
                  <li><a href="mysnippets.php">Mysnippets</a></li>  
                <li><a href="profile.php">Profile</a></li>
                <li><a href="snippets.php" class="paste-btn">+ Paste</a></li>
            </ul>
        </div>
    </nav>
    <form action="phpfunc/snippet-control.php" method="POST">
    <div class="snippet-container">
        <h2>New Snippet</h2>
        <textarea class="snippet-textarea" placeholder="Write your snippet here..." name="snippet_content"></textarea>

        <h3>Snippet Title: </h3>
        <div class="settings">
            
           
            <input type="text" id="tags" placeholder="Enter snippet title..." name="snippet_title">

            <label for="tags">Snippet language:</label>
            <input type="text" id="tags" placeholder="Enter snippet languauge..." name="snippet_language">
           
        </div>

        <input type = "submit" class="submit-btn"></button>
    </div>
    </form>
</body>
</html>
