
<!DOCTYPE html>
 <?php
         $MasterCustomerId=$this->session->userdata('MasterCustomerId');
		 $userType=$this->session->userdata('LicenceInfo');
		 $GUID=$this->session->userdata('GUID');
		 $isAdmin=$this->session->userdata('isAdmin');
		 $Ip = $this->session->userdata ('ip');
		 if(isset($userType)){
			if($userType=='SINGLE'){
				$reader_url=$this->config->item('single_reader_url');
			}
			else if($userType=='MULTI'){
				$reader_url=$this->config->item('multi_reader_url');
			}else if($userType=='IPBASED'){
				$reader_url=$this->config->item('ipbased_reader_url');
			}
		 }
		else{
			$reader_url=$this->config->item('reader_url');
		}

		
		//if(isset ( $subscribedBookList) && empty($Ip) ){
		if((isset ( $subscribedBookList) && empty($Ip)) || ($isAdmin=='admin')){
		foreach($subscribedBookList as $subsBook ){
	 	        $dateii = $subsBook->end_date; 
				$gracedate= $subsBook->grace_date;
				$datetime1 = date_create ($dateii);
		        $datetime2 = date_create (date( 'Y-m-d'));
				$datetime3 = date_create($gracedate);
				$today_time = strtotime($dateii);
				$currentdate = strtotime(date( 'Y-m-d'));
			    $grace_date=strtotime($gracedate);
		        $interval = $datetime2->diff ( $datetime1 )->format ( "%a" );
				$graceinterval = $datetime2->diff ( $datetime3 )->format ( "%a" );
				$SingleUserInterval = $this->config->item('SingleUserInterval');
		        $InstitutionalUserInterval = $this->config->item('InstitutionalUserInterval'); 
				$date = date("F j, Y", strtotime($dateii));
			if ($userType == 'SINGLE' && $SingleUserInterval>= $interval && $today_time>$currentdate && empty($Ip)){
				$msg = 'Your license will expire on '. $date .  '<a href="https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/My-Account/Pay-Balances" target="_blank">&nbsp;Renew Now <a>';
				$this->session->set_flashdata('message',$msg);
		   	}else if($userType == 'MULTI' && $InstitutionalUserInterval>=$interval && $today_time>$currentdate && $isAdmin=='admin'){ 
				 $msg = 'Your institution\'s license will expire on  '. $date .'.&nbsp;Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
				 $this->session->set_flashdata('message',$msg);
			//}else if($userType == 'IPBASED' && $InstitutionalUserInterval>=$interval && $today_time>$currentdate && $this->session->userdata('MasterCustomerId')==$this->session->userdata('MasterCustomermainId') && $isAdmin=='admin'){
			}else if($userType == 'IPBASED' && $InstitutionalUserInterval>=$interval && $today_time>$currentdate  && $isAdmin=='admin'){
				 $msg = 'Your institution\'s license will expire on  '. $date .'.&nbsp;Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
				 $this->session->set_flashdata('message',$msg);
			}else if( $grace_date >= $today_time && $currentdate>$today_time){
				if($userType=='SINGLE'){
			    $msg = 'Your license will expire on '. $date .  '<a href='. base_url () .'>,&nbsp;.Renew Now</a>';
				$this->session->set_flashdata('message',$msg);
			   } else if($userType == 'MULTI' &&  $isAdmin=='admin'){ 
			   	$msg = 'Your license has expired but you are in a grace period.&nbsp; Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
			    $this->session->set_flashdata('message',$msg);
				}else  if($userType == 'IPBASED' && $this->session->userdata('MasterCustomerId')==$this->session->userdata('MasterCustomermainId') &&  $isAdmin=='admin'){
						
			    $msg = 'Your license has expired but you are in a grace period.&nbsp; Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
			    $this->session->set_flashdata('message',$msg);
			   }
			 } 
     	}	   
    }
	if(isset ( $subscribedBookList1) && !empty($Ip)){
		foreach($subscribedBookList1 as $subsBook ){
	 	        $dateii = $subsBook->end_date; 
				$gracedate= $subsBook->grace_date;
				$datetime1 = date_create ($dateii);
		        $datetime2 = date_create (date( 'Y-m-d'));
				$datetime3 = date_create($gracedate);
				$today_time = strtotime($dateii);
				$currentdate = strtotime(date( 'Y-m-d'));
			    $grace_date=strtotime($gracedate);
		        $interval = $datetime2->diff ( $datetime1 )->format ( "%a" );
				$graceinterval = $datetime2->diff ( $datetime3 )->format ( "%a" );
				$SingleUserInterval = $this->config->item('SingleUserInterval');
		        $InstitutionalUserInterval = $this->config->item('InstitutionalUserInterval'); 
				$date = date("F j, Y", strtotime($dateii));
			if ($userType == 'SINGLE' && $SingleUserInterval>= $interval && $today_time>$currentdate && empty($Ip)){
				$msg = 'Your license will expire on '. $date .  '<a href="https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/My-Account/Pay-Balances" target="_blank">&nbsp;Renew Now <a>';
				$this->session->set_flashdata('message',$msg);
		   	}else if($userType == 'MULTI' && $InstitutionalUserInterval>=$interval && $today_time>$currentdate && $isAdmin=='admin'){ 
				 $msg = 'Your institution\'s license will expire on  '. $date .'.&nbsp;Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
				 $this->session->set_flashdata('message',$msg);
			}else if($userType == 'IPBASED' && $InstitutionalUserInterval>=$interval && $today_time>$currentdate && $this->session->userdata('MasterCustomerId')==$this->session->userdata('MasterCustomermainId') && $isAdmin=='admin'){
				 $msg = 'Your institution\'s license will expire on  '. $date .'.&nbsp;Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
				 $this->session->set_flashdata('message',$msg);
			}else if( $grace_date >= $today_time && $currentdate>$today_time){
				if($userType=='SINGLE'){
			    $msg = 'Your license will expire on '. $date .  '<a href='. base_url () .'>,&nbsp;.Renew Now</a>';
				$this->session->set_flashdata('message',$msg);
			   } else if($userType == 'MULTI' &&  $isAdmin=='admin'){ 
			   	$msg = 'Your license has expired but you are in a grace period.&nbsp; Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
			    $this->session->set_flashdata('message',$msg);
				}else  if($userType == 'IPBASED' && $isAdmin=='admin'){
			    $msg = 'Your license has expired but you are in a grace period.&nbsp; Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
			    $this->session->set_flashdata('message',$msg);
			   }
			 } 
     	}	   
    }
	// echo $reader_url;
?>
<!--<script type="text/javascript">
         $(document).ready(function(){

            // Check if the current URL contains '#'
            if(document.URL.indexOf("#")==-1)
            {
                // Set the URL to whatever it was plus "#".
                url = document.URL+"#";
                location = "#";

                //Reload the page
                location.reload(true);
            }
        });  
</script>-->
<!-- <script type="text/javascript">



         $(document).ready(function(){
         	var subscribedBookList1 = "<?php echo count($subscribedBookList1);?>";

            if(subscribedBookList1 == 0){
            	$(".bookshelf-heading").css("display","none");
            }else{
				$(".bookshelf-heading").css("display","none");
            }
            // Check if the current URL contains '#'
            if(document.URL.indexOf("#")==-1)
            {
            	$(".main_content_loading").css("opacity","0");
            	$(".overlay").css("display","block");
                // Set the URL to whatever it was plus "#".
                url = document.URL+"#";
                location = "#";

                //Reload the page
                location.reload(true);
            }else{
            	$(".main_content_loading").css("opacity","1");
            	$(".overlay").css("display","none");
            }
        });  
</script>
<style>
.flex-price {
    display: flex;
    justify-content: space-between;
}
.pricing-option p {
    text-align: left;
}
.full-row {
    display: flex;
    justify-content: space-between;
}
.col-50.ml-2{
	margin-left: 10px;
}
.text-left.mt--10{
	margin-top: 20px;
}
.rightSection h4 {
    color: #000;
    font-weight: 600;
}
.Link-List{
	list-style: none;
	text-align: left;
}
.mb--0{
	margin: 0;
}
.center-button {
    text-align: center;
    padding-top: 30px;
}
.center-button a {
    margin: 10px 0;
    padding: 7px;
    text-transform: uppercase;
}
a button{
    margin: 10px 0;
    padding: 7px;
    text-transform: uppercase;
}
.bookBox + .bookBox{
    display: none
}
.overlay {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: fixed;
    background: #0000005e;
    display: none;
}

.overlay__inner {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: absolute;
}

.overlay__content {
    left: 50%;
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
}

.spinner {
    width: 75px;
    height: 75px;
    display: inline-block;
    border-width: 2px;
    border-color: rgba(255, 255, 255, 0.05);
    border-top-color: #fff;
    animation: spin 1s infinite linear;
    border-radius: 100%;
    border-style: solid;
}

@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}

</style>-->
<?php
	$url = explode('/', $reader_url);
	array_pop($url);
	array_pop($url);
	$urlStrings = implode('/', $url);
	//echo $urlStrings; die;
	$value1=$this->session->userdata('bookmasterid');
	$value2=$this->session->userdata('MasterCustomerId');
?>

 <div class="container">
 	<div class="overlay">
	    <div class="overlay__inner">
	        <div class="overlay__content"><span class="spinner"></span></div>
	    </div>
	</div>
	<div class="row mt20 main_content_loading">
		<div class="col-md-12 ">
		<?php
          $msg = $this->session->flashdata('message');
		 if(isset($msg)){ ?>
		<div class="alert alert-error  alert-dismissable" style="border: 1px solid #ff0000;position: relative;">
        <a href="#" class="close-msg btn btn-primary " data-dismiss="alert" aria-label="close" style=" position: absolute; top: 50%;margin-top: -17px;right: 10px;">Close</a>
        <strong ><?php echo $msg; ?></strong>
        </div> 
		<?php } ?>
			<div class="booknameSection"><h4>Store</h4></div>
		</div>	
		<div class="col-md-9" style="margin-top: -7px;">
		<?php
		$bookarray=array();
		if(count($subscribedBookList1)>0 || count($subscribedBookList)>0){
		    
		?>
	<h3> AVAILABLE CONTENT FOR PURCHASE</h3>
		<?php
		}
		if (isset ( $subscribedBookList1 )) {
		    array_splice($subscribedBookList1, 1);
		    foreach ( $subscribedBookList1 as $subsBook1 ){
			   // $bookarray[]= $subsBook->m_bokid; 	   
                    $bookarray[]= $subsBook1->m_bokid;   
					$img_url = base_url () . '../asce_content/book/' . $subsBook1->m_bokisbn . '/vol-' . $subsBook1->m_volnumber . '/cover_img/' . $subsBook1->m_bokthump;
					$allbookurl = base_url () . 'product';
					?>
			<div class="row bookBox">
			<!-- 	<div class="col-md-2"><a  class="readcheck" href='<?php echo $urlStrings; ?>/<?php echo $subsBook->licence_type;?>/<?php echo $subsBook->m_bokid;?>/<?php echo $subsBook->m_volid;?>/<?php echo $this->session->userdata('MasterCustomermainId');?>/<?php echo !empty($value1)?$value1:$value2;?>/<?php echo $this->session->userdata('orderid');?>/<?php echo $this->session->userdata('OnlineEmailAddress');?>/<?php echo $this->session->userdata('login');?>/<?php echo $userType;?>'><img src="<?php echo $img_url;?>" class="img-responsive" width="120px" height="155px" /></a></div>-->
				<div class="col-md-2"><a  class="readcheck" href='<?php echo $allbookurl; ?>'><img src="<?php echo $img_url;?>" class="img-responsive" width="120px" height="155px" /></a></div>
				
				<div class="col-md-8 nopadding">
					<p><h5 class="heading"><b style="font-size: 15px;"><a 	href='<?php echo $allbookurl; ?>'><?php echo trim(preg_replace('/[(0-6)(8-9)-]/',' ',$subsBook1->m_boktitle)) ;?>:
					<?php echo substr($subsBook1->m_boksubtitle,0);?></a>
					</h5></b></p>
					<p class="nomargin"><?php echo substr($subsBook1->m_bokauthorname,0);?></p>
					<p><b>THIS SUBSCRIPTION INCLUDES ACCESS TO 7-22, 7-16, and 7-10.</b></p>
<p>ASCE 7 provides up-to-date and coordinated loading standards for general structural design.  The Standard describes the means for determining design loads including dead, live, soil, flood, tsunami, snow, rain, ice, earthquake, wind and fire, as well as how to assess load combinations.</p>
<p><strong>FEATURES</strong><br>
&bull; Side-by-side display of Provisions and Commentary.<br>
&bull; Redlining to track changes between editions.<br>
&bull; Annotation tools include highlighting and adding notes and bookmarks.<br>
&bull; Advanced search to look up key words by chapter, section, or specific type of content such as tables, captions, or appendices.<br>
&bull; Real-time updates of supplements and errata.<br>
&bull; Toggling between Customary and SI Units.<br></p>
<p>An integral part of building codes in the United States, structural engineers, architects, and those engaged in preparing and administering local building codes will find the structural load requirements in ASCE/SEI 7 essential to their practice.</p>
			
				</div>
				<div class="col-md-2">
				<!-- <a class="readcheck" href='<?php echo $urlStrings; ?>/<?php echo $subsBook1->licence_type;?>/<?php echo $subsBook1->m_bokid;?>/<?php echo $subsBook1->m_volid;?>/<?php echo $this->session->userdata('MasterCustomermainId');?>/<?php echo !empty($value1)?$value1:$value2;?>/<?php echo $this->session->userdata('orderid');?>/<?php echo $this->session->userdata('OnlineEmailAddress');?>/<?php echo $this->session->userdata('login');?>/<?php echo $userType;?>'>
					<button type="button" class="btn btn-primary btn-block btn-sm">Read</button></a> -->&nbsp;
					<a>
						<button  class="btn btn-primary btn-xs" disabled="true">ADD TO CART</button>
					</a>
					<br />
					<p>to purchase individual license</p>
					<a data-html="true" href="javascript:;" role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary btn-xs">CONTACT ASCE</a>
					<p>
						to inquire about corporate single- and multi-site license
					</p>	
					<?php if (!empty ($MasterCustomerId)){ ?>
			<!-- <a	href='<?php echo site_url('/DemoDescription?id='.$subsBook1->m_bokid."&isbn=".$subsBook->m_bokisbn)?>'>
			<button type="button" class="btn btn-primary btn-block btn-sm"> More Info</button></a> -->
			<?php }else{ ?>
			<!-- <a href='<?php echo site_url('/Description?id='.$subsBook1->m_bokid)?>'>
			<button type="button" class="btn btn-primary btn-block btn-sm">More Info</button></a> -->
			<?php } ?>
			</div>
			</div>
		 <?php
		     }
			}
		?>
		<?php
		 
	if (isset ( $subscribedBookList )) {
	    array_splice($subscribedBookList, 1);
		   foreach ( $subscribedBookList as $subsBook ){ 
			 if(in_array($subsBook->m_bokid,$bookarray))
				continue;
				$bookarray[]= $subsBook->m_bokid; 
					$img_url = base_url () . '../asce_content/book/' . $subsBook->m_bokisbn . '/vol-' . $subsBook->m_volnumber . '/cover_img/' . $subsBook->m_bokthump;
					$allbookurl = base_url () . 'product';
					?>
			<div class="row bookBox">
			<!-- 	<div class="col-md-2"><a  class="readcheck" href='<?php echo $urlStrings; ?>/<?php echo $subsBook->licence_type;?>/<?php echo $subsBook->m_bokid;?>/<?php echo $subsBook->m_volid;?>/<?php echo $this->session->userdata('MasterCustomermainId');?>/<?php echo !empty($value1)?$value1:$value2;?>/<?php echo $this->session->userdata('orderid');?>/<?php echo $this->session->userdata('OnlineEmailAddress');?>/<?php echo $this->session->userdata('login');?>/<?php echo $userType;?>'><img src="<?php echo $img_url;?>" class="img-responsive" width="120px" height="155px" /></a></div>-->
				<div class="col-md-2"><a  class="readcheck" href='<?php echo $allbookurl; ?>'><img src="<?php echo $img_url;?>" class="img-responsive" width="120px" height="155px" /></a></div>
				
				<div class="col-md-8 nopadding">
					<p><h5 class="heading"> <b style="font-size: 15px;"><a  class="readcheck" href='<?php echo $allbookurl; ?>'><?php echo trim(preg_replace('/[(0-6)(8-9)-]/',' ',$subsBook->m_boktitle)) ;?>:
					<?php echo substr($subsBook->m_boksubtitle,0);?>
					</a></p></b></h5>
					<p class="nomargin"><?php echo substr($subsBook->m_bokauthorname,0);?></p>
					<p><b>THIS SUBSCRIPTION INCLUDES ACCESS TO 7-22, 7-16, and 7-10.</b></p>
<p>ASCE 7 provides up-to-date and coordinated loading standards for general structural design.  The Standard describes the means for determining design loads including dead, live, soil, flood, tsunami, snow, rain, ice, earthquake, wind and fire, as well as how to assess load combinations.</p>
<p><strong>FEATURES</strong><br>
&bull; Side-by-side display of Provisions and Commentary.<br>
&bull; Redlining to track changes between editions.<br>
&bull; Annotation tools include highlighting and adding notes and bookmarks.<br>
&bull; Advanced search to look up key words by chapter, section, or specific type of content such as tables, captions, or appendices.<br>
&bull; Real-time updates of supplements and errata.<br>
&bull; Toggling between Customary and SI Units.<br></p>
<p>An integral part of building codes in the United States, structural engineers, architects, and those engaged in preparing and administering local building codes will find the structural load requirements in ASCE/SEI 7 essential to their practice.</p>
			
					
				</div>
				<div class="col-md-2">
				<!-- <a  class="readcheck" href='<?php echo $urlStrings; ?>/<?php echo $subsBook->licence_type;?>/<?php echo $subsBook->m_bokid;?>/<?php echo $subsBook->m_volid;?>/<?php echo $this->session->userdata('MasterCustomermainId');?>/<?php echo !empty($value1)?$value1:$value2;?>/<?php echo $this->session->userdata('orderid');?>/<?php echo $this->session->userdata('OnlineEmailAddress');?>/<?php echo $this->session->userdata('login');?>/<?php echo $userType;?>'>
					<button type="button" id="<?php echo $subsBook->m_bokid;?>" class="btn btn-primary btn-block btn-sm">Read</button></a> -->&nbsp;
					<a>
						<button  class="btn btn-primary btn-xs" disabled="true">ADD TO CART</button>
					</a>
					<br />
					<p>to purchase individual license</p>
					<a data-html="true" href="javascript:;" role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary btn-xs">CONTACT ASCE</a>
					<p>
						to inquire about corporate single- and multi-site license
					</p>	
					<?php if (!empty ($MasterCustomerId)){
				?>
				<!---	<a
								href='<?php echo site_url('/Description?id='.$subsBook->m_bokid."&isbn=".$subsBook->m_bokisbn)?>'>
					<button type="button" class="btn btn-primary btn-block btn-sm">More Info</button></a>--->
					<br>
					<!-- <a href='<?php echo site_url('/DemoDescription?id='.$subsBook->m_bokid."&isbn=".$subsBook->m_bokisbn)?>'>
					<button type="button" class="btn btn-primary btn-block btn-sm">More Info</button></a> -->
					 <?php }else{ ?>
					
						<!---<a href='<?php echo site_url('/Description?id='.$subsBook->m_bokid)?>'>
					<button type="button" class="btn btn-primary btn-block btn-sm">More Info</button></a>---->
					<?php } ?>
				</div>
			</div>		
		 <?php
		     }
			}
		?>

		 <?php
			if(count($productList)>0){
		?>
			<h3> AVAILABLE CONTENT FOR PURCHASE</h3>
		<?php
			}
			array_splice($productList, 1);
		foreach( $productList as $prod ){	
		if(in_array($prod->m_bokid,$bookarray))
		continue;		
	  	$img_url = base_url () . '../asce_content/book/' . $prod->m_bokisbn . '/vol-' . $prod->m_volnumber . '/cover_img/' . $prod->m_bokthump;
		?>	
			<div class="row bookBox">
				<div class="col-md-2"><a href='#'><img src="<?php echo $img_url;?>"  class="img-responsive" width="120px" height="155px" /></a> </div>
				<div class="col-md-8 nopadding">
					<p><h5 class="heading"><b style="font-size: 15px;"><?php echo trim(preg_replace('/[(0-6)(8-9)-]/',' ',$prod->m_boktitle)) ;?>:					<?php echo substr($prod->m_boksubtitle,0);?></b></p></h5>
					 <p><?php echo $prod->m_bokauthorname;?></p>
					<p><b>THIS SUBSCRIPTION INCLUDES ACCESS TO 7-22, 7-16, and 7-10.</b></p>
<p>ASCE 7 provides up-to-date and coordinated loading standards for general structural design.  The Standard describes the means for determining design loads including dead, live, soil, flood, tsunami, snow, rain, ice, earthquake, wind and fire, as well as how to assess load combinations.</p>
<p><strong>FEATURES</strong><br>
&bull; Side-by-side display of Provisions and Commentary.<br>
&bull; Redlining to track changes between editions.<br>
&bull; Annotation tools include highlighting and adding notes and bookmarks.<br>
&bull; Advanced search to look up key words by chapter, section, or specific type of content such as tables, captions, or appendices.<br>
&bull; Real-time updates of supplements and errata.<br>
&bull; Toggling between Customary and SI Units.<br></p>
<p>An integral part of building codes in the United States, structural engineers, architects, and those engaged in preparing and administering local building codes will find the structural load requirements in ASCE/SEI 7 essential to their practice.</p>
				</div>
				<div class="col-md-2">
			 <?php
			 if (!empty ( $GUID )) {
				?> <!--- <a	href='<?php echo site_url('/Description?id='.$prod->m_bokid)?>'>
					<button type="button" class="btn btn-primary btn-block btn-sm">Subscribe</button></a>--->
					
		     <?php
			    } else {
			   ?>
			   <!---	<a 	href='<?php echo site_url('/Description?id='.$prod->m_bokid)?>'>	
				<button type="button" class="btn btn-primary btn-block btn-sm">Subscribe</button></a>--->
				<br>
          <a href='https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/Merchandise/Product-Details/productId/225422877?AddtoCart=Y&returnURL=https://asce7.online/product' class="center-button">
				<button  class="btn btn-primary btn-xs">ADD TO CART</button>
			</a><br />
			<p>to purchase individual license</p>
			<a data-html="true" href="javascript:;" role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary btn-xs">CONTACT ASCE</a>
			<p>
				to inquire about corporate single- and multi-site license
			</p>				
		<?php
			}
		  ?>		
			</div>
		</div>
		 <?php
		 $bookarray[]= $prod->m_bokid;
			}
		?>
	<?php
	  foreach( $productList1 as $prod ){
		if(in_array($prod->m_bokid,$bookarray))
			continue;
			$img_url = base_url () . '../asce_content/book/' . $prod->m_bokisbn . '/vol-' . $prod->m_volnumber . '/cover_img/' . $prod->m_bokthump;
			?>	
			<div class="row bookBox">
				<div class="col-md-2"><img src="<?php echo $img_url;?>"  class="img-responsive" width="120px" height="155px" /> </div>
				<div class="col-md-8 nopadding">
					<h5 class="heading"><a href="#"><?php echo $prod->m_boktitle;?></a></h5>
					<p><?php echo substr($prod->m_bokdesc,50);?></p>
					 <p><?php echo $prod->m_bokauthorname;?></p>
				</div>
				<div class="col-md-2">
			 <?php
			if (!empty ( $GUID )) {
				?>
				<a href='https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/Merchandise/Product-Details/productId/225422877?AddtoCart=Y&returnURL=https://asce7.online/product'>
				<button  class="btn btn-primary btn-xs">Add to Cart</button>
			</a><br />
			<p>To purchase individual license</p>
			<a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary btn-xs">Contact ASCE</a>
			<p>
				to inquire about corporate single- and multi-site license
			</p>
			 <?php
				} else {
			?>	
				<a href='https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/Merchandise/Product-Details/productId/225422877?AddtoCart=Y&returnURL=https://asce7.online/product'>
				<button  class="btn btn-primary btn-xs">Add to Cart</button>
			</a><br />
			<p>To purchase individual license</p>
			<a data-html="true" href="javascript:;"  role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom"  data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="btn btn-primary btn-xs">Contact ASCE</a>
			<p>
				to inquire about corporate single- and multi-site license
			</p>		
				<?php
			}
			?>	
			</div>
			</div>
		 <?php
	}
  ?>
	</div>
	<div class="col-md-3" style="padding:20px;">
		<div class="rightSection sidebar-wrapper mt20 p10">
			<h4 class="pt-0">PRICING AND PURCHASE OPTIONS</h4>
			<p class="nomargin py-2">Individual User License</p>
			 <div class="flex-row-two">
					<div class="flex-price d-flex justify-content-between">
						<div class="pl-3" >List Price</div>
						<div >$210</div>
						
					</div>
					<div class="flex-price d-flex justify-content-between">
						<div class="pl-3">ASCE Member Price</div>
						<div >$157</div>
						
					</div>
					</div>
					<p class="nomargin py-2">Corporate Single-Site License</p>
					<div class="flex-row-two">
						<div class="d-flex justify-content-between">
							<div class="pl-3">(IP-Based, 3 Users)</div>
							<div class="">$475</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="pl-3">(IP-Based, 5 Users)</div>
							<div class="">$750</div>
						</div>
					</div>
					<p class="mx-0 my-4 ">
						Corporate Multi-site Licensing and pricing for additional concurrent users is available; <span><a data-html="true" href="javascript:;" role="button" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="<p class='text-center'>To order this license, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am-6:00 pm ET, or email <a href='mailto:asce7tools@asce.org'> asce7tools@asce.org</a>.</p><p class='text-center'></p>" class="">contact ASCE</a> for details</span>
					</p>
					<ul class="Link-List">
						<li>
							<a href="<?php echo site_url()?>/TermsAndCondition" target="_blank">View terms & Conditions</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>vedio/StdsOnline_ASCE_Single-Site_Subscription_073117_FINAL.pdf" target="_blank">Download Corporate License Agreement (PDF)</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
 </div>

<footer class="footer-bg ">
	<div class="container">
		<div class="row">
			<div class="col-md-4 text-left">
			 <a class="" href="http://www.asce.org/" target="blank"><img src="<?php echo base_url();?>img/footerlogo.png" /><br>
			       1801 Alexander Bell Drive<br>
				   Reston, VA 20191-4400<br>
				   703-295-6300 | 800-548-2723</a><br>
			</div>
			<div class="col-md-4 text-center">
					<a href="https://asce7hazardtool.online/" target="blank">ASCE 7 Hazard Tool</a><br>
				<a href="http://www.asce.org/asce-7/" target="blank">ASCE 7 Related Products</a><br>
			
			<a href="<?php echo base_url();?>TermsOfUse" target="blank">Terms of Use</a><br>
<a href="<?php echo base_url();?>AboutASCE7Online" target="blank">FAQs</a>
			</div>
			<div class="col-md-4 text-center">
				<a href=" http://www.asce.org/about_asce/" target="blank">About ASCE</a><br>
				<a href="http://www.asce.org/contact_us/ " target="blank">Contact Us</a><br>
				<a href="http://ascelibrary.org/" target="blank">ASCE Library</a>
			</div>
			<br>
			<div class="col-md-12 text-center color-white" style="
    margin-top: 5px;">
				© 2018 American Society of Civil Engineers
			</div>
		</div>
	</div>	
</footer>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom" style="
    width: 142%;">

<div class="modal-header" id="mod-header">

<h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
</div>
<div class="modal-body">
	All available seats for this license are in use. Please try again at a later time. Contact your institutional administrator for more information.
</div>
<div class="modal-footer" id="mod-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

</div>

</div>
</div>
</div> 



<div class="modal fade" id="myModalNotice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom" style="
    width: 142%;">

<div class="modal-header" id="mod-header">

<h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
</div>
<div class="modal-body">
        <?php echo $soaperror;?>
<!--    <span>NOTE: ASCE 7 Online is currently experiencing connectivity issues, causing some users to experience problems logging in. If you are having difficulties logging in, clearing your browser history (including cookies) back to the date of your last successful login may in some instances fix the problem. ASCE is working to resolve the problem as quickly as possible. We apologize for the inconvenience. Please contact <a href = "mailto: asce7tools@asce.org"> asce7tools@asce.org</a> if you need assistance.</span>-->
</div>
<div class="modal-footer" id="mod-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

</div>

</div>
</div>
</div>




<div class="modal fade" id="myModalA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom" style="
    width: 142%;">

<div class="modal-header" id="mod-header">

<h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
</div>
<div class="modal-body">
	All available seats for this license are in use. Additional seats are available for purchase. Contact ASCE for more information.
</div>
<div class="modal-footer" id="mod-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

</div>

</div>
</div>
</div> 

</body>
<script>
var adminflage = "<?php echo isset($_SESSION['isAdmin'])?$_SESSION['isAdmin']:'';?>";
//alert(adminflage);
$('.readcheck').click(function (e) {
	var aa = $(this).children().attr('id');
    e.preventDefault(); // otherwise, it won't wait for the ajax response
    $link = $(this);
//alert($link);	// because '$(this)' will be out of scope in your callback
    var base_url = window.location.origin;
	//alert(base_url);
  // var urlIPRange=base_url+"/products/index.php/product/iptimeout";
    $.ajax({
        type: 'POST',
        url: base_url+'/products/index.php/product/checkipcount',
        data: {id:aa},
        contentType: 'html',
        error: function (err) {
			return false;
        },
        success: function (err) {
			//alert(err);
			if(err==0){
                                if(adminflage!='')
                                    $('#myModalA').modal('show');
                                else
                                    $('#myModal').modal('show');
				e.preventDefault();
				return false;
			}else{
				//alert("error - " + err);
				window.location.href = $link.attr('href');
			}
            
        }
    });
});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});
</script>
<script>
        <?php if(isset($soaperror)) { ?>
	//$(document).ready(function(){
		$("#myModalNotice").modal('show');
	//});
        <?php } ?>
</script>
</html>
