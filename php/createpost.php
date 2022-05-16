<?php 

include 'dbconn.php';
$userName = "testUsername";
$title = htmlspecialchars($_POST['title']);
$date = htmlspecialchars($_POST['dateName']);
$content = htmlspecialchars($_POST['content']);
$sql = "INSERT INTO Post(username, title, date, content)
VALUES('$userName', '$title','$date','$content')";
  if (mysqli_query($conn, $sql)) {
        echo "New record has been added successfully !";
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
     }

mysqli_close($conn);
header('Location: ../index.php');
?>