<?php
/* Adds in the navigation bar the top of the page.*/
include('header.php');
?>

	<div class="container">
		<div class="row">
			<br>
			<br>
			<!--Add the header to the top of the page.-->
			<h1 id="page_title" class="contactTitle">Contact Us</h1>
		</div>
		<div class="row">
			<div class="col-sm-8 col-sm-push-2 contact-form" id="form_layout">
			
				<form class="form-horizontal" action="mailer.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('from','','RisEmail','subject','','R','verif_box','','R','message','','R');return document.MM_returnValue">
					<br>
					<div class="form-group">
						<label class="control-label col-sm-4" for="name">Your Name:</label>
						<div class="col-sm-7">
							<input class="form-control" name="name" type="text" id="name" value="<?php echo $_SESSION['lname'] . ", " . $_SESSION['name'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="from">Your e-mail:</label>
						<div class="col-sm-7">
							<input class="form-control" name="from" type="text" id="from" value="<?php echo $_SESSION['email'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="subject">Subject:</label>
						<div class="col-sm-7">
							<input class="form-control" name="subject" type="text" id="subject"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="verif_box">Type verification image:</label>
						<div class="col-sm-6">
							<input class="form-control" name="verif_box" type="text" id="verif_box" style=""/>
						</div>
						<div class="col-sm-1 ">
							<img src="verificationimage.php?<?php echo rand(0,9999);?>" alt="verification image, type it in the box" width="50" height="24" align="absbottom" />
						</div>
					</div>
					
					<!-- if the variable "wrong_code" is sent from previous page then display the error field -->
					<?php if(isset($_GET['wrong_code'])){?>
					<div class="form-group" id="wrong_verify">
						<label>Wrong verification code</label>
					</div>
					<?php ;}?>
					
					<div class="form-group">
						<label class="control-label col-sm-4" for="message">Message:</label>
						<div class="col-sm-7">
							<textarea name="message" id="message"></textarea>
						</div>
					</div>
					<input name="Submit" type="submit" id="submit" class="btn btn contactSubmitBtn" value="Send Message"/>
				</form>
			</div>
		</div>
		<br>
	</div>
	
<?php
/* Adds in the closing code, and footer information.*/
include('footer.php');
?>
