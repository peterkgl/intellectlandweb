<?php
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(session_id() == "sessionloggedinuser") {
    header("location: home.php");
  exit;
}
if(session_id() == "sessionuseradmin") {
    header("location: adminpanel.php");
  exit;
}

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fullnames = $email = $password = $confirm_password = "";
$fullnames_err = $email_err = $password_err = $confirm_password_err = "";

//login
$email_err1 = $password_err1 = "";

/*
|--------------------------------------------------------------------------
| REGISTRATION
|--------------------------------------------------------------------------
*/

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
 
    // Validate full names
    if(empty(trim($_POST["fullnames"]))){
        $fullnames_err = "Please enter fullnames.";
    } else{
        // Get full names      
        $fullnames = trim($_POST["fullnames"]);
        }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (fullnames, email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_fullnames, $param_email,$param_password);
            
            // Set parameters
            $param_fullnames = $fullnames;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                //destroy current session
                session_destroy();
                // so start a new session
                session_id("sessioncompleteprofileuser");
                session_start();
                $_SESSION["email"] = $email;  


                // Redirect to complete profile page
                header("location: complete-profile.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
   
}

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err1 = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err1 = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err1) && empty($password_err1)){
        // Prepare a select statement
        $sql = "SELECT id, email, password, user_level, verified FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $user_level, $user_ver);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            if ($user_level == 1) {
                                //destroy current session
                                session_destroy();
                                // so start a new complete profile session
                                session_id("sessionuseradmin");
                                session_start();
                                $_SESSION["email"] = $email;  
                                $_SESSION["id"] = $id;
                                // Redirect to complete profile page
                                header("location: adminpanel.php");    
                            }
                            else{
                                if ($user_ver == 0) {
                                //destroy current session
                                session_destroy();
                                // so start a new complete profile session
                                session_id("sessioncompleteprofileuser");
                                session_start();
                                $_SESSION["email"] = $email;  

                                // Redirect to complete profile page
                                header("location: complete-profile.php");               
                            } else {
                                // Password is correct, so start a new logged in session
                                //destroy current session
                                session_destroy();
                                // so start a new session
                                session_id("sessionloggedinuser");
                                session_start();
                                $_SESSION["id"] = $id;
                                $_SESSION["email"] = $email; 
                                                       
                                // Redirect user to welcome page
                                header("location: home.php");
                        }
                            }
                            
                            
                            
                        } else{
                            // Display an error message if password is not valid
                            $password_err1 = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $username_err1 = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
}

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
        <a href="index.php" class="logo-link">
        <img src="img/logo.png">
        <h1 class="logo-text">IntellectLand</h1>
    </a>
    </div>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
        <li><a href="about.php">About Us</a></li>
        <li><a href="index.php">Home</a></li>

    </ul>
</header>

	<div class="container-contact100">
		<div class="wrap-contact100">
				<span class="contact100-form-title">
					Contact Us
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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="modal-header">
            <span><img src="img/logo.png"> 
                    <label>IntellectLand - Log In</label>
            </span> 
                
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

    <div class="modal-body">    

    <div class="inner-addon-login left-addon <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
    <a href="#"><i class="fa fa-envelope"></i></a>
    <input type="text" name="email" value="<?php echo $email; ?>" class="form-control-login" placeholder="Email address">
    <span class="help-block"><?php echo $email_err1; ?></span>
</div>

    <div class="inner-addon-login left-addon <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    <a href="#"><i class="fa fa-lock"></i></a>
    <input type="password" name="password" class="form-control-login" placeholder="Password">
    <span class="help-block"><?php echo $password_err1; ?></span>
</div>

<br><input type="submit" name="login" id="login" value="Log in">

</form>
                    <div class="forgot">
                        <label>or &nbsp;</label><a href="">Forgot password</a>
                    </div>
                    <div id="blankSpace"></div>
                    <div class="no-account"><label>Don't have an account? <a href="#myModal-signUp"  data-toggle="modal" data-dismiss="modal">Join Us</a></label></div>
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


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

<div class="modal-body">
    <div class="inner-addon-login left-addon <?php echo (!empty($fullnames_err)) ? 'has-error' : ''; ?>">
    <a href="#"><i class="fa fa-user"></i></a>
    <input type="text" class="form-control-login" name="fullnames" autocomplete="off"
    value="<?php echo $fullnames; ?>" placeholder="Full names">
    <span class="help-block"><?php echo $fullnames_err; ?></span>
</div>              

    <div class="inner-addon-login left-addon <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
    <a href="#"><i class="fa fa-envelope"></i></a>
    <input type="text" class="form-control-login" name="email" autocomplete="off"
    value="<?php echo $email; ?>" placeholder="Email address">
    <span class="help-block"><?php echo $email_err; ?></span>
</div>

    <div class="inner-addon-login left-addon <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    <a href="#"><i class="fa fa-lock"></i></a>
    <input type="password" class="form-control-login" id="pass" name="password" autocomplete="off" value="<?php echo $password; ?>" placeholder="Password">
     <span class="help-block"><?php echo $password_err; ?></span>
</div>

<div class="inner-addon-login left-addon <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
    <a href="#"><i class="fa fa-lock"></i></a>
    <input type="password" class="form-control-login" id="c-pass" name="confirm_password" autocomplete="off" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
    <span class="help-block"><?php echo $confirm_password_err; ?></span>
</div>
<div id="blankSpace"></div>

<br><input type="submit" name="submit" id="submit" value="Join Us">
</form>

    <hr>                
    <label id="center">Already have an accounts? <a href="#myModal-signIn" data-toggle="modal" data-dismiss="modal">Log In</a></label>
                

                </div>
            
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
