
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
| CHANGE PASSWORD
|--------------------------------------------------------------------------
*/
$password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changepassword'])){

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
    if(empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "UPDATE users SET password = ? WHERE id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_id = $user_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
              $data = "user-profile.php?userprofile=$user_id";
echo ("<script>window.alert('Password Updated Successfully!'); window.location.href='$data';</script>");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
         

}

$whopostedit = $user_id;
$query11 = mysqli_query($link,"SELECT * FROM users_data WHERE id = $whopostedit");
while ($result11 = mysqli_fetch_array($query11, MYSQLI_ASSOC))
{  
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complete Your Profile</title>
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
    <style>
      form{
        margin-top: 50px;
      }
      #pass,#c-pass{
        margin-top: 10px;
        padding: 10px;
        width: 260px;
      }
      .btn-success{
        margin-left: 145px;
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
            .btn-success{
                margin-left: 0px;
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
                                    <li><a href="#">Account Settings</a></li>
                                    <li><hr></li>
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
            <li class="btn btn-primary"><i class="fa fa-users"></i> <a style="color: white;" href="viewallmembers.php"> MEMBERS </a></li>
            <br>
        </ul>
    </div>
</div>
<div class="content-panel">

        <fieldset class="fieldset">
            <h3 class="fieldset-title">Personal Info</h3>
            <div class="form-group avatar">
                                
            </div>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Profile Image</label>
                <div class="col-md-10 col-sm-9 col-xs-12">

                  <a href="updateprofiledata.php?userprofile=<?php echo $result11['id']; ?>">Change Other Profile Data</a>
<?php
$thisid = $result11['id'];
$query = "SELECT * FROM tbl_images WHERE id = $thisid";  
$result0 = mysqli_query($link, $query);  
while($row = mysqli_fetch_array($result0))  
{  
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" height="300px" width="200" class="img-profile img-responsive center-block"/>  ';  
}  
?>
                                    
                </div>
            </div>

    <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  >

            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Password</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input type="password" class="form-control-login" id="pass" name="password" autocomplete="off" placeholder="New Password">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Confirm Password</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <input type="password" class="form-control-login" id="c-pass" name="confirm_password" autocomplete="off" placeholder="Confirm Password">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="hidden" name="user_id" value="<?php echo $result11['id']; ?>">
                    <input type="submit" name="changepassword" value="CHANGE PASSWORD" class="btn btn-success">           
                </div>
            </div>
    </form>
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
?>