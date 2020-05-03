<?php
// Initialize the session
session_start();

// Check if the user is logged in, if yes go to home.php otherwise redirect to index page
if(session_id() != "sessionuseradmin") {
    header("location: index.php");
  exit;
}

// Include config file
require_once "config.php";

//retrive logged in user
$user_id = $_SESSION["id"];

/*
|--------------------------------------------------------------------------
| UPDATE PROFILE
|--------------------------------------------------------------------------
*/
$fullnames_err = $username_err = $firstname_err= $lastname_err= $maritalstatus_err= $biography_err= $email_err= $phone_err= $location_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateprofiledata'])){

  $thisuser = $_POST['user_id'];


  // Check if fullnames is empty
    if(empty(trim($_POST["fullnames"]))){
        $fullnames_err = "Please  Enter fullnames.";
    } else{

      $fullnames = $_POST['fullnames'];
    }

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please  Enter username.";
    } else{

      $username = $_POST['username'];
    }

    // Check if firstname is empty
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please  Enter firstname.";
    } else{

      $firstname = $_POST['firstname'];
    }

    // Check if lastname is empty
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please Enter  lastname.";
    } else{

      $lastname = $_POST['lastname'];
    }

    $gender = $_POST['gender'];  

    // Check if maritalstatus is empty
    if(empty(trim($_POST["maritalstatus"]))){
        $maritalstatus_err = "Please  Enter maritalstatus.";
    } else{

      $maritalstatus = $_POST['maritalstatus'];
    }

    // Check if biography is empty
    if(empty(trim($_POST["biography"]))){
        $biography_err = "Please  Enter biography.";
    } else{

      $biography = $_POST['biography'];
    }

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please  Enter email.";
    } else{

      $email = $_POST['email'];
    }

    // Check if phone is empty
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please Enter  phone.";
    } else{

      $phone = $_POST['phone'];
    }

    // Check if location is empty
    if(empty(trim($_POST["location"]))){
        $location_err = "Please Enter location.";
    } else{

      $location = $_POST['location'];
    }

    if(empty($fullnames_err) || empty($username_err) || empty($firstname_err) || empty($lastname_err) || empty($maritalstatus_err) || empty($biography_err) || empty($email_err) || empty($phone_err) || empty($location_err)) {
      

    // Prepare an insert statement
    $sql = "UPDATE users_data SET fullnames=?, username=?, firstname=?, lastname=?, gender=?, maritalstatus=?, biography=?, email=?, phone=?, location=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            
            mysqli_stmt_bind_param($stmt, "sssssssssss",
              
             $param_fullnames,
             $param_username, 
             $param_firstname,
             $param_lastname, 
             $param_gender,
             $param_maritalstatus, 
             $param_biography,
             $param_email, 
             $param_phone,
             $param_location,
             $param_id
             
           );
            
            // Set parameters
            $param_fullnames = $fullnames;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_gender = $gender;
            $param_maritalstatus = $maritalstatus;
            $param_biography = $biography;
            $param_email = $email;
            $param_phone = $phone;
            $param_location = $location;
            $param_id = $thisuser;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

    // Prepare an insert statement
    $sql = "UPDATE users SET fullnames=?, email=? WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            
          mysqli_stmt_bind_param($stmt, "sss",
            $param_fullnames,
            $param_email, 
            $param_id
           );

          // Set parameters
          $param_fullnames = $fullnames;
          $param_email = $email;
          $param_id = $thisuser;

          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){

            // Password is correct, so start a new logged in session
            //destroy current session
            session_destroy();
            // so start a new session
            session_id("sessionuseradmin");
            session_start();
            $_SESSION["id"] = $thisuser;
            $_SESSION["email"] = $email; 
                                                       
            $data = "user-profile.php?userprofile=$thisuser";
echo ("<script>window.alert('Profile Updated Successfully!'); window.location.href='$data';</script>");
            

              }
            }
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    else
    {
      echo "Something went wrong.";
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
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/info.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="../js/script.js"></script>
    <link type="text/css" href="../images/icons/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/home.css">
  <link rel="stylesheet" type="text/css" href="../css/theme.css">
  <link rel="stylesheet" type="text/css" href="../css/responsive.css">
  <link rel="shortcut icon" href="../favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="../img/logo.png">
    <style>
      #updatebtn{
        margin-left: 145px;
        margin-top: 10px;
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
        }
    </style>
</head>
<body>
  <header>
  <div class="logo">
    <a href="home.php" class="logo-link">
    <img src="../img/logo.png">
    <h1 class="logo-text">IntellectLand</h1>
  </a>
  </div>
  <i class="fa fa-bars menu-toggle"></i>
  <ul class="nav">
     <li><a href="../adminpanel.php">AdminPage </a></li>
      <li><a href="changepassword.php">Change Password </a></li>
    <li><a href="../logout.php">Log Out </a><i class="entypo-logout right"></i></li>
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
            
            <br>
        </ul>
    </div>
</div>../
<div class="content-panel">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" method="post">
        <fieldset class="fieldset">
            <h3 class="fieldset-title">Personal Info</h3>
            <div class="form-group avatar">
                                
            </div>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Profile Image</label>
                <div class="col-md-10 col-sm-9 col-xs-12">

                  <center><a href="updateprofileimage.php?userprofile=<?php echo $result11['id']; ?>">Change Profile Image</a></center>
                  
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
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Full Names</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="text" name="fullnames" value="<?php echo $result11['fullnames']; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">User Name</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="text" name="username" value="<?php echo $result11['username']; ?>" class="form-control">
                </div>
            </div>
        
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">First Name</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="text" value="<?php echo $result11['firstname']; ?>" name="firstname" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Last Name</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="text" value="<?php echo $result11['lastname']; ?>" name="lastname" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Gender</label>
                <div class="col-md-10 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
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
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <textarea class="form-control" name="biography" style="height: 100px;"><?php echo $result11['biography']; ?></textarea> 
                </div>
            </div>
        </fieldset>
        <fieldset class="fieldset">
            <h3 class="fieldset-title">Contact Info</h3>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Email</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="email" name="email" class="form-control" value="<?php echo $result11['email']; ?>" placeholder="Your email address">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Contact</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="text" name="phone" class="form-control" value="<?php echo $result11['phone']; ?>" placeholder="Your phone number">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Location</label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="text" name="location" class="form-control" value="<?php echo $result11['location']; ?>" placeholder="Your living place">
                                    
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="hidden" name="user_id" value="<?php echo $result11['id']; ?>">
                    <input type="submit" name="updateprofiledata" value="UPDATE" class="btn btn-primary" id="updatebtn">          
                </div>
            </div>
        </fieldset>
    </form>
</div>
</div>
</section>
</div>
</div>
<!-- footer area -->
    <footer>
        <span>&copy; 2020 IntellectLand | <i>Alrights reserved</i></span>
        
    </footer>
</body>
</html>
<?php
}
?>