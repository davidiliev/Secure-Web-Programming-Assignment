<?php 
session_start();
include 'dbconn.php';

if (isset($_SESSION['username'])) {
   $userName = htmlspecialchars($_SESSION['username']);
   $title = htmlspecialchars($_POST['title']);
   $date = htmlspecialchars($_POST['dateName']);
   
   // prapre any paragraphs for easy retrieval when in index.php.
   $paragraphs = explode("\n", htmlspecialchars($_POST['content']));
   for ($i = 0; $i < count($paragraphs); $i++)
   {
       $paragraphs[$i] = '<p>'.$paragraphs[$i].'</p>';
   }
   $content = implode('', $paragraphs); // store as one massive string

   $sql = "INSERT INTO Post(username, title, date, content)
   VALUES('$userName', '$title','$date','$content')";
     if (mysqli_query($conn, $sql)) {
           echo "New record has been added successfully !";
        } else {
           echo "Error: " . $sql . ":-" . mysqli_error($conn);
        }
   mysqli_close($conn);
   header('Location: ../index.php');
} else {
   mysqli_close($conn);
   echo "<h1>Permission denied.</h1>";
}
?>