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
$message_id = $_GET['thismessage'];

	//update users
    $query1 = mysqli_query($link,"UPDATE contact_us_messages SET replied = 0 WHERE id=$message_id");

    if ($query1) {
        $data = "contactusmessages.php";
echo ("<script>window.alert('Action Success!'); window.location.href='$data';</script>");
    }

?>
