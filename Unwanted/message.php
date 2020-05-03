<?php 
session_start();
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
  <link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="img/logo.png">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
<script src="js/chat.js"></script>
    <link rel="stylesheet" type="text/css" href="css/home.css">
  <link rel="stylesheet" type="text/css" href="css/responsive.css">
<link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/chat.css">
<style>
.modal-dialog {
    width: 400px;
    margin: 30px auto;  
}
</style>
</head>
<body>
	<header>
	<div class="logo">
		<?php echo'<a href="home.php" class="logo-link">
		<img src="img/logo.png">
		<h1 class="logo-text">IntellectLand</h1>
	</a>'?>
	</div>
	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav">
		<li><?php echo'<a href="home.php">Home</a>'?></li>
		<li><?php echo'<a href="#">Messaging<span class="badge top">10</span></a>'?></li>
		<li><a href="#">
    <img src="img/passport.jpg" class="nav-avatar" />
      <b class="caret"></b></a>
      <ul>
          <li><?php echo'<a href="user-profile.php">Your Profile</a>'?></li>
          <li><?php echo'<a href="info.php">Edit Profile</a>'?></li>
          <li><?php echo'<a href="#">Account Settings</a>'?></li>
          <li><hr></li>
          <li><?php echo'<a href="logout.php" class="logout">Logout</a>'?></li>
      </ul>
  </li>
	</ul>
</header>

<div class="container">     
  <br>    
  <?php if(isset($_SESSION['userid']) && $_SESSION['userid']) { ?>  
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
            echo '<img id="profile-img" src="userpics/'.$user['avatar'].'" class="online" alt="" />';
            echo  '<p>'.$user['username'].'</p>';
              echo '<div id="status-options">';
              echo '<ul>';
                echo '<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>';
                echo '<li id="status-away"><span class="status-circle"></span> <p>Away</p></li>';
                echo '<li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>';
                echo '<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>';
              echo '</ul>';
              echo '</div>';
          }
          echo '</div>';
          ?>
          </div>
          <div id="search">
            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
            <input type="text" placeholder="Search contacts..." />          
          </div>
          <div id="contacts"> 
          <?php
          echo '<ul>';
          $chatUsers = $chat->chatUsers($_SESSION['userid']);
          foreach ($chatUsers as $user) {
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
            echo '<img src="userpics/'.$user['avatar'].'" alt="" />';
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
          $userDetails = $chat->getUserDetails($currentSession);
          foreach ($userDetails as $user) {                   
            echo '<img src="userpics/'.$user['avatar'].'" alt="" />';
              echo '<p>'.$user['username'].'</p>';
              echo '<div class="social-media">';
                echo '<i class="fa fa-facebook" aria-hidden="true"></i>';
                echo '<i class="fa fa-twitter" aria-hidden="true"></i>';
                 echo '<i class="fa fa-instagram" aria-hidden="true"></i>';
              echo '</div>';
          } 
          ?>            
          </div>
          <div class="messages" id="conversation">    
          <?php
          echo $chat->getUserChat($_SESSION['userid'], $currentSession);            
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
  <?php } else { ?>
       
  <?php } ?> 
</div>        
      <!-- footer area -->

      <div class="footer">
    <div class="title">
      <p>IntellectLand</p>
    </div>
    <div>
    <ul class="nav" id="nav">
      <li id="footer-nav"><a href="#">Home</a></li>
      <li id="footer-nav"><a href="#">About</a></li>
      <li id="footer-nav"><a href="#">Contact</a></li>
    </ul>
    </div>
    <div class="search">
      <input type="text" id="search" placeholder="search anything.."><br>
      <button class="btn btn-secondary">Search</button>
    </div>
    <div class="message-area">
      <textarea id="message" placeholder="Enter your message here..."></textarea><br>
      <button class="btn btn-primary">Send</button><br>
      <span><label>or sign in with:</label></span>
      <i class="fa fa-facebook"></i>
      <i class="fa fa-twitter"></i>
      <i class="fa fa-youtube"></i>
    </div>
  </div>
  <footer>
    <span>&copy 2020 IntellectLand | <i>alright reserved</i></span>    
  </footer>
</body>
</html>