<?php 
include 'php/dbconn.php';
$errors = array(); 
if (isset($_POST["register"])){
$username = htmlspecialchars($_POST['username']);
$emailaddress = htmlspecialchars($_POST['emailaddress']);
$password= htmlspecialchars($_POST['password']);
$password2= htmlspecialchars($_POST['password2']);
$role = htmlspecialchars($_POST['role']);

$usernameCheck = "SELECT * FROM User WHERE username = '$username'";

$result = mysqli_query($conn,$usernameCheck);

$userResult= mysqli_fetch_assoc($result);

$emailCheck = "SELECT * FROM User WHERE emailAddress = '$emailaddress'";

$result2 = mysqli_query($conn,$emailCheck);

$emailResult= mysqli_fetch_assoc($result2);

if($userResult){

    if($userResult['username'] == $username){
    array_push($errors, "Username is taken!");
 
    }
  }
if($emailResult){

    if($emailResult['emailAddress'] == $emailaddress){
    array_push($errors, "Email address is taken!");
    }
}
if ($password != $password2) {

    array_push($errors, "Passwords do not match!");
}

if(count($errors) == 0){

$hashedPassword = crypt($password,'$1$');
$insertUser = "INSERT INTO User (username, emailAddress, password, role)
                VALUES('$username','$emailaddress','$hashedPassword','$role')";
    mysqli_query($conn,$insertUser);
                header('Location: index.php');
}
	
		}
             
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>Registration Page</title>
        <link rel="stylesheet" href="css/registration_style.css">
        <link rel="stylesheet" href="css/shared.css">
        <!--refencing a whole sheet for a hamburger menu...-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="javascript/navigation.js"></script>
    </head>
<body>
  <h1>Tom, Dick & Harry's</h1>  
  <div class="column">
    <div class="banner"></div>
    <!--Top-level navigation bar-->
    <div id="navbar" class="navbarclass">                            
      <ul id="navOptions">
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="login.php">Login</a></li>
          <li  id='navCurPageLi'><a href="registration.php">Register</a></li>
      </ul>
      <button href="javascript:void(0);" class="icon" onclick="mobileMenu()"> 
          <i class="fa fa-bars"></i></button>  
    </div>
    <div class="container">
      <form method="POST" action="registration.php" id="register" class="input-group">          
        <table class = "RegisterTable">
          <tr>
            <td>Username:</td>
            <td><input type="text" name="username" id="username" required></td>
          </tr>
               <tr>
            <td>Email Address:</td>
            <td><input type="email" name="emailaddress" id="emailaddress" required></td>
          </tr>
          <tr>
            <td>Password</td>
            <td>
              <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </td>
          </tr>
          <td>Confirm Password</td>
            <td>
              <input type="password" name="password2" id="password2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </td>
          </tr>
      <br>
        <tr>
          <td class="label">Role:</td>
          <td>
            <div><input type="radio" name="role" value="Author" required> Author</div>
            <div><input type="radio" name="role" value="Member" required> Member</div>
     
          </td>
        </tr>
        </table>
        <button id="myButton" class="submit-btn" name="register">Register</button>
	<?php include('php/errors.php'); ?>
      </form>
    </div>
  </div>
  <div class="footer">
    <p>UTAS   /    Assignment 1    /    Group 1</p>
  </div>
</body>
</html>
