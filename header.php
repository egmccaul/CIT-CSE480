<?php
    // Links to database connection file
    include('connect.php');

    session_start();

	// Verifies that the sessions are working correct across pages
    if(isset($_SESSION['views']))
        $_SESSION['views'] = $_SESSION['views']+ 1;
    else
      $_SESSION['views'] = 1;

	// Shows visual confirmation that sessions are working correctly.
//    echo "views = ". $_SESSION['views'];

?>

<head>
        <title>CIT/CSE 480 Project</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="fontawesome/css/font-awesome.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>

        <!-- Our file css -->
        <link rel="stylesheet" href="style.css" />
</head>

<body id="general_page">

<?php
		// Check whether login was submitted
        if (isset($_POST['logEmail'])) {

			// Gives visual confirmation that the submission was successful.
            echo "Submit successful.";

			// Give error message if login is not successful.
            if (empty($_POST['logEmail']) || empty($_POST['logPassword'])) {
                $error = "Username or Password is invalid";
            }
            else
            {
                // Define $username and $password
                $email=$_POST['logEmail'];
                $password=$_POST['logPassword'];

                // PDO query to check registered users
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
                    ?> <script>window.alert('Username Found!');</script> <?php

                    // Execute query and gather database information
                     $executed = $statement->execute();
                     $row = $statement->fetch(PDO::FETCH_ASSOC);

                    // Sets session variables
                     $_SESSION["name"] = $row['USER_FNAME'];
                     $_SESSION["lname"] = $row['USER_LNAME'];
					 $_SESSION["email"] = $row['USER_EMAIL'];

		    // Redirects to another page once
                     header('Location: album.php');

				 } else {



					// Redirects to another page once
                    // header('Location: account.php');

                //  else {


                    // Displays an error message if the username or password is invalid.
                ?> <script>window.alert('Login Credentials invalid!');</script> <?php

                // Reloads current page, which resolves issue were login it not recognizible in header.

                 header('Location: ' . $_SERVER['REQUEST_URI']);

		  }

                // header('Location: ' . $_SERVER['REQUEST_URI']);

				// There is a closing bracket for the if-else statement here.
            }
        }
    ?>
   <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="index.php"><img src="img/trailmixacorn.png" alt="TrailMix" style="width:auto;height:20px;"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
				<?php if(((basename($_SERVER['PHP_SELF'])) == "index.php") && isset($_SESSION["email"])){ ?>
				<ul class="nav navbar-nav">
                    <li><a id="GoToSplash" href="#splash-screen">Home</a></li>
                    <li><a id="GoToLearnMore" href="#learn-more">Learn More</a></li>
                    <li><a id="GoToAboutUs" href="#about-us">About</a></li>
                    <li><a id="contactUs" href="contact.php">Contact Us</a></li>
                    <!-- adding a contact page -->
					<li><a href="album.php">Album</a></li>

                </ul>
				<?php } else if((basename($_SERVER['PHP_SELF'])) == "index.php"){ ?>
				<ul class="nav navbar-nav">
                    <li><a id="GoToSplash" href="#splash-screen">Home</a></li>
                    <li><a id="GoToLearnMore" href="#learn-more">Learn More</a></li>
                    <li><a id="contactUs" href="contact.php">Contact Us</a></li>
                    <!-- adding a contact page -->
                    <li><a id="GoToAboutUs" href="#about-us">About</a></li>
                </ul>
				<?php } else if(isset($_SESSION["email"])){ ?>
                
				<ul class="nav navbar-nav">
                    <li><a id="goHome" href="index.php">Home</a></li>
                    <li><a id="contactUs" href="contact.php">Contact Us</a></li>
                    <!-- adding a contact page -->
					<li><a href="album.php">Album</a></li>
				</ul>
			<?php } else {?>
				<ul class="nav navbar-nav">
                    <li><a id="goHome" href="index.php">Home</a></li>
                    <li><a id="contactUs" href="contact.php">Contact Us</a></li>
                    <!-- adding a contact page -->
				</ul>
			<?php } ?>

            <!--Places the signup button on the right-hand side of the navbar,
              as well as the login dropdown-->
			<ul class="nav navbar-nav navbar-right">
				<?php
					/* Checks if a user is already signed in. If signed in, it
					will display user's name and log out button.*/
					if(isset($_SESSION["email"])){
				?>
					<li><h4 style="color:white; font-size: 15px">Welcome, <?php echo $_SESSION["name"];?> </h4></li>
					<li>
						<form class="navbar-form">
							<a href="account.php" class="btn btn-trailmix active" <?php session_write_close();?>>Account</a>
						</form>
					</li>
					<li>
						<form class="navbar-form">
							<a href="logout.php" class="btn btn-trailmix active">Logout</a>
						</form>
					</li>
				<?php
					} else {
						/* If user is not signed in, it will display login and signup
						buttons.*/
				?>
					<li class="dropdown">
						<a href="#" id="logbtn" class="dropdown-toggle" data-toggle="dropdown">Login</a>
						<div class="dropdown-menu">

							<form id="login" method="POST">
								<div class="form-group">
									<input type="text" name="logEmail" class="form-control" placeholder="Email">
								</div>
								<div class="form-group">
									<input type="password" name="logPassword" class="form-control" placeholder="Password">
								</div>
								<div class="form-group">
									<button class="btn btn-trailmix">Login</button>
								</div>
							</form>
						</div>
					</li>
					<li>
						<form class="navbar-form">
							<a href="register.php" class="btn btn-trailmix active "<?php session_write_close();?>>Sign Up</a>
						</form>
					</li>
				<?php } ?>
			</ul>
        </div>
    </nav>
<div class="pagewrapper">
