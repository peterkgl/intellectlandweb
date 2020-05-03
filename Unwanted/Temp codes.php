<!-- <?php
				$thisuser_id = htmlspecialchars($_SESSION["id"]); //who is logged in
				$thispost_id = $result2['id']; //this post

				$query4 = mysqli_query($link, "SELECT COUNT(user_id) AS numlikes FROM likes WHERE post_id = $thispost_id");
				$result4= mysqli_fetch_array($query4,MYSQLI_ASSOC);
				$query5 = mysqli_query($link, "SELECT * FROM likes WHERE post_id = $thispost_id ORDER BY created_at DESC LIMIT 1");
				$result5= mysqli_fetch_array($query5,MYSQLI_ASSOC);
				$latestlikeeid = $result5['user_id'];
				$query6 = mysqli_query($link, "SELECT * FROM users WHERE id = $latestlikeeid ");
				$result6= mysqli_fetch_array($query6,MYSQLI_ASSOC);

				?>
				Liked by <?php echo $result6['fullnames']; ?> and <?php echo $result4['numlikes']-1; ?> others -->