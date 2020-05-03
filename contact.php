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

/*
|--------------------------------------------------------------------------
| LEAVE A MESSAGE
|--------------------------------------------------------------------------
*/
// Define variable and initialize with empty values
$fullnames_err = "";
$email_err = "";
$phone_err = "";
$message_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitmessage'])){

	// Check if fullnames is empty
    if(empty(trim($_POST["fullnames"]))){
        $fullnames_err = "Please enter fullnames.";
    } else{
        $fullnames = trim($_POST["fullnames"]);
    }

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Check if phone is empty
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter phone.";
    } else{
        $phone = trim($_POST["phone"]);
    }

    // Check if message is empty
    if(empty(trim($_POST["message"]))){
        $message_err = "Please enter message.";
    } else{
        $message = trim($_POST["message"]);
    }
	
        if(empty($fullnames_err) && empty($email_err) && empty($phone_err) && empty($message_err)){
        	//Add new post

        	// Prepare an insert statement
        	$sql = "INSERT INTO contact_us_messages (fullnames, email, phone, message) VALUES (?, ?, ?, ?)";
        	if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_fullnames, $param_email, $param_phone, $param_message);
            
            // Set parameters
            $param_fullnames = $fullnames;
            $param_email = $email;
            $param_phone = $phone;
            $param_message = $message;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
            	// Redirect to news feed  page
                header("location: thankyou.php");
            }
            else{
                echo "Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        
        //close connection
        mysqli_close($link);
    }
}
}
$query1 = mysqli_query($link,"SELECT * FROM USERS WHERE id = $user_id");
while($result = mysqli_fetch_array($query1, MYSQLI_ASSOC))
{
    $query10 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $user_id");
    while($result10 = mysqli_fetch_array($query10, MYSQLI_ASSOC))
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
    <link rel="stylesheet" type="text/css" href="css/home.css">
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
            <li><a href="user-profile.php?userprofile=<?php echo $result['id']; ?>">My Profile</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </li>
    </ul>
</header>

	<div class="container-contact100">
		<div class="wrap-contact100">
				<span class="contact100-form-title">
					Leave Us A Message!
				</span>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100 <?php echo (!empty($fullnames_err)) ? 'has-error' : ''; ?>" >
					<span class="label-input100">Fullnames *</span>
					<input  type="text" style="width: 240px; height: 30px;margin-left: 10px;" name="fullnames" placeholder="Enter Your Fullnames ">
					<span class="help-block"> <?php echo $fullnames_err; ?> </span>
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>" >
					<span class="label-input100">Email *</span>
					<input  type="text" style="width: 250px; height: 30px;margin-left: 30px;" name="email" placeholder="Enter Your Email ">
					<span class="help-block"> <?php echo $email_err; ?> </span>
				</div>

				<div class="wrap-input100 bg1 rs1-wrap-input100 <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
					<span class="label-input100">Phone</span>
					<input  type="text" style="width: 250px; height: 30px;margin-left: 30px;" name="phone" placeholder="Enter Number Phone">
					<span class="help-block"> <?php echo $phone_err; ?> </span>
				</div>

				<div class="wrap-input100 validate-input bg0 <?php echo (!empty($message_err)) ? 'has-error' : ''; ?>">
					<span class="label-input100">Message</span>
					<textarea  style="width: 500px ;margin-left: 30px;" name="message" placeholder="Your message here..."></textarea>
					<span class="help-block"> <?php echo $message_err; ?> </span>
				</div>

				<div class="container-contact100-form-btn">
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						<input type="submit" name="submitmessage" value="Send Message">
				</div>
			</form>
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
	<!-- footer area -->
    <footer>
        <span>&copy; 2020 IntellectLand | <i>Alrights reserved</i></span>
        
    </footer>
</body>
</html>
<?php
} //result10
} //result
?>
