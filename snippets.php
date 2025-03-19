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
                <li><a href="profile.php">Profile</a></li>
                <li><a href="snippets.php" class="paste-btn">+ Paste</a></li>
            </ul>
        </div>
    </nav>

    <div class="snippet-container">
        <h2>New Snippet</h2>
        <textarea class="snippet-textarea" placeholder="Write your snippet here..."></textarea>

        <h3>Optional Snippet Settings</h3>
        <div class="settings">
            
            <label for="tags">Tags:</label>
            <input type="text" id="tags" placeholder="Enter tags...">

            <label for="syntax">Syntax Highlighting:</label>
            <select id="syntax">
                <option>None</option>
                <option>JavaScript</option>
                <option>Python</option>
                <option>PHP</option>
            </select>

            <label for="expiration">Snippet Expiration:</label>
            <select id="expiration">
                <option>Never</option>
                <option>10 minutes</option>
                <option>1 hour</option>
                <option>1 day</option>
            </select>
        </div>

        <button class="submit-btn">Save Snippet</button>
    </div>

</body>
</html>
