<!DOCTYPE html>
<html lang="en">
<head>
	<title>IntellectLand</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--custom css-->
	<link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="img/logo.png">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- font-awesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--fadeshow-->
    <link rel="stylesheet" type="text/css" href="css/contact/main.css">
	<!--custom css-->	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
</head>
<body>
<header>
	<div class="logo">
		<a href="index.php" class="logo-link">
		<img src="img/logo.png">
		<h1 class="logo-text">IntellectLand</h1>
	</a>
	</div>
	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav">
		<li><a href="about-us.php">About Us</a></li>
		<li><a href="index.php">Home</a></li>

	</ul>
</header>

	<div class="container-contact100">
		<div class="wrap-contact100">
				<span class="contact100-form-title">
					Thank You For Your Message!
				</span>
Intellectland is ....... Thanks Barmar! That is exactly what I was looking for. – Mr. B Dec 7 '16 at 23:44
1
Why isn't this utterly trivial and obvious? – Barmar Dec 7 '16 at 23:45
I'm a weekender. I don't develop anything full-time. I mess around and I'm still learning every single time I touch a keyboard. Thanks again for your help! – Mr. B Dec 7 '16 at 23:48
		</div>
	</div>
	<script src="js/script.js"></script>

<!-- Modal HTML for SIGN IN -->
<div id="myModal-signIn" class="modal fade">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<form method="post">
				<div class="modal-header">
				<span><img src="img/logo.png"> 
					<label>IntellectLand - Log In</label>
				</span>	
				
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">				
					<div class="inner-addon-login left-addon">
    <a href="#"><i class="fa fa-envelope"></i></a>
    <input type="text" name="email" class="form-control-login" placeholder="Email address">
</div>
	<div class="inner-addon-login left-addon">
    <a href="#"><i class="fa fa-lock"></i></a>
    <input type="password" name="password" class="form-control-login" placeholder="Password">
</div>
<button id="login">Login</button>
					<div class="forgot">
						<label>or</label> <a href="home.html">Forgot password</a>
					</div>
					<div id="blankSpace"></div>
					<div class="no-account"><label>Don't have an account? <a href="myModal-signUp"  data-toggle="modal">Sign up</a></label></div>
				</div>
			</form>
		</div>
	</div>
</div> 
<!-- Modal HTML for SIGN UP -->
<div id="myModal-signUp" class="modal fade">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<form method="post">
				<div class="modal-header">
				<span><img src="img/logo.png"><label>IntellectLand - Join Us</span></label></span>

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
<div class="modal-body">
	<div class="inner-addon-login left-addon">
    <a href="#"><i class="fa fa-user"></i></a>
    <input type="text" class="form-control-login" placeholder="Full name">
</div>				
	<div class="inner-addon-login left-addon">
    <a href="#"><i class="fa fa-envelope"></i></a>
    <input type="text" class="form-control-login" placeholder="Email address">
</div>
	<div class="inner-addon-login left-addon">
    <a href="#"><i class="fa fa-lock"></i></a>
    <input type="password" class="form-control-login" id="pass" placeholder="Password">
</div>
<div class="inner-addon-login left-addon">
    <a href="#"><i class="fa fa-lock"></i></a>
    <input type="password" class="form-control-login" id="c-pass" placeholder="Confirm Password">
</div>
<div id="blankSpace"></div>

	<div class="check">
	<input type="checkbox"> I'm in for emails with exciting discounts and personalized recommendations
	</div>
	<button id="login">Sign Up</button>
	<div id="blankSpace"></div>
	<small>By signing up you agree to our <a href="">terms of use</a> and <a href="">Privacy Policy</a></small>
	<div id="blankSpace"></div>

	<hr>				
	<label id="center">Already have an accounts? <a href="#myModal-signIn" data-toggle="modal">Log In</a></label>
				

				</div>
			</form>
		</div>
	</div>
</div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>
	<div class="footer">
		<div class="title">
			<a href="index.php">
			IntellectLand
		</a>
		</div>
		<div>
		<ul class="nav" id="nav">
			<li id="footer-nav"><a href="#">About</a></li>
			<li id="footer-nav"><a href="#">Contact</a></li>
			<li id="footer-nav"><a href="#myModal-signUp" data-toggle="modal">Join</a></li>
			<li id="footer-nav"><a
			href="#myModal-signIn" data-toggle="modal">Login
		</a>
		</ul>
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
		<span>&copy 2020 IntellectLand | <i>Alrights reserved</i></span>
		
	</footer>
</body>
</html>
