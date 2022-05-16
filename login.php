<?php

/*
    TODO:
    Sanatise user input
    Give feedback for failed log in attempt

    Other todo:
    navbar

*/


session_start();
require "php/dbconn.php";

$invalidLogin = false;
if (isset($_POST["userName"]) && isset($_POST["password"])) {
    $username = $_POST["userName"];
    $password = $_POST["password"];

    // sanatise here?

    // Complete this if statement
    if (authenticate($username, $password)) {
      $_SESSION["userId"] = $username;

      header("Location: index.php");
      exit();
    }
}

// Queries the DBMS with the supplied user details
// Returns true on successful authentication and false otherwise.
function authenticate($user, $pass)
{
    global $conn;

    // Complete this function
    $sql_query = 'SELECT userName, password, role FROM User WHERE userName="'.$user.'"';

    // upon successful insertion, close database connection
    $result = $conn->query($sql_query);
    if($result) { // connection established
      if($result->num_rows == 1) { // query found
        $row = $result->fetch_assoc();
        if ($row['username'] == $user && $row['password'] == $pass) {
            $_SESSION["userRole"] = $row['role'];
            return true;
        }
      }
    }
    return false;
}




?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <li><a href="archive.html">Archive</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="create.html">Create</a></li>
            <li id='navCurPageLi'><a href="login.php">Login</a></li>
        </ul>
        <button href="javascript:void(0);" class="icon" onclick="mobileMenu()"> 
            <i class="fa fa-bars"></i></button>  
    </div>

      <div class ="container">
        <!--Login Form-->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="loginForm" class="input-group">
          <!--Login Table-->
        <table class = "loginTable"> 
          <tr>
            <td>Username:</td>
            <td><input type="text" name="fname" id="fname" required></td>
          </tr>        
          <tr>
            <td>Password</td>
            <td>
              <input type="password" name="password" id="password" required>
            </td>
          </tr>       
        </table>
        <input submit type="submit" value="Login" />
        </form>
        <form method="POST" action="registration.html">
          <button id="myButton" class="submit-btn">Register</button>
        </form>
      </div>
    </div>
    <div class="footer">
      <p>UTAS   /    Assignment 1    /    Group 1</p>
    </div>
  </body>
</html>