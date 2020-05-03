<?php
require '../config.php';
$month=$_GET['mm'];
$year=$_GET['yy'];
$flag=$_GET['flag'];

$query="";


$aaa= $year."-".$month."-__";
$aaaa= $year."-"."__"."-__";
$bbb = " ";
$ccc="__:__:__";

$ddd = $aaa.$bbb.$ccc;
$eee = $aaaa.$bbb.$ccc;

//where a.created_at like ' ".$aaa." ".$bbb."' ";
if($flag==0)
$query="select * from users u INNER JOIN users_data a on u.id=a.id 
where a.created_at like '$ddd' AND user_level = 0";

else if($flag==1)
	$query="select * from users u INNER JOIN users_data a on u.id=a.id 
where a.created_at like '$eee' AND user_level = 0";
  

$res=mysqli_query($link,$query);
echo "<tbody border=1>";

$sno    = 1;

if (mysqli_affected_rows($link) != 0) {

	echo "<thead>
				<tr>
					<th>Sl.No</th>
					<th>Fullnames</th>
					<th>Username</th>
					<th>Firstname</th>
					<th>Lastname</th>
					<th>Gender</th>
					<th>MaritalStatus</th>
					<th>Biography</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Location</th>
					<th>JoinedOn</th>
				</tr>
	</thead>";

    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
      

                echo "<tr><td>".$sno."</td>";
                
                echo "<td>" . $row['fullnames'] . "</td>";

                echo "<td width='25%'>" . $row['username'] . "</td>";

                echo "<td>" . $row['firstname'] . "</td>";


                echo "<td>" . $row['lastname'] . "</td>";

                echo "<td>" . $row['gender'] . "</td>";

                echo "<td>" . $row['maritalstatus'] . "</td>";

                echo "<td>" . $row['biography'] . "</td>";

                echo "<td>" . $row['email'] . "</td>";

                echo "<td>" . $row['phone'] . "</td>";

                echo "<td>" . $row['location'] . "</td>";

                echo "<td>" . $row['created_at'] ."</td></tr>";
                
                $sno++;
            
        
    }

}
else{
	if($flag==0){
		$monthName = date("F", mktime(0, 0, 0, $month, 10));
		echo "<h2>No Data found On ".$monthName." ".$year."</h2>";
	}
	else if($flag==1)
		echo "<h2>No Data found On ".$year."</h2";
}
echo "</tbody>";


?>
