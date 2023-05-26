<?php require APPROOT . '/views/inc/header.php'; ?>
<h1><?php echo $data['title']; ?></h1>

<?php echo $data['error']; ?>

<p>
<br>
<form action="<?php echo URLROOT; ?>/pages/loginProcess" method = "post">
<input type="text" name="username" placeholder="username"><br>
<input type="password" name="password" placeholder="password"><br>
<input type="submit" value="Submit">
</form>
</p>

<?php require APPROOT . '/views/inc/footer.php'; ?>
