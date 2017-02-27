<?php 

// Adds in navbar and opening html.
include('header.php');

session_start();
	
/* This is the php code that will allow you to push the data to the database. */

	// Check database for current values and sets sessions based on values
    $statement = $dbh->prepare("SELECT * FROM USER WHERE USER_EMAIL = :email");
    // PDO binds entry to protect against SQL Injection
    $statement->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);

    // Executes query
    $executed = $statement->execute();

    // Fetches information from table
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    // Resets session variables
    $_SESSION["user_id"] = $row['USER_ID'];
    $_SESSION["name"] = $row['USER_FNAME'];
    $_SESSION["lname"] = $row['USER_LNAME'];
    $_SESSION["email"] = $row['USER_EMAIL'];

	// Check database for current values and sets sessions based on values
    $statement = $dbh->prepare("SELECT * FROM CAMERA WHERE USER_ID = :id");
    // PDO binds entry to protect against SQL Injection
    $statement->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_STR);

    // Executes query
    $executed = $statement->execute();

    // Fetches information from table
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    // Resets session variables
    $_SESSION["camera_id"] = $row['CAMERA_ID'];
    $_SESSION["cam_name"] = $row['CAMERA_NAME'];
    $_SESSION["cam_desc"] = $row['CAMERA_DESC'];

// Sets up sorting variable to allow images to appear by oldest or newest first.
if(isset($_POST['sort_type']) && !empty($_POST['sort_type']) && $_POST['sort_type']=="asc")
{
     $sort_type = "ASC";
	 unset($_POST['sort_type']);

}elseif(isset($_POST['sort_type']) && !empty($_POST['sort_type']) && $_POST['sort_type']=="desc"){

    $sort_type = "DESC";
	unset($_POST['sort_type']);
	
} else {
	$sort_type = "DESC";
}

// Set number of photos to display per page.
$photosPerPage = 12;
	
// Check database for total number of photos
$countStatement = $dbh->prepare("SELECT count(*) FROM photo WHERE CAMERA_ID=:cam_id");

$countStatement->bindParam(':cam_id', $_SESSION["camera_id"], PDO::PARAM_STR);

// Executes query
$countStatement->execute();

// Set variable to the number of rows found.
$totalPhotos = $countStatement->fetchColumn();

// Find the number of pages of photos needed. Rounds up to nearest full page.
$totalPages = ceil($totalPhotos / $photosPerPage); 

//Pagination Code
	// Check that the page number is set.
	if(!isset($_GET['page'])){
		$_GET['page'] = 0;
	}else{
	// Convert the page number to an integer
		$_GET['page'] = (int)$_GET['page'];
	}

	// If the page number is less than 1, make it 1.
	if($_GET['page'] < 1){
		$_GET['page'] = 1;
	// Check that the page is below the last page
	}else if($_GET['page'] > $totalPages){
		$_GET['page'] = $totalPages;
	}
	
?>

<style>
#album_page{
	color: #eccf14;
    font-family: Lucida Sans Unicode;
    font-size: 15px;
    position: absolute;
    width: 100%;
    height: auto;
    background-image: url(img/trailmixbackround.jpg);
    background-size: cover;
    background-color: #fff;
    background-attachment: fixed;
}

/* Setup styling for the search results section at the bottom of the page, and pagination. */
#photo_output{
	background-color: rgba(22,25,26, 0.8);
	color: #eccf14;
	width: 100%;
	padding-bottom: 30px;
	position:fixed;
	bottom:0px;
}

/* Sets up default image tile sizes, and surrounding whitespace around tile. */
#album_page .img-thumbnail{
	height:300px;
	width:400px;
	padding: 10px;
	margin: 10px;
}

/* Sets stylizing on the ascend and descend filter buttons. */
#album_page button{
	margin: 10px;
	float: center;
}

/* Settings for the save image button. */
#save{
	margin-right: 15px;
	margin-top:23px;
	float: right;
}

/* Settings for the cancel buttons on the update image description. */
#cancel{
	margin-right: 20px;
	float: right;
	margin-top: 0px;
}

/* Sets up most of the button styling on the modal. */
.modal button{
	margin-right: 10px;
	margin-top:10px;
	float: right;
	margin-bottom:0px;
}

/* Settings for the edit button on the modal. */
#edit_button{
	margin-right:15px;
}

/* Settings for the save and reset button on the modal. */
#update_group{
	margin-right:7px;
}

/* Sets the amount of room at the bottom of the modal image for caption content. */
.carousel-inner { 
	padding-bottom:125px;
}

/* Sets styling for the caption under the image of the modal carousel. */
.carousel-caption{
	width:100%;
	height: 250px;
	background-color: rgba(22,25,26, 0.8);
	position: absolute;
	left:0;
	right:auto;
	bottom:-250px;
	padding-top:0px;
	padding-bottom: 10px;
}

/* Sets photo title in the modal caption to be left-aligned. */
#photo_title{
	text-align:left;
}

/* Sets the general size, and left/right buttons on the modal carousel. */
.carousel-control{
	heigth:80%;
	top:200px;
	bottom:auto;
	color: black;
}

/* Sets the modal image to be centered in the body section. */
.modal img{
	margin:auto;
}

/* Adds a right margin to make tiles appear to stay within border when resizing page. */
#gal{
	margin-right:10px;
}

/* Sets the Modal width. */
@media screen and (min-width: 768px) {
        .modal-dialog {
          width: 80%; /* New width for default modal */
        }
</style>

<div id="album_page">

	<div class="row" id="gal" >

		<!-- Holds the button to sort the photos by either oldest or newest first. -->
		<div class="col-xs-12">
			<h1 class="page-header album_title">Photos</h1>
			<form name="Sort" method="post">
				<button class="btn btn-trailmix" id="asc_sort" type="submit" name="sort_type" value="asc">Ascending <span class="glyphicon glyphicon-triangle-top"></span></button>
				<button class="btn btn-trailmix" id="desc_sort" type="submit" name="sort_type" value="desc">Descending <span class="glyphicon glyphicon-triangle-bottom"></span></button>
			</form>
		</div>

		<?php
		// Calculate the starting number
		$startPhoto = ($_GET['page'] - 1) * $photosPerPage;

		// Setup counter to link to correct photo in carousel.
		$photoSlideLink = 0;
		
		// Check database for current available classes based on student criteria
		$classStatement = $dbh->prepare("SELECT * FROM photo WHERE CAMERA_ID=:cam_id ORDER BY photo_id " . $sort_type . " LIMIT " . $startPhoto . "," . $photosPerPage);

		$classStatement->bindParam(':cam_id', $_SESSION["camera_id"], PDO::PARAM_STR);

		// Executes query
		$classExecuted = $classStatement->execute();

		// Gather all results and outputs in loop.
		$classes = $classStatement->fetchAll();

		foreach ($classes as $row=>$classRow){
			$photo_id = $classRow['PHOTO_ID'];
			$photo_name = $classRow['PHOTO_TITLE'];
			$photo_desc = $classRow['PHOTO_DESC'];
			$photo_path = $classRow['PHOTO_PATH'];
			?>
			
			<!-- Outputs a tile for every photo result found in database, until given limit is reached. -->
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 thumb" data-toggle="modal" data-target="#myModal">
				<!-- Sets the photo to move to correct image in carousel when clicked. -->
				<a href="#myGallery" data-slide-to="<?php echo $photoSlideLink;?>">
					<img class="img-thumbnail" src='<?php echo $photo_path?>'>
				</a>
			</div>
			<?php
			// Increments photo link count, which is uest to make sure that image moves to correct slide in carousel.
			$photoSlideLink++;
		}?>
		
	</div>
	
	<!-- Adds page navigation to the page. -->
	<div class="text-center" id="photo_output">
		<div class="row">
			<!-- Tells user what photos are being displayed, and total images in album. -->
			<p>Showing <?php echo ($startPhoto+1) . "-" . ($startPhoto+12); ?> of <?php echo $totalPhotos; ?></p>
		</div>
		<div class="row">
			<ul class="pagination">
				<!-- Generates the correct number of pagination links, which will show next grouping of photos. -->
				<?php
					foreach(range(1, $totalPages) as $page){
						// Check if we're on the current page in the loop
						if($page == $_GET['page']){
							echo '<li class="active"><a href="?page=' . $page . '">' . $page . '</a></li>';
						}else if($page == 1 || $page == $totalPages || ($page >= $_GET['page'] - 2 && $page <= $_GET['page'] + 2)){
							echo '<li><a href="?page=' . $page . '">' . $page . '</a></li>';
						}
					}
				?>
				
			</ul>
		</div>
	</div>
	
</div>

	
	<!-- Pop-up Modal to hold enlarged images in carousel.Fades the backgroup when open. -->
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
			
				<!-- Holds the header for the pop-up modal. -->
				<div class="modal-header">
					<!-- Need to pull album session variable out and enter into modal header. -->
					<div class="pull-left">TrailMix Photo Gallery</div>
					<button type="button" class="close" data-dismiss="modal" title="Close"> <span class="glyphicon glyphicon-remove"></span></button>
				</div>
				
				<!-- Holds main content of the modal. In this case, an image in a carousel. -->
				<div class="modal-body">

					<!-- Begins the carousel. -->
					<div id="myGallery" class="carousel slide" data-interval="false">
						<div class="carousel-inner">
						
							<?php // PHP starts to populate the carousel based on page, and album viewing.
							
							// Sets up variables for photo start and end, and loop counter.
							// Calculate the starting number
							$startPhoto = ($_GET['page'] - 1) * $photosPerPage;
							// Counts the current photo being output, which allows images to scroll to the correct image in carousel.
							$loop_count = 0;
							
							// Check database for first 12 photos. Need to update SQL to pull images based on user, and camera ID. Good for current testing.
							$classStatement = $dbh->prepare("SELECT * FROM photo WHERE CAMERA_ID=:cam_id ORDER BY photo_id " . $sort_type . " LIMIT " . $startPhoto . "," . $photosPerPage);

							$classStatement->bindParam(':cam_id', $_SESSION["camera_id"], PDO::PARAM_STR);

							// Executes query
							$classExecuted = $classStatement->execute();

							// Gather all results and outputs in loop.
							$classes = $classStatement->fetchAll();

							foreach ($classes as $row=>$classRow){
								$photo_id = $classRow['PHOTO_ID'];
								$photo_name = $classRow['PHOTO_TITLE'];
								$photo_desc = $classRow['PHOTO_DESC'];
								$photo_path = $classRow['PHOTO_PATH'];
															
								// Increments the loop count for the below if statement, to associate carousel slides.
								$loop_count++;
								
								// Checks whether it is the first item generated, which will set it to active on the carousel.
								if ($loop_count==1){
								?>
								<div class="item active"> <img src="<?php echo $photo_path?>" alt="">
									<div class="carousel-caption">
										<div id="photo_info">
											<div class="col-xs-8">
												<!-- Outputs the title of the photo. Currentlying using photo ID, might want to change to user defined name. -->
												<h3 id="photo_title">Image <?php echo $photo_id;?>: <?php echo $photo_name;?></h3>
											</div>
											<div class="col-xs-4">
												<!-- Holds a button to allow users to download image to device. -->
												<a id="save" href="<?php echo $photo_path?>" class="btn btn-trailmix" role="button" download>Save Image ...</a>
											</div>
											<div class="col-xs-8">
												<!-- Holds a description of the image. Currently hold place holder. Might want to change to user defined description. -->
												<p><?php echo $photo_desc;?></p>
											</div>
											<div class="col-xs-4">
												<!-- Holds a button that will allow users to change image title and description. -->
												<button class="btn btn-trailmix" id="edit_button" onclick='showContent("photo_update"); hideContent("photo_info");'>Edit <span class="glyphicon glyphicon-edit"></span></button>
											</div>
										</div>
										
										<!-- Holds the form to allow user to define image title and description. -->
										<div id="photo_update" style="display:none;">
											<form method="post">
												<div class="col-xs-9">
													<div class="row">
														<div class="col-xs-3">
															<p>Image Title:</p>
														</div>
														<div class="col-xs-9">
															<!-- Input for Image title. Currently uses photo ID as title. -->
															<input id="image_desc" type="text" name="image_title" class="form-control" value='<?php echo $photo_name;?>'>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3">
															<p>Image Description:</p>
														</div>
														<div class="col-xs-9">
															<!-- Input for Image description. Currently uses photo ID as description. -->
															<input id="image_desc" type="text" name="image_descript" class="form-control" value='<?php echo $photo_desc;?>'>
														</div>
													</div>
												</div>
												
												<!-- Holds reset and submit buttons for image description fields. -->
												<div class="col-xs-3">
													<div class="row" id="update_group">
														<div class="form-group">
															<button type="submit" class="btn btn-success">Submit</button>
															<button type="reset" class="btn btn-danger">Reset Form</button>
														</div>
													</div>
												</div>
											</form>
											
											<!-- Holds button to cancel changes, and revert back to the standard image description information. -->
											<div class="row" id="cancel" >
												<button class="btn btn-trailmix" onclick='showContent("photo_info"); hideContent("photo_update");'>Cancel</span></button>
											</div>
										</div>
									</div>
								</div>
								
								<?php
								// If not the first image output into carousel then loop until complete.
								}else{
								?>
								<!-- Set carousel item to the correct associated image. -->
								<div class="item"> <img src="<?php echo $photo_path?>" alt="">
									<div class="carousel-caption">
									
										<!-- Holds the general image information. -->
										<div id="photo_info<?php echo $photo_id;?>">
											<div class="col-xs-8">
												<!-- Holds the image title. Currently using photo ID as placeholder. -->
												<h3 id="photo_title">Image <?php echo $photo_id;?>: <?php echo $photo_name;?></h3>
											</div>
											<div class="col-xs-4">
												<!-- Holds button to download the image onto user's device. -->
												<a id="save" href="<?php echo $photo_path?>" class="btn btn-trailmix" role="button" download>Save Image ...</a>
											</div>
											<div class="col-xs-8">
												<!-- Holds the image description. Currently using photo ID as placeholder. -->
												<p><?php echo $photo_desc;?></p>
											</div>
											<div class="col-xs-4">
												<!-- Holds button to allow users to enter user defined title and description. -->
												<button class="btn btn-trailmix" id="edit_button" onclick='showContent("photo_update<?php echo $photo_id;?>"); hideContent("photo_info<?php echo $photo_id;?>");'>Edit <span class="glyphicon glyphicon-edit"></span></button>
											</div>
										</div>
										
										<!-- Holds form to allow user to define image title and description. -->
										<div id="photo_update<?php echo $photo_id;?>" style="display:none;">
											<form method="post">
												<div class="col-xs-9">
													<div class="row">
														<div class="col-xs-3">
															<p>Image Title:</p>
														</div>
														<div class="col-xs-9">
															<!-- Placeholder for actual image title. -->
															<input id="image_desc" type="text" name="image_title" class="form-control" value='<?php echo $photo_name;?>'>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3">
															<p>Image Description:</p>
														</div>
														<div class="col-xs-9">
															<!-- Placeholder for actual image description. -->
															<input id="image_desc" type="text" name="image_descript" class="form-control" value='<?php echo $photo_desc;?>;?>'>
														</div>
													</div>
												</div>
												
												<!-- Holds submit and reset button for the user defined title and description fields. -->
												<div class="col-xs-3">
													<div class="row" id="update_group">
														<div class="form-group">
															<button type="submit" class="btn btn-success">Submit</button>
															<button type="reset" class="btn btn-danger">Reset Form</button>
														</div>
													</div>
												</div>
											</form>
											
											<!-- Holds button to cancel changes and revert back to standard image description. -->
											<div class="row" id="cancel" >
												<button class="btn btn-trailmix" onclick='showContent("photo_info<?php echo $photo_id;?>"); hideContent("photo_update<?php echo $photo_id;?>");'>Cancel</span></button>
											</div>
										</div>
										
									</div>
								</div>
								<?php
								}
							}?>
						
						</div> <!-- Ends the image carousel contents. -->
						
						<!-- Begin Previous and Next buttons to cycle through images in carousel. -->
						<a class="left carousel-control" href="#myGallery" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>
						<a class="right carousel-control" href="#myGallery" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					</div><!-- Ends the carousel section. -->
				</div><!-- Ends the body section of the modal. -->
				
				<div class="modal-footer">
					<button class="btn-sm close" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div><!-- Ends Modal window -->
	
<script language="JavaScript">4
  // Function to show and hide content based on id specificed on function use.
  function showContent(id){
    document.getElementById(id).style.display = "block";
  }
  function hideContent(id){
    document.getElementById(id).style.display = "none";
  }
</script>
	
<!-- Closes off the page, and includes footer. -->
<?php include("footer.php"); ?>