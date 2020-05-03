<?php
//Initialize the session
session_start();

//Check if the user is logged in As admin, if yes continue otherwise redirect to index page
if(session_id() != "sessionuseradmin") {
   header("location: index.php");
 exit;
}
//Include config file
require_once "../config.php";
//retrive ADMIN ID
$admin_id = $_SESSION["id"];
//retrive ADMIN EMAIL
$admin_email = $_SESSION["email"];

//get post id
$post_id = $_GET["postid"];


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
                
                $data = "adminviewpostdetails.php?postid=$postcomment_id";
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
        $data = "adminviewpostdetails.php?postid=$thispost";
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
        $data = "adminviewpostdetails.php?postid=$thispost";
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



$query1 = mysqli_query($link,"SELECT * FROM USERS WHERE id = $admin_id");
while($result = mysqli_fetch_array($query1, MYSQLI_ASSOC))
{
  $query10 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $admin_id");
  while($result10 = mysqli_fetch_array($query10, MYSQLI_ASSOC))
  {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="shortcut icon" href="favicon.png?v=1.1" type="../image/png"> 
    <link rel="icon" type="image/ico" href="../img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
    <link type="text/css" href="../images/icons/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <!-- font-awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--fadeshow-->
    <link rel="stylesheet" href="../css/jquery.fadeshow-0.1.1.min.css" />
    <!--custom css-->
    <link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="../img/logo.png">
    <link type="text/css" href="../css/demo.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/theme.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">
    <style>
        #notification{
        background-color: tomato;
        color: #fff;
        border-radius: 5px;
        padding: 2px;
    </style>
</head>
<body>
<header class="top">
    <div class="logo">
        <a href="#" class="logo-link">
        <img src="../img/logo.png">
        <h1 class="logo-text">IntellectLand - Admin Page</h1>
    </a>
    </div>
    <ul class="nav">
    <li><a href="../logout.php">Log Out </a><i class="entypo-logout right"></i></li>
  </ul>
</header>

<div class="sidebar">
  <ul class="leftNav">
  <li><a href="../adminpanel.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a></li><br><br>

  <li><a href="homeadmin.php"><i class="fa fa-fw fa-plane"></i>Posts</a></li>
  <li><a href="viewmembers.php"><i class="fa fa-fw fa-group"></i> All Members</a></li>
  <li><a href="viewadminmembers.php"><i class="fa fa-fw fa-group"></i> Admin Members</a></li>
  <li><a href="viewmembersbymonth.php"><i class="fa fa-fw fa-group"></i> New Members</a></li>
  <li><a href="contactusmessages.php"><i class="fa fa-fw fa-inbox"></i> Inbox
    <?php
      $query1 = "SELECT * FROM contact_us_messages WHERE replied = 1";  
      $result1 = mysqli_query($link, $query1);  
      $row = mysqli_num_rows($result1);
      if ($row > 0) { ?>
        <span id="notification"><?php echo $row; ?></span>
      <?php } ?>
      <span></span>
</a></li>
  <li><a href="chatmessages.php"><i class="fa fa-fw fa-comment"></i> Chat

      <?php
      $query16 = "SELECT * FROM CHAT WHERE reciever_userid = $admin_id AND status = 1";  
      $result16 = mysqli_query($link, $query16);  
      $rows = mysqli_num_rows($result16);
      if ($rows > 0) { ?>
        <span id="notification"><?php echo $rows; ?></span>
      <?php } ?>
      <span style="color: red;"></span>
    </a></li>
  </ul>
</div>


<div class="main">
    <div id="home">
  <h2>Post Details</h2>

<div class="stream-list">

<?php 
$fullnames = $result['fullnames'];
$query2 = mysqli_query($link,"SELECT * FROM POSTS WHERE id=$post_id ORDER BY created_at desc");
while ($result2 = mysqli_fetch_array($query2, MYSQLI_ASSOC))
{ 
    
?>

<div class="media stream">
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
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <a href="deletecommentadmin.php?postid2=<?php echo $result2['id']; ?>" class="btn btn-danger pull-right">Delete Post</a>
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
             $userid = $result2['user_id'];
            //determine if this user has already liked this post
            $result = mysqli_query($link,
                "SELECT * FROM likes WHERE user_id=$admin_id AND post_id=".$result2['id']." ");

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
                        <th style="text-align: left; text-transform: uppercase;"><?php echo $fullnames; ?>
                         
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="deletecommentadmin.php?commentid=<?php echo $result6['id']; ?>" class="pull-right">Delete Comment</a>
                
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
<?php
}
}
}
?>

</div>
</div>
</body>
</html>