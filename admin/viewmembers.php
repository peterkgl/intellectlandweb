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

$query11 = mysqli_query($link,"SELECT * FROM users WHERE id = $admin_id");
while ($result11 = mysqli_fetch_array($query11, MYSQLI_ASSOC))
{
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/info.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="../js/script.js"></script>
    <link type="text/css" href="../images/icons/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/home.css">
  <link rel="stylesheet" type="text/css" href="../css/theme.css">
  <link rel="stylesheet" type="text/css" href="../css/responsive.css">
  <link rel="shortcut icon" href="../favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="../img/logo.png">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
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
        <img src="../img/logo.png">
        <h1 class="logo-text">IntellectLand - Admin Page</h1>
    </a>
    </div>
    <ul class="nav">
    <li><a href="../logout.php">Log Out </a><i class="entypo-logout right"></i></li>
  </ul>
</header>

<div class="sidebar">
  <ul class="left-nav">
  <li><a href="../adminpanel.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a></li><br><br>

  <li><a href="homeadmin.php"><i class="fa fa-fw fa-plane"></i>Posts</a></li>
  <li class="active"><a href="viewmembers.php"><i class="fa fa-fw fa-group"></i> All Members</a></li>
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
  <h2>All Intellectland community members</h2>

  <a href="viewsuspendedusers.php">View Suspended Users</a><br><br>
          <fieldset class="fieldset">
            
<div class="table-responsive">
    <table class="table table-collapse" style="padding-left: 10px; width: 100%;">
<thead style="background-color: #006669;color: #fff;">
  <tr>
  <th>Fullnames </th>
  <th>Username</th>
  <th>Firstname</th>
  <th>Lastname</th>
  <th>Email</th>
  <th>Phone</th>
  <th>Location</th>
  <th>Image</th>
  <th colspan="2" id="action" style="background-color: tomato;text-align: center;">Action</th>
</tr>
</thead>
<!-- Get all system users -->
<?php
$loggedinuser = $result11['id'];
$query12 = mysqli_query($link,"SELECT * FROM users WHERE verified = 1 AND user_level = 0 AND suspended = 0 order by id DESC");
while ($result12 = mysqli_fetch_array($query12, MYSQLI_ASSOC))
{ 
  
  $thisuserid = $result12['id'];

  if ($result12['id'] == $result11['id']) {
    continue;
  } else {

  $query13 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $thisuserid");
  while ($result13 = mysqli_fetch_array($query13, MYSQLI_ASSOC))
  {
?> 
<tbody>
  <tr>
<th><a href="user-profile.php?userprofile=<?php echo $result13['id']; ?>"><?php echo $result13['fullnames']; ?></a></th>
<th><?php echo $result13['username']; ?></th>
<th><?php echo $result13['firstname']; ?></th>
<th><?php echo $result13['lastname']; ?></th>
<th><?php echo $result13['email']; ?></th>
<th><?php echo $result13['phone']; ?></th>
<th><?php echo $result13['location']; ?></th>


<!-- removed email and phone -->

    <th>
<?php
$thisid = $result13['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" height="50" width="50"/>  ';  
}  
?>

 </th>
    <th><a href="message.php?thisuser=<?php echo $thisuserid; ?>" class="btn btn-primary">ChatMe</a></th>
    <th>
        <?php
        //determine if this user has been already suspended
        $result = mysqli_query($link,
          "SELECT * FROM users WHERE id=$thisuserid AND suspended=1 ");

          if (mysqli_num_rows($result) == 1) { ?>
     <a href="allowuser.php?userid=<?php echo $thisuserid; ?>" class="btn btn-success">Activate Account</a>

                <?php } else { ?>               
        <a href="suspenduser.php?userid=<?php echo $thisuserid; ?>" class="btn btn-danger">Suspend</a>
                

                <?php } ?>
    </th>
  </tr>
  <?php 
  }
  }
  }
  }
   ?>
</tbody>
</table>
</div>
</fieldset>
</div>
</div>
</body>
</html>