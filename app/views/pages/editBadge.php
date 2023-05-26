<?php require APPROOT . '/views/inc/header.php'; ?>
<h1><?php echo $data['title']; ?></h1>


<?php

$badge = $data['editInfo'];


?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



<form action="<?php echo URLROOT; ?>/pages/editBadgeProcess/<?php echo $badge->badge_id ?>" method="post">

    <p><input type="text" name="badge_name" placeholder="Name" value = "<?php echo $badge->name ?>"></p>

	    <p><textarea name="badge_description" placeholder="Description"><?php echo $badge->description  ?></textarea></p>

		    <p><textarea name="badge_requirements" placeholder="Requirements"><?php echo $badge->requirements ?></textarea></p>

			    <p><select name="badge_category" id="badge_category">

				        <option value="">Category</option>
			<?php echo $data['categories'];?>
						    </select></p>

							<p>Hidden:
							<input type="radio" id="hidden1" name="hidden" <?php if($badge->hidden == 0) {echo "checked";} ?> value="0">
							  <label for="hidden1">False</label>
							    <input type="radio" id="age2" name="hidden" <?php if($badge->hidden == 1) {echo "checked";} ?> value="1">
								  <label for="hidden2">True</label><br>  
									</p>

							    <p><input type="text" name="img" placeholder="Image Link" value= "<?php echo $badge->img ?>" ></p>

								    <p><input type="submit"></p>

									</form>

<?php require APPROOT . '/views/inc/footer.php'; ?>
