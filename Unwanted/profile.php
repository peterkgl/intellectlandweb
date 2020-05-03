<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IntellectLand</title>
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
</head>
<body>
  <header>
  <div class="logo">
    <?php echo'<a href="home.php" class="logo-link">
    <img src="img/logo.png">
    <h1 class="logo-text">IntellectLand</h1>
  </a>'?>
  </div>
  <i class="fa fa-bars menu-toggle"></i>
  <ul class="nav">
    <li><?php echo'<a href="home.php">Home</a>'?></li>
    <li><?php echo'<a href="message.php">Messaging<span class="badge top">10</span></a>'?></li>
    <li><a href="#">
                              <img src="img/passport.jpg" class="nav-avatar" />
                                <b class="caret"></b></a>
                                <ul>
                                    <li><?php echo'<a href="user-profile.php">Your Profile</a>'?></li>
                                    <li><?php echo'<a href="info.php">Edit Profile</a>'?></li>
                                    <li><?php echo'<a href="#">Account Settings</a>'?></li>
                                    <li><hr></li>
                                    <li><?php echo'<a href="login.php" class="logout">Logout</a>'?></li>
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
                        <img class="img-profile img-circle img-responsive center-block" src="img/passport.jpg" alt="">
                        <ul class="meta list list-unstyled">
                            <li class="name">ndahayo jean pierre
                                <label class="label label-info">love for life</label>
                            </li>
                            <li class="activity">Joined since: 18-02-2020</li>
                        </ul>
                    </div>
                </div>
                <div class="content-panel">
                  
                    <form class="form-horizontal" method="POST">
                      <fieldset class="fieldset"><a href=""><input type="button" name="button" class="btn btn-primary pull-right" value="ChatMe"></a></fieldset>
                    
                        <fieldset class="fieldset">
                            <h3 class="fieldset-title">Personal Info</h3>
                            <div class="form-group avatar">
                                
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12 control-label">User Name</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
        
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12 control-label">First Name</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Last Name</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Gender</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="radio" name="gender" checked> Male
                                    <input type="radio" name="gender"> Female
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Martal Status</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                  <select name="status" class="form-control">
                                    <option value="1">Single</option>
                                    <option value="2">Married</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12 control-label">Bio</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <h3 class="fieldset-title">Contact Info</h3>
                            <div class="form-group">
                                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Email</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="email" class="form-control" placeholder="Your email address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Contact</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Your phone number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Location</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Your living place">
                                    
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="footer">
    <div class="title">
      <p>IntellectLand</p>
    </div>
    <div>
    <ul class="nav" id="nav">
      <li id="footer-nav"><a href="#">Home</a></li>
      <li id="footer-nav"><a href="#">About</a></li>
      <li id="footer-nav"><a href="contact.html">Contact</a></li>
    </ul>
    </div>
    <div class="search">
      <input type="text" id="search" placeholder="search anything.."><br>
      <button class="btn btn-secondary">Search</button>
    </div>
    <div class="message-area">
      <textarea id="message" placeholder="Enter your message here..."></textarea><br>
      <button class="btn-send">Send</button><br>
      <span><label>or sign in with:</label></span>
      <i class="fa fa-facebook"></i>
      <i class="fa fa-twitter"></i>
      <i class="fa fa-youtube"></i>
    </div>
  </div>
  <footer>
  <span>&copy 2020 IntellectLand | <i>alright reserved</i></span>
  </footer>
</body>
</html>