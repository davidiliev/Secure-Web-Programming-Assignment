<?php

require_once "php/dbconn.php";
$errors = array();
session_start();

$invalidLogin = false;
if (isset($_POST["username"]) && isset($_POST["password"])) {

  //validate and sanatise user input
  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    $username = validate($_POST["username"]);
    $password = validate($_POST["password"]);

  if (empty($username)) {
  		array_push($errors, "User Name is required!");
  }else if(empty($password)){
  		array_push($errors, "Password is required!");
  }else{
    
  // verify password
 	$sql = "SELECT * FROM User WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows == 1) {
        	$row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
              $_SESSION['username'] = $row['username'];
              $_SESSION['role'] = $row['role'];
        		  header("Location: index.php");
            //echo "Match";
       		 }else{
        		array_push($errors, "The username or password do not match");
            }
        }
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/shared.css">
    <!--refencing a whole sheet for a hamburger menu...-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/navigation.js"></script>
  </head>
<body>
  <h1>Tom, Dick & Harry's</h1>
    <div class ="column">
      <div class="banner"></div>
      <!--Top-level navigation bar-->
      <div id="navbar" class="navbarclass">                            
        <ul id="navOptions">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li id='navCurPageLi'><a href="login.php">Login</a></li>
            <li><a href="registration.php">Register</a></li>
        </ul>
        <button href="javascript:void(0);" class="icon" onclick="mobileMenu()"> 
            <i class="fa fa-bars"></i></button>  
    </div>
    <div class ="container">
        <!--Login Form-->
        <form method="POST" action="login.php" id="loginForm" class="input-group">
          <!--Login Table-->
        <table class = "loginTable"> 
          <tr>
            <td>Username:</td>
            <td><input type="text" name="username" id="username" required></td>
          </tr>        
          <tr>
            <td>Password</td>
            <td>
              <input type="password" name="password" id="password" required>
            </td>
          </tr>       
        </table>
        <button id="myButton" class="submit-btn" name="login">Log In</button>
        <?php include('php/errors.php'); ?>
        </form>
      </div>
    </div>
    <div class="footer">
      <p>UTAS   /    Assignment 1    /    Group 1</p>
    </div>
  </body>
</html>