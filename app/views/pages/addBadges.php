<?php require APPROOT . '/views/inc/header.php'; ?>
<h1><?php echo $data['title']; ?></h1>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<h1>Badges</h1>

<p>Add new badges using this form</p>

<form action="<?php echo URLROOT; ?>/pages/addBadgesProcess" method="post">

    <p><input type="text" name="badge_name" placeholder="Name"></p>

	    <p><textarea name="badge_description" placeholder="Description"></textarea></p>

		    <p><textarea name="badge_requirements" placeholder="Requirements"></textarea></p>

			    <p><select name="badge_category" id="badge_category">

				        <option value="">Category</option>
			<?php echo $data['categories'];?>
						    </select></p>
							
							<p>Hidden:
							<input type="radio" id="hidden1" name="hidden" checked value="0">
							  <label for="hidden1">False</label>
							    <input type="radio" id="age2" name="hidden" value="1">
								  <label for="hidden2">True</label><br>  
									</p>

							    <p><input type="text" name="img" placeholder="Image Link"></p>

								    <p><input type="submit"></p>

									</form>

<?php require APPROOT . '/views/inc/footer.php'; ?>
