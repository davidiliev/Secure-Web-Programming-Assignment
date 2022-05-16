<?php 

include 'dbconn.php';
$username = htmlspecialchars($_POST['username']);
$password= htmlspecialchars($_POST['password']);
$password2= htmlspecialchars($_POST['password2']);
$role = htmlspecialchars($_POST['role']);

$usernameCheck = "SELECT * FROM User WHERE username = '$username'";

$result = mysqli_query($conn,$usernameCheck);

$userResult= mysqli_fetch_assoc($result);

if ($password != $password2) {
    header("Location: registration.html");
}

if($userResult){
    if($userResult == $username){
        header("Location: registration.html");
    }
}

$insertUser = "INSERT INTO User (username, password, role)
                VALUES('$username','$password','$role')";

    mysqli_query($conn,$insertUser);
                header('Location: ../index.html');


                //TODO: ERROR MESSAGES

?>