<?php
// Add code here
session_start(); // req?
session_destroy();
header("Location: index.php");
exit();
?>