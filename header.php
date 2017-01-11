<?php

    // Turn off error reporting
error_reporting(0);








    include('connect.php');

    session_start();

    if(isset($_SESSION['views']))
        $_SESSION['views'] = $_SESSION['views']+ 1;
    else
      $_SESSION['views'] = 1;

    echo "views = ". $_SESSION['views'];

    echo "Current age is: " . $_SESSION['age'];

?>

<head>
        <title>CIT 345 Project</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Utilization of Bootstrap -->	
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-	BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
     
        <!-- Our file css -->
        <link rel="stylesheet" href="style.css" />
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <!-- Adds some css to the elements in the page -->
        <style type="text/css">

            
            
        </style>  
        
    </head>


<body id="general_page">
<div class="pagewrapper">
    <?php
        if (isset($_POST['logEmail'])) {
            echo "Submit successful.";
            if (empty($_POST['logEmail']) || empty($_POST['logPassword'])) {
                $error = "Username or Password is invalid";
            }
            else
            {
                // Define $username and $password
                $email=$_POST['logEmail'];
                $password=$_POST['logPassword'];

                // PDO query to check registered users
                $statement = $dbh->prepare("SELECT * FROM Student WHERE STU_PASS = :pass AND STU_EMAIL = :email");

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
                    $_SESSION["stu_id"] = $row['STU_NUM'];
                    $_SESSION["name"] = $row['STU_FNAME'];
                    $_SESSION["lname"] = $row['STU_LNAME'];
                    $_SESSION["address"] = $row['STU_SADDRESS'];
                    $_SESSION["city"] = $row['STU_CITY'];
                    $_SESSION["state"] = $row['STU_STATE'];
                    $_SESSION["zip"] = $row['STU_ZIP'];
                    $_SESSION["birth"] = $row['STU_BIRTH'];
                    $_SESSION["phone"] = $row['STU_PHONE_NUM'];
                    $_SESSION["email"] = $row['STU_EMAIL'];
                    $_SESSION["pass"] = $row['STU_PASS'];
                    $_SESSION["belt"] = $row['STU_BELT'];

                    $age = date_diff(date_create($_SESSION['birth']), date_create('today'))->y;
                    $_SESSION['age'] = $age;

                    header('Location: account.php');
                   
                } else {
                	
                    // Displays an error message if the username or password is invalid.
                ?> <script>window.alert('Login Credential invalid!');</script> <?php

                // Reloads current page, which resolves issue were login it not recognizible in header.
                header('Location: ' . $_SERVER['REQUEST_URI']);
                }
            }
        }
    ?>
   <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li <?php if (stripos($_SERVER['REQUEST_URI'],'index.php') !== false) {echo 'class="active"'; session_write_close();} ?> ><a href="index.php">Home</a></li>
                    <li <?php if (stripos($_SERVER['REQUEST_URI'],'About_Us.php') !== false) {echo 'class="active"'; session_write_close();} ?> ><a href="About_Us.php">About Us</a></li>
                    <li <?php if (stripos($_SERVER['REQUEST_URI'],'Contact_Us.php') !== false) {echo 'class="active"'; session_write_close();} ?> ><a href="Contact_Us.php">Contact Us</a></li>
                    <?php 
                        /* Checks if a user is already signed in. If signed in, it 
                        will display user's name and log out button.*/
                        if(isset($_SESSION["email"])){
                    ?>
                    <li <?php if (stripos($_SERVER['REQUEST_URI'],'classes.php') !== false) {echo 'class="active"'; session_write_close();} ?> ><a href="classes.php">Classes</a></li>
                    <?php } ?>
                </ul>
                
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
                            <a href="logout.php" class="btn btn-trailmix">Logout</a>
                        </form>
                    </li>
                    <?php
                        } else {
                            /* If user is not signed in, it will display login and signup
                            buttons.*/
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login</a>
                        <div class="dropdown-menu">
                            
                            <form id="login" method="POST">
                                <div class="form-group">
                                    <input type="text" name="logEmail" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="logPassword" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <form class="navbar-form">
                            <a href="register.php" class="btn btn-trailmix" <?php session_write_close();?>>Sign Up</a>
                        </form>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
