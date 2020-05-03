<?php
//Initialize the session
session_start();

//Check if the user is logged in As admin, if yes continue otherwise redirect to index page
if(session_id() != "sessionuseradmin") {
    header("location: index.php");
  exit;
}
//Include config file
require_once "config.php";
//retrive ADMIN ID
$admin_id = $_SESSION["id"];
//retrive ADMIN EMAIL
$admin_email = $_SESSION["email"];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="img/logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <link rel="stylesheet" type="text/css" href="css/DashMain.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <style>
      #notification{
        background-color: tomato;
        color: #fff;
        border-radius: 5px;
        padding: 2px;
      }
    </style>
</head>
<body>
<header class="top">
    <div class="logo">
        <a href="#" class="logo-link">
        <img src="img/logo.png">
        <h1 class="logo-text">IntellectLand - Admin Entry</h1>
    </a>
    </div>
    <ul class="nav">
     <li><a href="admin/user-profile.php?userprofile=<?php echo $admin_id;?>">My Profile </a><i class="entypo-logout right"></i></li>
    <li><a href="logout.php">Log Out </a><i class="entypo-logout right"></i></li>
  </ul>
</header>

<div class="sidebar">
  <ul class="left-nav">
  <li class="active"><a href="adminpanel.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a></li><br><br>

  <li><a href="admin/homeadmin.php"><i class="fa fa-fw fa-plane"></i>Posts</a></li>
  <li><a href="admin/viewmembers.php"><i class="fa fa-fw fa-group"></i> All Members</a></li>
  <li><a href="admin/viewadminmembers.php"><i class="fa fa-fw fa-group"></i> Admin Members</a></li>
  <li><a href="admin/viewmembersbymonth.php"><i class="fa fa-fw fa-group"></i> New Members</a></li>
  <li><a href="admin/contactusmessages.php"><i class="fa fa-fw fa-inbox"></i> Inbox
  <?php
      $query1 = "SELECT * FROM contact_us_messages WHERE replied = 1";  
      $result1 = mysqli_query($link, $query1);  
      $row = mysqli_num_rows($result1);
      if ($row > 0) { ?>
        <span id="notification"><?php echo $row; ?></span>
      <?php } ?>
      <span></span>
</a></li>

  <li><a href="admin/chatmessages.php"><i class="fa fa-fw fa-comment"></i> Chat

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
    <!-- First Section Statistics -->
  <h2>Intellectland In Numbers</h2>

      <hr>

      <div class="col-sm-3"><a href="admin/viewmembers.php">      
        <div class="tile-stats tile-green">
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
            <h2>All Members Joined</h2><br> 
            <?php
              // date_default_timezone_set("Africa/Kigali"); 
              // $date  = date('Y-m');
              // $query = "select * from enrolls_to WHERE  paid_date LIKE '$date%'";

              $query = "select * from USERS WHERE verified=1 AND user_level = 0";
              //echo $query;
              $result  = mysqli_query($link, $query);
              $members = mysqli_num_rows($result);
              
              echo $members;
              ?>
            </div>
        </div></a>
      </div>


      <div class="col-sm-3"><a href="admin/viewmembersbymonth.php">     
        <div class="tile-stats tile-aqua">
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
            <h2>Joined This Month</h2><br>  
              <?php
              date_default_timezone_set("Africa/Kigali"); 
              $date  = date('Y-m');
              $query = "select COUNT(*) from users WHERE created_at LIKE '$date%' AND user_level = 0";

              //echo $query;
              $result = mysqli_query($link, $query);
              $i      = 1;
              if (mysqli_affected_rows($link) != 0) {
                  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                      echo $row['COUNT(*)'];
                  }
              }
              $i = 1;
              ?>
            </div>
        </div></a>      
      </div>


      <div class="col-sm-3"><a href="admin/viewadminmembers.php">      
        <div class="tile-stats tile-blue">
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
            <h2>All Admin Members</h2><br> 
            <?php
              // date_default_timezone_set("Africa/Kigali"); 
              // $date  = date('Y-m');
              // $query = "select * from enrolls_to WHERE  paid_date LIKE '$date%'";

              $query = "select * from USERS WHERE verified=1 AND user_level=1";
              //echo $query;
              $result  = mysqli_query($link, $query);
              $members = mysqli_num_rows($result);
              
              echo $members;
              ?>
            </div>
        </div></a>
      </div>

       <div class="col-sm-3"><a href="admin/homeadmin.php">      
        <div class="tile-stats tile-red">
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
            <h2>Total Number of Posts</h2><br> 
            <?php
              // date_default_timezone_set("Africa/Kigali"); 
              // $date  = date('Y-m');
              // $query = "select * from enrolls_to WHERE  paid_date LIKE '$date%'";

              $query = "select * from POSTS";
              //echo $query;
              $result  = mysqli_query($link, $query);
              $posts = mysqli_num_rows($result);
              
              echo $posts;
              ?>
            </div>
        </div></a>
      </div>
       <!-- First Section Statistics END-->


</div>
</div>
</body>
</html>