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
					Intellectland
				</span>
Intellectland is ....... Thanks Barmar! That is exactly what I was looking for. – Mr. B Dec 7 '16 at 23:44
1
Why isn't this utterly trivial and obvious? – Barmar Dec 7 '16 at 23:45
I'm a weekender. I don't develop anything full-time. I mess around and I'm still learning every single time I touch a keyboard. Thanks again for your help! – Mr. B Dec 7 '16 at 23:48
		</div>
	</div>
	<script src="js/script.js"></script>
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