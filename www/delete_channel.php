<?php
include ('./includes/header.php');
if ( $user =='')
{
	header('Location: login.php');
}else
{
	$check_channel = mysqli_query($mysqli,"SELECT * FROM channels WHERE Created_by = '$user'");
$check_numrows = mysqli_num_rows($check_channel);
if ($check_numrows == 0) {
header('Location: create_channel.php');
}else{
	while ($row = mysqli_fetch_assoc($check_channel)) {
		# code...
		$Id = $row['Id'];
		$Channel_nameo = $row['Channel_name'];
		$Created_by = $row['Created_by'];
		$Date = $row['Date_created'];
		$Channel_pic = $row['Channel_pic'];
		if (isset($_POST['no'])) 
		{
			header("Location:  channel.php?c=".$Channel_nameo);
		}
		if (isset($_POST['yes'])) {
			# code...
			$subcribe_query = mysqli_query($mysqli,"DELETE FROM `subscribtions` WHERE subscribed_to='$Channel_nameo'")or die('Error, insert query failed');
			if ($Channel_pic == '') {
				# code...
			}else{
			unlink($Channel_pic);
		}
			$channel_query = mysqli_query($mysqli,"DELETE FROM `channels` WHERE Channel_name='$Channel_nameo'")or die('Error, insert query failed');
			$check_video = mysqli_query($mysqli,"SELECT * FROM videos WHERE Uploaded_by = '$user'");
			$check_numrows_v = mysqli_num_rows($check_video);
			if ($check_numrows == 0) {
			}else
			{
				while ($r = mysqli_fetch_assoc($check_video)) {
					$Uploaded_by = $r['Uploaded_by'];
					$File_location = $r['File_location'];
					$Video_id = $r['Video_id'];
					unlink($File_location);
					$video_query = mysqli_query($mysqli,"DELETE FROM `videos` WHERE Uploaded_by='$user'")or die('Error, insert query failed');
					$comment_query = mysqli_query($mysqli,"DELETE FROM `comments` WHERE Video_id='$Video_id'")or die('Error, insert query failed');
				}
			}
			header("Location:  settings.php");
		}
}
}
}
?>
<h1> Are you sure you want to delete channel ?</h1>
<p style="text-align: center; font-size: 20px;"> your uploaded videos will go forever<br />do you wish to continue</p>
<br />
<center>
<form action="delete_channel.php" method="POST">
<input type="submit" name="yes" value="yes">&nbsp&nbsp
	<input type="submit" name="no" value="no">
	</form>
	</center>
<?php
include ('./includes/footer.php');
?>