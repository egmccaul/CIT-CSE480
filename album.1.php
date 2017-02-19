<?php
/* Adds in the navigation bar the top of the page.*/
include('header.php');
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
     body{
         margin-left: 0px;
         margin-top: 0px;
         margin-right: 0px;
         margin-bottom: 0px;
         /*background-color:#C0c0c0;*/
     }
     .container{
         margin-top:75px;
         background-color:gray;
         position:relative;
     }
  #form_layout{
      margin-top:80px;
    
  }
  #preview0{
      min-width:auto;
      min-height:auto;
      
      max-width:241px;
      max-height:114px;
  }
    
        </style>
    </head>
       <div class="container" id='form_layout'> 
        <div class="row">  
        <div class='col-xl-6 col-lg-offset-1'>
            <!--col-xs-6 col-sm-offset-3-->
        
        <img class="col-xs-3 " id="preview0" src='TestImages/07-trail-cam-animals-funny-when-humans-arent-around.jpg'/>
        <img class="col-xs-3" id="preview0" src='TestImages/8_400w1.jpg'/>
        <img class="col-xs-3 " id="preview0" src='TestImages/alien-trail-cam.jpg'/>
        <img class="col-xs-3 " id="preview0" src='TestImages/featured.jpg'/>
          
    </div>
</div> <!-- end image preview -->
<div class="row">  
        <div class='col-xl-6 col-lg-offset-1'>
        
        <img class="col-xs-3 " id="preview0" src='TestImages/07-trail-cam-animals-funny-when-humans-arent-around.jpg'/>
        <img class="col-xs-3" id="preview0" src='TestImages/8_400w1.jpg'/>
        <img class="col-xs-3 " id="preview0" src='TestImages/alien-trail-cam.jpg'/>
        <img class="col-xs-3 " id="preview0" src='TestImages/featured.jpg'/>
          
    </div>
</div> <!-- end image preview -->
<div class="row">  
        <div class='col-xl-6 col-lg-offset-1'>
        
        <img class="col-xs-3 " id="preview0" src='TestImages/07-trail-cam-animals-funny-when-humans-arent-around.jpg'/>
        <img class="col-xs-3" id="preview0" src='TestImages/8_400w1.jpg'/>
        <img class="col-xs-3 " id="preview0" src='TestImages/alien-trail-cam.jpg'/>
        <img class="col-xs-3 " id="preview0" src='TestImages/featured.jpg'/>
          
    </div>
</div> <!-- end image preview -->
       </div>
       <div class='col-xs-10 col-sm-offset-5'>
       <nav aria-label="...">
   <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <!--For the next button-->
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>

  </ul>
</nav>
</div>
    </body>
</html>
