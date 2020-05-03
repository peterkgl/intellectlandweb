<?php
//Initialize the session
session_start();

//Check if the user is logged in As admin, if yes continue otherwise redirect to index page
if(session_id() != "sessionuseradmin") {
    header("location: ../index.php");
  exit;
}
//Include config file
require_once "../config.php";
//retrive ADMIN ID
$admin_id = $_SESSION["id"];
//retrive ADMIN EMAIL
$admin_email = $_SESSION["email"];

    /*
    |--------------------------------------------------------------------------
    | Adding new Admin
    |--------------------------------------------------------------------------
    */
    // Define variables and initialize with empty values
    $password = $confirm_password = "";
    $password_err = $confirm_password_err = "";

    $fullnames = $username = $firstname = $lastname = $gender = $maritalstatus = $biography = $email = $phone = $location = $image = "";

    $fullnames_err = $username_err = $firstname_err = $lastname_err = $gender_err = $maritalstatus_err = $biography_err = $email_err = $phone_err = $location_err = $image_err = "";

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



           //GET DATA OF JUST INSERTED USER

          $sql = "SELECT id, fullnames, email, user_level, verified FROM USERS WHERE email = ?";
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
    

          // NOW, INSERT HIM INTO USERSDATA, TBL_IMAGES AND CHATUSERS

      //validate fullnames
      if(empty(trim($_POST["fullnames"]))){
        $fullnames_err = "Please enter fullnames.";
      } else{
        // Get username      
        $fullnames = trim($_POST["fullnames"]);
      }

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
      if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
      } else{
        // Get username      
        $email = trim($_POST["email"]);
      }

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
    if(empty($fullnames_err) && empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($gender_err) && empty($maritalstatus_err) && empty($biography_err) && empty($email_err) && empty($phone_err) && empty($location_err) && empty($image_err)){
        
     
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
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
              
              //mark the account verified
              $sql = "UPDATE users SET verified = 1, user_level = 1 WHERE id = ?";
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

                $data = "viewadminmembers.php";
echo ("<script>window.alert('Admin Added Successfully!'); window.location.href='$data';</script>");

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
            } else{
                echo "Something went wrong. Please try again later.";
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
	<title>Admin Panel</title>
	<link rel="shortcut icon" href="favicon.png?v=1.1" type="../image/png"> 
    <link rel="icon" type="image/ico" href="../img/logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
  <link rel="stylesheet" type="text/css" href="../css/theme.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
<header class="top">
    <div class="logo">
        <a href="#" class="logo-link">
        <img src="../img/logo.png">
        <h1 class="logo-text">IntellectLand - Admin Page</h1>
    </a>
    </div>

    <style type="text/css">
      span{
        color: red;
      }
    </style>
    <ul class="nav">
    <li><a href="../logout.php">Log Out </a><i class="entypo-logout right"></i></li>
  </ul>
</header>

<div class="sidebar">
  <ul class="left-nav">
  <li><a href="../adminpanel.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a></li><br><br>

  <li><a href="homeadmin.php"><i class="fa fa-fw fa-plane"></i>Posts</a></li>
  <li><a href="viewmembers.php"><i class="fa fa-fw fa-group"></i> All Members</a></li>
  <li><a href="viewadminmembers.php"><i class="fa fa-fw fa-group"></i> Admin Members</a></li>
  <li><a href="viewmembersbymonth.php"><i class="fa fa-fw fa-group"></i> New Members</a></li>
  <li><a href="contactusmessages.php"><i class="fa fa-fw fa-inbox"></i> Inbox
    <?php
      $query1 = "SELECT * FROM contact_us_messages WHERE replied = 1";  
      $result1 = mysqli_query($link, $query1);  
      $row = mysqli_num_rows($result1);
      if ($row > 0) { ?>
        <span id="notification"><?php echo $row; ?></span>
      <?php } ?>
      <span></span>
</a></li>
  <li><a href="chatmessages.php"><i class="fa fa-fw fa-comment"></i> Chat

      <?php
      $query16 = "SELECT * FROM CHAT WHERE reciever_userid = $admin_id AND status = 1";  
      $result16 = mysqli_query($link, $query16);  
      $rows = mysqli_num_rows($result16);
      if ($rows > 0) { ?>
        <span id="notification"><?php echo $rows; ?></span>
      <?php } ?>
      <span style="color: red;"></span>
    </a></li>
  </ul>
</div>


<div class="main">
	<div id="home">
  <h2>Add New Admin</h2>
  <p>

<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <fieldset class="fieldset">
        <h3 class="fieldset-title">Admin Info</h3>
           
  <div class="form-group">
                <label class="formlabel control-label">Full Names</label>
                <div class="formfield">
                    <input type="text" name="fullnames" class="form-control"><br>
                    <span> <?php echo $fullnames_err; ?> </span>
                </div>
  </div>
  <div class="form-group">
                <label class="formlabel control-label">Firstname</label>
                <div class="formfield">
                    <input type="text" name="firstname" class="form-control"><br>
                    <span> <?php echo $firstname_err; ?> </span>
                </div>
  </div>
  <div class="form-group">
                <label class="formlabel control-label">Lastname</label>
                <div class="formfield">
                    <input type="text" name="lastname" class="form-control"><br>
  <span> <?php echo $lastname_err; ?> </span>
                </div>
  </div>
  <div class="form-group">
                <label class="formlabel control-label">Username</label>
                <div class="formfield">
                    <input type="text" name="username" class="form-control"><br>
  <span> <?php echo $username_err; ?> </span>
                </div>
  </div>
<div class="form-group">
                <label class="formlabel control-label">Password</label>
                <div class="formfield">
                    <input type="password" name="password" class="form-control"><br>
  <span><?php echo $password_err; ?></span>
                </div>
  </div>
  <div class="form-group">
                <label class="formlabel control-label">Confirm Password</label>
                <div class="formfield">
                    <input type="password" name="confirm_password" class="form-control"><br>
  <span><?php echo $confirm_password_err; ?></span>
                </div>
  </div>
  <div class="form-group">
                <label class="formlabel control-label">Gender</label>
                <div class="formfield">
                    <input type="radio" name="gender" value="male" checked> Male
                    <input type="radio" name="gender" value="female"> Female<br>
  <span> <?php echo $gender_err; ?> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="formlabel control-label">Marital Status</label>
                <div class="formfield">
                  <select name="maritalstatus" class="form-control">
      <option value="single" selected="yes">Single</option>
      <option value="married">Married</option>
      </select><br>
  <span> <?php echo $maritalstatus_err; ?> </span>
                </div>
            </div>

                        <div class="form-group">
                <label class="formlabel control-label">Bio</label>
                <div class="formfield">
                    <textarea type="text" name="biography" class="form-control"></textarea>
                    <br>
  <span> <?php echo $biography_err; ?> </span>
                </div>
            </div>
        </fieldset>
        <fieldset class="fieldset">
            <h3 class="fieldset-title">Contact Info</h3>
            <div class="form-group">
                <label class="formlabel  control-label">Email</label>
                <div class="formfield">
                    <input type="text" name="email" class="form-control"><br>
  <span> <?php echo $email_err; ?> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="formlabel  control-label">Contact</label>
                <div class="formfield">
                    <input type="text" name="phone" class="form-control"><br>
  <span> <?php echo $phone_err; ?> </span>

                </div>
            </div>
            <div class="form-group">
                <label class="formlabel  control-label">Location</label>
                <div class="formfield">
                    <input type="text" name="location" class="form-control"><br>
  <span> <?php echo $location_err; ?> </span>            
                </div>
            </div>
            <fieldset class="fieldset">
            <h3 class="fieldset-title">Upload Profile Image</h3>
            <div class="form-group">
                <label class="formlabel control-label">Image</label>
                <div class="formfield">
                  <span style="color: red;">Image extension should be .png .jpg .jpeg size less than 1MB</span>  
                    <input type="file" class="file-input form-control image"  name="image" id="image"/><br>
  <span><?php echo $image_err; ?></span> 
                </div>
            </div>
   </fieldset>
        </fieldset>
        <center><input type="submit" name="submit" value="PROCEED" class="btn btn-primary"></center>
    </form>
  </p>
</div>
</div>
</body>
</html>