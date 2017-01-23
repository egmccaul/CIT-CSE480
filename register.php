<?php
/* Adds in the navigation bar the top of the page.*/
include('header.php');
?>

<div class="start-screen">
		

<!-- Setup form section to Sign up for a new account -->
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-push-2" id="form_layout">
			<form class="form-horizontal" id="signup" method="POST">
				<!-- Holds the title of the form section -->
				<p>Sign up for a new account below:</p>
				</br>
				<div class="form-group">
					<label class="control-label col-sm-3" for="fname">First Name:</label>
					<div class="col-sm-8">
						<input type="text" name="fname" class="form-control" placeholder="First Name">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="lname">Last Name:</label>
					<div class="col-sm-8">
						<input type="text" name="lname" class="form-control" placeholder="Last Name">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="email">Email:</label>
					<div class="col-sm-8">
						<input type="email" name="email" class="form-control" placeholder="Email">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="password">Password:</label>
					<div class="col-sm-8">
						<input type="password" name="password" class="form-control" placeholder="Password">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-9 col-sm-offset-3">
						<input type="submit" class="btn btn-trailmix" value="Submit Registration">
					</div>
				</div>
			</form>
		</div>
	</div>       
</div>
</div>

<?php
/* Adds in the footer at the bottom of the page.*/
include('footer.php');
?>