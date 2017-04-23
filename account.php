<?php
	/* Add in the link to the header */
	include('header.php');
	
	session_start();
	/* This holds the information regarding the update information for the selected camera. */
	/* outputs new camera name and description of the camera selected */
	if ((isset($_POST['edit_camera_name'])) && ($_POST['edit_camera_name'] <> "") && (isset($_POST['edit_camera_desc'])) && ($_POST['edit_camera_desc'] <> "")){
		$_SESSION['new_cam_id'] = $_SESSION['current_cam'];
		$_SESSION['new_cam_name'] = $_POST['edit_camera_name'];
		$_SESSION['new_cam_desc'] = $_POST['edit_camera_desc'];
		
		/*echo $_SESSION['new_cam_id'];
		echo $_SESSION['new_cam_name'];
		echo $_SESSION['new_cam_desc'];*/
		
		
		/* SQL to check whether camera name already in use by the user. */
		$updateCam_Check = $dbh->prepare("SELECT * FROM camera WHERE CAMERA_NAME=:cam_name AND USER_ID=:id");

		/* Bind variable strings to prevent SQL injection. */
		$updateCam_Check->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$updateCam_Check->bindParam(':cam_name', $_SESSION['new_cam_name'], PDO::PARAM_STR);
		
		// Executes query to find camera with same name.
		$executed = $updateCam_Check->execute();
		
		// Count number of rows to see if any are found.
		$number_rows = $updateCam_Check->fetchColumn();

		// If a user is found to match the criteria give error, otherwise update camera information.
		if ($number_rows != false) {
			?> <script>window.alert('Camera name already in use.');</script><?php
		} else {
			/* if it is not associated with the user, then insert new association into camera table. */
			$updateCam_Insert = $dbh->prepare("UPDATE camera SET CAMERA_NAME=:cam_name, CAMERA_DESC=:cam_desc WHERE CAMERA_ID =:cam_id");
	
			/* Bind new submitted email string to prevent SQL injection. */
			$updateCam_Insert->bindParam(':cam_id', $_SESSION['new_cam_id'], PDO::PARAM_INT);
			$updateCam_Insert->bindParam(':cam_name', $_SESSION['new_cam_name'], PDO::PARAM_STR);
			$updateCam_Insert->bindParam(':cam_desc', $_SESSION['new_cam_desc'], PDO::PARAM_STR);
			
			// Executes query to find other account which might already use this new email.
			$updateExecuted = $updateCam_Insert->execute();
			
			// Check whether it executed successfully.
			if ($updateExecuted == true){
				echo "<script>window.alert('Camera information updated successfully.');</script>";
			} else {
				echo "<script>window.alert('Camera information failed to update.');</script>";
			}
		}
	} else {
		unset($_SESSION['new_cam_id']);
		unset($_SESSION['new_cam_name']);
		unset($_SESSION['new_cam_desc']);
	}

/* This holds the information regarding the selected camera to be edited. */
	/* outpus current camera id of the camera selected to be edited for testing purposes. */
	//echo $_SESSION['current_cam'];
	
	/* If a camera is selected to be edited, set a session variable. */
	if ((isset($_POST['edit_cam_id'])) && ($_POST['edit_cam_id'] <> "")){
		$_SESSION['current_cam'] = $_POST['edit_cam_id'];
		$_SESSION['current_cam_name'] = $_POST['edit_cam_name'];
		$_SESSION['current_cam_desc'] = $_POST['edit_cam_desc'];
	/* If camera is not selected, verify that the session variable is no longer set. */
	} else {
		unset($_SESSION['current_cam']);
		unset($_SESSION['current_cam_name']);
		unset($_SESSION['current_cam_desc']);
	}
	
	/* If the cancel button is selected when editing a camera, clear session variable. */
	if ((isset($_POST['camera_cancel'])) && ($_POST['camera_cancel'] <> "")){
		unset($_SESSION['current_cam']);
		unset($_SESSION['current_cam_name']);
		unset($_SESSION['current_cam_desc']);
	}
	
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
	
/* Checks whether the fields for first name, last name, and email are entered. */
	if (isset($_POST['fname_new']) && isset($_POST['lname_new']) && isset($_POST['email_new'])){
		
		/* Not sure if we really need to setup variables to hold these values. */
		$fname = $_POST['fname_new'];
		$lname = $_POST['lname_new'];
		$email_new = $_POST['email_new'];
		
		/* Check whether new email is different than current email. If different check to see if account exists. */
		if ($_SESSION['email'] <> $_POST['email_new']){
			
			/* Check whether new email address already has an account. */
			$email_check = $dbh->prepare("SELECT USER_EMAIL FROM USER WHERE USER_EMAIL=:email");
			
			/* Bind new submitted email string to prevent SQL injection. */
			$email_check->bindParam(':email', $email_new, PDO::PARAM_STR);
			
			// Executes query to find other account which might already use this new email.
            $executed = $email_check->execute();
			
			// Count number of rows to see if any are found.
            $number_rows = $email_check->fetchColumn();
            echo $number_rows; 

            // If a user is found to match the criteria
            if ($number_rows != false) {
				?> <script>window.alert('Error updating email address.');</script> <?php
			} else {
				
				/* Checks whether a new password and confirm password is entered. */
				if (empty($_POST['pass1']) && empty($_POST['pass2'])){
					
					/* Enter Query to update only the first name, last name, and email address. */
					$std_update = $dbh->prepare("UPDATE USER SET USER_FNAME=:fname, USER_LNAME=:lname, USER_EMAIL=:email WHERE USER_EMAIL=:email_old");
					
					/* Bind new submitted email string to prevent SQL injection. */
					$std_update->bindParam(':fname', $fname, PDO::PARAM_STR);
					$std_update->bindParam(':lname', $lname, PDO::PARAM_STR);
					$std_update->bindParam(':email', $email_new, PDO::PARAM_STR);
					$std_update->bindParam(':email_old', $_SESSION['email'], PDO::PARAM_STR);

					
					// Executes query to find other account which might already use this new email.
					$stdUpdate_executed = $std_update->execute();
					
					if ($stdUpdate_executed = true){
						// Display a successful update message.
						$_SESSION['email'] = $email_new;
						
						?> <script>window.alert('Standard Information update successful!');</script> <?php
					} else {
						?> <script>window.alert('Standard Information updated failed!');</script> <?php
						
						$_SESSION['email'] = $email_new;
					}
					
				} elseif (($_POST['pass1'] == $_POST['pass2'])){
					
					$pass = $_POST['pass1'];
					
					/* Enter Query to update all criteria: first name, last name, email address, and password. */
					$pass_update = $dbh->prepare("UPDATE USER SET USER_FNAME=:fname , USER_LNAME=:lname , USER_EMAIL=:email , USER_PASS=:pass WHERE USER_EMAIL=:email_old;");
					
					/* Bind new submitted email string to prevent SQL injection. */
					$pass_update->bindParam(':fname', $fname, PDO::PARAM_STR);
					$pass_update->bindParam(':lname', $lname, PDO::PARAM_STR);
					$pass_update->bindParam(':email', $email_new, PDO::PARAM_STR);
					$pass_update->bindParam(':pass', $pass, PDO::PARAM_STR);
					$pass_update->bindParam(':email_old', $_SESSION['email'], PDO::PARAM_STR);

					
					// Executes query to find other account which might already use this new email.
					$psUpdate_executed = $pass_update->execute();
					
					 if ($psUpdate_executed = true){
						 $_SESSION['email'] = $email_new;
						 
						 // Display a successful update message.
						 ?> <script>window.alert('Standard Information and Password update successful!');</script> <?php
						
					} else {
						
						?> <script>window.alert('Standard Information and Password update failed!');</script> <?php
					}
					 
				} else {
					?> <script>window.alert('Something went wrong on update.');</script><?php
				}
				
				//header('Location: ' . $_SERVER['REQUEST_URI']);
			}
		} else {
			$email = $_SESSION['email'];
			
			/* Checks whether a new password and confirm password is entered. */
			if (empty($_POST['pass1']) && empty($_POST['pass2'])){
				
				/* Enter Query to update only the first name, last name, and email address. */
				$std_update = $dbh->prepare("UPDATE USER SET USER_FNAME=:fname, USER_LNAME=:lname, USER_EMAIL=:email WHERE USER_EMAIL=:email_old");
				
				/* Bind new submitted email string to prevent SQL injection. */
				$std_update->bindParam(':fname', $fname, PDO::PARAM_STR);
				$std_update->bindParam(':lname', $lname, PDO::PARAM_STR);
				$std_update->bindParam(':email', $email, PDO::PARAM_STR);
				$std_update->bindParam(':email_old', $_SESSION['email'], PDO::PARAM_STR);

				
				// Executes query to find other account which might already use this new email.
				$stdUpdate_executed = $std_update->execute();
				
				if ($stdUpdate_executed = true){
					// Display a successful update message.
					?> <script>window.alert('Standard Information update successful!');</script> <?php
				} else {
					?> <script>window.alert('Standard Information update failed!');</script> <?php
				}
				
			} elseif (($_POST['pass1'] == $_POST['pass2'])){
				
				$pass = $_POST['pass1'];
				
				/* Enter Query to update all criteria: first name, last name, email address, and password. */
				$pass_update = $dbh->prepare("UPDATE USER SET USER_FNAME=:fname , USER_LNAME=:lname , USER_EMAIL=:email , USER_PASS=:pass WHERE USER_EMAIL=:email_old;");
				
				/* Bind new submitted email string to prevent SQL injection. */
				$pass_update->bindParam(':fname', $fname, PDO::PARAM_STR);
				$pass_update->bindParam(':lname', $lname, PDO::PARAM_STR);
				$pass_update->bindParam(':email', $email, PDO::PARAM_STR);
				$pass_update->bindParam(':pass', $pass, PDO::PARAM_STR);
				$pass_update->bindParam(':email_old', $_SESSION['email'], PDO::PARAM_STR);

				
				// Executes query to find other account which might already use this new email.
				$psUpdate_executed = $pass_update->execute();
				
				 if ($psUpdate_executed = true){
					// Display a successful update message.					
					?> <script>window.alert('Standard Information and Password update successful!');</script> <?php
				} else {
					?> <script>window.alert('Standard Information and Password update failed!');</script> <?php
				}
			}
				//header('Location: ' . $_SERVER['REQUEST_URI']);
		}
		
		session_write_close();
		
		header("Refresh: 0; url=account.php");
		
	} else {
?>	
<style>
	/* add additional styling for new sections. */
	#add_camera{
		background-color: rgba(22,25,26, 0.8);
        border-radius: 10px;
        padding: 15px 25px 15px 25px;
	}
	#edit_camera{
		background-color: rgba(22,25,26, 0.8);
        border-radius: 10px;
        padding: 15px 25px 15px 25px;
	}

	/* add a few formatting items to previously created items on the stylesheet. */
	button{
		margin: 5px;
	}
	#account_page{
		padding-bottom: 75px;
	}
	
	/* Still need to figure out what button scheme we would like to go with. */
	#camera_cancel{
		width: 125px;
	}
	#camera_submit{
		width: 125px;
	}
</style>

<div class="container" id="account_page">
    <div class="row" >
	
		<br>
        <div class="col-sm-5 col-sm-push-1">

			<div id="populated_info">
				<div class="row" >
					<!-- Outputs users name above image. -->
					<h4><?php echo "Welcome, ".$_SESSION['name']." ".$_SESSION['lname'];?></h4>
				</div>
				<!--<div class="row">
					<!-- enter user image here. Just using placeholder image at the moment. -->
					<!--<img src="http://mdepinet.org/wp-content/uploads/person-placeholder.jpg" class="img-responsive">
				</div>-->
				<div class="row">
					<div class="col-md-10">
						<h3>Profile</h3>
					</div>
					<div class="col-md-2">
						<br>
						<!-- Holds the edit button, which will unlock the populated fields for editing. -->
						<button class="btn btn-trailmix" onclick='showContent("user_form"); hideContent("populated_info");'>Edit <span class="glyphicon glyphicon-edit"></span></button>
					</div>
				</div>
				<hr COLOR="yellow">
				
				<!-- Holds row for user name information. -->
				<div class="row">
					<div class="col-md-6">
						<p>Name:</p>
					</div>
					<div class="col-md-6">
						<!-- Placeholder for actual users first and last name on profile. -->
						<?php echo $_SESSION['lname'].", ".$_SESSION['name']; ?>
					</div>
				</div>
				
				<!-- Holds row for user email information. -->
				<div class="row">
					<div class="col-md-6">
						<p>Email:</p>
					</div>
					<div class="col-md-6">
						<!-- Placeholder for actual users email on profile. -->
						<?php echo $_SESSION['email']; ?>
					</div>
				</div>
				
				<!-- Holds row for user password information. -->
				<div class="row">
					<div class="col-md-6">
						<p>Password:</p>
					</div>
					<div class="col-md-6">
						<!-- if edit is selected display a form field instead of placeholder.
							Deciding if we should display with other edit information. -->
						<!-- Placeholder for stared passward. -->
						<p>********</p>
					</div>
				</div>
			</div>

			<div id="user_form" style="display:none;">
				<div class="row" >
					<!-- Outputs users name above image. -->
					<h4><?php echo "Welcome, ".$_SESSION['name']." ".$_SESSION['lname'];?></h4>
				</div>
				<div class="row">
					<!-- enter user image here. Just using placeholder image at the moment. -->
					<img src="http://mdepinet.org/wp-content/uploads/person-placeholder.jpg" class="img-responsive">
				</div>
				<div class="row">
					<div class="col-md-10">
						<h3>Profile</h3>
					</div>
					<div class="col-md-2">
						<br>
						<!-- Holds the edit button, which will unlock the populated fields for editing. -->
						<button class="btn btn-danger" onclick='showContent("populated_info"); hideContent("user_form");'>Cancel <span class="glyphicon glyphicon-undo"></span></button>
					</div>
				</div>
				<hr COLOR="yellow">
				
				<form method='post'>
					<!-- Holds row for user first name information entry. -->
					<div class="row">
						<div class="col-md-3">
							<p>First Name:</p>
						</div>
						<div class="col-md-6">
							<!-- Placeholder for actual users profile. -->
							<input id="fname_text" type="text" name="fname_new" class="form-control" value='<?php echo $_SESSION["name"];?>' required>
						</div>
					</div>
					<br>
					
					<!-- Holds row for user last name information entry. -->
					<div class="row">
						<div class="col-md-3">
							<p>Last Name:</p>
						</div>
						<div class="col-md-6">
							<!-- Placeholder for actual users profile. -->
							<input id="lname_text" type="text" name="lname_new" class="form-control" value='<?php echo $_SESSION["lname"];?>'>
						</div>
					</div>
					<br>
					
					<!-- Holds row for user email information entry. -->
					<div class="row">
						<div class="col-md-3">
							<p>Email:</p>
						</div>
						<div class="col-md-6">
							<!-- Placeholder for actual users profile. 
								Don't forget to add the email session to the header.php file. -->
							<input id="email_text" type="email" name="email_new" class="form-control" value='<?php echo $_SESSION["email"];?>'>
						</div>
					</div>
					<hr>
					
					<!-- Holds row for user confirm password information entry. -->
					<div id="pass_edit">
						<div class="row">
							<div class="col-md-3">
								<p>New Password:</p>
							</div>
							<div class="col-md-6">
								<!-- if edit is selected display a form field instead of placeholder -->
								<!-- Placeholder for stared passward. -->
								<input type="password" id="pass1" name="pass1" class="form-control">
								<meter max="4" id="password-strength-meter"></meter>
							</div>
							<div class="col-md-3">
								<!-- Add in a meter to tell whether password meets criteria -->
								<p id="password-strength-text"></p>
							</div>
						</div>
					
						<div class="row">
							<div class="col-md-3">
								<p>Confirm Password:</p>
							</div>
							<div class="col-md-6">
								<!-- if edit is selected display a form field instead of placeholder -->
								<!-- Placeholder for stared passward. -->
								<input type="password" id="pass2" name="pass2" class="form-control" onkeyup="checkPass(); return false;">
							</div>
							<div class="col-md-3">
								<span id="confirmMessage" class="confirmMessage"></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Submit</button>
						<button type="reset" class="btn btn-danger">Reset Form</button>
					</div>
				</form>
				<br>
			</div>
			
		</div>
	    
		<div class="col-sm-5 col-sm-push-1">
		
			<!-- php to gather the camera information associated to the user's account. -->
            <div id="camera_section">
                <div class="row">
					<div class="col-md-10">
						<h3>Cameras</h3>
					</div>
					<div class="col-md-2">
						<br>
						<button class="btn btn-trailmix" onclick='showContent("add_camera"); hideContent("camera_section");'>Add <span class="glyphicon glyphicon-plus"></span></button>
					</div>
				</div>
				<hr>
				
				<!-- Generate Header for the list of cameras. -->
				<div class="row">
					<div class="col-sm-4">
						<p>Camera Name</p>
					</div>
					<div class="col-sm-4">
						<p>Camera Description</p>
					</div>
				</div>
				<hr>
				
				<!-- Generates the correct number of cameras from database.-->	
				<?php {
					/* Find all camera that match user's id. */
					$current_Cams = $dbh->prepare("SELECT * FROM camera WHERE USER_ID=:id");
			
					/* Bind user id string to prevent SQL injection. */
					$current_Cams->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
					
					// Executes query to find all cameras associated to account.
					$executed = $current_Cams->execute();
					
					// Grabs all values from the database, and outputs in loop.
					$number_rows = $current_Cams->fetchAll();

					foreach ($number_rows as $row=>$albumList){
						// Set variables to each camera entry's information.
						$cam_id = $albumList['CAMERA_ID'];
						$cam_name = $albumList['CAMERA_NAME'];
						$cam_desc = $albumList['CAMERA_DESC'];
				?>
					<!-- Outputs information about each camera. -->
					<form method="post">
						<div class="row">
							<div class="col-md-5">
								<p><?php echo $cam_name;?></p>
							</div>
							<div class="col-md-5">
								<p><?php echo $cam_desc;?></p>
							</div>
							<!-- Holds hidden inputs for each of these criteria. Used for generating prefilled edit fields. -->
							<div class="col-md-2">
								<input name="edit_cam_id" style="display:none;" value="<?php echo $cam_id;?>"></input>
								<input name="edit_cam_name" style="display:none;" value="<?php echo $cam_name;?>"></input>
								<input name="edit_cam_desc" style="display:none;" value="<?php echo $cam_desc;?>"></input>
								<button class="btn btn-trailmix" formmethod="post">Edit <span class="glyphicon glyphicon-edit"></span></button>
							</div>
							<br>
							<br>
						</div>
					</form>
				<?php }
				
				} ?>
				<br>
			</div>
					
			
			<!-- php to add new camera to user's profile. -->
			<?php
			
				if ((isset($_POST['add_camera_name'])) && (isset($_POST['add_camera_desc'])) && (isset($_POST['add_camera_id']))){
										
					/* Verify the camera name is not already associated with the user. */
					$newCam_Check = $dbh->prepare("SELECT * FROM camera WHERE (CAMERA_ID =:cam_id AND USER_ID =:id) OR (CAMERA_NAME=:cam_name AND USER_ID=:id)");
			
					/* Bind new submitted email string to prevent SQL injection. */
					$newCam_Check->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
					$newCam_Check->bindParam(':cam_name', $_POST['add_camera_name'], PDO::PARAM_STR);
					$newCam_Check->bindParam(':cam_id', $_POST['add_camera_id'], PDO::PARAM_STR);
					
					// Executes query to find other account which might already use this new email.
					$executed = $newCam_Check->execute();
					
					// Count number of rows to see if any are found.
					$number_rows = $newCam_Check->fetchColumn();

					// If a user is found to match the criteria
					if ($number_rows != false) {
						?> <script>window.alert('Camera name or ID is already in use.');</script><?php
					} else {
						/* if it is not associated with the user, then update new association into camera table. */
						$newCam_Insert = $dbh->prepare("UPDATE camera SET USER_ID =:id, CAMERA_NAME=:cam_name, CAMERA_DESC=:cam_desc WHERE CAMERA_ID =:cam_id");
				
						/* Bind new submitted email string to prevent SQL injection. */
						$newCam_Insert->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
						$newCam_Insert->bindParam(':cam_id', $_POST['add_camera_id'], PDO::PARAM_INT);
						$newCam_Insert->bindParam(':cam_name', $_POST['add_camera_name'], PDO::PARAM_STR);
						$newCam_Insert->bindParam(':cam_desc', $_POST['add_camera_desc'], PDO::PARAM_STR);
						
						// Executes query to find other account which might already use this new email.
						$insertExecuted = $newCam_Insert->execute();						  
						if ($insertExecuted = true){
							$file_Structure = './Pictures/User'.$_SESSION['user_id'].'/Camera'.$_POST['add_camera_id'];
							echo $file_Structure;
							//mkdir('./Pictures/'.$_SESSION['user_id'].'/Camera'.$_POST['add_camera_id'], 0777);
							if (!mkdir($file_Structure, 0777, true)) {
    								die('Failed to create folders...');
							}

							unset($_POST['add_camera_name']);
							unset($_POST['add_camera_desc']);
							unset($_POST['add_camera_id']);
							echo "<script>window.alert('Camera added successfully!');</script>";
							echo "<script>location.reload();</script>";
						}else{
							echo "<script>window.alert('Camera addition failed!');</script>";
						}
					}
				}
			?>
			<div id="add_camera" style="display:none;">
				<div class="row">
					<h3>Cameras</h3>
					<hr>
					<p>Add a new camera to your account.</p>
				</div>
				<br>
				<br>
				<form method='post'>
					<!-- Input for camera ID. -->
					<div class="row">
						<div class="col-md-3">
							<label for="add_camera_id">Camera ID:</label>
						</div>
						<div class="col-md-8">
							<input id="add_camera_id" type="text" name="add_camera_id" class="form-control">
						</div>
					</div>
					<br>
					<!-- Input for camera name. -->
					<div class="row">
						<div class="col-md-3">
							<label for="add_camera_name">Camera Name:</label>
						</div>
						<div class="col-md-8">
							<input id="add_camera_name" type="text" name="add_camera_name" class="form-control">
						</div>
					</div>
					<br>
					<!-- Input for camera description. -->
					<div class="row">
						<div class="col-md-3">
							<label for="camera_desc">Camera Description:</label>
						</div>
						<div class="col-md-8">
							<input id="camera_desc" type="text" name="add_camera_desc" class="form-control">
						</div>
					</div>
					<br>
					<!-- Holds submit and cancel buttons. -->
					<div class="row">
						<button id="camera_submit" class="btn btn-success" type="submit">Add Camera <span class="glyphicon glyphicon-plus"></span></button>
						<button id="camera_reset" class="btn btn-primary" type="reset">Reset</button>
						<button id="camera_cancel" class="btn btn-danger" type="button" onclick='showContent("camera_section"); hideContent("add_camera");'>Cancel <span class="glyphicon glyphicon-remove"></span></button>
					</div>
				</form>
			</div>
			
			<!-- php to update camera associated with user's profile. -->
			<?php
				/* Check whether session variable has been set for camera edit selection. */
				if ((isset($_SESSION['current_cam'])) && ($_SESSION['current_cam'] <> "")){
					/* Find all camera information associated with the camera selected. */
					$current_Cams = $dbh->prepare("SELECT * FROM camera WHERE CAMERA_ID=:cam_id");
			
					/* Bind current camera selection string to prevent SQL injection. */
					$current_Cams->bindParam(':cam_id', $_SESSION['current_cam'], PDO::PARAM_INT);
					
					// Executes query to find camera information
					$executed = $current_Cams->execute();
					
					// Count number of rows to see if any are found.
					$currentCam_data = $current_Cams->fetch(PDO::FETCH_ASSOC);
					
					// Setup variables
					$currentCam_name = $currentCam_data['CAMERA_NAME'];
					$currentCam_desc = $currentCam_data['CAMERA_DESC'];
				
			?>
			<!-- Outputs fields to edit the camera information. -->
			<br>
			<div id="edit_camera">
				<div class="row">
					<h3>Cameras</h3>
					<hr>
					<p>Edit a camera associated with your account.</p>
				</div>
				<br>
				<br>
				<form method="post">
					<!-- Holds Camera Name field populated with current camera name. -->
					<div class="row">
						<div class="col-md-3">
							<label for="camera_name">Camera Name:</label>
						</div>
						<div class="col-md-8">
							<input id="camera_name" type="text" name="edit_camera_name" class="form-control" value="<?php echo $currentCam_name;?>">
						</div>
					</div>
					<br>
					<!-- Holds Camera Description field with current camera description. -->
					<div class="row">
						<div class="col-md-3">
							<label for="camera_desc">Camera Description:</label>
						</div>
						<div class="col-md-8">
							<input id="camera_desc" type="text" name="edit_camera_desc" class="form-control" value="<?php echo $currentCam_desc;?>">
						</div>
					</div>
					<br>
					<!-- Holds submit, reset, and cancel buttons for update section. -->
					<div class="row">
						<button id="camera_submit" class="btn btn-success" type="submit">Edit Camera <span class="glyphicon glyphicon-plus"></span></button>
						<button id="camera_reset" class="btn btn-primary" type="reset">Reset</button>
						<button id="camera_cancel" class="btn btn-danger" type="button" onclick='showContent("camera_section"); hideContent("edit_camera");'>Cancel <span class="glyphicon glyphicon-remove"></span></button>
					</div>
				</form>
			</div>
			<?php }?>
			<br>
	</div>
</div>
<!-- Enter Javascript for hide and show functionality -->
<script language="JavaScript">
  
  function showContent(id){
    document.getElementById(id).style.display = "block";
  }
  function hideContent(id){
    document.getElementById(id).style.display = "none";
  }
  
/* Holds JavaScript for password meter */
	var strength = {
	  0: "Bad",
	  1: "Weak",
	  2: "Good",
	  3: "Strong",
	  4: "Very Strong"
	}
	var password = document.getElementById('pass1');
	var meter = document.getElementById('password-strength-meter');
	var text = document.getElementById('password-strength-text');

	password.addEventListener('input', function() {
	  var val = password.value;
	  var result = zxcvbn(val);

	  // Update the password strength meter
	  meter.value = result.score;

	  // Update the text indicator
	  if (val !== "") {
		text.innerHTML = "Strength: " + strength[result.score]; 
	  } else {
		text.innerHTML = "";
	  }
	});
	
/* Checks the confirmation password field matchs that of the new password field. */
	function checkPass()
	{
		//Store the password field objects into variables ...
		var pass1 = document.getElementById('pass1');
		var pass2 = document.getElementById('pass2');
		//Store the Confimation Message Object ...
		var message = document.getElementById('confirmMessage');
		//Set the colors we will be using ...
		var goodColor = "#66cc66";
		var badColor = "#ff6666";
		//Compare the values in the password field 
		//and the confirmation field
		if(pass1.value == pass2.value){
			//The passwords match. 
			//Set the color to the good color and inform
			//the user that they have entered the correct password 
			pass2.style.boxShadow = "0px 0px 30px green";
			message.style.color = goodColor;
			message.innerHTML = "Passwords Match!"
		}else{
			//The passwords do not match.
			//Set the color to the bad color and
			//notify the user.
			pass2.style.boxShadow = "0px 0px 30px red";
			message.style.color = badColor;
			message.innerHTML = "Passwords Do Not Match!"
		}
	}  
  
</script>

<?php
	/* Ends the above bracket from the php. */
	}
	
	/* Add in the link to the footer */
	include('footer.php');
?>