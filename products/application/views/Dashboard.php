<?php 
   $Licence=$this->session->userdata ( 'LicenceInfo' );
   ?>

<div class="container bootstrap snippet">
    <div class="row margin-bottom-10 mt30">
        <div class="col-md-3 col-sm-6">
            <div class="servive-block servive-block-red" style="height: 220px;">
               <img
					src="<?php echo base_url(); ?>/images/icon2.png" style="height: 45px; ">
                <h2 class="heading-md"><a href="<?php echo site_url(); ?>User_reports" style="color: white;">Usage Reports</a></h2>
                <p>Access usage reports for your institution.</p>                        
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="servive-block servive-block-yellow" style="height: 220px;">
                <img
					src="<?php echo base_url(); ?>/images/icon1.png" style="height: 48px; ">
                <h2 class="heading-md"><a href="<?php echo site_url(); ?>MultiLicenses" style="color: white;">Licenses</a></h2>
                <p>View licenses for your institution.</p>
            </div>
        </div>
		<?php
		
		if($Licence=='MULTI')
		{
		?>
        <div class="col-md-3 col-sm-12">
            <div class="servive-block servive-block-dark-blue" style="height: 220px;">            
                <i class=" icon-2x color-light fa fa-envelope-o" style="
    font-size: 40px;
"></i>
                <h2 class="heading-md"><a href="<?php echo site_url(); ?>MuserAdmin" style="color: white;">Invited Users</a></h2>
                <p>Invite and manage license sub users.</p>
            </div>
			
			
        </div>
		<?php 
			}
			?>
			
		<?php
		if($Licence=='IPBASED')
		{
		?>
		
		<div class="col-md-3 col-sm-12">
            <div class="servive-block servive-block-dark-blue" style="height: 220px;">            
               <img
					src="<?php echo base_url(); ?>/images/IP-address-wt.png" style="height: 48px;">
                <h2 class="heading-md"><a href="<?php echo site_url(); ?>IpuserAdmin" style="color: white;">IP Ranges</a></h2>
                <p>View registered IP addresses assigned for your institution.</p>
            </div>
        </div>
		<?php 
			}
			?>
        <div class="col-md-3 col-sm-12">
            <div class="servive-block servive-block-sea" style="height: 220px;">            
               <img
					src="<?php echo base_url(); ?>/images/icon3.png" style="height: 48px;">
                <h2 class="heading-md"><a href="<?php echo site_url(); ?>ListBooks" style="color: white;">Books</a></h2>
                <p>View books available for your institution.</p>
            </div>
        </div>
    </div>
</div>

 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom">

<div class="modal-header" id="mod-header">

<h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
</div>
<div class="modal-body">
<script>
function show_confirm(id){
	  // alert(id);
	  // window.location='<?php echo site_url();?>/'+'MuserAdmin/deleteSubUser/'+id;
	   $('#myModal').modal('show');
	   //$("#okbtn").attr("data-dismiss",id);
	}
	
</script>Usage Reports are not currently available. 
</div>
<div class="modal-footer" id="mod-footer">

<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>

</div>

</div>
</div>
</div>
<footer class="footer-bg " style="
    margin-top: 325px;">
	<div class="container">
		<div class="row" >
			<div class="col-md-4 text-left">
			 <a class="" href="http://www.asce.org/" target="blank"><img src="http://asce.adi-mps.com/products/img/footerlogo.png" /><br>
			       1801 Alexander Bell Drive<br>
				   Reston, VA 20191-4400<br>
				   703-295-6300 | 800-548-2723</a><br>
			</div>
			<div class="col-md-4 text-center" >
				<a href="https://asce7hazardtool.online/" target="blank">ASCE 7 Hazard Tool</a><br>
				<a href="http://www.asce.org/asce-7/" target="blank">ASCE 7 Related Products</a><br>

<a href="<?php echo base_url();?>TermsOfUse" target="blank">Terms of Use</a><br>
<a href="<?php echo base_url();?>AboutASCE7Online" target="blank">FAQs</a>
			</div>
			<div class="col-md-4 text-center" >
				<a href=" http://www.asce.org/about_asce/" target="blank">About ASCE</a><br>

<a href="http://www.asce.org/contact_us/ " target="blank">Contact Us</a><br>
				<a href="http://ascelibrary.org/" target="blank">ASCE Library</a>
			</div>
			<br>
			<div class="col-md-12 text-center color-white" >
				© 2018 American Society of Civil Engineers
			</div>
		</div>
	</div>	
</footer> 
