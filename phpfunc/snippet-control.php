<?php
require("dbconfig.php");
$username = $_SESSION['user_name'];
$sql = "SELECT id FROM users WHERE username = '$username'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    $user_id = $row['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST ["snippet_content"];
    $title = $_POST ["snippet_title"];
    $language = $_POST ["snippet_language"];

    $errors = [];
    
    if (empty($title)) {
        $errors[] = "Title is required.";
    }
    if (empty($content)) {
        $errors[] = "Content cannot be empty.";
    }
    if (empty($language)) {
        $errors[] = "Please select a language.";
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
    $insert_sql = "INSERT INTO snippets (user_id, title, content, language, created_at) 
    VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("isss", $user_id, $title, $content, $language); 

        if ($stmt->execute()) {
        echo "Snippet added successfully!";
        }
 
    }   
}












// // update if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $title = $_POST['title'];
//     $code = $_POST['code'];
//     $language = $_POST['language'];
//     $conn->query("UPDATE snippets SET title='$title', code='$code', language='$language' WHERE id=$snippet_id AND user_id=$user_id");
//     header("Location: dashboard.php");
// }

// $result = $conn->query("SELECT * FROM snippets WHERE id=$snippet_id AND user_id=$user_id");
// $snippet = $result->fetch_assoc();
// ?>