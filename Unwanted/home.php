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
	<!--custom css-->	
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<link rel="stylesheet" type="text/css" href="css/theme.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="img/logo.png">
</head>
<body>
<header>
	<div class="logo">
		<?php echo'<a href="home.php" class="logo-link">
		<img src="img/logo.png">
		<h1 class="logo-text">IntellectLand</h1>
	</a>';?>
	</div>
	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav">
		<li><?php echo'<a href="home.php">Home</a>'?></li>
		<li><?php echo'<a href="message.php">Messaging<span class="badge top">10</span></a>'?></li>
		<li><a href="#">
                              <img src="img/passport.jpg" class="nav-avatar" />
                                <b class="caret"></b></a>
                                <ul>
                                    <li><?php echo'<a href="user-profile.php">Your Profile</a>'?></li>
                                    <li><?php echo'<a href="info.php">Edit Profile</a>'?></li>
                                    <li><?php echo'<a href="#">Account Settings</a>'?></li>
                                    <li><hr></li>
                                    <li><?php echo'<a href="login.php" class="logout">Logout</a>'?></li>
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
	<a target="_blank" href="img/passport.jpg">
	<img src="img/passport.jpg">
</a>
	<br>
	<?php echo'<a href="user-profile.php">
	<label>NDAHAYO JEAN PIERRE</label>
</a>'?>
<?php echo'<a href="user-profile.php">View Profile</a>'?>
</ul>
</div>
<!--/.sidebar-->
</div>

<div class="span9">
<div class="content">

<div class="module">
<div class="module-head">
<h3>News Feed</h3>
</div>
<div class="module-body">
<div class="stream-composer media">
<a href="#" class="media-avatar medium pull-left">
<img src="img/passport.jpg">
</a>
<div class="media-body">
<div class="row-fluid">
<textarea class="span12" style="height: 70px; resize: none;"></textarea>
</div>
<div class="clearfix">
<a href="#" class="btn btn-primary pull-right">
Post
</a>
<a href="#" class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="Upload a photo">
<i class="icon-camera shaded"></i>
</a>
<a href="#" class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="Upload a video">
<i class="icon-facetime-video shaded"></i>
</a>
</div>
</div>
</div>

<div class="stream-list">

<div class="media stream">
<?php echo'<a href="profile.php" class="media-avatar medium pull-left">
<img src="img/passport.jpg">
</a>'?>
<div class="media-body">
<div class="stream-headline">
	<?php echo'<a href="profile.php">
<h5 class="stream-author">
user1 
</h5>
</a>'?>
<small class="pull-right">07-3-2020</small>
<div class="stream-text slide pull-left">
Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add.  
</div>
</div><!--/.stream-headline-->
<div class="stream-options">
<a href="#" class="btn btn-small">
<i class="icon-thumbs-up shaded"></i>
Like
</a>
<a href="#" class="btn btn-small">
<i class="icon-reply shaded"></i>
Reply
</a>
<a href="#myModal" data-toggle="modal" class="btn btn-small">
<i class="icon-comment shaded"></i>
Comment
</a>
</div>
</div>
</div><!--/.media .stream-->
<div class="media stream">
<?php echo'<a href="profile.php" class="media-avatar medium pull-left">
<img src="img/passport.jpg">
</a>'?>
<div class="media-body">
<div class="stream-headline">
<?php echo'<a href="profile.php">
<h5 class="stream-author">
user2
</h5>
</a>'?>
<small class="pull-right">07-3-2020</small>
<div class="stream-text slide pull-left">
You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. 

</div>

</div><!--/.stream-headline-->

<div class="stream-options">
<a href="#" class="btn btn-small">
<i class="icon-thumbs-up shaded"></i>
Like
</a>
<a href="#" class="btn btn-small">
<i class="icon-reply shaded"></i>
Reply
</a>
<a href="#myModal" data-toggle="modal" class="btn btn-small">
<i class="icon-comment shaded"></i>
Comment
</a>
</div>
</div>
</div>
<div class="media stream">
<a href="#" class="media-avatar medium pull-left">
<img src="img/passport.jpg">
</a>
<div class="media-body">
<div class="stream-headline">
<?php echo'<a href="profile.php">
<h5 class="stream-author">
user3 
</h5>
</a>'?>
<small class="pull-right">07-3-2020</small>
<div class="stream-text slide pull-left">
You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. 
</div>
</div><!--/.stream-headline-->
<div class="stream-options">
<a href="#" class="btn btn-small">
<i class="icon-thumbs-up shaded"></i>
Like
</a>
<a href="#" class="btn btn-small">
<i class="icon-reply shaded"></i>
Reply
</a>
<a href="#myModal" data-toggle="modal" class="btn btn-small">
<i class="icon-comment shaded"></i>
Comment
</a>
</div>
</div>
</div>
</div>
</div><!--/.module-body-->
</div><!--/.module-->
</div><!--/.content-->
</div><!--/.span9-->
</div>
</div><!--/.container-->
</div><!--/.wrapper-->


<!-- modal comment -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
    <div class="modal-content">
      <!--Body-->
      <div class="modal-body">
        <div class="md-form">
          <textarea type="text" id="modal-comment" class="md-textarea form-control" placeholder="write your comment"></textarea>
        </div>

      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-primary waves-effect waves-light">Send
          <i class="fa fa-paper-plane ml-1"></i>
        </a>
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
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
			<li id="footer-nav"><a href="contact.html">Contact</a></li>
		</ul>
		</div>
		<div class="search">
			<input type="text" id="search" placeholder="search anything.."><br>
			<button class="btn btn-secondary">Search</button>
		</div>
		<div class="message-area">
			<textarea id="message" placeholder="Enter your message here..."></textarea><br>
			<button class="btn-send">Send</button><br>
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
</body>
</html>