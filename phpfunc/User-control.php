<?php
require("dbconfig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'] ?? null;
    $currentPass = $_POST["current_password"] ?? "";
    $newPass = $_POST["new_password"] ?? "";

    if (!$user_id) {
        die("<h1 class='error'>Error: User not logged in.</h1>");
    }

    // ✅ Use a properly prepared SQL statement
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    if (!$stmt) {
        die("<h1 class='error'>Error preparing statement: " . $conn->error . "</h1>");
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // ✅ Debugging outputs
    var_dump($hashed_password); // Check if password is fetched
    var_dump($user_id); // Ensure user_id is correct

    if (empty($hashed_password)) {
        die("<h1 class='error'>Error: No password found for this user ID.</h1>");
    }

    // ✅ Verify current password correctly
    if (!password_verify($currentPass, $hashed_password)) {
        die("<h1 class='error'>Incorrect current password</h1>");
    }

    // ✅ Validate new password
    if (strlen($newPass) < 8) {
        die("<h1 class='error'>Password must be at least 8 characters long</h1>");
    }

    // ✅ Hash new password
    $new_hashed_password = password_hash($newPass, PASSWORD_DEFAULT);

    // ✅ Update password in the database
    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    if (!$update_stmt) {
        die("<h1 class='error'>Error preparing update statement: " . $conn->error . "</h1>");
    }

    $update_stmt->bind_param("si", $new_hashed_password, $user_id);
    if ($update_stmt->execute()) {
        echo "<h1>Password updated successfully!</h1>";
    } else {
        echo "<h1 class='error'>Error updating password: " . $update_stmt->error . "</h1>";
    }
    $update_stmt->close();
}
?>





//function addNew($conn,$fname,$lname,$username,$password,$email)
// {
//     $res = checkUserExist($conn,$email,$username);
//     if($res)
//         return false;
//     else {
//       $result = $conn->query("INSERT INTO users(fname,lname,username,password,email) VALUES ('$fname','$lname','$username','$password','$email')");
//           $_SESSION['logged'] = 1;
//            $_SESSION['user_login'] = $email;
//           $_SESSION['user_name'] = $username;
//           return true;
//      }
//   }
  
  
//   function delete($conn,$id)
//   {
//       $result = $conn->query("DELETE FROM users WHERE ID='$id'");
//   }
  
//   function update($conn,$id,$fname,$lname,$username,$password,$email)
//   {
//    $result = $conn->query("UPDATE users SET fname='$fname',lname='$lname' ,username='$username', password='$password' , email='$email'  WHERE id='$id'");
//   }
  
//   function getUserById($conn,$id)
//   {
//       $result = $conn->query("Select * from users WHERE id='$id'");
//       while($row = mysqli_fetch_array($result))
//     {
//       print_r($row);
//     } 
//   }
  
//   function checkUserExist($conn,$email,$username)
//   {
//       $result = $conn->query("Select * from users WHERE Email='$email' or username='$username'");
//       if($result->num_rows>0){
//           return true;
//       }	
//       else{
//           return false;
//       }
//   }
  
  
  
//   function checkLoginUser($conn,$loginEm,$loginPass)
//   {
//       $result = $conn->query("Select * from users WHERE email='$loginEm' ");
//       if($result->num_rows>0){
//           $row = mysqli_fetch_array($result);
  
//           if (password_verify($loginPass, $row['password'])) {
//               $_SESSION['logged'] = 1;
//               $_SESSION['user_login'] = $row['email'];
//               $_SESSION['user_name'] = $row['username'];
//               return true;
//               }	
//        }
//            else {
//               $_SESSION['logged'] = 0;
//               $_SESSION['user_login'] = "";
//               $_SESSION['user_name'] = "";
//               return false;
//       }
//   }

// // $errors= [];

// // $action = $_POST["action"]??"" ;

// // if ($action == "checklogin") {
// //     $loginEm = trim($_POST["login-email"]);
// //     $loginPass = trim($_POST["login-password"]);
    
// //     if (empty($loginEm)) {
// //       $errors[] = "Email is required";
// //      }
// //       elseif (!filter_var($loginEm, FILTER_VALIDATE_EMAIL)) {
// //       $errors[] = "Invalid email format";
// //        }
// //     if (empty($loginPass)) {
// //         $errors[] = "Password is required";
// //     }
// //     if (empty($errors)) {
// //         $res = checkLoginUser($conn, $loginEm, $loginPass);
// //         if ($res) {
// //             header('Location: ../home.php');
// //             exit();
// //         } else {
// //             $errors[] = "Invalid email or password";
// //         }
// //     }
// //     header('Location: ../index.php');
// // }

// //  elseif ($action == "register") {
// //     $fname = $_POST["first-name"] ?? "";
// //     $lname = $_POST["last-name"] ?? "";
// //     $email = $_POST["email"] ?? "";
// //     $username = $_POST["username"] ?? "";
// //     $password = $_POST["password"] ?? "";
// //     $confirm_password = $_POST ["confirm_password"] ?? "" ;
      
// //     //   if (empty($fname)) {
// //     //     $errors[] = "First name is required";
// //     //  }
// //     // if (empty($lname)) {
// //     //     $errors[] = "Last name is required";
// //     //   }
// //     if (empty($email)) {
// //         $errors[] = "Email is required";
// //      } 
// //      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
// //         $errors[] = "Invalid email format";
// //      }
// //     if (empty($username)) {
// //         $errors[] = "Username is required";
// //       }
// //     if (empty($password)) {
// //         $errors[] = "Password is required";
// //      }   
// //      elseif (strlen($password) < 8) {
// //         $errors[] = "Password must be at least 8 characters long";
// //       }
// //       if ($password !== $confirm_password) {
// //         $errors[] = 'Password does not match !';
// //     }
    
// //       $hashed_password = password_hash($password, PASSWORD_DEFAULT);
// //     if (empty($errors)) {
// //         $res = addNew($conn, $fname, $lname, $username, $hashed_password, $email);
// //         if ($res) {
// //             header('Location: ../home.php');
// //             exit();
// //         } else {
// //             $errors[] = "User already exists";
// //         }
// //     }
// // }


// // ?>
// // <!-- <!DOCTYPE html>
// // <html lang="en">
// // <head>
// //     <meta charset="UTF-8">
// //     <meta name="viewport" content="width=device-width, initial-scale=1.0">
// //     <title>Login/Register</title>
// //     <style>
// //         .error {
// //             color: red;
// //             background: #fee;
// //             padding: 10px;
// //             border: 1px solid red;
// //             margin-bottom: 10px;
// //             list-style: none;
// //             font-size: 20px;
// //         }
// //     </style>
// // </head>
// // <body>
// //     <?php if (!empty($errors)) : ?>
// //         <div class="error">
// //             <ul>
// //                 <?php foreach ($errors as $error) : ?>
// //                     <li><?php echo htmlspecialchars($error); ?></li>
// //                 <?php endforeach; ?>
// //             </ul>
// //         </div>
// //     <?php endif; ?>
// // </body>
// // </html> -->
