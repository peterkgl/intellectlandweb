<?php
// Initialize the session
session_start();

// Check if the user is logged in, if yes go to home.php otherwise redirect to index page
if(session_id() != "sessionloggedinuser" && session_id() != "sessionuseradmin") {
    header("location: ../index.php");
  exit;
}
// Include config file
require_once "config.php";
//retrive logged in user
$admin_id = $_SESSION["id"];


/*
|--------------------------------------------------------------------------
| DELETE POST (HOMEADMIN.PHP)
|--------------------------------------------------------------------------
*/
if (!empty($_GET["postid"])) {
//get comment id
$post_id =  $_GET["postid"];

	//delete in likes
	$query1 = mysqli_query($link,"DELETE FROM likes WHERE post_id=$post_id");

	//delete in comments
	$query2 = mysqli_query($link,"DELETE FROM comments WHERE post_id=$post_id");

	//Finally delete Post itself
	$query3 = mysqli_query($link,"DELETE FROM posts WHERE id=$post_id");


	if ($query1 && $query2 && $query3) {
		// Redirect to adminposts  page
        $data = "homeadmin.php";
echo ("<script>window.alert('Post deleted Successfully!'); window.location.href='$data';</script>");
	}
	//close connection
        mysqli_close($link);
}

/*
|--------------------------------------------------------------------------
| DELETE POST (ADMINVIEWPOSTDETAILS.PHP)
|--------------------------------------------------------------------------
*/
if (!empty($_GET["postid2"])) {
//get comment id
$post_id =  $_GET["postid2"];

	//delete in likes
	$query1 = mysqli_query($link,"DELETE FROM likes WHERE post_id=$post_id");

	//delete in comments
	$query2 = mysqli_query($link,"DELETE FROM comments WHERE post_id=$post_id");

	//Finally delete Post itself
	$query3 = mysqli_query($link,"DELETE FROM posts WHERE id=$post_id");


	if ($query1 && $query2 && $query3) {
		// Redirect to adminposts  page
        $data = "homeadmin.php";
echo ("<script>window.alert('Post deleted Successfully!'); window.location.href='$data';</script>");
	}
	//close connection
        mysqli_close($link);
}

/*
|--------------------------------------------------------------------------
| DELETE COMMENT (ADMINVIEWPOSTDETAILS.PHP)
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
	$query2 = mysqli_query($link,"UPDATE POSTS SET comments = comments-1 WHERE id=$thispost");

	if ($query1 && $query2) {
		// Redirect to news feed  page
        $data = "adminviewpostdetails.php?postid=$thispost";
echo ("<script>window.alert('Post deleted Successfully!'); window.location.href='$data';</script>");
	}
	//close connection
        mysqli_close($link);
}


/*
|--------------------------------------------------------------------------
| DELETE COMMENT (HOMEADMIN.PHP)
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
	$query2 = mysqli_query($link,"UPDATE POSTS SET comments = comments-1 WHERE id=$thispost");

	if ($query1 && $query2) {
		// Redirect to news feed  page

                $data = "homeadmin.php";
echo ("<script>window.alert('Comment deleted Successfully!'); window.location.href='$data';</script>");
	}
	//close connection
        mysqli_close($link);
}

?>
