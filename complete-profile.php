<?php
// Initialize the session
session_start();

// Check if the user is logged in, if yes go to home.php
if(session_id() == "sessionloggedinuser") {
    header("location: home.php");
  exit;
}

// Check if the user has complete profile priv otherwise go to index.php
if(session_id() != "sessioncompleteprofileuser") {
    header("location: index.php");
  exit;
}

// Include config file
require_once "config.php";
//retrive logged in user
$user_email = $_SESSION["email"];
          //echo $user_email;
          $sql = "SELECT id, fullnames, email, user_level, verified FROM USERS WHERE email = ?";
          if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $user_email;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
              // Store result
                mysqli_stmt_store_result($stmt);
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                  mysqli_stmt_bind_result($stmt, $user_id, $fullnames, $user_email, $user_level, $verified);
                  if(mysqli_stmt_fetch($stmt)){}
                }
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
              }
            }
          else{
                echo "Something went wrong. Inserting.";
          }
          // Close statement
          mysqli_stmt_close($stmt);
    

    /*
    |--------------------------------------------------------------------------
    | Completing user profile
    |--------------------------------------------------------------------------
    */
    $fullnames1 = $username = $firstname = $lastname = $gender = $maritalstatus = $biography = $email1 = $phone = $location = $image = "";

    $fullnames1_err = $username_err = $firstname_err = $lastname_err = $gender_err = $maritalstatus_err = $biography_err = $email1_err = $phone_err = $location_err = $image_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

      //validate fullnames
        $fullnames1 = $fullnames;

      //validate username
      if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
      } else{
        // Get username      
        $username = trim($_POST["username"]);
      }

      //validate firstname
      if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter firstname.";
      } else{
        // Get firstname      
        $firstname = trim($_POST["firstname"]);
      }

      //validate lastname
      if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter lastname.";
      } else{
        // Get lastname      
        $lastname = trim($_POST["lastname"]);
      }

      //validate gender
      if(empty(trim($_POST["gender"]))){
        $gender_err = "Please enter gender.";
      } else{
        // Get gender      
        $gender = trim($_POST["gender"]);
      }

      //validate maritalstatus
      if(empty(trim($_POST["maritalstatus"]))){
        $maritalstatus_err = "Please enter maritalstatus.";
      } else{
        // Get maritalstatus      
        $maritalstatus = trim($_POST["maritalstatus"]);
      }

      //validate biography
      if(empty(trim($_POST["biography"]))){
        $biography_err = "Please enter biography.";
      } else{
        // Get biography      
        $biography = trim($_POST["biography"]);
      }

      //validate email      
        $email1 = $user_email;

      //validate phone
      if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter phone.";
      } else{
        // Get phone      
        $phone = trim($_POST["phone"]);
      }

      //validate location
      if(empty(trim($_POST["location"]))){
        $location_err = "Please enter location.";
      } else{
        // Get location      
        $location = trim($_POST["location"]);
      }      
    
    // Validate file input to check if is not empty
    if (! file_exists($_FILES["image"]["tmp_name"])) {
        $image_err = "Choose image file to upload.";
    }    
    else {
      
    


    // Check input errors before inserting in database
    if(empty($fullnames1_err) && empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($gender_err) && empty($maritalstatus_err) && empty($biography_err) && empty($email1_err) && empty($phone_err) && empty($location_err) && empty($image_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users_data (id, fullnames, username, firstname, lastname, gender, maritalstatus, biography, email, phone, location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            
            mysqli_stmt_bind_param($stmt, "sssssssssss",
             $param_id, 
             $param_fullnames,
             $param_username, 
             $param_firstname,
             $param_lastname, 
             $param_gender,
             $param_maritalstatus, 
             $param_biography,
             $param_email, 
             $param_phone,
             $param_location
             
           );
            
            // Set parameters
            $param_id = $user_id;
            $param_fullnames = $fullnames1;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_gender = $gender;
            $param_maritalstatus = $maritalstatus;
            $param_biography = $biography;
            $param_email = $email1;
            $param_phone = $phone;
            $param_location = $location;
            
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
              

              //mark the account verified
              $sql = "UPDATE users SET verified = 1 WHERE id = ?";
              if($stmt = mysqli_prepare($link, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "s", $param_id);
              // Set parameters
              $param_id = $user_id;
              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt)){

                $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
                $query = "INSERT INTO tbl_images(id, name) VALUES ('$user_id','$file')";  
                if(mysqli_query($link, $query))  
                {    
                  //nothing
                }
                else
                {
                  echo "Image insert failed!";
                }  

                $query2 = "INSERT INTO chat_users(userid, username) VALUES ('$user_id','$username')";  
                if(mysqli_query($link, $query2))  
                {    
                  //nothing
                }
                else
                {
                  echo "Chat users insert failed!";
                }  


                //destroy current session
                session_destroy();
                // so start a new session
                session_id("sessionloggedinuser");
                session_start();
                $_SESSION["id"] = $user_id;  
                $_SESSION["email"] = $email1;


                // Redirect to HomePage home.php
                header("location: home.php");

              }
              else{
                echo "Something went wrong. Verifying.";
              }
              
            } else{
                echo "Something went wrong. Inserting.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        // Close connection
        mysqli_close($link);
    }
    
    }

    }
}


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
    <li><a href="#">
                              <img src="userpics/user7.png" class="nav-avatar" />
</a>
</header>
<div class="container">
    <div class="view-account">
        <section class="module">
            <div class="module-inner">
                <div class="side-bar">
                    <div class="user-info">
                        <img class="img-profile img-circle img-responsive center-block" src="userpics/user7.png" alt="">
                        <ul class="meta list list-unstyled">
                            <li class="name" style="text-transform: uppercase;">
                              <?php echo $fullnames; ?>
                                <label class="label label-info">Member</label>
                            </li>
                            <!-- <li class="activity">Joined since: 18-02-2020</li>
                            <li class="btn btn-primary"><i class="fa fa-users"></i> MEMBERS</li> -->
                        </ul>
                    </div>
                </div>
<div class="content-panel">
  <h3>One Last step, Complete your profile!</h3>

<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset class="fieldset">
            <h3 class="fieldset-title">Personal Info</h3>
            <div class="form-group avatar">
                                
            </div>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Full Names</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="text" disabled class="form-control" value="<?php echo($fullnames); ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">User Name</label>
      <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <input type="text" autocomplete="off" name="username" class="form-control" placeholder="Your Username">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
            </div>
        
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">First Name</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                    <input type="text" autocomplete="off" placeholder="Your Firstname" name="firstname" class="form-control">
                    <span class="help-block"><?php echo $firstname_err; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Last Name</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                    <input type="text" autocomplete="off" placeholder="Your Lastname" name="lastname" class="form-control">
                    <span class="help-block"><?php echo $lastname_err; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Gender</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="radio" checked name="gender" value="male" > Male
                    <input type="radio" name="gender" value="female"> Female
                </div>
            </div>
                            
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Marital Status</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                  <select name="maritalstatus" class="form-control">
                    <option value="single" selected="yes">Single</option>
                    <option value="married">Married</option>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Bio</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($biography_err)) ? 'has-error' : ''; ?>">
                    <textarea name="biography" placeholder="Short Biography" class="form-control"></textarea>
                    <span class="help-block"><?php echo $biography_err; ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class="fieldset">
            <h3 class="fieldset-title">Contact Info</h3>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Email</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="email" class="form-control" value="<?php echo $user_email; ?>" disabled placeholder="Your email address">

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Contact</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                    <input type="text" autocomplete="off" name="phone" class="form-control" placeholder="Your phone number">
                    <span class="help-block"><?php echo $phone_err; ?></span>

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Location</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($location_err)) ? 'has-error' : ''; ?>">
                    <input type="text" name="location" class="form-control" placeholder="Your living place">
                        <span class="help-block"><?php echo $location_err; ?></span>            
                </div>
            </div>
            <fieldset class="fieldset">
            <h3 class="fieldset-title">Upload Profile Image</h3>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Image</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                  <span class="help-block" style="color: red;">Image extension should be .png .jpg .jpeg size less than 1MB</span>  
                    <input type="file" class="file-input form-control image"  name="image" id="image"/>
                    <span class="help-block"><?php echo $image_err; ?></span> 
                </div>
            </div>
            </fieldset>
        </fieldset>
        <center><input type="submit" name="submit" value="PROCEED"></center>
    </form>
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
            <li id="footer-nav"><a href="#">Home |</a></li>
            <li id="footer-nav"><a href="#">About |</a></li>
            <li id="footer-nav"><a href="#">Contact</a></li>
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
// }
?>