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


//get post id
$post_id = $_GET["postid"];


/*
|--------------------------------------------------------------------------
| DELETE POST
|--------------------------------------------------------------------------
*/

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletepost'])){
	$thispost= $_POST['thispost_id'];  //get id of the post to delete
	$query1 = mysqli_query($link,"DELETE FROM POSTS WHERE id = $thispost ");
	if ($query1) {
		$data = "home.php";
echo ("<script>window.alert('Post Deleted Successfully!'); window.location.href='$data';</script>");
	}
	//close connection
        mysqli_close($link);
}

/*
|--------------------------------------------------------------------------
| LIKE POST
|--------------------------------------------------------------------------
*/

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['likepost'])){
	$thispost= $_POST['thispost_id'];  //get id of the post
	$thisuser= $_POST['thisuser_id'];  //get id of the user

	//increment likes in posts
	$query1 = mysqli_query($link,"UPDATE posts SET likes = likes+1 WHERE id=$thispost");

	//add a like into likes
	$query2 = mysqli_query($link,"INSERT INTO likes (user_id, post_id) VALUES ($thisuser, $thispost)");
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
| UNLIKE POST
|--------------------------------------------------------------------------
*/

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unlikepost'])){
	$thispost= $_POST['thispost_id'];  //get id of the post
	$thisuser= $_POST['thisuser_id'];  //get id of the user

	//decrement likes in posts
	$query1 = mysqli_query($link,"UPDATE posts SET likes = likes-1 WHERE id=$thispost");

	//remove a like into likes
	$query2 = mysqli_query($link,"DELETE FROM likes WHERE user_id = $thisuser AND post_id = $thispost");
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
| ADD COMMENT
|--------------------------------------------------------------------------
*/

// Define variable and initialize with empty values
$postcomment_data_err = $postcomment_id = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postcomment'])){

	$postcomment_id= $_POST['postcomment_id'];  //get id of the post
	$thisuser = $_SESSION["id"];

	// Validate post
    if(empty(trim($_POST["usercomment"]))){
        $postcomment_data_err = "Please enter Comment.";
    } else{
        if(empty($post_data_err)){
        	//Add new post
        	//get data from form
        	$postcomment_data = trim($_POST["usercomment"]);

        	$sql = "INSERT INTO comments (comment_data, user_id, post_id) VALUES (?, ?, ?)";
        	$sql1 = "UPDATE posts SET comments = comments+1 WHERE id = ?";
        	if($stmt = mysqli_prepare($link, $sql)){
        		if($stmt1 = mysqli_prepare($link, $sql1)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_comment, $param_userid, $param_postid);
            mysqli_stmt_bind_param($stmt1, "s", $param_postid);
            
            // Set parameters
            $param_comment = $postcomment_data;
            $param_userid = $thisuser;
            $param_postid = $postcomment_id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)){
            	// Redirect to news feed  page
				
                $data = "viewpostdetails.php?postid=$postcomment_id";
                header("location: $data");
            }
            else{
                $postcomment_data_err = "Something went wrong. Inserting.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        	}

		}
		//close connection
        mysqli_close($link);
	}
}
}


/*
|--------------------------------------------------------------------------
| EDIT POST
|--------------------------------------------------------------------------
*/
$editpost_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editthis-post'])){

	// Check if editpost is empty
    if(empty(trim($_POST["editthispost"]))){
        $editpost_err = "Please enter post data.";
    } else{

        $thispost = $_POST['thispost_id'];  //get id of the post edited
		$newpostdata = $_POST['editthispost']; //get data
    }
    if (empty($editpost_err) || empty($thispost) || empty($newpostdata)) {
    	
		$sql = "UPDATE posts SET post_data = ? WHERE id = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_postdata, $param_id);
            
            // Set parameters
            $param_postdata = $newpostdata;
            $param_id = $thispost;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to news feed  page
        $data = "viewpostdetails.php?postid=$thispost";
                header("location: $data");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    else
    {
    	echo "Something went wrong.";
    }
}


/*
|--------------------------------------------------------------------------
| SEARCH POST
|--------------------------------------------------------------------------
*/
$search_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchpost'])){

    // Check if search is empty
    if(empty(trim($_POST["searchfield"]))){
        $search_err = "Please enter post data.";
    } else{

        $searchkey = $_POST['searchfield'];  //get search keyword
       
    }
    if (empty($search_err) || empty($searchkey)) {
        
        // $sql = "UPDATE posts SET post_data = ? WHERE id = ?";
         
        // if($stmt = mysqli_prepare($link, $sql)){
        //     // Bind variables to the prepared statement as parameters
        //     mysqli_stmt_bind_param($stmt, "ss", $param_postdata, $param_id);
            
        //     // Set parameters
        //     $param_postdata = $newpostdata;
        //     $param_id = $thispost;
            
        //     // Attempt to execute the prepared statement
        //     if(mysqli_stmt_execute($stmt)){
                // Redirect to complete profile page
$data = "searchresults.php?key=$searchkey";
header("location: $data");
            // } else{
            //     echo "Something went wrong. Please try again later.";
            // }

    //         // Close statement
    //         mysqli_stmt_close($stmt);
    //     }
    // }
    // else
    // {
    //     echo "Something went wrong.";
    }
}

/*
|--------------------------------------------------------------------------
| Others
|--------------------------------------------------------------------------
*/

$query1 = mysqli_query($link,"SELECT * FROM USERS WHERE id = $user_id");
while($result = mysqli_fetch_array($query1, MYSQLI_ASSOC))
{
	$query10 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $user_id");
	while($result10 = mysqli_fetch_array($query10, MYSQLI_ASSOC))
	{
	

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>IntellectLand</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="js/script.js"></script>
    <link type="text/css" href="css/demo.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<!-- font-awesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--fadeshow-->
	<link rel="stylesheet" href="css/jquery.fadeshow-0.1.1.min.css" />
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<!--custom css-->	
	<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<link rel="stylesheet" type="text/css" href="css/theme.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="img/logo.png">
<style>
        .stream-options{
            display: inline-block;
            width: 100%;
        }
        .stream-options h5{
            display: inline-flex;
        }
        .like label{
            background-color: red;
        }
        #txtPassportNumber{
            height: 50px;
            width: 500px;
            border-radius: 5px;
            border: none;
            background-color: red;
            position: relative;
        }
        #submit{
            border: none;
        }
        #submit:hover{
            background-color: lightgrey;
        }
        #reply{
            position: absolute;
            margin-left: -53px;
        }
        .btn-small:hover{
            background-color: lightgrey;
        }
        #btnReply{
            position: absolute;
            margin-left: -68px;
            height: 50px;
            padding-top: 15px;
        }
        .list-unstyled{
            list-style: none;
            text-align: center;
        }
        #list{
            text-align: center;
            margin-left: 40px;
        }
        #usercomment{
            position: relative;
            height: 50px; 
            resize: none;
        }
        #comment{
            margin-top: -70px;            
            position: relative;
            height: 50px;
        }
        table, tr, td{
            border-collapse: collapse;
            font-size: 14px;
        }
        .pt10{
            padding-right: 10px; 
        }
        .footer{
            height: 120px;
        }
        #contact-info{
            margin-top: 20px;
        }
        #nav{
            display: inline-flex;
            margin-right: 50px;
            margin-top: 0px;
        }
        #search,.search{
            width: 270px;
            margin-left: 0px;
        }
        @media only screen and (max-width: 758px){
            .footer{
                height: 190px;
                padding-left: 10px;
                padding-top: 10px;
            }
            .message-area{
                margin-top: -70px;
            }
            .title{
                margin: 5px;
                padding: 0px;
            }
            .nav{
                padding: 0px;
                margin: 0px;
            }
            #footer-nav{
                margin: 0px;
                padding: 0px;
            }
            #list{
                margin-left: 110px;
            }
            .label-info{
                margin-left: -10px;
            }
            #userimg{
                margin-left: 10px;
            }
        }
        
    </style>
</head>
<body>
<header>
	<div class="logo">
		<a href="home.php" class="logo-link">
		<img src="img/logo.png">
		<h1 class="logo-text">IntellectLand</h1>
	</a>
	</div>
	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav">
		<li><a href="home.php">Home</a></li>
		<li><a href="chatmessages.php">Messaging

      <?php
      $query16 = "SELECT * FROM CHAT WHERE reciever_userid = $user_id AND status = 1";  
      $result16 = mysqli_query($link, $query16);  
      $rows = mysqli_num_rows($result16);
      if ($rows > 0) { ?>
        <span class="badge top"><?php echo $rows; ?></span>
      <?php } ?>

      <span class="badge top"></span>

    </a></li>
		<li><a href="#">                   

<?php
$thisid = $result['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" class="nav-avatar"/>  ';  
}  
?>
        <b class="caret"></b></a>
        <ul>
            <li><a href="user-profile.php?userprofile=<?php echo $result['id']; ?>">My Profile</a></li>
           <!--  <li><hr></li> -->
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </li>
	</ul>
</header>
<div class="wrapper">
<div class="container">
<div class="row">
<div class="span3">
<div class="sidebar">
<ul class="widget widget-menu unstyled slide">
    
<?php
$thisid = $result['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" class="nav-avatar" id="userimg">  ';  
}  
?>

    <br>
<a href="user-profile.php?userprofile=<?php echo $result['id']; ?>">
<ul class="meta list list-unstyled">
    <li class="name" style="text-transform: uppercase;"><?php echo $result['fullnames']; ?>
        <br><label class="label label-info">Starter</label><br>
    </li>
</a>
    <li id="list"><a style="color: white; width: 160px;" href="viewallmembers.php"><button class="btn btn-primary"><i class="fa fa-users"></i>MEMBERS</button> </a></li>
</ul>
</ul>
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="search <?php echo (!empty($search_err)) ? 'has-error' : ''; ?>" style="margin-left: 0px;">
            <input type="text" id="search" name="searchfield" placeholder="Search Posts.."><br>
            <span class="help-block"><?php echo $search_err; ?></span>
            <button name="searchpost" class="btn btn-secondary" id="search">Search</button>
            </div>
    </form>
<!--/.sidebar-->
</div>

<div class="span9">
	<div class="content">
		

<div class="stream-list">

<?php 
$fullnames = $result['fullnames'];
$query2 = mysqli_query($link,"SELECT * FROM POSTS WHERE id=$post_id ORDER BY created_at desc");
while ($result2 = mysqli_fetch_array($query2, MYSQLI_ASSOC))
{ 
	
?>

<div class="media stream" style="background-color: #fff; margin-bottom: 20px;">
<a href="user-profile.php?userprofile=<?php echo $result2['id']; ?>" class="media-avatar medium pull-left">

<?php
$whopostedit = $result2['user_id'];
$query = "SELECT * FROM tbl_images WHERE id = $whopostedit";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" class="nav-avatar"/>  ';  
}  
?>

	</a>
	<div class="media-body">
		<div class="stream-headline">
			<a href="user-profile.php?userprofile=<?php echo $result2['user_id']; ?>">
			<h5 class="stream-author">
			<?php
			$userid = $result2['user_id']; 
			$query3 = mysqli_query($link,"SELECT * FROM USERS WHERE id = $userid");
			$result3 = mysqli_fetch_array($query3,MYSQLI_ASSOC);
			echo $result3['fullnames']; 
			 ?>
			</h5>
			</a>

			<small class="pull-right" style="color: #288ef4;">Posted at: <?php echo $result2['created_at']; ?></small>
			<div class="stream-text slide pull-left">
					<?php echo $result2['post_data']; ?>
			<br><br></div>
		</div><!--/.stream-headline-->
	</div>
		<div class="stream-options">
			<div class="like">
			

			 <?php
			//determine if this user has already liked this post
			$result = mysqli_query($link,
				"SELECT * FROM likes WHERE user_id=$user_id AND post_id=".$result2['id']." ");

				if (mysqli_num_rows($result) == 1) { ?>
							
				<h5>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<a href="" class="btn btn-small">
					<?php echo $result2['likes']; ?>
				<i class="icon-thumbs-up shaded"></i>				
				<?php
				$thisuser_id = htmlspecialchars($_SESSION["id"]); //who is logged in
				$thispost_id = $result2['id']; //this post
				?>
				
				<input type="hidden" name="thispost_id" value="<?php echo $thispost_id; ?>">
				<input type="hidden" name="thisuser_id" value="<?php echo $thisuser_id; ?>">
				<input type="submit" class="btn btn-small" id="submit" name="unlikepost" value="Unlike">
			</a>
				</form>
				</h5>

				<?php } else { ?>				
				<h5>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<a href="" class="btn btn-small">

				<?php
				
				$thisuser_id = htmlspecialchars($_SESSION["id"]); //who is logged in
				$thispost_id = $result2['id']; //this post
				?>
				<?php echo $result2['likes']; ?>
				<i class="icon-thumbs-up shaded">
					
				</i>
				<input type="hidden" name="thispost_id" value="<?php echo $thispost_id; ?>">
				<input type="hidden" name="thisuser_id" value="<?php echo $thisuser_id; ?>">
				<input type="submit" class="btn btn-small" id="submit" name="likepost" value="Like">
			</a>
				</form>
				</h5>
				

				<?php } ?>


			
			<a  data-toggle="modal" class="btn btn-small">
			<?php echo $result2['comments']; ?>
			<i class="icon-comment shaded"></i>
			Comments
			</a>

			<?php 
			$thispost_id = $result2['id']; //this post

			$query6 = mysqli_query($link,"SELECT * FROM comments where post_id = $thispost_id ORDER BY created_at asc");
			if (!empty($query6)) {
			while ($result6 = mysqli_fetch_array($query6, MYSQLI_ASSOC))
			{ 
			$postedby = $result6['user_id'];
			$query7 = mysqli_query($link,"SELECT * FROM USERS WHERE id = $postedby");
			$result7 = mysqli_fetch_array($query7, MYSQLI_ASSOC);
			$fullnames = $result7['fullnames'];
			?>
			<!-- Table for a comment card -->
			<table style="width: 750px;border: 1px; background-color: #eeeeee; margin-left: 100px; margin-bottom: 10px;">
				<thead>
					<tr>
						<th style="text-align: left; text-transform: uppercase;">
                            <?php echo $fullnames; ?>

                <?php
                $userid7 = $result6['user_id']; //who commented
                $user_id7 = htmlspecialchars($_SESSION["id"]); //who is logged in
                $thispost_id = $result6['post_id'];
                if ($userid7 == $user_id7) {
                 ?>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="deletecomment.php?commentid=<?php echo $result6['id']; ?>">Delete Comment</a>
                <?php 
                }
                ?>
                            
                        </th>
						<th colspan="1" style="text-align: right;color: #288ef4;"><?php echo $result6['created_at']; ?></th>
		
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2" style="text-align: left;">
						<?php echo $result6['comment_data']; ?>
					</td>
					</tr>
					
				</tbody>
			</table>
			<!-- End of Table for a comment card -->
			
			<?php
			# code...
			} ?>
			

			<?php }
			
			?>

			

			            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row-fluid <?php echo (!empty($postcomment_data_err)) ? 'has-error' : ''; ?>" >
                        <textarea class="span12" name="usercomment" id="usercomment" placeholder="Drop your comment.."></textarea>
                        <?php $thispost_id = $result2['id']; //this post ?>
                        <?php 
                        if ($result2['id'] == $postcomment_id) { ?>
                            <span class="help-block"> <?php echo $postcomment_data_err; ?> </span>
                        <?php }
                        else
                        { ?>
                            <span class="help-block"></span>
                        <?php } 
                        
                        ?>
                        
                        <input type="hidden" name="postcomment_id" value="<?php echo $thispost_id; ?>">
                        <input type="submit" name="postcomment" value="Comment" id="comment" class="btn btn-success pull-right">            
            </div>
            </form>
            </div>

            <div id="unlike">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
                    $userid7 = $result2['user_id']; //who posted
                    $user_id7 = htmlspecialchars($_SESSION["id"]); //who is logged in
                    $thispost_id = $result2['id'];
                if ($userid7 == $user_id7) {
                    
                 ?>
                 <h5>
                <input type="hidden" name="thispost_id" value="<?php echo $thispost_id; ?>">
                <input type="submit" name="deletepost" value="Delete Post" class="btn btn-danger">
                
                <a data-toggle="modal" data-target="#edit-post<?php echo $thispost_id;?>">
                <input type="submit" name="edit-post" value="Edit Post" class="btn btn-success"></a>
                </h5>
<?php 
}
?>
            </form>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<!-- edit post Modal -->

<div class="modal fade" id="edit-post<?php echo $thispost_id;?>">
<div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
    <div class="modal-content">
      <!--Body-->
      <div class="modal-body">
        <div class="md-form <?php echo (!empty($editpost_err)) ? 'has-error' : ''; ?>">
        <input type="hidden" name="thispost_id" value="<?php echo $thispost_id; ?>">
        <textarea type="text" id="modal-comment" name="editthispost" class="md-textarea form-control" placeholder="Edit your post"><?php
        $query16 = mysqli_query($link,"SELECT * FROM POSTS WHERE id = $thispost_id");
        $result16 = mysqli_fetch_array($query16, MYSQLI_ASSOC);
        echo $result16['post_data'];
        ?></textarea>
        <span class="help-block"> <?php echo $editpost_err; ?> </span>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <input type="submit" name="editthis-post" value="Save" class="btn btn-primary">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
      </div>

    </form>
    </div>
  </div>
</div>
</div>


</div><!--/.media .stream-->
</div>
<?php
}
?>
</div>
</div><!--/.module-body-->
</div><!--/.module-->
</div><!--/.content-->
</div><!--/.span9-->
</div>
</div><!--/.container-->
</div><!--/.wrapper-->


<!-- footer area -->

<div class="footer">
        <div class="title">
            <p>IntellectLand</p>
        </div>
        <div>
        <ul class="nav" id="nav">
            <li id="footer-nav"><a href="#">Home |</a></li>
            <li id="footer-nav"><a href="about-us.php">About |</a></li>
            <li id="footer-nav"><a href="contact.php">Contact</a></li>
        </ul>
        </div>
        <form id="contact-info">
            <p>Contact info</p>
            <p><i class="fa fa-envelope pt10"></i><span>www.intellectland.info</span></p>
            <p><i class="fa fa-phone pt10"></i><span>+123456789</span></p>
    </form>
        <div class="message-area pull-right">
            
            <label>or sign in with:

            <i class="fa fa-facebook"></i>
            <i class="fa fa-twitter"></i>
            <i class="fa fa-youtube"></i></label>
        </div>
</div>
    <footer>
        <span>&copy; 2020 IntellectLand | <i>Alrights reserved</i></span>
        
    </footer>
</body>
</body>
</html>
<?php
} //result10
} //result
?>
