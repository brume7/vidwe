<?php
include ('./includes/header.php');
?>
<link rel="stylesheet" type="text/css" href="/css/channel_style.css" />
<?php
$Channel = $_GET['c'];
$check_channel = mysqli_query($mysqli,"SELECT * FROM channels WHERE Channel_name='$Channel'");
$num_channel = mysqli_num_rows($check_channel);
if($num_channel == 1){
	while ($row = mysqli_fetch_assoc($check_channel)) {
		# code...
		$Id = $row['Id'];
		$Channel_name = $row['Channel_name'];
		$Created_by = $row['Created_by'];
		$Date = $row['Date_created'];
		$Channel_pic = $row['Channel_pic'];
		if (isset($_POST['submit'])) {
				# code..
		if ($user == '') {
			# code..
			header('Location: login.php');
		}else{
			if ($user == $Created_by) {
				# code...
			}else{
			$check_sub_user = mysqli_query($mysqli,"SELECT * FROM subscribtions WHERE subscribed_to='$Channel_name' AND User_who_subscribed = '$user'");
			$num_check_sub_user = mysqli_num_rows($check_sub_user);
		if ($num_check_sub_user != 0) {
				# code...
				$subcribe_query = mysqli_query($mysqli,"DELETE FROM `subscribtions` WHERE subscribed_to='$Channel_name' AND User_who_subscribed = '$user'")or die('Error, insert query failed');

			}else{	
		$subcribe_query = mysqli_query($mysqli,"INSERT INTO `subscribtions`( `User_who_subscribed`, `subscribed_to`) VALUES ('$user','$Channel_name')")or die('Error, insert query failed');
	}
			}
		}
		}
		$check_username = mysqli_query($mysqli,"SELECT * FROM users WHERE Username='$Created_by'");
       $num_username = mysqli_num_rows($check_username);
       if($num_username == 1)
       {
       	while ($row = mysqli_fetch_assoc($check_username)) {
		# code...
		$Id = $row['Id'];
		$Firstname = $row['Firstname'];
		$Lastname = $row['Lastname'];
		$Username = $row['Username'];
		$Email = $row['Email'];
		$Password = $row['Password'];
		$Date_of_birth = $row['Dob'];
		$Locked = $row['Locked'];
		if($Locked == 'yes'){
			echo "<h1>this has channel blocked</h1>";
		}else{
			
		?>
		<div class="channeloptions">
			<h1><?php echo $Channel_name; ?></h1>
			<center>
				<?php
				if ($Channel_pic == '') {
					# code...
					?>
					<img src="data/channels/images/icons/default.jpg"/><br /><br />
					<?php
				}else
				{
					?>
					<img src="<?php echo $Channel_pic ?>"/><br /><br />
					<?php
				}
				?>
			<form action="channel.php?c=<?php echo $Channel_name; ?>" method="POST" >
				<?php
				$check_sub_user = mysqli_query($mysqli,"SELECT * FROM subscribtions WHERE subscribed_to='$Channel_name' AND User_who_subscribed = '$user'");
			$num_check_sub_user = mysqli_num_rows($check_sub_user);
		if ($num_check_sub_user != 0) {
				# code...
			?>
			<input type="submit" name="submit" value="unsubscribe">
			<?php
			}else{	
				?>
		<input type="submit" name="submit" value="subscribe">
		<?php
	}
				?>
			</form>
			<div style="color: orange;">
			<?php
	$check_sub_sub = mysqli_query($mysqli,"SELECT * FROM subscribtions WHERE subscribed_to = '$Channel_name'");
	$num_check_sub_sub = mysqli_num_rows($check_sub_sub);
	if ($num_check_sub_sub <= 1 ) {
		# code...
		echo $num_check_sub_sub."<br />subscriber";
	}else
	{
		echo $num_check_sub_sub."<br /> subscribers";
	}
	?>
</div>
		</center> 
		</div>
		<div class="channelvideocontainer">
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />
			<img src="#" height="100" width="180" />

		</div>
		<?php
	}
}

       }else
       {
       	echo "unknown error";
       }
		
	}
?>
<?php
}
else
{
	header('Location: index.php');
}
?>
<?php
include ('./includes/footer.php');
?> 