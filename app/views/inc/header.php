
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo SITENAME; ?></title>


<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="<?php echo URLROOT; ?>/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>


</head>
<body> 

<p>
<div class="container">

<a href="<?php echo URLROOT; ?>pages/">Home</a>
<a href="<?php echo URLROOT; ?>pages/viewBadges">View Badges</a>
<a href="<?php echo URLROOT; ?>pages/addBadges">Add New Badge</a>
<br>

<!-- removre this for production -->

<a href="<?php echo URLROOT; ?>pages/login">Login</a>

<?php
if(isset($_SESSION['username'])){
	echo '<a href="'. URLROOT.'/pages/logout">Logout</a><br><br> ';

	echo "You are currently logged in as " . $_SESSION['username'];
} else {
	echo "<br><br>Please log in to use the full site!";
}
?>
