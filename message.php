<?php 
session_start();

// Check if the user is logged in, if yes go to home.php otherwise redirect to index page
if(session_id() != "sessionloggedinuser") {
    header("location: index.php");
  exit;
}

// Include config file
require_once "config.php";

//retrive logged in user
$loguser_id = $_SESSION["id"];

//retrive clicked on user
$user_id = $_GET['thisuser'];

$_SESSION['userid'] = $loguser_id;

/*
|--------------------------------------------------------------------------
| Others
|--------------------------------------------------------------------------
*/

$query1 = mysqli_query($link,"SELECT * FROM USERS WHERE id = $loguser_id");
while($result = mysqli_fetch_array($query1, MYSQLI_ASSOC))
{
  $query10 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $loguser_id");
  while($result10 = mysqli_fetch_array($query10, MYSQLI_ASSOC))
  {

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IntellectLand </title>
  <!-- jQuery===modal-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- font-awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--fadeshow-->
  <link rel="stylesheet" href="css/jquery.fadeshow-0.1.1.min.css"/>
  <!--custom css--> 
  <link rel="stylesheet" type="text/css" href="css/chat.css">
  <link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png">
    <link rel="icon" type="image/ico" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="css/home.css">
<link href="css/style.css" rel="stylesheet" id="bootstrap-css">
<script src="js/chat.js"></script>
  <link rel="stylesheet" type="text/css" href="css/responsive.css">
<style>
.chat{
          background-color: inherit;
          width: 100%;
        }
        .messages{
          margin-top: 10px;
        }
        .message-input{
          font-size: 20px;
          margin-bottom: -5px;
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
      $query16 = "SELECT * FROM CHAT WHERE reciever_userid = $loguser_id AND status = 1";  
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
            <li><a href="user-profile.php?userprofile=<?php echo $loguser_id; ?>">My Profile</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
  </li>
  </ul>
</header>

  <?php if(!empty($_SESSION['userid'])) { ?>  
    <div class="chat">  
      <div id="frame">    
        <div id="sidepanel">
          <div id="profile">
          <?php
          include ('Chat.php');
          $chat = new Chat();
          $loggedUser = $chat->getUserDetails($_SESSION['userid']);
          echo '<div class="wrap">';
          $currentSession = '';
          foreach ($loggedUser as $user) {
            $currentSession = $user['current_session'];

            $thisid = $user['userid'];
            $query = "SELECT * FROM tbl_images WHERE id = $thisid";  
            $result0 = mysqli_query($link, $query);  
            while($row = mysqli_fetch_array($result0)) {    
            echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" class="online"/>  ';  
            }  
            //echo '<img id="profile-img" src="userpics/'.$user['avatar'].'" class="online" alt="" />';
            echo  '<p>'.$user['username'].'</p>';
              echo '<div id="expanded">';     
             
              echo '</div>';
          }
          echo '</div>';
          ?>
          </div>
          <div id="contacts"> 
          <?php
          echo '<ul>';
          
            $query15 = mysqli_query($link,"SELECT * FROM chat_users WHERE userid = $user_id");
            $user = mysqli_fetch_array($query15, MYSQLI_ASSOC);
            
            $status = 'offline';            
            if($user['online']) {
              $status = 'online';
            }
            $activeUser = '';
            if($user['userid'] == $currentSession) {
              $activeUser = "active";
            }
            echo '<li id="'.$user['userid'].'" class="contact '.$activeUser.'" data-touserid="'.$user['userid'].'" data-tousername="'.$user['username'].'">';
            echo '<div class="wrap">';
            echo '<span id="status_'.$user['userid'].'" class="contact-status '.$status.'"></span>';
            $thisid = $user['userid'];
            $query = "SELECT * FROM tbl_images WHERE id = $thisid";  
            $result0 = mysqli_query($link, $query);  
            while($row = mysqli_fetch_array($result0)) {    
            echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" />  ';  
            }  
            //echo '<img src="userpics/'.$user['avatar'].'" alt="" />';
            echo '<div class="meta">';
            echo '<p class="name">'.$user['username'].'<span id="unread_'.$user['userid'].'" class="unread">'.$chat->getUnreadMessageCount($user['userid'], $_SESSION['userid']).'</span></p>';
            echo '<p class="preview"><span id="isTyping_'.$user['userid'].'" class="isTyping"></span></p>';
            echo '</div>';
            echo '</div>';
            echo '</li>'; 
          }
          echo '</ul>';
          ?>
          </div>
          
        </div>      
        <div class="content" id="content"> 
          <div class="contact-profile" id="userSection">  
          <?php
          if ($user_id == $currentSession) {
          
          $userDetails = $chat->getUserDetails($currentSession);
          foreach ($userDetails as $user) {                   
             $thisid = $user['userid'];
            $query = "SELECT * FROM tbl_images WHERE id = $thisid";  
            $result0 = mysqli_query($link, $query);  
            while($row = mysqli_fetch_array($result0)) {    
            echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" />  ';  
            }                   
            //echo '<img src="userpics/'.$user['avatar'].'" alt="" />';
              echo '<p>'.$user['username'].'</p>';
          } 
      } else { ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <b>Click On Contact In Left Hand To Open Chat</b>
            
          <?php }
          ?>            
          </div>
          <div class="messages" id="conversation">    
          <?php
          if ($user_id == $currentSession) {
         echo $chat->getUserChat($_SESSION['userid'], $currentSession);    
          } else { ?>
        <br>
          <?php }
          ?>            
          </div>
<div class="message-input" id="replySection">       
            <div class="message-input" id="replyContainer">
              <div class="wrap">
                <input type="text" class="chatMessage" id="chatMessage<?php echo $currentSession; ?>" placeholder="Write your message..." />
                <button class="submit chatButton" id="chatButton<?php echo $currentSession; ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button> 
              </div>
            </div>          
          </div>
        </div>
      </div>
    </div>
  <?php 
}
}
?>

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