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

<style>

.content2 {
	padding: 20px 15px;
	background-color: #fff;
}
.color-white{
	/*color:#FFF;*/
}

.mt15{
	    margin-top: -15px;
}

.mt20{
	    margin-top: 20px;
}
.mt30{

    margin-top: 30px;

}

.th-bg{
	background:#eee;
	
	}
.img-thumb {
   
    max-width: 140px;
    height: 160px;
    padding: 4px;
    /* line-height: 1.42857143; */
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.news-v1-info {
    margin-left: 0;
    margin-top: 30px;
    overflow: hidden;
      padding: 8px 8px 8px 0px;
    border-top: solid 1px #eee;
}



.detail-heading {
    padding: 15px;
    margin: 15px;
    color: #fff;
    background: #0c5fa8;
}

.detail-img-thumb {
   
    max-width: 160px;
    height: 180px;
    padding: 4px;
    /* line-height: 1.42857143; */
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.stock-bg {
    margin-left: 0;
    margin-top: 10px;
    overflow: hidden;
    padding: 10px 8px 10px 10px;
    background: #eee;
    font-size: 13px;
    font-weight: 600;
}

.stock-color {
    color: #0c5fa8;
}

.stock-dvdr {
    margin-left: 0;
    margin-top: 10px;
    overflow: hidden;
      padding: 8px 8px 8px 0px;
    border-top: solid 1px #eee;
}


</style>

</head>
<?php 
//echo '<pre>';
//echo $this->uri->segment(1);
//print_r($productList);
?>
<body><form action="<?php echo $lvar;?>/asce_service/index.php/auth/login" method="post" accept-charset="utf-8">
	<div id="formControl">
		<div class="header">
        
         <div class="container">
         
         <div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4 col-xs-6">        <img src="<?php echo base_url();?>/images/Logo_White_145x58.png">
</div>
  <div class="col-md-4 text-right"><?php if(empty($_REQUEST['GUID'])){?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?ASCEURL=<?php echo $lvar;?>/products/" style="color: #FFFFFF; font-size:16px; font-weight:600">Login</a><?php }else {?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?logoff=Y&ASCEURL=<?php echo $lvar;?>/products/" style="color: #FFFFFF; font-size:16px; font-weight:600">Logout</a><?php }?></div>
</div>
         </div>
        
       </div>
		
        
        
        <div id="login_details">
			<?php foreach($productList as $proddesc){
				$img_url=base_url().'../asce_content/book/'.$proddesc->m_bokisbn.'/vol-'.$proddesc->m_volnumber.'/cover_img/'.$proddesc->m_bokthump;
				?>
            <div class="container">
 
  <div class="panel panel-default mt30">
    <div class="panel-body" style="margin-top: -15px;">
    
    <div class="row">
	  <div class="col-md-12 text-right mt30"><a href='javascript:window.history.back();'><button type="button" class="btn btn-primary btn-sm">View All Books &nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
</button></a></div></div>
  <div class="detail-heading"><?php echo $proddesc->product_name;?>
</div>
  <span class="col-md-2"><img src="<?php echo $img_url;?>" class=" detail-img-thumb img-responsive" alt=""></span>
  <div class="col-md-7">
    
        
        
        
      </strong></p>
      
      
              <p><b>Author  </b><?php echo $proddesc->m_bokauthorname;?> </p>
              
              <p><ul class="list-inline stock-bg">
							<!--<li><span>HARD COVER  IN STOCK
</span></li>
							<li>|</li>
                            
                            <li><span class="stock-color"><?php echo $proddesc->price;?></span>&nbsp;List&nbsp;<span class="stock-color"><?php echo $proddesc->price;?></span>&nbsp;&nbsp;ASCE Member&nbsp;&nbsp;
 </li>
						</ul></p>
                        
                        <ul class="list-inline stock-dvdr">
							<li><span>Stock No.  </span></li>
							<li>|</li>-->
                            
                            <li> <a href="#">ISBN: <?php echo $proddesc->m_bokisbn;?>
</a></li>
						</ul>
</div>
  <div class="col-md-3 text-right mt30">
  <div class=""><select name="Subscription Type
" class="countries form-control" id="Subscription" onchange='status_get()'>
                    <option selected="selected">Subscription Type
</option>
                    <option value="single" countryid="1">Single</option>
                   <option value="multi_3" countryid="1">Multi</option>
                   <!-- <option value="multi_5" countryid="1">Multi-5</option>-->
                   <!-- <option value="ip_3" countryid="1">IP-Based-3</option>-->
                    <option value="ip_5" countryid="1">IP-Based</option>
                    </select></div>
                   <!-- <h4><input type='radio' name='mem_type' value='member'>Member <input type='radio' name='mem_type' value='non_member'>Non Member</h4>-->
   <h4><a href='#'>Member $<?php echo $proddesc->member_price;?></a></h4>
    <h4><a href='#'>Non-Member $<?php echo $proddesc->nonmember_price;?></a></h4>
    <p><a href='https://secure.asce.org/PUPGeCart/estore/AddProductToCart.aspx?ProductId=<?php echo $proddesc->master_product_id;?> '><button type="button" class="btn btn-primary btn-sm" id='buy_now' style='display:none;'>Buy Now
 &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a></p>
<!-- ------------------------------------For Contact Admin-------------------->
 <p><a href='javascript:show_confirm()'><button type="button" class="btn btn-primary btn-sm" id='contact_admin' style='display:none;'>Contact ASCE

 &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a></p>
  </div>
</div>
   <hr>
   
   <div class="row mt20">
  <div class="col-md-12"><div class="">
  
  <ul class="nav nav-tabs">
  
    <li class='active'><a data-toggle="tab" href="#DESCRIPTION">DESCRIPTION</a></li>
     <li><a data-toggle="tab" href="#Authors">About the Authors</a></li>
  </ul>

  <div class="tab-content">
    <div id="DESCRIPTION" class="tab-pane fade in active">
  <?php echo $proddesc->product_discription;?>                             
                            </div>
                            <div class="tab-pane fade in" id="Authors">
             <h4>About the Authors       </h4>
<?php echo $proddesc->m_bokauthorname;?>            
    </div>
</div></div>
  
</div>
    
    
    </div>
  </div>
  
  
  
  
  
  
</div>
<?php }?>
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


function show_confirm(){
	alert('To order this product, please contact ASCE Customer Service for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am - 6:00 pm ET or ascelibrary@asce.org. Multi-site pricing is available for IP-based subscriptions.');
	}
</script>
            
		</div>
	</div></form>
</body></html>