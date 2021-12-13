<!DOCTYPE html>

<!--end of navigation-->

<!--banner Start-->

<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
  a.free-trail-btn {
    background: #68bd45;
    min-width: 14em;
    color: #fff;
    border-radius: 20px;
    padding: 10px 70px;
    font-size: 18px;
    font-weight: bold;
    box-shadow: 0 14px 28px rgb(0 0 0 / 25%), 0 10px 10px rgb(0 0 0 / 22%);
}
.banner-caption{
  display: block;
}
.bannerContent{
  padding: 100px 0 30px 0;
}
.btn-center{
  display: flex;
  justify-content: center;
}
</style>
<div id="carousel-example-generic" data-interval="false" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    
    
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active text-center">
      <img src="img/landing.jpg" alt="banner" style="
    display: -webkit-inline-box;
" >
      
      <div style="display:none; position: absolute;    font-size: 18px;    top: 8%;    width: 100%;    max-width: 863px;    background: #fff;    padding: 10px;    border: 4px solid #ef1313;
    left: 0;    right: 0;    margin: auto;">
          
    NOTICE: The ASCE 7 Online website will be unavailable Sunday, June 20th, 2021 between the hours of 12:00 AM EST and 6:00 AM EST due to scheduled server maintenance. We apologize for the inconvenience. Please contact <a href = "mailto: asce7tools@asce.org">asce7tools@asce.org</a> if you need assistance.
          
      </div>
      
      <div class="banner-caption">
        <p class="bannerContent">A faster, easier way to work with Standard ASCE 7<br><a href="<?php echo base_url(); ?>product" class="btn bannerBtn mt10">Get Started</a>
		<a href="#" class="btn bannerBtn2 mt10" data-toggle="modal" data-target="#myModal">Watch Video</a>
		</p>
  <!--   <p class="text-center btn-center">
        <a class="free-trail-btn" href="https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/Merchandise/Product-Details/productId/273416299?AddToCart=Y&returnURL=<?php echo base_url(); ?>product">
          Free Trial
        </a>
      </p>--> 
      </div>
    </div>
    <div class="item text-center">
      <img src="img/banner1.jpg" alt="banner" style="
    display: -webkit-inline-box;
" >
      <div class="banner-caption">
       <p class="bannerContent">A faster, easier way to work with Standard ASCE 7<br> <a href="<?php echo base_url(); ?>product" class="btn bannerBtn mt10">Get Started</a>
	   <a href="#" class="btn bannerBtn2 mt10" data-toggle="modal" data-target="#myModal">Watch Video</a>
	   </p>
      </div>
    </div>
     
  </div>


  
  
  <!-- Modal Start -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg ">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ASCE 7 Online Video</h4>
        </div>
        <div class="modal-body">
		
		
		

       <video  style="width:100%;"   controls=""  poster="<?php echo base_url();?>vedio/poster.jpg">
  <source src="<?php echo base_url();?>vedio/ASCE 7 Online Final _Sept 2017_revision.mp4" type="video/mp4">
  <source src="mov_bbb.ogg" type="video/ogg">
  Your browser does not support HTML5 video.
</video>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal End -->
  
  <!-- Controls -->
 
 
</div>
<section class="mainContainer">
	<div class="container">
		<div class="row">
			<!-- <div class="col-lg-3">
				<img src="img/botImg.jpg" class="img-responsive">
			  <h4>Easy to Use Features</h4>
			  <ul class="ul">
				<li>Side-by-Side display of Provisions and Commentary</li>
				<li> Redlining</li>
				<li> Annotation</li>
				<li> Real-time updates</li>
			 </ul>
			</div> -->
			<div class="col-lg-4">
                       <h5 class="h5" style="font-size: 16px;"><b>Corporate</b></h5>
           			  <ul class="ul">
				<li> Two-layer annotations allow firms to embed vetted notes in the text of the Standard for the secure, uniform sharing of information within a company.</li>
				<li> Subscription-based, concurrent user license.</li>
				<li> Access 24/7.</li>
			 </ul>
			</div>
			<div class="col-lg-4">

   <h5 class="h5" style="font-size: 16px;"><b>Academia</b></h5>
			 <ul class="ul">
				<li> Aid faculty in teaching students to understand and interpret Standard ASCE7.</li>
				<li> Annotation tools allow faculty to embed  course notes in the text of the Standard for use in the classroom, and students to save personal notes.</li>
				<li> Semester-based, seat licenses available.</li>
			</ul>
			  <p>Contact <a href="mailto:asce7tools@asce.org">asce7tools@asce.org</a> for more information.</p>
			</div>
			<div class="col-lg-4">
				
				<form class="form-horizontal custForm" action="<?php echo base_url();?>" method="post" name='ora' id="asceForm">
				<h5 class="h5" style="font-size: 16px;"><b>Request for Corporate Access Quotes</b></h5>
				  <div class="form-group">
					<div class="col-sm-12">
                                            <input type="email" required="" name="email" class="form-control" id="inputEmail3" placeholder="Email*">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-12">
					 <input type="text" required="" name="FirstName" class="form-control" id="FirstName" placeholder="First Name*">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-12">
					   <input type="text" required="" name="LastName" class="form-control" id="LastName" placeholder="Last Name*">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-12">
					  <input type="text" name="Company" class="form-control" id="Company" placeholder="Company">
					</div>
				  </div>
				   <div class="form-group">
					<div class="col-sm-12">
					  <input type="text" name="Numberofsites" class="form-control" id="Numberofsites" placeholder="Number of sites">
					</div>
				  </div>
                                 <div class="form-group">
                                     <div class="col-sm-12">
				  <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>" data-callback="enableBtn"></div> 
				  </div>
				  </div>
                                  
                                  <div class="form-group">
					<div class="col-sm-12">
					   <input type="submit" name="submit" class="btn btn-primary">
					</div>
				  </div>
					
				</form>
			</div>
		</div>	
	</div>
</section>
<?php
          if(isset($msg1))
              unset($msg1);
          $msg1 = $this->session->flashdata('bulkimportmessage'); 
		 // 
		 if(isset($msg1) && (!empty($msg1))){ 
		 ?>
                    <div class="modal fade" id="memberModaldashbord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                    <div class="modal-dialog modal-sm">
                    <div class="modal-content" id="popup-custom">

                    <div class="modal-header" id="mod-header">

                    <h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
                    </div>
                    <div class="modal-body">
                    <strong ><?php echo $msg1; ?></strong>
                    </div>
                    <div class="modal-footer" id="mod-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>

                    </div>

                    </div>
                    </div>
                    </div> 
                    <script>
                    $(window).on('load',function(){
                          $('#memberModaldashbord').modal('show');
                      });
                    </script>
                    <?php
                    unset($msg1);
		 }
		 ?>
 
