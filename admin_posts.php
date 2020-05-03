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
</head>
<body>
<header class="top">
    <div class="logo">
        <a href="#" class="logo-link">
        <img src="../img/logo.png">
        <h1 class="logo-text">IntellectLand - Admin Page</h1>
    </a>
    </div>
</header>

<div class="sidebar">
  <a href="../adminpanel.php"><i class="fa fa-fw fa-home"></i>Overview</a><br><br>

  <a href="homeadmin.php"><i class="fa fa-fw fa-plane"></i>Posts</a>
  <a href="viewmembers.php"><i class="fa fa-fw fa-group"></i> Community Members</a>
  <a href="viewadminmembers.php"><i class="fa fa-fw fa-group"></i> Admin Members</a>
  <a href="viewmembersbymonth.php"><i class="fa fa-fw fa-group"></i> Members By Month</a>
  <a href="chatmessages.php"><i class="fa fa-fw fa-comment"></i>Chats

      <?php
      $query16 = "SELECT * FROM CHAT WHERE reciever_userid = $admin_id AND status = 1";  
      $result16 = mysqli_query($link, $query16);  
      $rows = mysqli_num_rows($result16);
      if ($rows > 0) { ?>
        <span style="color: red;"><?php echo $rows; ?></span>
      <?php } ?>
      <span style="color: red;"></span>
    </a>
</div>

<div class="main">
	<div id="home">
  <h2>Posts</h2>
  <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
  <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
</div>
</div>
</body>
</html>