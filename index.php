<?php
/*
    TODO:
    Add author name to the post
    Add css for author name

    Other todo:
    navbar
*/


session_start();
// connect to database
require "php/dbconn.php";

// get the first four recent posts
// display posts

function displayPosts() {
    global $conn;
    // Query Post table for the 4 mosts recent rows. Uses MariaDB syntax
    // TODO: consider username
    $sql_query = "SELECT title, content, date FROM Post ORDER BY date DESC LIMIT 4";

    // upon successful insertion, close database connection
    $result = $conn->query($sql_query);
    if($result) { // connection established
      if($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) {
            echo '<div id="post"><h2>'.$row["title"].'</h2><p id="date">'.$row["date"].'</p><p>'.$row["content"].'</p></div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tom, Dick & Harry's</title>
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/shared.css">
        <!--referencing a whole sheet for a hamburger menu...-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="javascript/navigation.js"></script>
    </head>
    <body>     
        <h1>Tom, Dick & Harry's</h1>
        <div id="column">
            <div class="banner"></div>
            <!--Top-level navigation bar-->
            <div id="navbar" class="navbarclass">  
                <ul id="navOptions">
                    <!--Generate bar based on user role-->
                    <?php  
                    if (isset($_SESSION["userRole"])) {
                        if ($_SESSION["userRole"]=="Author") {
                            // display index, archive, create, about, logout
                            echo '<li id="navCurPageLi"><a href="index.php">Home</a></li>
                            <li><a href="archive.html">Archive</a></li>
                            <li><a href="create.html">Create</a></li>
                            <li><a href="about.html">About</a></li>'; // TODO: add logout


                        } else { // Member
                            // display index, archive, about, logout
                            echo '<li id="navCurPageLi"><a href="index.php">Home</a></li>
                            <li><a href="archive.html">Archive</a></li>
                            <li><a href="about.html">About</a></li>'; // TODO: add logout

                        }
                    } else { // Visitor
                        // display index, about, login, register
                        // TODO: include replace .html with .php when required.
                        echo '<li id="navCurPageLi"><a href="index.php">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="registration.html">Register</a></li>';      
                    }
                    ?>
                </ul>
                <button href="javascript:void(0);" class="icon" onclick="mobileMenu()"> 
                    <i class="fa fa-bars"></i></button>  
            </div>
            <div id="mainSection">
                <?php displayPosts()?>
            </div>
        </div>

        <div class="footer">
            <p>UTAS   /    Assignment 1    /    Group 1</p>
          </div>
    </body>
</html>