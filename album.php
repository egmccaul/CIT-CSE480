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

	if(isset($_POST['album_select'])){
		//echo $_POST['album_select'];
		if($_POST['album_select'] <> ''){
			$_SESSION['camera_id'] = $_POST['album_select'];
			unset($_POST['album_select']);
			session_write_close();
			header('Location: photos.php');
		}
	}
?>


<div id="album_page">
	<?php
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
		$albumsPerPage = 12;
			
		// Check database for total number of photos
		$countStatement = $dbh->prepare("SELECT count(*) FROM CAMERA WHERE USER_ID=:user_id");

		$countStatement->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);

		// Executes query
		$countStatement->execute();

		// Set variable to the number of rows found.
		$totalAlbums = $countStatement->fetchColumn();
		
		// Find the number of pages of photos needed. Rounds up to nearest full page.
		$totalPages = ceil($totalAlbums / $albumsPerPage); 
		if($totalPages < 1){
			$totalPages = 1;
		}

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

	<div class="row" id="gallery" >

		<!-- Holds the button to sort the photos by either oldest or newest first. -->
		<div class="col-xs-12">
			<h1 class="page-header album_title">Camera Albums</h1>
			<form name="Sort" method="post">
				<button class="btn btn-trailmix" id="asc_sort" type="submit" name="sort_type" value="asc">Ascending <span class="glyphicon glyphicon-triangle-top"></span></button>
				<button class="btn btn-trailmix" id="desc_sort" type="submit" name="sort_type" value="desc">Descending <span class="glyphicon glyphicon-triangle-bottom"></span></button>
			</form>
		</div>

		<form method="post">
		<?php
		
		// Check database for current available classes based on student criteria
		$albumStatement = $dbh->prepare("SELECT * FROM camera WHERE USER_ID=:user_id ORDER BY CAMERA_ID " . $sort_type);

		$albumStatement->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);

		// Executes query
		$albumExecuted = $albumStatement->execute();

		// Gather all results and outputs in loop.
		$albums = $albumStatement->fetchAll();

		foreach ($albums as $row=>$albumRow){
			$camera_id = $albumRow['CAMERA_ID'];
			$camera_name = $albumRow['CAMERA_NAME'];
			$camera_desc = $albumRow['CAMERA_DESC'];
			
			// Check count of available images exist. If exist then use below query, otherwise set a placeholder image
			$albumImageCheck=$dbh->prepare("SELECT count(*) FROM photo WHERE CAMERA_ID=:cam_id");
			
			$albumImageCheck->bindParam(':cam_id', $camera_id, PDO::PARAM_STR);
			
			$albumCheckExecuted = $albumImageCheck->execute();
			
			$totalPhotosInAlbum = $albumImageCheck->fetchColumn();
			
			if ($totalPhotosInAlbum == 0){
				?>
				<!-- Outputs a tile for every photo result found in database, until given limit is reached. -->
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 thumb">
					<div id="photo_tile" class="col-xs-12 text-center">
						<p><?php echo "Camera ".$camera_id.": ".$camera_name;?></p>
						<p>Description: <?php echo $camera_desc;?></p>
						
						<img class="img-thumbnail" src='http://placehold.it/400x300' onclick='alert("Album currently empty!");'>
					</div>
				</div>
				<?php
			} else {
				
				// Get last photo from each camera
				$albumLatestStatement = $dbh->prepare("SELECT * FROM photo WHERE CAMERA_ID=:cam_id ORDER BY PHOTO_ID DESC LIMIT 1");

				$albumLatestStatement->bindParam(':cam_id', $camera_id, PDO::PARAM_STR);

				// Executes query
				$albumLatestExecuted = $albumLatestStatement->execute();

				// Gather all results and outputs in loop.
				$albumLatest = $albumLatestStatement->fetchAll();
				
				foreach ($albumLatest as $row=>$albumLatestRow){
					$photo_id = $albumLatestRow['PHOTO_ID'];
					$photo_name = $albumLatestRow['PHOTO_TITLE'];
					$photo_desc = $albumLatestRow['PHOTO_DESC'];
					$photo_path = $albumLatestRow['PHOTO_PATH'];
					
					if($photo_path <> "" && isset($photo_path))
						$fileName = $photo_path;
					else
						$fileName = "http://placehold.it/400x300";
				
				?>	<!-- Goes in main div below: data-toggle="modal" data-target="#myModal" -->
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 thumb">
						<div id="photo_tile" class="col-xs-12 text-center">
							<p><?php echo "Camera ".$camera_id.": ".$camera_name;?></p>
							<p>Description: <?php echo $camera_desc;?></p>
							
							<input class="img-thumbnail" type="image" name="album_select" src='<?php echo $fileName?>' value='<?php echo $camera_id;?>' />
							<!--<img class="img-thumbnail" src='<?php echo $fileName?>' onclick='location.href = "./album5.php"; '>-->
						</div>
					</div>
				<?php
				
				}
			}
		}
		
		?>
		</form>
	</div>
	
	<!-- Adds page navigation to the page. -->
	<div class="text-center" id="photo_output">
		<div class="row">
			<!-- Tells user what photos are being displayed, and total images in album. -->
			<p>Showing <?php 
				if ($totalAlbums > $albumsPerPage){
					echo ($startPhoto+1) . "-" . ($startPhoto+12) . " of " . $totalAlbums . "albums"; 
				} else {
					echo $totalAlbums . " of " . $totalAlbums . " albums";
				}?></p>
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