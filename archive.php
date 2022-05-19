<?php
/*
    TODO: find better retrieval query
    css to pad below a post(?)
*/

session_start();
require "php/dbconn.php";

// get the first four recent posts
function displayPosts() {
    global $conn;
    // Query Post table for the 4 mosts recent rows. Uses MariaDB syntax
    //$sql_query = "SELECT title, date FROM Post ORDER BY date DESC OFFSET 4 ROWS"; // db version; can't use OFFSET 4 ROWS;
    // Dumb solution
    $sql_query = "SELECT title, date FROM Post ORDER BY date DESC LIMIT 4,9999";

    // upon successful insertion, close database connection
    $result = $conn->query($sql_query);
    if($result) { // connection established
      if($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) {
            $date = strtotime($row["date"]);

            echo '<div id="post"><h2>'.$row["title"].'</h2><p id="date">'.date('d M Y', $date).'</p></div>';
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
        <title>Archive</title>
        <link rel="stylesheet" href="css/archive.css">
        <link rel="stylesheet" href="css/shared.css">
        <!--refencing a whole sheet for a hamburger menu...-->
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
                    <?php  
                    if (isset($_SESSION["userRole"])) {
                        if ($_SESSION["userRole"]=="Author") {
                            // display index, archive, create, about, logout
                            echo '<li><a href="index.php">Home</a></li>
                            <li id="navCurPageLi"><a href="archive.php">Archive</a></li>
                            <li><a href="create.html">Create</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="logout.php">Log out</a></li>'; 

                        } else { // Member
                            // display index, archive, about, logout
                            echo '<li><a href="index.php">Home</a></li>
                            <li id="navCurPageLi"><a href="archive.php">Archive</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="logout.php">Log out</a></li>'; 
                        }
                    } // No option for visitor. Can't access this page without a userRole. 
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