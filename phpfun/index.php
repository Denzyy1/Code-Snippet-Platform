<!DOCTYPE html>
<?php
    require("phpfunc/dbconfig.php");

    if(isset($_SESSION['logged'])) {
        if($_SESSION['logged'] == 1){
            header('Location: ./home.php');
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
    
    function delete($conn,$id)
    {
        $result = $conn->query("DELETE FROM users WHERE ID='$id'");
    }
    
    function update($conn,$id,$fname,$lname,$username,$password,$email)
    {
     $result = $conn->query("UPDATE users SET fname='$fname',lname='$lname' ,username='$username', password='$password' , email='$email'  WHERE id='$id'");
    }
    
    function getUserById($conn,$id)
    {
        $result = $conn->query("Select * from users WHERE id='$id'");
        while($row = mysqli_fetch_array($result))
      {
        print_r($row);
      } 
    }
    
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
    
    
    
    function checkLoginUser($conn,$loginEm,$loginPass)
    {
        $result = $conn->query("Select * from users WHERE email='$loginEm' ");
        if($result->num_rows>0){
            $row = mysqli_fetch_array($result);
    
            if (password_verify($loginPass, $row['password'])) {
                $_SESSION['logged'] = 1;
                $_SESSION['user_login'] = $row['email'];
                $_SESSION['user_name'] = $row['username'];
                return true;
                }	
         }
             else {
                $_SESSION['logged'] = 0;
                $_SESSION['user_login'] = "";
                $_SESSION['user_name'] = "";
                return false;
        }
    }
    
    $errors= [];
    
    $action = $_POST["action"]??"" ;
    
    if ($action == "checklogin") {
        $loginEm = trim($_POST["login-email"]);
        $loginPass = trim($_POST["login-password"]);
        
        if (empty($loginEm)) {
          $errors[] = "Email is required";
         }
          elseif (!filter_var($loginEm, FILTER_VALIDATE_EMAIL)) {
          $errors[] = "Invalid email format";
           }
        if (empty($loginPass)) {
            $errors[] = "Password is required";
        }
        if (empty($errors)) {
            $res = checkLoginUser($conn, $loginEm, $loginPass);
            if ($res) {
                header('Location: ./home.php');
                exit();
            } else {
                $errors[] = "Invalid email or password";
            }
        }
        
    }
    
     elseif ($action == "register") {
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


            
            
            <?php if (!empty($errors)) : ?>
                <div class="error">
                    <ul class = " error-list" >
                        <?php foreach ($errors as $error) : ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            
            <form action=""  method="post">
                <label for="email">Email address</label>
                <div class="input-group">
                    <span class="icon">📧</span>
                    <input type="email" id="email" name="login-email" placeholder="Email address" >
                </div>

                <label for="password">Password</label>
                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" id="password" name="login-password" placeholder="Password" >
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
