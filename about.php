<?php
    session_start();
    // connect to database
    require "php/dbconn.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
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
                    if (isset($_SESSION["userRole"])) {
                        if ($_SESSION["userRole"]=="Author") {
                            // display index, archive, create, about, logout
                            echo '<li><a href="index.php">Home</a></li>
                            <li><a href="archive.php">Archive</a></li>
                            <li><a href="create.html">Create</a></li>
                            <li id="navCurPageLi"><a href="about.php">About</a></li>
                            <li><a href="logout.php">Log out</a></li>'; 

                        } else { // Member
                            // display index, archive, about, logout
                            echo '<li><a href="index.php">Home</a></li>
                            <li><a href="archive.php">Archive</a></li>
                            <li id="navCurPageLi"><a href="about.php">About</a></li>
                            <li><a href="logout.php">Log out</a></li>'; 
                        }
                    } else { // Visitor
                        // display index, about, login, register
                        // TODO: include replace .html with .php when required.
                        echo '<li><a href="index.php">Home</a></li>
                        <li id="navCurPageLi"><a href="about.php">About</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="registration.html">Register</a></li>';      
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
                <br>- A minimum of 8 characters
                <br>- Must contain one number
                <br>- Must contain one uppercase and one lowercase
            </p>
            <h2>Registration Approach</h2>
            <p>
                For the registration / login page and how they interact with each other. We decided to direct the user to a separate registration page, instead of taking the JavaScript approach. This was mainly because as a group, to split the assignment into 3 equal amounts, each group member would need to get a total of 30 marks worth of work. With the registration page worth 15 marks and the login worth 10 marks, we split these two tasks up. However, if we decided that both the registration.html and login.html pages were done by a single member, then we would of gone the JavaScript route.
            </p>
            <h2>Additions</h2>
            <p>
                Beyond the scope of the assignment we added: 
                <br>
                - .....
            </p>
            <p>
                The navigation bar was overhauled due to previous feedback. The navigation bar features an icon, for smaller screens, and a re-usable style.
            </p>
            <h2>References</h2>
            <p>
                - Banner image: <a href="https://www.flickr.com/photos/akitzmil/3455932653/in/photolist-6goynK-6gsKHy-7jsapk-58YzVk-4sE5gU-TwnFk-7jsati-bacZf2-7jw3oq-6A3GB-N2zic-F9gjy9-7jw3js-7jsaxM-5GHUU2-pL1DL-2TsCfg-EHFvk-enYB-cboTm-49HHMv-3RgcJ-98aJd-F9gbwh-EdRMPW-pRb4xU-izESoj-qjvWtq-9F1kV5-4jGkQ-7rXZJ-7rZUW-aKCY6t-5VtSjs-asBTTA-9NzeoM-4BoUFF-ddkdgg-aZigXM-qTwaov-a23SwE-bpnTY5-7afHmJ-52kW24-5isbRj-5V4AFW-7AoJNf-sntFU-7AoJT7-2evHs">'Bookshelf' taken by Andrew Kitzmiller on April 19, 2009</a>.
                <br>
                - Navigation bar was heavily modified using code from W3 Schools (specifically, <a href="https://www.w3schools.com/howto/howto_js_topnav_responsive.asp">this link</a>).
                <br>
                - Hamburger menu icon was sourced from an ajax <a href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">library</a>.
                <br>- Included in the password policy, the Regex pattern used for the password restriction is sourced from W3 Schools.
            </p>
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
                    <td>33.33%</td>
                </tr>
                <tr>
                    <td>Tom Dickinson</td>
                    <td>508620</td>
                    <td>33.33%</td>
                </tr>
                <tr>
                    <td>Lachlan Frawley</td>
                    <td>504916</td>
                    <td>33.33%</td>
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