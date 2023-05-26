<?php require APPROOT . '/views/inc/header.php'; ?>
<h1><?php echo $data['title']; ?></h1>

<?php

$badge = $data['badge'];
$user = $data['user'];
$error = $data['error'];

if($error != ""){
	echo "Error: $error";
}

?>

<form>
<label for="badge">Enter a badge ID:</label>
<input type="text" id="badge" value= "<?php  echo $badge; ?>"name="badge">
<br>
<label for="user">Enter a student ID:</label>
<input type="text" id="user" value= "<?php  echo $user; ?>" name="user">
<br><br>
<input type="submit" value="Submit">
</form>

<?php require APPROOT . '/views/inc/footer.php'; ?>
