<?php
// Initialize the session
session_start();

// Check if the user is logged in, if yes go to home.php otherwise redirect to index page
if(session_id() != "sessionloggedinuser") {
    header("location: index.php");
  exit;
}
// Include config file
require_once "config.php";
//retrive logged in user
$user_id = $_SESSION["id"];

/*
|--------------------------------------------------------------------------
| DELETE COMMENT (VIEWPOSTDETAILS.PHP)
|--------------------------------------------------------------------------
*/
if (!empty($_GET["commentid"])) {
//get comment id
$comment_id =  $_GET["commentid"];

//get postid
$query10 = mysqli_query($link,"SELECT * FROM comments WHERE id = $comment_id");
$result10 = mysqli_fetch_array($query10, MYSQLI_ASSOC);
$thispost = $result10['post_id'];

//delete comment
	$query1 = mysqli_query($link,"DELETE FROM comments WHERE id=$comment_id");

	//decrement post comments
	$query2 = mysqli_query($link,"UPDATE POSTS SET comments = comments-1 WHERE id=3");

	if ($query1 && $query2) {
		// Redirect to news feed  page
        $data = "viewpostdetails.php?postid=$thispost";
                header("location: $data");
	}
	//close connection
        mysqli_close($link);
}


/*
|--------------------------------------------------------------------------
| DELETE COMMENT (HOME.PHP)
|--------------------------------------------------------------------------
*/
if (!empty($_GET["commentid2"])) {
//get comment id
$comment_id =  $_GET["commentid2"];

//get postid
$query10 = mysqli_query($link,"SELECT * FROM comments WHERE id = $comment_id");
$result10 = mysqli_fetch_array($query10, MYSQLI_ASSOC);
$thispost = $result10['post_id'];

//delete comment
	$query1 = mysqli_query($link,"DELETE FROM comments WHERE id=$comment_id");

	//decrement post comments
	$query2 = mysqli_query($link,"UPDATE POSTS SET comments = comments-1 WHERE id=3");

	if ($query1 && $query2) {
		// Redirect to news feed  page
        $data = "home.php?postid=$thispost";
                header("location: $data");
	}
	//close connection
        mysqli_close($link);
}

?>
