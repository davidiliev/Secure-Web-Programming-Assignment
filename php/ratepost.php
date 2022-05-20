<?php
include 'dbconn.php';

$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$postId = isset($_POST['postId']) ? htmlspecialchars($_POST['postId']) : '';
$rating = isset($_POST['rating']) ? htmlspecialchars($_POST['rating']) : '';

if ($username != '' && $postId != '' && $rating != '') {

    // TODO: Currently a user can pass in another username ... client side issue (index.php).

    // check if post id exists
    $sql_query_post = 'SELECT id FROM Post WHERE id="'.$postId.'"';
    $postCheck = mysqli_query($conn,$sql_query_post);
    if($postCheck && $postCheck->num_rows == 1) {
        // post exist.

        // check client rating is correct
        if ($rating == 0) {
            $sql_query_delete = 'DELETE FROM Rating WHERE postId='.$postId.' AND username="'.$username.'"';

            mysqli_query($conn, $sql_query_delete);
        } else if ($rating == 1 || $rating == -1) {
            $sql_query_insert = 'INSERT INTO Rating VALUES ("'.$username.
            '", '.$rating.', '.$postId.') ON DUPLICATE KEY UPDATE username="'.
            $username.'", rating='.$rating.', postId='.$postId.'';

            mysqli_query($conn, $sql_query_insert);
        }

        // else do nothing since client side is suspicous 
    }
    // else do nothing since client side is suspicous 
    exit();
}
?>