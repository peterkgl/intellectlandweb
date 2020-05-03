
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
$image_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateprofileimage'])){

  $thisuser = $_POST['user_id'];

    // Validate file input to check if is not empty
    if (! file_exists($_FILES["image"]["tmp_name"])) {
        $image_err = "Choose image file to upload.";
    }    
    else {

    if(empty($image_err)){

    $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
    $query = "UPDATE tbl_images SET name='$file' WHERE id=$user_id";  
    if(mysqli_query($link, $query))  
    {    
      $data = "user-profile.php?userprofile=$thisuser";
echo ("<script>window.alert('Image Updated Successfully!'); window.location.href='$data';</script>");
    }
    else
    {
      $image_err = "Image insert failed!";
    }  
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
            #list{
                margin-left: 110px;
            }
            .label-info{
                margin-left: -10px;
            }
            #userimg{
                margin-left: 10px;
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
                <label class="label label-info">ADMIN</label>
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
echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" height="200px" width="150" class="img-profile img-responsive center-block"/>  ';  
}  
?>
                                    
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  >

            <div class="form-group">
                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Image</label>
                <div class="col-md-10 col-sm-9 col-xs-12 <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                  <span class="help-block" style="color: red;">Image extension should be .png .jpg .jpeg size less than 1MB</span> 
                    <input type="file" class="file-input form-control image"  name="image" id="image"/>
                    <span class="help-block"><?php echo $image_err; ?></span> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <input type="hidden" name="user_id" value="<?php echo $result11['id']; ?>">
                    <center><input type="submit" name="updateprofileimage" value="UPDATE" class="btn btn-primary"></center>            
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