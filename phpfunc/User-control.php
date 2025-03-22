<?php
require("dbconfig.php");

    $username = $_SESSION['user_name'];
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); 
        $_SESSION['user_id'] = $row['id'];
}

  //var_dump($user_id); 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user_id = $_SESSION['user_id'];
    $currentPass = $_POST["current_password"]?? "";
    $newPass = $_POST["new_password"]?? "";

  
    if (strlen($newPass) < 8) {
        echo " <h1 class= 'error'>Password must be at least 8 characters long</h1>";
        exit();
    }
    
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
    } else {
        die("Error: No password found for this user ID.");
    }


    if (!password_verify($currentPass, $hashed_password)) {
        echo "Incorrect current password";
    } else {
   
        $new_hashed_password = password_hash($newPass, PASSWORD_DEFAULT);


        $update_sql = "UPDATE users SET password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    }
}