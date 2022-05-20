<?php
session_start();
// connect to database
require "php/dbconn.php";

// get the first four recent posts
function displayPosts() {
    global $conn;
    // Query Post table for the 4 mosts recent rows. Uses MariaDB syntax
    $sql_query = "SELECT title, content, date, username, id FROM Post ORDER BY date DESC LIMIT 4";

    // upon successful insertion, close database connection
    $result = $conn->query($sql_query);
    if($result) {
        if($result->num_rows > 0) { 
            while ($row = $result->fetch_assoc()) {

                // convert string to date and format
                $date = strtotime($row["date"]);

                // display post contents with new date format
                echo '<div id="post"><h2>'.$row["title"].
                '</h2><p id="date">By '.$row["username"].'<br>Published '.
                date('d M Y', $date).'</p><p>'.
                $row["content"].'</p>';

                // rating feature below and close div.
                $likes = 0;
                $dislikes = 0;

                // get like and dislike counts from all users
                $sql_query_post_likes = "SELECT COUNT(*) as likes FROM Rating WHERE postId=".$row["id"]." AND rating=1";
                $result1 = $conn->query($sql_query_post_likes);
                $sql_query_post_dislikes = "SELECT COUNT(*) as dislikes  FROM Rating WHERE postId=".$row["id"]." AND rating=-1";
                $result2 = $conn->query($sql_query_post_dislikes);

                if($result1) {
                    $result1=$result1->fetch_assoc();
                    $likes = isset($result1['likes']) ? $result1['likes'] : 0;                
                }

                if($result2) {
                    $result2=$result2->fetch_assoc();
                    $dislikes = isset($result2['dislikes']) ? $result2['dislikes'] : 0;     
                }

                // check user is logged in
                if(isset($_SESSION['role']) && isset($_SESSION['username'])) {
                    // user logged in

                    // Case members: Only members can rate. Generate necessary code.
                    if ($_SESSION['role']=="Member") {
                        $sql_query_user_rating = 'SELECT rating FROM Rating WHERE postId='.
                        $row["id"].' AND username="'.$_SESSION['username'].'"';
        
                        $user_rating = 0;
                        $result3 = $conn->query($sql_query_user_rating);
                        if($result3) {
                            $result3=$result3->fetch_assoc();
                            if (isset($result3['rating'])) {
                                $user_rating = $result3['rating'];                
                            }
                        }

                        // display rating buttons and counts (with consideration to user's current rating)
                        if ($user_rating > 0) {
                            // liked 
                            echo '<form id="rating"><button id="likeButton'.$row["id"].'" onclick="return clickLike('.$row["id"].');">
                            <i id="likeIcon'.$row["id"].'" class="fa fa-thumbs-up" aria-hidden="true"></i></button>
                            <span id="likeCount'.$row["id"].'">'.$likes.'</span> | <button id="dislikeButton'.$row["id"].'" onclick="return clickDislike('.$row["id"].');">
                            <i id="dislikeIcon'.$row["id"].'" class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
                            <span id="dislikeCount'.$row["id"].'">'.$dislikes.'</span></form></div>';

                        } else if ($user_rating < 0) {
                            // disliked 
                            echo '<form id="rating"><button id="likeButton'.$row["id"].'" onclick="return clickLike('.$row["id"].');">
                            <i id="likeIcon'.$row["id"].'" class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
                            <span id="likeCount'.$row["id"].'">'.$likes.'</span> | <button id="dislikeButton'.$row["id"].'" onclick="return clickDislike('.$row["id"].');">
                            <i id="dislikeIcon'.$row["id"].'" class="fa fa-thumbs-down" aria-hidden="true"></i></button>
                            <span id="dislikeCount'.$row["id"].'">'.$dislikes.'</span></form></div>';
                        } else {
                            //  neutral
                            echo '<form id="rating"><button id="likeButton'.$row["id"].'" onclick="return clickLike('.$row["id"].');">
                            <i id="likeIcon'.$row["id"].'" class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
                            <span id="likeCount'.$row["id"].'">'.$likes.'</span> | <button id="dislikeButton'.$row["id"].'" onclick="return clickDislike('.$row["id"].');">
                            <i id="dislikeIcon'.$row["id"].'" class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
                            <span id="dislikeCount'.$row["id"].'">'.$dislikes.'</span></form></div>';
                        }
                    } else { 
                        // Case: Author. Clicking on buttons brings up message.
                        echo '<div id="rating"><button onclick="clickAuthor()"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button> '.
                        $likes.' | <button onclick="clickAuthor()"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button> ' .
                        $dislikes.'</div></div>';

                        // Clicking on buttons brings up message.
                    }

                } else { 
                    // Case: Visitor. Clicking on buttons brings up message.
                    echo '<div id="rating"><button onclick="clickVisitor()"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button> '.
                    $likes.' | <button onclick="clickVisitor()"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button> ' .
                    $dislikes.'</div></div>';
                }
            }
        }
    }
}
?>
        <script>
            // declare functions here otherwise functions can not be reached.
            function clickVisitor() { alert("Only members can access this feature."); }
            function clickAuthor(){
                alert("Authors can not influence posts via ratings. Only members can access this feature."); }
        </script>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                    if (isset($_SESSION["role"])) {
                        if ($_SESSION["role"]=="Author") {
                            // display index, archive, create, about, logout
                            echo '<li id="navCurPageLi"><a href="index.php">Home</a></li>
                            <li><a href="archive.php">Archive</a></li>
                            <li><a href="create.html">Create</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="php/logout.php">Log out</a></li>'; 

                        } else { // Member
                            // display index, archive, about, logout
                            echo '<li id="navCurPageLi"><a href="index.php">Home</a></li>
                            <li><a href="archive.php">Archive</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="php/logout.php">Log out</a></li>'; 
                        }
                    } else { // Visitor
                        // display index, about, login, register
                        echo '<li id="navCurPageLi"><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="registration.php">Register</a></li>';      
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
    <script>
        function clickLike(id) {
            var userName =  <?php echo '"'.$_SESSION['username'].'"'?>;
            var likeBtn = document.getElementById('likeIcon' + id);
            var dislikeBtn = document.getElementById('dislikeIcon' + id);
            var likeCount = document.getElementById('likeCount' + id);
            var dislikeCount = document.getElementById('dislikeCount' + id);
            var rating = 0;

            // if like not press => pressed
            if (likeBtn.className == "fa fa-thumbs-o-up") { // like not pressed => like
                if (dislikeBtn.className == "fa fa-thumbs-down") { // dislike pressed                    
                    dislikeBtn.className = "fa fa-thumbs-o-down"; // set dislike not pressed                    
                    dislikeCount.textContent--; // decrement dislike number
                } // dislike not pressed
                likeBtn.className = "fa fa-thumbs-up";                
                likeCount.textContent++; // increment like number
                rating = 1;
            } else { // like already pressed => unlike
                likeBtn.className = "fa fa-thumbs-o-up";                
                likeCount.textContent--; // decrement like number
                rating = 0;
            }

            $.ajax({
                type:"post",
                url:"php/ratepost.php",
                data: 
                {  
                'username' : userName, // can't access this function without being a member.
                'postId' : id,
                'rating' : rating
                },
                cache:false,
                success: function (html) 
                {
                $('#msg').html(html);
                }
            });

            return false;
        }

        function clickDislike(id) {
            var userName =  <?php echo '"'.$_SESSION['username'].'"'?>;
            var likeBtn = document.getElementById('likeIcon' + id);
            var dislikeBtn = document.getElementById('dislikeIcon' + id);
            var likeCount = document.getElementById('likeCount' + id);
            var dislikeCount = document.getElementById('dislikeCount' + id);
            var rating = 0;

            // same logic as like, opposite values.
            if (dislikeBtn.className == "fa fa-thumbs-o-down") {
                if (likeBtn.className == "fa fa-thumbs-up") { 
                    likeBtn.className = "fa fa-thumbs-o-up";
                    likeCount.textContent--;
                } 
                dislikeBtn.className = "fa fa-thumbs-down";
                dislikeCount.textContent++;
                rating = -1;
            } else {
                dislikeBtn.className = "fa fa-thumbs-o-down";
                dislikeCount.textContent--;
                rating = 0;
            }

            $.ajax({
                type:"post",
                url:"php/ratepost.php",
                data: 
                {  
                'username' : userName, // can't access this function without being a member.
                'postId' : id,
                'rating' : rating
                },
                cache:false,
                success: function (html) 
                {
                $('#msg').html(html);
                }
            });
            return false;
        }
    </script>
    </body>
</html>