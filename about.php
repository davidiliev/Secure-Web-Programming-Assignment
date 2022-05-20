<?php
    session_start();
    // connect to database
    require "php/dbconn.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About</title>
        <link rel="stylesheet" href="css/about.css">
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
                    if (isset($_SESSION["role"])) {
                        if ($_SESSION["role"]=="Author") {
                            // display index, archive, create, about, logout
                            echo '<li><a href="index.php">Home</a></li>
                            <li><a href="archive.php">Archive</a></li>
                            <li><a href="create.html">Create</a></li>
                            <li id="navCurPageLi"><a href="about.php">About</a></li>
                            <li><a href="php/logout.php">Log out</a></li>'; 

                        } else { // Member
                            // display index, archive, about, logout
                            echo '<li><a href="index.php">Home</a></li>
                            <li><a href="archive.php">Archive</a></li>
                            <li id="navCurPageLi"><a href="about.php">About</a></li>
                            <li><a href="php/logout.php">Log out</a></li>'; 
                        }
                    } else { // Visitor
                        // display index, about, login, register
                        // TODO: include replace .html with .php when required.
                        echo '<li><a href="index.php">Home</a></li>
                        <li id="navCurPageLi"><a href="about.php">About</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="registration.php">Register</a></li>';      
                    }
                    ?>
                </ul>
                <button href="javascript:void(0);" class="icon" onclick="mobileMenu()"> 
                    <i class="fa fa-bars"></i></button>  
            </div>
            <h2>"The French Dispatch" - Online Blog</h2>
            <p>The theme of our blog is inspired by the film The French Dispatch by Wes Anderson. The film brings to life a collection of short-stories published in the titular magazine “The French Dispatch”. Lachlan and Tom are also avid readers, so it made sense from a design perspective to lean into that.
                <br><br>The French Dispatch magazine uses an array of muted colours that we thought would translate well into an online blog to create a simple, minimalistic design that would have the additional benefit of being straight-forward to implement. This allowed us to focus on the HTML and CSS elements of the assignment, without stressing too much about the design aspect (although that is important).
            </p>
            <h2>Password Policy</h2>
            <p>A password policy defines the password strength rules that are used to determine whether a new password is valid. Our password policy for new user registration require:
            </p>
            <ul>
                <li>A minimum of 8 characters</li>
                <li>Must contain one number</li>
                <li>Must contain one uppercase and one lowercase</li>
            </ul>
            <h2>Registration Approach</h2>
            <p>
                For the registration / login page and how they interact with each other. We decided to direct the user to a separate registration page, instead of taking the JavaScript approach. This was mainly because as a group, to split the assignment into 3 equal amounts, each group member would need to get a total of 30 marks worth of work. With the registration page worth 15 marks and the login worth 10 marks, we split these two tasks up. However, if we decided that both the registration.html and login.html pages were done by a single member, then we would of gone the JavaScript route.
            </p>
            <h2>Changes to blog posts</h2>
            <p>
            Previously, posts were generated via Javascript. The script would generate four div 
            elements, referred to as posts, containing child elements for each necessary component (title, date, content).
            <br><br>
            The current approach generates posts via PHP. A single SQL query is used to retrieve the data required to build four posts. Posts are constructed using the same elements as before with the addition of an element containing the author's user name. A rating system has also been implemented
             and expands the code required to generate each post. Details about the rating system appear further below.       
            </p>

            <h2>HTTP Method Used</h2>
            <p>
            The method we used to submit the login and registration data to the user is the POST method. We used POST over GET, as POST requests are never cached and do not remain in the browser history, whereas, GET requests do. For a Log In and Registration system, it is pivotal to make it as secure as possible and in our opinion a GET request lacks security.
            </p>
            <h2>Roles</h2>
            <p>There are two distinct roles for users; 'Author' and 'Member'. These roles are assigned during registration based on the user's choice and stored in a session variable. All unregistered users are considered 'Visitors'. However, there is no 'Visitor' role stored in a session variable. Changing from 'Member' to 'Author', and vice versa, can only be achieved via a database administrator.
            <br><br>User roles define how the navigation bar is generated and displayed. For each role, the navigation bar contains links as follows: </p>
            <ul>
            <li>Author: Index, Archive, Create, About, Log out </li>
            <li>Member: Index, Archive, About, Log out</li>
            <li>Visitor: Index, About, Log in, Register</li>
            </ul>
            <p>
            While navigating the website via the bar above does work, create.html can be accessed without being an author. This can be achieved by entering the url. This isn't an issue since submitting a new post fails if a user is not an author. A solution to this is problem would consist of setting the create page as php and redirect users that are not authors (similar to archive.php).  
            <br><br>
            There are also restrictions to the rating system based on a user's role. This is discussed in the section below.
            </p>

            <h2>Additional Feature: Rating System</h2>
            <p>A rating system has been implemented to allow members to rate recent posts. Users can view separate like and dislike counts associated with each recent post. 
            <br><br>
                In the database, a table for ratings exists to allow many users (username) to rate many posts (postId). An additional single column for the rating stores an individual user's rating for a post (-1 or 1). If a user changes their rating from like to dislike, the rating is updated (vice verse). If a user removes their rating from a previously rated post, a query is sent to delete the row/relation. 
            <br><br>
            The rating system is only featured on the main page (index.php). Only members can rate posts. Other roles are given a specialised alert message unique to their role which denies access to rating.
            <br><br>
            During planning the main problem considered was updating the front and backend without refreshing the page. After a quick browse, a few options were available. Use forms and store a session variable for the hashed password(?), use cookies to track the user’s current position, use an iframe and/or use the jquery library. The later was chosen to gain some exposure to the jqueries. This was troublesome and the result contains an exploit.  
            <br><br>
            There are two known issues with this system: 
            </p>
            <ol>
            <li> A member can change their username via the console and like a post as an existing user. 
            </li>
            <li> Uncaught syntax error. Ignoring the previous issue, the webpage works as intended. This issue is perhaps a result of javascript and php not being arranged well.
            </li>
            </ol>
            <p> Other issues regarding errors and methods may exist (Using onlick()…). However, these are the main issues that require additional time to complete.
            </p>


            <h2>Additional info</h2>
            <p>
                The navigation bar was overhauled due to previous feedback. The navigation bar features an icon, for smaller screens, and a re-usable style.
            </p>
            <h2>References</h2>
            <ul>
            <li>Banner image: <a href="https://www.flickr.com/photos/akitzmil/3455932653/in/photolist-6goynK-6gsKHy-7jsapk-58YzVk-4sE5gU-TwnFk-7jsati-bacZf2-7jw3oq-6A3GB-N2zic-F9gjy9-7jw3js-7jsaxM-5GHUU2-pL1DL-2TsCfg-EHFvk-enYB-cboTm-49HHMv-3RgcJ-98aJd-F9gbwh-EdRMPW-pRb4xU-izESoj-qjvWtq-9F1kV5-4jGkQ-7rXZJ-7rZUW-aKCY6t-5VtSjs-asBTTA-9NzeoM-4BoUFF-ddkdgg-aZigXM-qTwaov-a23SwE-bpnTY5-7afHmJ-52kW24-5isbRj-5V4AFW-7AoJNf-sntFU-7AoJT7-2evHs">'Bookshelf' taken by Andrew Kitzmiller on April 19, 2009</a>.</li>
            <li>Navigation bar was heavily modified using code from W3 Schools (specifically, <a href="https://www.w3schools.com/howto/howto_js_topnav_responsive.asp">this link</a>).</li>
            <li>Hamburger menu and rating icons are sourced from an ajax <a href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">library</a>.</li>
            <li>Errors for login and registration were inspired by a <a href=”https://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database”>tutorial</a></li>
            <li>A post on jquery which influenced the functions clickLike() & clickDislike() in index.php (<a href=https://stackoverflow.com/questions/2866063/submit-form-without-page-reloading>link</a>)</li>
            <li>Included in the password policy, the Regex pattern used for the password restriction is sourced from W3 Schools.</li>
            </ul>

            <h2 id=author_heading>Authors</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Student #</th>
                    <th>Contribution</th>
                </tr>
                <tr>
                    <td>David Iliev</td>
                    <td>163516</td>
                    <td>37.5%</td>
                </tr>
                <tr>
                    <td>Tom Dickinson</td>
                    <td>508620</td>
                    <td>25%</td>
                </tr>
                <tr>
                    <td>Lachlan Frawley</td>
                    <td>504916</td>
                    <td>37.5%</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>
                UTAS   /    Assignment 1    /    Group 1
            </p>
        </div>
    </body>
</html>