<?php
	/* Add in the link to the header */
	include('header.php');
?>

<div class="container">
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
				<!-- Will hold the editable user information, which will be hidden by default until edit button pressed. -->
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