<?php
//Initialize the session
session_start();

//Check if the user is logged in As admin, if yes continue otherwise redirect to index page
if(session_id() != "sessionuseradmin") {
   header("location: ../index.php");
 exit;
}
//Include config file
require_once "../config.php";
//retrive ADMIN ID
$admin_id = $_SESSION["id"];
//retrive ADMIN EMAIL
$admin_email = $_SESSION["email"];

//get search key
$searchdata = $_GET['key'];


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

  <li class="active"><a href="homeadmin.php"><i class="fa fa-fw fa-plane"></i>Posts</a></li>
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
    <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="admin-search <?php echo (!empty($search_err)) ? 'has-error' : ''; ?>" style="margin-left: 0px;">
      <input type="text" id="admin-search" name="searchfield" placeholder="Search Posts.."><br>
      <span class="help-block"><?php echo $search_err; ?></span>
      <button name="searchpost" id="admin-searchbtn">Search</button>
      </div>
    </form>
</div>


<div class="main">
    <div id="home">
  <h2>Posts</h2>

<div class="stream-list">

<?php 
$fullnames = $result['fullnames'];
$query2 = mysqli_query($link,"SELECT * FROM POSTS  WHERE post_data LIKE '%$searchdata%' ORDER BY created_at desc");
while ($result2 = mysqli_fetch_array($query2, MYSQLI_ASSOC))
{ 
    
?>

<div class="media stream" style=" margin-bottom: 20px;">
<a href="user-profile2.php?userprofile=<?php echo $result2['id']; ?>" class="media-avatar medium pull-left">

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
            <a href="user-profile2.php?userprofile=<?php echo $result2['user_id']; ?>">
            <h5 class="stream-author">
            <?php
            $userid = $result2['user_id']; 
            $query3 = mysqli_query($link,"SELECT * FROM USERS WHERE id = $userid");
            $result3 = mysqli_fetch_array($query3,MYSQLI_ASSOC);
            echo $result3['fullnames']; 
             ?>
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <a href="deletecommentadmin.php?postid=<?php echo $result2['id']; ?>" class="btn btn-danger pull-right">Delete Post</a>
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

              <a  class="btn btn-small">
            <?php echo $result2['likes']; ?>
            <i class="fa fa-share"></i>
            Likes
            </a>
                 
              <a  class="btn btn-small">
            <?php echo $result2['shares']; ?>
            <i class="fa fa-share"></i>
            Share
            </a>
  

            <a  data-toggle="modal" class="btn btn-small">
            <?php echo $result2['comments']; ?>
            <i class="icon-comment shaded"></i>
            Comments
            </a>   
            

            <?php 
            $thispost_id = $result2['id']; //this post
            $query6 = mysqli_query($link,"SELECT * FROM comments where post_id = $thispost_id ORDER BY created_at DESC limit 2");
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
                <a href="deletecommentadmin.php?commentid2=<?php echo $result6['id']; ?>" class="pull-right">Delete Comment</a>
                
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
            } ?>
            <?php
            $q6 = mysqli_query($link,"SELECT * FROM comments where post_id = $thispost_id");
            $rows = mysqli_num_rows($q6);
            if ($rows > 2) { ?>
                <a style="margin-left: 100px; " href="adminviewpostdetails.php?postid=<?php echo $result2['id']; ?>"> View all Comments </a>
            <?php } 
            ?>

            <?php }
            
            ?>

    </div>

  </div>

</div><!--/.media .stream-->
<?php

}
}
}
?>

</div>
</div>
</body>
</html>