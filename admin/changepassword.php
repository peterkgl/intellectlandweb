
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
//retrive ADMIN ID
$admin_id = $_SESSION["id"];
//retrive ADMIN EMAIL
$admin_email = $_SESSION["email"];

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
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <style>
      form{
        margin-top: 50px;
      }
      #pass,#c-pass{
        margin-top: 10px;
        padding: 10px;
        width: 260px;
        border-radius: 3px;
      }
      .btn-success{
        margin-left: 177px;
      }
      #notification{
        background-color: tomato;
        color: #fff;
        border-radius: 5px;
        padding: 2px;
  </style>
</head>
<body>
<header class="top">
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

<div class="sidebar">
  <ul class="left-nav">
  <li><a href="../adminpanel.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a></li><br><br>

  <li><a href="homeadmin.php"><i class="fa fa-fw fa-plane"></i>Posts</a></li>
  <li><a href="viewmembers.php"><i class="fa fa-fw fa-group"></i> All Members</a></li>
  <li class="active"><a href="viewadminmembers.php"><i class="fa fa-fw fa-group"></i> Admin Members</a></li>
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
  
        <fieldset class="fieldset">
            <h3 class="fieldset-title">Personal Info</h3>
            <div class="form-group avatar">
                                
            </div>
            <div class="form-group">
                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Profile Image</label>
                <div class="col-md-10 col-sm-9 col-xs-12">

                  <a href="updateprofiledata.php?userprofile=<?php echo $user_id; ?>">Change Other Profile Data</a>
<?php
$thisid = $user_id;
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
        </fieldset></p>
</div>
</div>
</body>
</html>