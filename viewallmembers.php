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

//current logged in user
$query11 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $user_id");
while ($result11 = mysqli_fetch_array($query11, MYSQLI_ASSOC))
{  
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IntellectLand</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/info.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">
  <link rel="stylesheet" type="text/css" href="css/theme.css">
  <link rel="stylesheet" type="text/css" href="css/responsive.css">
  <link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="img/logo.png">
    <style type="text/css">
      th,td{ 
      
      text-align: left; 
   
      padding: 5px;
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
                height: 195px;
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
$thisid = $result11['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" class="nav-avatar"/>  ';  
}  
?>

                                <b class="caret"></b></a>
                                <ul>
                                    <li><a href="user-profile.php?userprofile=<?php echo $result11['id']; ?>">My Profile</a></li>
                                    <li><a href="logout.php" class="logout">Logout</a></li>
                                </ul>
                            </li>
  </ul>
</header>
<div class="container">
    <div class="view-account">
        <section class="module">
            <div class="module-inner">
                <div class="side-bar">
                    <div class="user-info">
                      
<?php
$thisid = $result11['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" class="img-profile img-circle img-responsive center-block"/>  ';  
}  
?>
        <ul class="meta list list-unstyled">
            <li class="name" style="text-transform: uppercase;"><?php echo $result11['fullnames']; ?>
                <label class="label label-info">Starter</label>
            </li>
            <li class="activity">Joined: <?php echo $result11['created_at']; ?></li>
            <li class="btn btn-primary"><i class="fa fa-users"></i> MEMBERS</li>
        </ul>
    </div>
</div>
<div class="content-panel">
        <fieldset class="fieldset">
            <h3 class="fieldset-title">Intellectland community members</h3>
            <div class="form-group avatar">                     
            </div>
            
<div class="table-responsive">
    <table class="table table-collapse">
<thead style="background-color: #006669;color: #fff;">
  <tr>
  <th>Fullnames </th>
  <th>Image</th>
  <th></th>
</tr>
</thead>
<!-- Get all system users -->
<?php
$loggedinuser = $result11['id'];
$query12 = mysqli_query($link,"SELECT * FROM users WHERE verified = 1 order by id DESC");
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
    <td><a href="user-profile.php?userprofile=<?php echo $result13['id']; ?>"><?php echo $result13['fullnames']; ?></a></td>

<!-- removed email and phone -->

    <td>
<?php
$thisid = $result13['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" height="50" width="50"/>  ';  
}  
?>

 </td>
    <td><a href="message.php?thisuser=<?php echo $result13['id'];?>" class="btn btn-primary">ChatMe</a></td>
  </tr>
  <?php 
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
</section>
</div>
</div>
<!-- footer area -->

<div class="footer">
        <div class="title">
            <p>IntellectLand</p>
        </div>
        <div>
        <ul class="nav" id="nav">
            <li id="footer-nav"><a href="home.php">Home |</a></li>
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
</html>
<?php

}
//}
?>