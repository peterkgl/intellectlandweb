<?php
// Initialize the session
session_start();

// Check if the user is logged in, if yes go to home.php
if(session_id() == "sessionloggedinuser") {
    header("location: home.php");
  exit;
}

// Check if the user has complete profile priv otherwise go to index.php
if(session_id() != "sessionpaymentuser") {
    header("location: index.php");
  exit;
}

$email = $_SESSION["email"];  
/*
|--------------------------------------------------------------------------
| PAYMENTs
|--------------------------------------------------------------------------
*/

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postpayment'])){
    
                //destroy current session
                session_destroy();
                // so start a new session
                session_id("sessioncompleteprofileuser");
                session_start();
                $_SESSION["email"] = $email;  


                // Redirect to complete profile page
                header("location: complete-profile.php");
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>IntellectLand</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- font-awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--custom css-->
    <link rel="shortcut icon" href="favicon.png?v=1.1" type="image/png"> 
    <link rel="icon" type="image/ico" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    
</head>
<body>
    <header>
  <div class="logo">
    <a href="#" class="logo-link">
    <img src="img/logo.png">
    <h1 class="logo-text">IntellectLand</h1>
  </a>
  </div>                
</header>
    <div class="container">
        <div class="title">
                <h2>IntellectLand Payment Form</h4>
        </div>
        <div class="row">
            <div class="column info">
                <div class="select">
                <select id="select">
                    <option value="1">Monthly</option>
                    <option value="2">Yearly</option>
                </select>
                <div class="brief">
                    <h3>Intellectland joining contribution</h3>
                    <h4>You can choose by paying monthly or annually</h4>

                </div>
            </div>
                <div class="1 price">
                    <h3 id="four"><strong><i>$4</i></strong></h3>
                </div>
                <div class="2 price">
                    <h3 id="six"><strong><i>$16</i></strong></h3>
                </div>
            </div>
            <div class="column payment">
                <div class="method">
                <div class="credit-card">
                    <label id="credit"><input type="radio" name="payment" value="credit" checked>Credit Card</label>
                </div>
                <div class="paypal">
                    <label id="pay"><input type="radio" name="payment" value="paypal">Pay<span id="pal">Pal</span></label>
                </div>
            </div>
            <div class="credit form">
                <div class="card-number">
                <input type="text" name="number" id="cardnumber" placeholder="card number">
                <span id="fa-icon"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-paypal"></i></span>
            </div>
            <div class="security-code">
                <input type="text" name="" placeholder="mm/yy" id="issueDate">
                <input type="text" name="" placeholder="Security Code(CVC)" id="code">
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    
            <button type="submit" name="postpayment" value="postpayment" id="btnProceed">PROCEED</button>
</form>
            </div>
        <div class="paypal form" style="display: none;">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    
            <button type="submit" name="postpayment" value="postpayment" id="btnProceed">PayPal chechout</button>
</form>
        </div>
        </div>
        </div>
        <script src="js/payment.js"></script>
    </div>
</body>
</html>