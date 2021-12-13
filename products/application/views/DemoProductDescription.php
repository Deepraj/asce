<!--end of navigation-->
<?php
error_reporting(0);
//print_r($_SESSION); 
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
<?php
//echo $reader_url; die;
$url = explode('/', $reader_url);
array_pop($url);
array_pop($url);
 $urlStrings = implode('/', $url);
 //echo $urlStrings; die;
 $value1=$this->session->userdata('bookmasterid');
	  $value2=$this->session->userdata('MasterCustomerId');
?>
 <div class="container">
  <div class="row mt20">
	<?php 
	if(isset($books)){
	   foreach($books as $proddesc){
    //echo "<pre>";  print_r($proddesc); die;
	?> 
	  <div class="col-md-12 ">
	      <div class="booknameSection"><h4><?php  echo $proddesc->m_boktitle; ?>:&nbsp;<?php  echo $proddesc->m_boksubtitle; ?></h4></div>
	 </div>	  
		<div class="col-md-9">
			<h3>This product contains access to both ASCE 7-10 and ASCE 7-16  </h3>
			<div class="row bookBox">
				<div class="col-md-2" data-toggle="tab">
				<?php if(!empty($proddesc->m_bokthump)){
                $img_url = base_url () . '../asce_content/book/' . $proddesc->m_bokisbn . '/vol-' . $proddesc->m_volnumber . '/cover_img/' . $proddesc->m_bokthump;
				?>
				<div class=""><img src="<?php echo $img_url; ?>" class="img-responsive" width="120px" height="155px"></div>
				<?php }else{ ?>
				<div class="prod_desc">PRODUCT DESCRIPTION  </div>
				<?php } ?>
				</div>
			    <div class="col-md-8 nopadding">
					<p><h5 class="heading">&nbsp;
					<b style="font-size: 15px;"><?php  echo $proddesc->m_boktitle; ?>:&nbsp;<?php  echo $proddesc->m_boksubtitle; ?></b></h5></p>
					<p>&nbsp; <?php  echo $proddesc->m_bokauthorname; ?></p>
					<p style="
    margin-top: -18px;
">&nbsp;<?php echo $proddesc->m_bokdesc; ?></p>
					<?php
			if(isset($subscriptions)){
	   foreach($subscriptions as $prodsubs){
		   if($prodsubs['isbn']!="")
		   {
		//  echo "<pre>"; print_r($prodsubs); die;
		   ?>
					<div class="col-md-2" style=" margin-left: 611px;">
					
					<a 	href='<?php echo $urlStrings; ?>/<?php echo  $prodsubs['licence_type'];?>/<?php echo $proddesc->m_bokid;?>/<?php echo $proddesc->m_volid;?>/<?php echo $this->session->userdata('MasterCustomermainId');?>/<?php echo !empty($value1)?$value1:$value2;?>/<?php echo $this->session->userdata('OnlineEmailAddress');?>/<?php echo $this->session->userdata('login');?>/<?php echo $userType;?>'>
<button type="button" class="btn btn-primary btn-block btn-sm" style="width:   
123px;position: absolute;bottom: 431px">Read Book</button></a>&nbsp;
					</div>
					
					<?php
		   }
		}
			}

			?>
					
				</div>
			</div>
		</div>
		<div class="col-md-3">
			 <div class="rightSection bgGray mt20 p10 text-center">
			<?php
			
			//echo "<pre>//////////";print_r($subscriptions[0]['product_name']);die;
     if(!empty($subscriptions))
      {	
  //echo "fdsf"; die;
		
		if( ($this->session->userdata('LicenceInfo') == 'SINGLE' || $this->session->userdata('LicenceInfo') =='MULTI' ||  $this->session->userdata('LicenceInfo') == 'IPBASED') && (!empty($this->session->userdata('ip')) ) )
		{
		
			  ?> 
			 <h4>Your Current License</h4>
			 <?php
		}
		
		
		if( ($this->session->userdata('LicenceInfo') == 'SINGLE' || $this->session->userdata('LicenceInfo') =='MULTI' ||  $this->session->userdata('LicenceInfo') == 'IPBASED') && (empty($this->session->userdata('ip')) ) &&  (!empty($masterId) ) &&(!empty($subscriptions[0]['product_name'])) )
		{
		
			  ?> 
			 <h4>Your Current License</h4>
			 <?php
		}
		
		
		?>
		
		
			 <?php
			if(isset($subscriptions)){
	   foreach($subscriptions as $prodsubs){
		 // echo "<pre>"; print_r($prodsubs); die;
		   ?>
			
			<p><strong><?php  echo $prodsubs['product_name'];?> </strong></p>
			
			<?php
		}
			}

			?>
			
			
			<?php
		if( ($this->session->userdata('LicenceInfo') == 'SINGLE' || $this->session->userdata('LicenceInfo') =='MULTI' ||  $this->session->userdata('LicenceInfo') == 'IPBASED') && (!empty($this->session->userdata('ip')) ))
		{
			  ?> 
				 
			 <hr />
			 <?php 
			 }
         }
			  ?>
			 
				<h4>Purchase Options</h4>
				<?php
				if(empty($subscriptions[0]['product_name']) )  {
				//	echo "fdfd"; die;
?>					
				
				<p><strong>12-month Subscription Rates</strong></p>
				
				<p><strong>INDIVIDUAL USER LICENSE</strong></p>
				
				
				<p>
			List:  $200<?php //echo $proddesc->nonmember_price; ?>
           <?php
		
		     if ($proddesc->member_price != 0){
			?>				 
				
				ASCE Member :$<?php  echo $proddesc->member_price;?>
 
			 <?php } ?>	
				
				</br><a href='https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/Merchandise/Product-Details/productId/225422877?AddToCart=Y&returnURL=http://beta.asce.mpstechnologies.com/product'>
							
				<button  class="btn btn-primary   btn-xs">Add to Cart</button></a></p>
				<p>By purchasing an item you agree to our <a href="<?php echo site_url()?>/TermsAndCondition" target="_blank">Terms and Conditions.</a></p>
				
				
				
				<?php
				}
				?>
				
				
	
				
				
				<?php if($this->session->userdata('LicenceInfo')!='IPBASED' && $this->session->userdata('LicenceInfo')!='MULTI' ){ ?>
				
				<p><strong>CORPORATE SINGLE SITE LICENSE</strong></p>
				<p>ASCE 7 Online IP Based License (3 Users): $450<br><a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary   btn-xs">Contact ASCE</a></p>
				<p>ASCE 7 Online IP Based License (5 Users): $720<br><a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary   btn-xs">Contact ASCE</a></p>
				<p><a href="<?php echo base_url();?>vedio/StdsOnline_ASCE_Single-Site_Subscription_073117_FINAL.pdf" target="_blank">Download Corporate License</a></p>
				
				
				<?php } ?>
				
				
				<?php
				
				 if($this->session->userdata('LicenceInfo')=='MULTI' ){ ?>
				<p><strong>12-month Subscription Rates</strong></p>
				<?php 
				 }
				?>
				<?php 
				if(isset($subscriptions)){
	   foreach($subscriptions as $prodsubs){
		 //echo "<pre>"; print_r($prodsubs); die;
		  if($this->session->userdata('LicenceInfo')=='IPBASED'  && $prodsubs['licence_count']<=3&& $prodsubs['Nigotiate_count']<=3){ ?>
		  <?php 
		 if(!empty($subscriptions[0]['isbn']))
		 {?>
	 <p><strong>12-month Subscription Rates</strong></p>
	 <?php
		 }
		  ?>
		  
		  <p><strong>CORPORATE SINGLE SITE LICENSE</strong></p>
				
				<?php 
		 if(!isset($subscriptions[0]['isbn']))
		 {?>
	 <p>ASCE 7 Online IP Based License (3 Users): $450<br><a data-html="true" href="http://www.asce.org/contact_us/"target="_blank"  role="button"  class="btn btn-primary   btn-xs">Contact ASCE</a></p>
	 <?php
		 }
		  ?>
				<p>ASCE 7 Online IP Based License (5 Users): $720<br><a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary   btn-xs">Contact ASCE</a></p>
				<p><a href="<?php echo base_url();?>vedio/StdsOnline_ASCE_Single-Site_Subscription_073117_FINAL.pdf" target="_blank">Download Corporate License</a></p>
				
				
				<?php 
	         }
		     if($this->session->userdata('LicenceInfo')=='IPBASED'  && ($prodsubs['licence_count']>3 || $prodsubs['Nigotiate_count']>3) )
			 {
				// echo "fdfd"; die;
				 ?>
		
				
				<p><strong>12-month Subscription Rates</strong></p>
		 <?php
			 }
		 
		     }
				}
				?>
				
				
				
				<p class="mt30">Corporate Multi-site Licensing and pricing for additional concurrent users is available.</p>
				
				<p><a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary   btn-xs">Contact ASCE</a></p>
				
			 </div>
		</div>
		<?php }}?>
    </div>
</div>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});
</script>
