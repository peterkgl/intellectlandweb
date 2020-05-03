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
                session_id("sessionpaymentuser");
                session_start();
                $_SESSION["email"] = $email;  


                // Redirect to complete profile page
                header("location: userpayment.php");
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
        $sql = "SELECT id, email, password, user_level, verified, suspended FROM users WHERE email = ?";
        
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
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $user_level, $user_ver, $suspended);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            if ($suspended == 1) {
                                //destroy current session
                                session_destroy();
                                // so start a new complete profile session
                                session_id("sessionusersuspended");
                                session_start();
                                $_SESSION["email"] = $email;  
                                $_SESSION["id"] = $id;
                                // Redirect to complete profile page
                                header("location: suspendeduser.php");    
                                
                            } else {
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


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IntellectLand</title>
    <!-- jQuery===modal-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- font-awesome-->
    
    <!--fadeshow-->
    <link rel="stylesheet" href="css/jquery.fadeshow-0.1.1.min.css" />
    <!--custom css-->   
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="img/logo.png">
    <style>
        body{
            overflow-x: hidden;
        }
        header{
            width: 103%;
        }
        .nav{
            margin-right: 50px;
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
        #login,#submit {
  background-color: #ec5252;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 400px;
}

#login:hover {
  opacity: 0.8;
}
#submit:hover{
  opacity: 0.8;
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
            .row{
                display: block;
            }
            .card{
                text-align: center;
            }
            .card span img{
                margin-left: 0px;
            }
        }
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
        <li><a href="contact-us.php">Contact Us</a></li>
        <li><a href="#myModal-signUp" data-toggle="modal">Join Us</a></li>
        <li><a href="#myModal-signIn" data-toggle="modal">Login</a></li>

    </ul>
</header>

    <div class="background"></div>
    
    <div class="text slide">
        <h1 id="h1">Our Africa</h1>
        <h2 id="h2">Our continent Africa, we love you!</h2>
        
    </div>
    
    <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="js/jquery.fadeshow-0.1.2.min.js" type="text/javascript"></script>
    <!-- Custom Script-->
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
<div class="card" style="text-align: center;">
    <h1>Why IntellectLand</h1>
</div>
    <div class="row">
<div class="card">
    <span><img src="img/afri.jfif"></span>
</div>
<div class="card">
    <p class="slide">
                      Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar.                       
        </p>
        
</div>
</div>
<!-- Container (Portfolio Section) -->
<div id="portfolio" class="container-fluid text-center bg-grey">
  
  <h2>Recent Post</h2>
  <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>


<!-- Wrapper for slides -->
<div class="carousel-inner" role="listbox">
<?php
// Include config file
require_once "config.php";
$query14 = mysqli_query($link,"SELECT * FROM posts ORDER BY likes DESC LIMIT 1");
while ($result14 = mysqli_fetch_array($query14, MYSQLI_ASSOC))
{
    $whopostedit = $result14['user_id'];
    $query15 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $whopostedit");
    while ($result15 = mysqli_fetch_array($query15, MYSQLI_ASSOC))
    {
?>        
<div class="item active">
<h4>
<?php
$thisid = $result15['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'"/>  ';  
}  
?>
<br>
<?php echo $result14['post_data']; 
}
}
?>
</h4>
</div>


<?php
// Include config file
require_once "config.php";
$loops =0;
$query14 = mysqli_query($link,"SELECT * FROM posts ORDER BY likes DESC LIMIT 2");
while ($result14 = mysqli_fetch_array($query14, MYSQLI_ASSOC))
{
    if ($loops == 0) {
        $loops++;
        continue;
    } else {
        # code...
    
    
    $whopostedit = $result14['user_id'];
    $query15 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $whopostedit");
    while ($result15 = mysqli_fetch_array($query15, MYSQLI_ASSOC))
    {
?>        
<div class="item">
<h4>
<?php
$thisid = $result15['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'"/>  ';  
}  
?>
<br>
<?php echo $result14['post_data']; 
}
}
}
?>
</h4>
</div>

<?php
// Include config file
require_once "config.php";
$lo = 0;
$query14 = mysqli_query($link,"SELECT * FROM posts ORDER BY likes DESC LIMIT 3");
while ($result14 = mysqli_fetch_array($query14, MYSQLI_ASSOC))
{
    if ($lo <= 1) {
        $lo++;
        continue;
    } else {
        
    $whopostedit = $result14['user_id'];
    $query15 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $whopostedit");
    while ($result15 = mysqli_fetch_array($query15, MYSQLI_ASSOC))
    {
?>        
<div class="item">
<h4>
<?php
$thisid = $result15['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'"/>  ';  
}  
?>
<br>
<?php echo $result14['post_data']; 
}
}
}
?>
</h4>
</div>


    </div>
    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="fa fa-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="fa fa-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
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
            <p>Contact info</p>
            <p><i class="fa fa-envelope pt10"></i><span>www.intellectland.info</span></p>
            <p><i class="fa fa-phone pt10"></i><span>+123456789</span></p>
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
