<?php
include ('./includes/header.php');
$Channel_name = '';
if ( $user =='')
{
	header('Location: login.php');
}else{
	$check_channel = mysqli_query($mysqli,"SELECT Channel_name FROM channels WHERE Created_by = '$user'");
$check_numrows = mysqli_num_rows($check_channel);
if ($check_numrows == 0) {
if (isset($_POST['submit'])) {
	# code...
	$Channel_name = strip_tags($_POST['channel_name']);
	$Created_by = $user;
	$Date_created = date("y-m-d");
	if($Channel_name == trim($Channel_name) && strpos($Channel_name, ' ') !== false){

                echo "<center>Your username must not contain any whitespace</center>";
            }else{
	if ($Channel_name == '') {
		# code...
		echo "channel name cannot be left empty";
	}else{
	$check_cname = mysqli_query($mysqli,"SELECT Channel_name FROM channels WHERE Channel_name = '$Channel_name'");
	$check_numrows = mysqli_num_rows($check_cname);
	if ($check_numrows != 0) {
			# code...
		echo 'this channel name already exist';
		}else{
	$submit = mysqli_query($mysqli,"INSERT INTO `channels`( `Channel_name`, `Created_by`, `Date_created`, `Channel_pic`) VALUES ('$Channel_name', '$Created_by', '$Date_created','')")or die('Error, insert query failed');
	header('Location: settings.php');
}
}
}
}
?>
<h1>Create your channel</h1>
<form action="create_channel.php" method="POST">
	channel Name:&nbsp<input type="text" size="40" maxlength="32"  name="channel_name">&nbsp&nbsp&nbsp&nbsp&nbsp
	<input type="submit" name="submit" value="Create channel">
</form>
<?php
}else{
	header('Location: settings.php');
}
}
include ('./includes/footer.php');
?>