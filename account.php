<?php
	/* Add in the link to the header */
	include('header.php');
	
/* This is the php code that will allow you to push the data to the database. */
	
?>

<div class="container" id="account_page">
    <div class="row" >
	
		<br>
        <div class="col-sm-5 col-sm-push-1">

			<div id="populated_info">
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
				
				<!-- Not sure if we will use this section, just basing off wireframes. -->
				<div class="row">
					<div class="col-md-6">
						<p>Date of Birth:</p>
					</div>
					<div class="col-md-6">
						<!-- Placeholder for actual users date of birth. -->
						<p>10/10/87</p>
					</div>
				</div>
				
				<!-- Not sure if we will use this section, just basing off wireframes. -->
				<div class="row">
					<div class="col-md-6">
						<p>Location:</p>
					</div>
					<div class="col-md-6">
						<!-- Placeholder for actual users date of birth. -->
						<p>Norfolk, VA</p>
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
						<button class="btn btn-trailmix" onclick='showContent("populated_info"); hideContent("user_form");'>Edit <span class="glyphicon glyphicon-edit"></span></button>
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
					<hr>
					
					<!-- Not sure if we will use this section, just basing off wireframes. -->
					<div class="row">
						<div class="col-md-3">
							<p>Date of Birth:</p>
						</div>
						<div class="col-md-6">
							<!-- Placeholder for actual users date of birth. -->
							<p>10/10/87</p>
						</div>
					</div>
					
					<!-- Not sure if we will use this section, just basing off wireframes. -->
					<div class="row">
						<div class="col-md-3">
							<p>Location:</p>
						</div>
						<div class="col-md-6">
							<!-- Placeholder for actual users date of birth. -->
							<p>Norfolk, VA</p>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success" method="post">Submit</button>
					</div>
				</form>
				<br>
			</div>
			
		</div>
	    
		<div class="col-sm-5 col-sm-push-1">
            <div id="camera_section">
                <div class="row">
					<div class="col-md-10">
						<h3>Cameras</h3>
					</div>
					<div class="col-md-2">
						<br>
						<button class="btn btn-trailmix">Add <span class="glyphicon glyphicon-plus"></span></button>
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
				
				<!-- Will need to use PHP to generate the correct number of camera lines from database.
					This is just a placeholder for the moment to guage look and feel of page.
					We can use the first camera as a construct for all generations of this section.-->
				<div class="row">
					<div class="col-md-5">
						<p>Camera 1</p>
					</div>
					<div class="col-md-5">
						<p>West Trail</p>
					</div>
					<div class="col-md-2">
						<button class="btn btn-trailmix">Edit <span class="glyphicon glyphicon-edit"></span></button>
					</div>
					<br>
					<br>
				</div>
				<br>
			</div>
			<br>
			
		</div>
		<div id="add_camera" style="display:none;">
				<div class="row">
					<h3>Cameras</h3>
					<hr>
					<p>Add a new camera to your account.</p>
				</div>
				<br>
				<br>
				<form>
					<div class="row">
						<div class="col-md-3">
							<label for="add_camera_name">Camera Name:</label>
						</div>
						<div class="col-md-8">
							<input id="add_camera_name" type="text" name="camera_name" class="form-control">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-3">
							<label for="camera_desc">Camera Description:</label>
						</div>
						<div class="col-md-8">
							<input id="camera_desc" type="text" name="camera_desc" class="form-control">
						</div>
					</div>
					<br>
					<div class="row">
						<button id="camera_submit" class="btn btn-success" type="submit">Add Camera <span class="glyphicon glyphicon-plus"></span></button>
						<button id="camera_cancel" class="btn btn-danger" type="button" onclick='showContent("camera_section"); hideContent("add_camera");'>Cancel</button>
					</div>
				</form>
			</div>


			<div id="edit_camera" style="display:none;">
				<div class="row">
					<h3>Cameras</h3>
					<hr>
					<p>Edit a camera associated with your account.</p>
				</div>
				<br>
				<br>
				<form>
					<div class="row">
						<div class="col-md-3">
							<label for="camera_name">Camera Name:</label>
						</div>
						<div class="col-md-8">
							<input id="camera_name" type="text" name="camera_name" class="form-control" value="">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-3">
							<label for="camera_desc">Camera Description:</label>
						</div>
						<div class="col-md-8">
							<input id="camera_desc" type="text" name="camera_desc" class="form-control" value="">
						</div>
					</div>
					<br>
					<div class="row">
						<button id="camera_submit" class="btn btn-success" type="submit">Add Camera <span class="glyphicon glyphicon-plus"></span></button>
						<button id="camera_cancel" class="btn btn-danger" type="button" onclick='showContent("camera_section"); hideContent("edit_camera");'>Cancel</button>
					</div>
				</form>
			</div>

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
	/* Add in the link to the footer */
	include('footer.php');
?>