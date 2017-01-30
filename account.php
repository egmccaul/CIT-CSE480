<?php
	/* Add in the link to the header */
	include('header.php');
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
						<div class="col-md-6">
							<p>First Name:</p>
						</div>
						<div class="col-md-6">
							<!-- Placeholder for actual users profile. -->
							<input id="fname_text" type="text" name="fname_new" class="form-control" value='<?php echo $_SESSION["name"];?>'>
						</div>
					</div>
					<br>
					
					<!-- Holds row for user last name information entry. -->
					<div class="row">
						<div class="col-md-6">
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
						<div class="col-md-6">
							<p>Email:</p>
						</div>
						<div class="col-md-6">
							<!-- Placeholder for actual users profile. 
								Don't forget to add the email session to the header.php file. -->
							<input id="email_text" type="email" name="email_new" class="form-control" value='<?php echo $_SESSION["email"];?>'>
						</div>
					</div>
					<hr>
					
					<!-- Holds row for user password information entry. -->
					<div class="row">
						<div class="col-md-6">
							<p>Password:</p>
						</div>
						<div class="col-md-6">
							<!-- Holds button to allow editing of password. -->
							<button class="btn btn-trailmix" onclick='showContent("pass_edit");'>Edit <span class="glyphicon glyphicon-edit"></span></button>
						</div>
					</div>
					<br>
					<div id="pass_edit" style="display:none;">
						<!-- Holds row for user confirm password information entry. -->
						<div class="row">
							<div class="col-md-6">
								<p>New Password:</p>
							</div>
							<div class="col-md-6">
								<!-- if edit is selected display a form field instead of placeholder -->
								<!-- Placeholder for stared passward. -->
								<input id="pass1_text" type="password" name="pass1" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6">
								<p>Confirm Password:</p>
							</div>
							<div class="col-md-6">
								<!-- if edit is selected display a form field instead of placeholder -->
								<!-- Placeholder for stared passward. -->
								<input id="pass2_text" type="password" name="pass2" class="form-control">
							</div>
						</div>
						<button class="btn btn-trailmix">Edit <span class="glyphicon glyphicon-edit"></span></button>
					</div>
					<br>
					
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
					<div class="form-group">
						<button type="submit" class="btn btn-success" method="post">Submit</button>
					</div>
				</form>
				<br>
			</div>
			
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
	</div>
</div>
<!-- Enter Javascript for hide and show functionality -->

<?php
	/* Add in the link to the footer */
	include('footer.php');
?>
