<!DOCTYPE html>
<?php
 require("phpfunc/dbconfig.php");

    if(isset($_SESSION['logged'])) {
        if($_SESSION['logged'] == 1){
            header('Location: ./home.php');
        }
    }
    $errors= [];

    function checkUserExist($conn,$email,$username)
    {
        $result = $conn->query("Select * from users WHERE Email='$email' or username='$username'");
        if($result->num_rows>0){
            return true;
        }	
        else{
            return false;
        }
    }
    
    
    function addNew($conn,$fname,$lname,$username,$password,$email)
    {
      $res = checkUserExist($conn,$email,$username);
      if($res)
          return false;
      else {
        $result = $conn->query("INSERT INTO users(fname,lname,username,password,email) VALUES ('$fname','$lname','$username','$password','$email')");
            $_SESSION['logged'] = 1;
             $_SESSION['user_login'] = $email;
            $_SESSION['user_name'] = $username;
            return true;
       }
    }
    
    $action = $_POST["action"]??"" ;

      if ($action == "register") {
        $fname = $_POST["first-name"] ?? "";
        $lname = $_POST["last-name"] ?? "";
        $email = $_POST["email"] ?? "";
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";
        $confirm_password = $_POST ["confirm_password"] ?? "" ;
          
        
        if (empty($email)) {
            $errors[] = "Email is required";
         } 
         elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
         }
        if (empty($username)) {
            $errors[] = "Username is required";
          }
        if (empty($password)) {
            $errors[] = "Password is required";
         }   
         elseif (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
          }
          if ($password !== $confirm_password) {
            $errors[] = 'Password does not match !';
        }
        
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if (empty($errors)) {
            $res = addNew($conn, $fname, $lname, $username, $hashed_password, $email);
            if ($res) {
                header('Location: ./home.php');
                exit();
            } else {
                $errors[] = "User already exists";
            }
        }
    }


    ?>
    
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

        <?php if (!empty($errors)) : ?>
                <div class="error">
                    <ul class = " error-list" >
                        <?php foreach ($errors as $error) : ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

        <form action="" method="POST">
            <div class="input-group">
                <input type="text" name="first_name" placeholder="First Name"  >
                <input type="text" name="last_name" placeholder="Last Name" >
            </div>

            <input type="email" name="email" placeholder="Email Address" >
            <input type="text" name="username" placeholder="Username" >

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" >
                <input type="password" name="confirm_password" placeholder="Confirm Password" >
            </div>
            <input  hidden type="text" name="action" value="register">
            <button type="submit" class="btn">Create New Account</button>
        </form>

        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>

</body>
</html>
