
<?php require APPROOT . '/views/inc/header.php'; ?>
<br>
<br>

<h1><?php echo $data['title']; ?></h1>

<?php

$cats = $data['categories'];

$badges = $data['badges'];

$limit = $data['limit'];
$offset = $data['offset'];
$category = $data['category'];
$order = $data['order'];

$last = $data['lastOffset'];

?>

<p>
			Category: -
<a href= "<?php echo URLROOT . "pages/viewBadges/$limit/$offset/$order"; ?>" >All Badges</a>
	        <?php 
			$id = 1;
			foreach ($cats as $cat): ?>
<a href= "<?php echo URLROOT . "pages/viewBadges/$limit/$offset/$id/$order"; ?>" ><?php echo $cat->cat_name; $id += 1; ?></a> - 
			<?php endforeach; ?>
</p>
			<p>Order By: -
<a href= "<?php echo URLROOT . "pages/viewBadges/$limit/$offset/$category/0"; ?>" >Date Created</a> - 
<a href= "<?php echo URLROOT . "pages/viewBadges/$limit/$offset/$category/1"; ?>" >Alphabetical</a> - 
<a href= "<?php echo URLROOT . "pages/viewBadges/$limit/$offset/$category/2"; ?>" >Number Earned</a> - 
			</p>
			<br>
<p>

<!-- Display the badges using Bootstrap accordion -->
    <div class="accordion" id="badgesAccordion">
	        <?php foreach ($badges as $badge): ?>
			            <div class="card">
						                <div class="card-header" id="heading-<?php echo $badge->badge_id; ?>">
										                    <h2 class="mb-0">
															                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $badge->badge_id; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $badge->badge_id; ?>">
																					                            <?php echo $badge->name; ?>
																												                        </button>
																																		                    </h2>
																																							                </div>

																																											                <div id="collapse-<?php echo $badge->badge_id; ?>" class="collapse" aria-labelledby="heading-<?php echo $badge->badge_id; ?>" data-parent="#badgesAccordion">
																																															                    <div class="card-body">
																																																				                        <img src="<?php echo $badge->img; ?>" alt="Badge Image" class="mr-3" style="max-width: 200px;">
																																																										                        <p class="card-text"><?php echo $badge->description; ?> </p>

<?php

?>

<p>Earned by: <?php echo $badge->requirements?></p>
<p><?php echo $cats[$badge->badge_category_id - 1]->cat_name ?></p>

																																																																						                    </div>
																																																																											                </div>
																																																																															            </div>
																																																																																		        <?php endforeach; ?>
																																																																																				    </div>
<p>
<br>
<a href="<?php echo URLROOT . "pages/viewBadges/$limit/0"; ?>">First</a>
<a href="<?php echo URLROOT . "pages/viewBadges/$limit/".($offset - 10); ?>">Previous</a>
<a href="<?php echo URLROOT . "pages/viewBadges/$limit/".($offset + 10); ?>">Next</a>
<a href="<?php echo URLROOT . "pages/viewBadges/$limit/$last"; ?>">Last</a>
</p>																																																																																					

<br>
<!-- Include the Bootstrap JavaScript library -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</p>
</p>
<?php require APPROOT . '/views/inc/footer.php'; ?>
