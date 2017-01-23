<?php
/* Adds in the navigation bar the top of the page.*/
include('header.php');

// If form submitted, insert values into the database.
	if (isset($_POST['email'])){
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		// PDO check for previous user
			$statement = $dbh->prepare("SELECT * FROM USER WHERE USER_PASS = :pass AND USER_EMAIL = :email");
			// PDO binds entry to protect against SQL Injection
			$statement->bindParam(':pass', $password, PDO::PARAM_STR);
			$statement->bindParam(':email', $email, PDO::PARAM_STR);

			// Executes query
			$executed = $statement->execute();

			// Count number of rows
			$number_rows = $statement->fetchColumn();

			// If a user is found to match the criteria
			if ($number_rows > 0) {
				// Display a user found message.
				?> <script>window.alert('Email Already Found!');</script> <?php
			} else {

				// PDO database entry query - (Removed state due to issues inserting into database, works after removal, defaulted to "Michigan")
				$insertState = $dbh->prepare("INSERT INTO Student(USER_FNAME, USER_LNAME, USER_EMAIL, USER_PASS) VALUES (:fname, :lname, :email, :password)");
				
				// PDO binds entry to protect against SQL Injection
				$insertState->bindParam(':fname', $fname, PDO::PARAM_STR);
				$insertState->bindParam(':lname', $lname, PDO::PARAM_STR);
				$insertState->bindParam(':email', $email, PDO::PARAM_STR);
				$insertState->bindParam(':password', $password, PDO::PARAM_STR);

				// Executes query
				$insertExecuted = $insertState->execute();

				if ($insertExecuted = true){
					// Redirects after successful to home page
					header("Location: index.php");
				}
			}

	}else{
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
		/* Closes above PHP and MySQL Query. */
	}
		
/* Adds in the footer at the bottom of the page.*/
include('footer.php');
?>
