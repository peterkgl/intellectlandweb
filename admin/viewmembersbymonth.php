<?php
//Initialize the session
session_start();

//Check if the user is logged in As admin, if yes continue otherwise redirect to index page
if(session_id() != "sessionuseradmin") {
    header("location: index.php");
  exit;
}
//Include config file
require_once "../config.php";
//retrive ADMIN ID
$admin_id = $_SESSION["id"];
//retrive ADMIN EMAIL
$admin_email = $_SESSION["email"];

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
      table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#selectnew{
  text-align: center;
  margin-top: 15%;
}
#syear,#smonth{
  width: 30%;
  height: 30px;
  font-size: 18px;
  border-radius: 4px;
  text-align: center;
  margin-top: 30px;
}
.a1-btn{
  width: 60%;
  margin-top: 10px;
  border-radius: 4px;
  padding: 5px;
  font-size: 18px;
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
        <a href="#" class="logo-link">
        <img src="../img/logo.png">
        <h1 class="logo-text">IntellectLand - Admin Page</h1>
    </a>
    </div>
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
  <li class="active"><a href="viewmembersbymonth.php"><i class="fa fa-fw fa-group"></i> New Members</a></li>
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
    <div id="selectnew">
  <h2>Members By Month</h2>
  <form>
  <?php
  // set start and end year range
  $yearArray = range(2000, date('Y'));
  ?>
  <!-- displaying the dropdown list -->
  <select name="year" id="syear">
      <option id="oyear" value="0">Select Year</option>
      <?php
      foreach ($yearArray as $year) {
          // if you want to select a particular year
          $selected = ($year == date('Y')) ? 'selected' : '';
          echo '<option id="myear" '.$selected.' value="'.$year.'">'.$year.'</option>';
      }
      ?>
  </select>
  <?php
  // set the month array
  $formattedMonthArray = array(
                      "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                      "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                      "09" => "September", "10" => "October", "11" => "November", "12" => "December",
                  );

  ?>
  <!-- displaying the dropdown list -->
  <select name="month" id="smonth">
      <option value="0">Select Month</option>
      <?php

      foreach ($formattedMonthArray as $month) {
          // if you want to select a particular month
          $mm=implode(array_keys($formattedMonthArray,$month));
          $selected = ($mm == date('m')) ? 'selected' : '';
          // if you want to add extra 0 before the month uncomment the line below
          //$month = str_pad($month, 2, "0", STR_PAD_LEFT);
          echo '<option '.$selected.' value="'.$mm.'">'.$month.'</option>';
      }
      ?>
  </select><br>

  <input type="button" class="a1-btn a1-blue btn btn-secondary" name="search" onclick="showMember();" value="Search">

</form>
</div>
<div class="table-responsive">
<table class="table table-collapse" id="memmonth">
  
</table>
</div>

<script>

  function showMember(){
    var year=document.getElementById("syear");
    var month=document.getElementById("smonth");
    var iyear=year.selectedIndex;
    var imonth=month.selectedIndex;
    var mnumber=month.options[imonth].value;
    var ynumber=year.options[iyear].value;
    if(mnumber=="0" || ynumber=="0"){
      document.getElementById("memmonth").innerHTML="";
      return;
    }
    else{
      if(window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
      }
      xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status ==200){
          document.getElementById("memmonth").innerHTML=this.responseText;
        }
      };
      xmlhttp.open("GET","over_month.php?mm="+mnumber+"&yy="+ynumber+"&flag=0",true);
      xmlhttp.send();
    }

  }

</script>
</div>
</div>
</body>
</html>