<?php
/* Adds in the navigation bar the top of the page.*/
include('header.php');
?>

<!-- Enter HTML here -->

<div id="splash-screen" class="splash-screen">
    <div class="col-md-12 text-center splash-logo">
      <img src="img/trailmix-logo.png">
      <div class="text-center">
          <h2>Movement on your trail?</h2>
          <h1>Instant notification.</h1>

          <a id="GoToLearnMore" href="#learn-more" class="btn btn-trailmix cta">Learn More</a>

      </div>
    </div>
</div>

<div id="learn-more">
	<div class="row">
		<div class="container feature-section">
			<div class="col-md-6 feature-text-left">
				<p>Mount your Trailmix Motion Activated Camera to a tree along a path to watch it</p>
			</div> 
			<!-- end of learn-more div class -->
			<div class ="col-md-6 feature-img">
				<img src="img/maxresdefault.jpg"
				alt ="motion activated camera mounted to tree" />
			</div>
		</div>
	</div>
</div>

	<div id="feature1-photo" class="row content-section photo-section">
    <!-- #feature1-photo background-image will be a deer walking past a tree-mounted camera and activating it -->
		<div class="container">

		</div>
	</div>
	<!-- end feature1-photo div -->

  <div class="row">
		<div class="container feature-section">
      <div class="col-md-6 feature-img">
				<img src="img/hunterphone.jpg" alt="hunter receiving notification on phone" />
			</div>
			<div class="col-md-6 feature-text-right">
				<p>Receive an instant notification on your phone or tablet as soon as movement is detected</p>
			</div> 
		</div> <!-- end feature secion div -->
	</div>
	<!-- end row div -->


  <div id="feature2-photo" class="row content-section photo-section">
    <!-- #feature2-photo background-image will be video in gif format of a recording of a deer passing by from a fish-eye camera's point-of-view -->
		<div class="container">

		</div>
	</div>

  <div class="row">
        <div class="container feature-section">
			<div class="col-md-6 feature-text-left">
				<p>View your map when you arrive to select the area of your trail that has the most activity</p>
			</div> <!-- end of about class -->
			

			<!-- this div will call to scroll from trailmixjs -->
			<!-- scrollDiv id is used to call scroll function -->
			<div id="scrollDiv" class="col-md-6 feature-img">
				<img src="img/heatmap.jpg" alt="Heat map of deer activity" />
			</div>
		</div>
  </div>

	
	<div id="feature3-photo" class="row content-section photo-section">
    <div id="about-us">
				<h2>About Us</h2>
				<p class="p"> We at Inspired are a team of developers who love technology and are commited to providing our customers quality products.
				</p>
				<p class="p"> We are looking to innovate different aspects of technology and hopefully allow these innovations to benefit the people that use them.
				</p>
				<p class="p"> TrailMix is a little project we decided to create to help bring to light the hobby of hunting and wildlife capture.
				</p>
				<p class="p last"> With TrailMix hunters and wildlife enthusiassts can now remotely manage their trail cameras without tediously visiting them daily.
				</p>
			</div> <!-- end of about class -->
		<!-- <div class="container">

		</div> -->
	</div>
	<!-- needed to make an extra copy
	of our footer and not include
	footer.php in this file in order for
	.hide() .show() animations
	to work
	this also involves includeing the 
	body and html tags to be included on this
	index.php. Hence every other page includes
	the footer except for this one.
	also styling #footindex has been added
	next to css #foot had to include our 
	scripts on this page as well. -->
	<div id="footindex" class="col-sm-12">
            <footer>
                <p>CIT/CSE 480: Senior Capstone. &copy; 2017</p>
				<p>Abdul Naeem, Emily McCauley, Patrick Cordero, Peter Kalinowski, Tyler Downie,
				Tyler Miller</p>
            </footer>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<script src="js/waypoints.min.js" type="text/javascript"></script>
<script src="js/trailmix.js" type="text/javascript"></script>
</body>
</html>

<!-- 
<?php
/* Adds in the footer at the bottom of the page.*/
//include('footer.php');
?> -->
