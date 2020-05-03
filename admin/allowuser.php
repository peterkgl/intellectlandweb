<?php
// Initialize the session
session_start();

// Check if the user is logged in, if yes go to home.php otherwise redirect to index page
if(session_id() != "sessionuseradmin") {
    header("location: ../index.php");
  exit;
}
// Include config file
require_once "config.php";
//retrive logged in user
$admin_id = $_SESSION["id"];
$user_id = $_GET['userid'];

	//update users
    $query1 = mysqli_query($link,"UPDATE users SET suspended = 0 WHERE id=$user_id");

    if ($query1) {
        $data = "viewmembers.php";
echo ("<script>window.alert('User Retrieved Successfully!'); window.location.href='$data';</script>");
    }

?>
