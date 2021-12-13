<?php
/* ---------------------------Subscribed Product List---------------------------- */
$userType = $this->session->userdata ( 'LicenceInfo' );
if (isset ( $subscribedBookList )) {
	foreach ( $subscribedBookList as $subsBook ) {
		$img_url = base_url () . '../asce_content/book/' . $subsBook->m_bokisbn . '/vol-' . $subsBook->m_volnumber . '/cover_img/' . $subsBook->m_bokthump;
		?>
<div class="panel panel-default">
<div class="clearfix"></div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
				<img src="<?php echo $img_url;?>" class="img-thumb img-responsive"
					alt="Cinque Terre" width="120px" height="155px" >
			</div>
			<div class="col-md-7">
				<p>
					<strong><?php echo $subsBook->m_boktitle;?>
                          </strong>
				</p>
				<p style="text-align: justify;"><i class="fa fa-user text-primary" aria-hidden="true"></i> &nbsp;<?php echo $subsBook->m_bokauthorname;?></p>
				<p>
				
				
				<ul class="list-inline news-v1-info">
					<li><?php echo $subsBook->m_bokdesc;?></li>
					<li></li>
				</ul>
				</p>
				<p style="color: #B22222;"> <?php  echo DateInterval($subsBook ->end_date,$userType); ?></p>
			</div>
			<div class="col-md-3 text-right">

				<p>
					<!--<a
						href='<?php echo $reader_url; ?><?php echo $subsBook->m_bokid;?>/<?php echo $subsBook->m_volid;?>/<?php echo $this->session->userdata('MasterCustomerId');?>'>
						<button type="button" class="btn btn-primary btn-sm">
							Read Book &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
						</button>
					</a>--->
				</p>
			</div>
		</div>
	</div>
</div>
<?php
	}
}
?>
<!---------------------------------------------------End-------------------------------------------------------------->

<footer class="footer-bg " style="
    margin-top: 410px;">
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

<a href="<?php echo base_url();?>index.php/TermsOfUse" target="blank">Terms of Use</a><br>
<a href="<?php echo base_url();?>index.php/AboutASCE7Online" target="blank">FAQs</a>
			</div>
			<div class="col-md-4 text-center" style="
    margin-left: -6px;
">
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
</html>
