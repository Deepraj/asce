<?php
$lvar="http://".$_SERVER['HTTP_HOST'];

?>
<!-- saved from url=(0057)http://asce.adi-mps.com/asce_service/index.php/auth/login -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ASCE</title>
	<link href="<?php echo base_url();?>css/bootstrap.min.css?version={ver}" rel="stylesheet">
	<link href="http://asce.adi-mps.com/asce/vendors/font-awesome/css/font-awesome.min.css?version={ver}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css " />
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.11.3.min.js?version={ver}"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap.min.js?version={ver}"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/main.js " ></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.form.js " ></script>
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
   <script type="text/javascript"  src="<?php echo base_url();?>js/jquery.min.js"></script>
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui.js"></script>
	<style>
	.ui-widget-header,.ui-state-default, ui-select{
	 background:#0c5fa8;
	 /* background:#fff;
	 border: 1px solid #b9cd6d;
	 color: #FFFFFF;
	 font-weight: bold; */
}
</style>
</head>
<body>
<!--product detail start--------------> 
<form action="<?php echo site_url('/Description'); ?>" method="post" accept-charset="utf-8">
	<div id="formControl">
		<div class="header">
         <div class="container">
         <div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4 col-xs-6">
  <img src="<?php echo base_url();?>/images/Logo_White_145x58.png">
  </div>
  <div class="col-md-4 text-right">
  <?php if(empty($_REQUEST['GUID'])){?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?ASCEURL=<?php echo $lvar.$_SERVER['REQUEST_URI']; ?>" style="color: #FFFFFF; font-size:16px; font-weight:600">Login</a><?php }else {?>
  <a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?logoff=Y&ASCEURL=<?php echo $lvar;?>/products/" style="color: #FFFFFF; font-size:16px; font-weight:600">Logout</a><?php }?></div>
</div>
 </div>
</div>
<!--Book  detail start--------------> 
<div class="container">
 <div class="panel panel-default mt30">
 <div class="panel-body" style="margin-top: -15px;">
    <div class="row">
   <div class="col-md-12 text-right mt30"><a href='<?php echo base_url(); ?>'>
	<button type="button" class="btn btn-primary btn-sm">View All Books &nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
   </button></a></div></div>
   <?php foreach($bookInfo as $bookdesc) { ?>
      <?php 
        $img_url=base_url().'../asce_content/book/'.$bookdesc->m_bokisbn.'/vol-'. $bookdesc->m_volnumber.'/cover_img/'.$bookdesc->m_bokthump;
     ?>
  <div class="detail-heading">BOOK NAME : <?php echo $bookdesc->m_boktitle; ?>
  </div>
  <span class="col-md-2"><img src="<?php echo $img_url;?>" class=" detail-img-thumb img-responsive" alt=""></span>
  <div class="col-md-6">      
  <p><b>Author Name : </b><?php echo $bookdesc->m_bokauthorname; ?> </p>
  <p><ul class="list-inline stock-bg">
     <li>ISBN: <?php echo $bookdesc->m_bokisbn; ?></li>
    </ul> 
  </div>	  
</div>
      
 <hr>
 <div class="row mt20">
  <div class="col-md-12">
  <div class="">
  <ul class="nav nav-tabs">
   <li class='active'><a data-toggle="tab" href="#DESCRIPTION">BOOK DESCRIPTION</a></li>
  </ul>
  <div class="tab-content">
    <div id="DESCRIPTION" class="tab-pane fade in active">
     <p align='justify'> <?php echo $bookdesc->m_bokdesc; ?></p>                            
    </div>                         
</div>
</div>
</div>
</div>
<?php } ?>
 </div>
 </div>
<!--Book  detail End-------------->
<div id="login_details">
<?php foreach($productList as $proddesc){ ?>
 <div class="container">
 <div class="panel panel-default mt30">
 <div class="panel-body" style="margin-top: -15px;">
  <div class="detail-heading">PRODUCT NAME : <?php echo $proddesc->product_name;?>
</div>
  <span class="col-md-2" data-toggle="tab">PRODUCT DESCRIPTION :  
  </span>
  <div class="col-md-6">  
  <div class="tab-content">
    <div id="DESCRIPTION" class="tab-pane fade in active" style="text-align:justify;" >
    <p align='justify'><?php echo $proddesc->product_discription; ?></p>                           	
    <br/>
	
	 
	<?php 
	 $option='';
	 $counter=0;
	 $id=$_GET['id'];
	foreach($IpBased as $IpBasedBook){
	          if($proddesc->product_id==$IpBasedBook->product_id){
			  if($IpBasedBook->book_id != $id){	
		  
   $option.='<li><a href="'.site_url('/Description?id='.$IpBasedBook->m_bokid).'" target="_blank">'. $IpBasedBook->m_boktitle.' </a></li>';
		
			  $counter++; 			  
			}
		}			 
	}  ?>
 
<?php  if($counter !=0){  ?>
<p style="font-weight:bold;">This Product Contains the Following Books:</p>
 <ul style="margin-left:20px;">
   <?php  echo $option; } ?>
 </ul>
  
	</div>   
  </div>
 </div>		 
  <div class="col-md-4 text-right mt30">
  Subscription Type :&nbsp;<?php echo $proddesc->license_type;?>
	<?php if($proddesc->license_type =='Single User')
	{ ?>
 <h4>Price : $<?php echo $proddesc->nonmember_price;?></h4>
 <?php if($proddesc->member_price!=0)
 { ?>
<h4>Member Price : $<?php echo $proddesc->member_price;?></h4>
 <?php }
 ?>
    <p><a href='https://secure.asce.org/PUPGeCart/estore/AddProductToCart.aspx?ProductId=<?php echo $proddesc->master_product_id;?>'><button  type="button"  class="btn btn-primary btn-sm" id='buy_now' >Purchase</button></a></p>
	<?php
	}
	else
	{
	?>
	<?php if($proddesc->nonmember_price !=0){?>
	<h4>Price : $<?php echo $proddesc->nonmember_price;?></h4>
   <?php if($proddesc->member_price!=0)
    { ?>
  <h4>Member Price : $<?php echo $proddesc->member_price;?></h4>
	<?php }}?>
 <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="margin-top: 5px;">Contact ASCE</button>
 <div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog" style="background-color:white">
      <!-- Modal content-->
      <div class="modal-content" style="background-color:white">
      
        <div class="modal-body" style="background-color:white">
          <p align='justify'>To order this product, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am - 6:00 pm ET or <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> Multi-site pricing is available for IP-based subscriptions.</p>
        </div>
        <div class="modal-footer" style="background-color:white">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	<?php 
	 }
	?>
<!-- ------------------------------------For Contact Admin-------------------->
  </div>
  </div>
</div>      
 </div>
<?php } ?>
</div>
</div>
<script>
function status_get(){
	//alert('Anuj');
	 $('#buy_now').show();
	 var value = $('select#Subscription option:selected').val();
	 if(value=='single'){
		 $('#buy_now').show();
	  $('#contact_admin').hide();}
	 else{
		 $('#buy_now').hide();
		  $('#contact_admin').show();
	 }
	// alert(value);
} 
</script>  
 </div>
</div>
</form>
</body>
</html>