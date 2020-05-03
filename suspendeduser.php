<?php
// Initialize the session
session_start();

// Check if the user is logged in, if yes go to home.php otherwise redirect to index page
if(session_id() != "sessionusersuspended") {
    header("location: index.php");
  exit;
}

// Include config file
require_once "config.php";

//retrive logged in user
$user_id = $_SESSION["id"];

$whopostedit = $user_id;
$query11 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $whopostedit");
while ($result11 = mysqli_fetch_array($query11, MYSQLI_ASSOC))
{  

?>
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
	<style>
		.pt10{
            padding-right: 10px; 
        }
        .footer{
            height: 120px;
        }
        #contact-info{
            margin-top: 20px;
        }
        #contact-title{
        	color: #fff;
        	margin-top: 7px;
        }
        #contact{
        	color: #fff;
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
		<a href="index.php" class="logo-link">
		<img src="img/logo.png">
		<h1 class="logo-text">IntellectLand</h1>
	</a>
	</div>
	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav">
		<li><a href="index.php">Home</a></li>

	</ul>
</header>

	<div class="container-contact100">
		<div class="wrap-contact100">
				<span class="contact100-form-title">
					Sorry, <?php echo $result11['firstname']." ".$result11['lastname']; ?>!
				</span>
Your login has been suspended by Intellectland community administration due to violating
community guidelines. If you wish to reclaim your account, Please <a href="contact-us.php"><strong style="color: blue;"> Send Your Claim Here.</strong></a> <br><br>
Once your claim has been accepted, You will receive an email!

		</div>
	</div>
	<script src="js/script.js"></script>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>
	<!-- footer -->
    <div class="footer">
        <div class="title">
            <a href="index.php">
            IntellectLand
        </a>
        </div>
        <div>
        <ul class="nav" id="nav">
            <li id="footer-nav"><a href="about.php">About</a></li>
            <li id="footer-nav"><a href="contact-us.php">Contact</a></li>
            <li id="footer-nav"><a href="#myModal-signUp" data-toggle="modal">Join</a></li>
            <li id="footer-nav"><a
            href="#myModal-signIn" data-toggle="modal" data-dismiss="modal">Login
        </a>
        </ul>
        </div>
        <form id="contact-info">
            <p id="contact-title">Contact info</p>
            <p id="contact"><i class="fa fa-envelope pt10"></i><span>www.intellectland.info</span></p>
            <p id="contact"><i class="fa fa-phone pt10"></i><span>+123456789</span></p>
    </form>
        <div class="message-area pull-right">
           
            <span><label>or sign in with:</label></span>
            <i class="fa fa-facebook"></i>
            <i class="fa fa-twitter"></i>
            <i class="fa fa-youtube"></i>
        </div>
    </div>
    <footer>
        <span>&copy 2020 IntellectLand | <i>Alright reserved</i></span>
        
    </footer>
</body>
</html>
<?php
}
?>