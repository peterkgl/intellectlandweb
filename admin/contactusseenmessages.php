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
    <link type="text/css" href="../images/icons/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/home.css">
  <link rel="stylesheet" type="text/css" href="../css/theme.css">
  <link rel="stylesheet" type="text/css" href="../css/responsive.css">
  <link rel="shortcut icon" href="../favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="../img/logo.png">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<style>
   html{
            scroll-behavior: smooth;
        }
        #myBtn {
  display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  font-size: 25px;
  border: none;
  outline: none;
  background-color: tomato;
  color: white;
  cursor: pointer;
  padding: 20px;
  border-radius: 4px;
}

#myBtn:hover {
  background-color: #006669;
}
#notification{
        background-color: tomato;
        color: #fff;
        border-radius: 5px;
        padding: 2px;
</style>
<body>
<header class="top">
    <div class="logo">
        <a href="#" class="logo-link">
        <img src="../img/logo.png">
        <h1 class="logo-text">IntellectLand - Admin Page</h1>
    </a>
    </div>
    <ul class="nav">
      <li><a href="addnewadmin.php">Add New Admin</a></li>
    <li><a href="../logout.php">Log Out </a><i class="entypo-logout right"></i></li>
  </ul>
</header>

<div class="sidebar">
  <ul class="left-nav">
  <li><a href="../adminpanel.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a></li><br><br>

  <li><a href="homeadmin.php"><i class="fa fa-fw fa-plane"></i>Posts</a></li>
  <li><a href="viewmembers.php"><i class="fa fa-fw fa-group"></i> All Members</a></li>
  <li><a href="viewadminmembers.php"><i class="fa fa-fw fa-group"></i> Admin Members</a></li>
  <li><a href="viewmembersbymonth.php"><i class="fa fa-fw fa-group"></i> New Members</a></li>
  <li class="active"><a href="contactusmessages.php"><i class="fa fa-fw fa-inbox"></i> Inbox
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
  <h2>Messages</h2>

<fieldset class="fieldset">
<div class="table-responsive">
    <table class="table table-collapse" style="padding-left: 10px; width: 100%;">
<thead style="background-color: #006669;color: #fff; text-align: left;">
  <tr>
  <th>Fullnames </th>
  <th>Email</th>
  <th>Phone</th>
  <th>Message</th>
  <th>Sent On</th>
</tr>
</thead>
<!-- Get all system users -->
<?php
  $query13 = mysqli_query($link,"SELECT * FROM contact_us_messages WHERE replied = 0 order by created_at DESC");
  while ($result13 = mysqli_fetch_array($query13, MYSQLI_ASSOC))
  {
?> 
<tbody>
  <tr>
<td><?php echo $result13['fullnames']; ?></td>
<td><?php echo $result13['email']; ?></td>
<td><?php echo $result13['phone']; ?></td>
<td>
  <textarea disabled style="height: 60px; width: 400px; resize: none;"><?php echo $result13['message']; ?></textarea>  
  </td>
<td><?php echo $result13['created_at']; ?></a></td>

  </tr>
  <?php 
  }
  }
   ?>
</tbody>
</table>
</div>
</fieldset>
</div>
</div>
<!-- scroll to top button -->
<button onclick="topFunction()" id="myBtn" title="Go to top">^</button>
<script>
var mybutton = document.getElementById("myBtn");
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
</body>
</html>