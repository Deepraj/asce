
<!--end of navigation-->
<?php
$masterId = $this->session->userdata ( 'MasterCustomerId' );
	   $userType=$this->session->userdata('LicenceInfo');
		 if(isset($userType)){
			if($userType=='SINGLE'){
				$reader_url=$this->config->item('single_reader_url');
			}
			else if($userType=='MULTI'){
				$reader_url=$this->config->item('multi_reader_url');
			}
			else if($userType=='IPBASED'){
				$reader_url=$this->config->item('ipbased_reader_url');
			}
		else{
			 $reader_url=$this->config->item('reader_url');
		}
	 }
?>
 <div class="container">
 <?php foreach($subscribedProductList as $subsProd){ 
//print_r($subsProd); die;
?>
	<div class="row mt20">
	
	
		<div class="col-md-12 ">
			<div class="booknameSection"><h4><?php echo $subsProd->product_name;?></h4></div>
		</div>
		<div class="col-md-9">
			<h3>MY CONTENT</h3>
			<div class="row bookBox">
			
					<div class="col-md-2" data-toggle="tab"><div class="prod_desc">PRODUCT DESCRIPTION  </div></div>
				<div class="col-md-8 nopadding">
					<h5 class="heading"><a href="#"><?php echo $subsProd->product_name;?></a></h5>
					<p><?php echo $subsProd->product_discription; ?></p>
					<p class="nomargin">New significant features include:</p>
										<br />
		<?php
	$option = '';
	$counter = 0;
	$id = $_GET ['id'];
	//echo "<pre>";print_r($SubsBooks); die;
	foreach ( $SubsBooks as $subscribedBook ) {
		if ($subsProd->product_id == $subscribedBook->product_id) {
			if ($subscribedBook->book_id != $id) {
				$option .= '<li><i class="fa fa-check" style="font-size: 12px;" aria-hidden="true"></i>&nbsp;<a href="' . site_url ( '/Description?id=' . $subscribedBook->m_bokid ."&isbn=".$subscribedBook->m_bokisbn).'" target="_blank">' . $subscribedBook->m_boktitle . ' </a></li>';
				 $counter ++; 
			}
		}
	} 
?>
					
					
					
					
 
<?php  if($counter !=0){  ?>
<p style="font-weight: bold;">This Product Contains the Following Books:</p>
	<ul style="margin-left: 0px;" class="bookslist">
   <?php  echo $option; } ?>
 </ul>

				</div>
				<!---<div class="col-md-2">
					<button type="button" class="btn btn-primary btn-block btn-sm">Read Book</button>
					<button type="button" class="btn btn-primary btn-block btn-sm">More Info</button>
				</div>---->
			</div>
			
		</div>
		<div class="col-md-3">
			 <div class="rightSection bgGray mt20 p10 text-center">
				<h4>Purchase Options</h4>
				<p><strong>12-month Subscription Rates</strong></p>
				<p><strong><?php echo $subsProd->licence_type;?> USER LICENSE</strong></p>
				<p>List: $200; ASCE Member: $150<br>
				<a
	href='https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/Merchandise/Product-Details/productId/225422877&AddToCart=Y&returnURL=http://beta.asce.mpstechnologies.com/product;?>'>
				
				<button  class="btn btn-primary   btn-xs">
				
				Add to Cart</button></a></p>
			 
				<p>By purchasing an item you agree to our <a href="#">Terms and Conditions.</a></p>
				<p><strong>CORPORATE SINGLE SITE LICENSE</strong></p>
				<p>Up to 3 Concurrent Users: $400<br><a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET.</p><p class='text-center'><a href='#' class=''>Download Price Sheet</a></p>" class="btn btn-primary   btn-xs">Contact ASCE</a></p>
				<p>Up to 5 Concurrent Users: $720<br><a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET.</p><p class='text-center'><a href='#' class=''>Download Price Sheet</a></p>" class="btn btn-primary   btn-xs">Contact ASCE</a></p>
				<p class="mt30">Corporate Multi-site Licensing and pricing for additional concurrent users is available.</p>
				<p><a href="#" class="">Download Corporate License</a></p>
				
				
			 </div>
		</div>
	</div>
	
	<?php } ?>
	
	
	
	
	
	<?php foreach($productList as $proddesc){ ?>
	
	
	
	
	
	
	<div class="row mt20">
	
	
		<div class="col-md-12 ">
			<div class="booknameSection"><h4><?php echo $proddesc->product_name;?></h4></div>
		</div>
		<div class="col-md-9">
			<h3>This product contains access to both demo1 and demo2.</h3>
			<div class="row bookBox">
					<div class="col-md-2" data-toggle="tab"><div class="prod_desc">PRODUCT DESCRIPTION  </div></div>
				<div class="col-md-8 nopadding">
					<h5 class="heading"><a href="#"><?php echo $proddesc->product_name;?></a></h5>
					<p><?php echo $proddesc->product_discription; ?></p>
					<p class="nomargin">New significant features include:</p>
				<?php
	     $option = '';
	     $counter = 0;
	      $id = $_GET ['id'];
	foreach ( $IpBased as $IpBasedBook ) {
		if ($proddesc->product_id == $IpBasedBook->product_id) {
			if ($IpBasedBook->book_id != $id) {
				$option .= '<li><i class="fa fa-caret-right" style="font-size: 13px;" aria-hidden="true"></i>&nbsp;<a href="' . site_url ( '/Description?id=' . $IpBasedBook->m_bokid ) .'" target="_blank">' . $IpBasedBook->m_boktitle . ' </a></li>';
				$counter ++;
			}
		}
	}
	?>
					
					
					
					
					 
<?php  if($counter !=0){  ?>
<p style="font-weight: bold;">This Product Contains the Following Books:</p>
	<ul style="margin-left: 0px;" class="bookslist">
   <?php  echo $option; } ?>
 </ul>
				</div>
				<!---<div class="col-md-2">
					<button type="button" class="btn btn-primary btn-block btn-sm">Read Book</button>
					<button type="button" class="btn btn-primary btn-block btn-sm">More Info</button>
				</div>---->
			</div>
			
			
		</div>
		<div class="col-md-3">
			 <div class="rightSection bgGray mt20 p10 text-center">
				<h4>Purchase Options</h4>
				<p><strong>12-month Subscription Rates</strong></p>
				<p><strong><?php echo strtoupper($proddesc->license_type); ?> LICENSE</strong></p>
				
				<p>
				<?php
	
	if ($proddesc->license_type == 'Single User') {
		?>
				List:  $<?php echo $proddesc->nonmember_price;?>
 <?php
		
		if ($proddesc->member_price != 0) {
			?>				 
				
				ASCE Member : $<?php echo $proddesc->member_price;?>
 <?php
		}
		?>
				
				<br>
				<a
	href='https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/Merchandise/Product-Details/productId/225422877&AddToCart=Y&returnURL=http://beta.asce.mpstechnologies.com/product?ProductId=<?php echo $proddesc->master_product_id;?>'>
				
				
				<button  class="btn btn-primary   btn-xs">Add to Cart</button></a></p>
				
				
				
				<?php
	} else {
		?>
		<?php if($proddesc->nonmember_price !=0){?>
		
		 List:  $<?php echo $proddesc->nonmember_price;?>
		 <?php
			
			if ($proddesc->member_price != 0) {
				?>
		ASCE Member : $<?php echo $proddesc->member_price;?>
	<?php }}?>
			 
				<p>By purchasing an item you agree to our <a href="#">Terms and Conditions.</a></p>
				<p><strong>CORPORATE SINGLE SITE LICENSE</strong></p>
				<p>Up to 3 Concurrent Users: $400<br><a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET.</p><p class='text-center'><a href='#' class=''>Download Price Sheet</a></p>" class="btn btn-primary   btn-xs">Contact ASCE</a></p>
				
				
				<p>Up to 5 Concurrent Users: $720<br><a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET.</p><p class='text-center'><a href='#' class=''>Download Price Sheet</a></p>" class="btn btn-primary   btn-xs">Contact ASCE</a></p>
				<p class="mt30">Corporate Multi-site Licensing and pricing for additional concurrent users is available.</p>
				<p><a href="#" class="">Download Corporate License</a></p>
				<?php } ?>
				
			 </div>
		</div>
	</div>
	
	
	<?php } ?>
	
	
	
	
	
 </div>


<!--Scripts put here-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	
    $('[data-toggle="popover"]').popover();
});
</script>
