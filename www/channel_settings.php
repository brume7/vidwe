<?php
include ('./includes/header.php');
if ( $user =='')
{
	header('Location: login.php');
}else{
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
		if (isset($_POST['delete_channel'])) 
		{
			header('Location: delete_channel.php');
		}
		if (isset($_POST['delete'])) 
		{
			if ($Channel_pic == 'data/channels/images/icons/default.jpg' || $Channel_pic == '') 
			{
				echo "No image to delete";
			}else
			{
				unlink($Channel_pic);
				$assoc_del_pic = mysqli_query($mysqli,"UPDATE `channels` SET `Channel_pic`= '' where Created_by = '$user' ");
				header("Location: channel.php?c=".$Channel_nameo);
			}
		}
		if (isset($_POST['upload_image_sub'])) {
			# code...
			if (isset($_FILES['channel_pic'])) {
			# code...
				if (($_FILES['channel_pic']['type']=='image/jpeg') || ($_FILES['channel_pic']['type']=='image/png') || $_FILES['channel_pic']['type']=='image/gif') {
				$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
				$random_directory = substr(str_shuffle($chars), 0, 15);
				if (file_exists('data/channels/images/icons/' . $random_directory . ''.$_FILES['channel_pic']['name'])) {
					# code...
					echo "image exists";
				}else
				{
					if ($Channel_pic == '') {
						# code...
						move_uploaded_file($_FILES['channel_pic']['tmp_name'],'data/channels/images/icons/' . $random_directory . ''.$_FILES['channel_pic']['name']);
					$img_name = $_FILES['channel_pic']['name'];
					$channel_pic = $random_directory.$img_name;
					$assoc_channel_pic = mysqli_query($mysqli,"UPDATE `channels` SET `Channel_pic`= 'data/channels/images/icons/$channel_pic' where Created_by = '$user' ");
					header("Location: channel.php?c=".$Channel_nameo);
					}else
					{
						unlink($Channel_pic);
						move_uploaded_file($_FILES['channel_pic']['tmp_name'],'data/channels/images/icons/' . $random_directory . ''.$_FILES['channel_pic']['name']);
					$img_name = $_FILES['channel_pic']['name'];
					$channel_pic = $random_directory.$img_name;
					$assoc_channel_pic = mysqli_query($mysqli,"UPDATE `channels` SET `Channel_pic`= 'data/channels/images/icons/$channel_pic' where Created_by = '$user' ");
					header("Location: channel.php?c=".$Channel_nameo);
					}

				}
		}else
		{
			echo "invalid file";
		}
		}
	}
		
		if (isset($_POST['change_cname'])) {
			# code...
			$Channel_name = strip_tags($_POST['Channel_name']);
			if($Channel_name == trim($Channel_name) && strpos($Channel_name, ' ') !== false){

                echo "<center>Your username must not contain any whitespace</center>";
            }else
            {
                $change = mysqli_query($mysqli,"UPDATE `channels` SET `Channel_name`= '$Channel_name' where Created_by = '$user' ");
            }
		}
	}
?>
<h1>Upload your channel image</h1>
<form action="channel_settings.php" method="POST" enctype="multipart/form-data">
	Upload your image:&nbsp&nbsp<input type="file" name="channel_pic" accept="image/*" multiple="false">
	<input type="submit" name="upload_image_sub" value="upload image">&nbsp&nbsp
	<input type="submit" name="delete" value="delete image">
	<br />
	<br />
	<br />
	Edit channel name:&nbsp&nbsp<input type="text" size="40" maxlength="32"  name="Channel_name" value="<?php echo $Channel_nameo; ?>">&nbsp <input type="submit" name="change_cname" value="Change name">
	<br />
	<br />
	<br />
	<input type="submit" name="delete_channel" value="delete channel">
</form>
<?php
}
}
include ('./includes/footer.php');
?>