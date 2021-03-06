<!-- saved from url=(0057)http://asce.adi-mps.com/asce_service/index.php/auth/login -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Reader</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style-ie-only.css">
<style>
.dropbtn {
    /* background-color: #4CAF50;  */
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
   /*  background-color: #f9f9f9;  */ 
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover { /* background-color: #f1f1f1; */  }

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    /* background-color: #3e8e41; */ 
}
</style>
</head>
<body>
<form action="" method="post" accept-charset="utf-8">
	<div id="formControl">
		<div class="header">
         <div class="container">
         <div class="row">
  <div class="col-md-4">
  </div>
  <div class="col-md-4"> 
  <img src="./images/Logo_White_145x58.png">
</div>
<div class="col-md-4 text-right">

<?php if(!empty($_REQUEST['GUID'])){?>
<div class="dropdown"><span class="dropbtn">Profile</span>
<div class="dropdown-content">
  <a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?logoff=Y&ASCEURL=<?php echo base_url(); ?>">Logout</a>
 <?php  } ?>
 </div>
 </div>
  </div>
  </div>
 </div>
 </div>
<div class="container">
    <?php   
	    if(!empty($_REQUEST['GUID'])){ ?>
	    <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="view" style="text-align:right; padding-right:20px; padding-top:60px;">
  <a href='http://asce.mpstechnologies.com/products/'>
 <button type="button" class="btn btn-primary btn-sm">View All Book &nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
   </button></a></div>
	    <?php 
	    //print_r($productList); die;
	    if(empty($productList)){?>
	     <h4 >You have not any subscribed product.Please go to Subscribe Books.</h4>
       <a href="http://asce.mpstechnologies.com/products/"> Product List </a>	
	    <?php }else{?>
	    <div class="col-md-12"><h3> Your Subscribe Products</h3></div>
        <div class="clearfix"></div>
	    <?php 
	    }
		//echo "<pre>"; print_r($productList); die;
		
	    foreach ($productList as $list){
	    	   $msg="";
	       	   $enddate=strtotime($list->end_date);
	    	   $startdate=strtotime($list->start_date);
	    	   $currentdate=strtotime(date('Y-m-d'));   	   
	    	   $datetime1 = date_create($list->end_date);
	    	   $datetime2 = date_create(date('Y-m-d'));
	       	   $interval = $datetime2->diff($datetime1)->format("%a"); 
			   $user_id=$list->master_id;
	    	   //$interval=2;
	          if($interval==2){
	       	   	$msg="Your Product Subscription Expire on &nbsp;".$list->end_date;
	       	   } 
			   if($list->m_licence_type == 'SINGLE'){ 
	    		   if($list->line_status=='A' && $enddate>$currentdate){ 	
	    			$img_url=base_url().'../asce_content/book/'. $list->m_bokisbn.'/vol-'. $list->m_volnumber.'/cover_img/'. $list->m_bokthump;
	    		?>
	    	<div class="panel panel-default mt30">
				    <div class="panel-body">
				 <div class="row">
				  <div class="col-md-2"><img src="<?php echo $img_url;?>" class="img-thumb img-responsive" alt="Cinque Terre" width="1600" height="1067"></div>
				  <div class="col-md-7">
			      <p class="mt30"><strong><?php echo $list->product_name; ?>
				      </strong></p>
				              <p><?php echo limit_text($list->product_discription,50);?></p>
				              <p><ul class="list-inline news-v1-info">
								<li><span>By|<?php echo $list->m_bokauthorname;?></span></li>			
								</ul>
							</p>				
				  </div>
				  <div class="col-md-3 text-right mt30"> 
				   <h5><?php  echo $msg;  ?></h5>
				    <p><a href='<?php echo site_url('/Description?id='.$list->product_id.'&&GUID='.$_REQUEST['GUID']).'/'.$user_id;?>'><button type="button" class="btn btn-primary btn-sm">View Subscribe Books List &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
				</button></a></p>
		  </div>
		</div>
	  </div>
	    <?php 		
    }else{ ?>
    <h4 >Please Your Product Subscribe Date has been Expired. Please Subscribe Product Again.GO TO </h4>
  <a href="<?php echo site_url(); ?>/products/"> Product List</a>
    <?php 
    }
	}else{		
	   if($list->m_licence_type=='MULTI'){
	   if($list->line_status=='A' && $enddate>$currentdate){
       $img_url=base_url().'../asce_content/book/'. $list->m_bokisbn.'/vol-'. $list->m_volnumber.'/cover_img/'. $list->m_bokthump;
   	?>
   			   <div class="panel panel-default mt30">
				<div class="panel-body">
				 <div class="row">
				  <div class="col-md-2"><img src="<?php echo $img_url;?>" class="img-thumb img-responsive" alt="Cinque Terre" width="1600" height="1067"></div>
				  <div class="col-md-7">
			      <p class="mt30"><strong><?php echo $list->product_name; ?>
				      </strong></p>
				              <p><?php echo limit_text($list->product_discription,50);?></p>
				              <p><ul class="list-inline news-v1-info">
								<li><span>By |  <?php echo $list->m_bokauthorname;?></span></li>
							    </ul>
							</p>
				  </div>
				  <div class="col-md-3 text-right mt30">  
				    <h4><?php echo $msg; ?></h4> 
				    <p><a href='<?php echo site_url('/Description?id='.$list->product_id.'&&GUID='.$_REQUEST['GUID'])?>'><button type="button" class="btn btn-primary btn-sm">View Books List &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
				</button></a></p>
		  </div>
		</div>
	  </div>	
  <?php  }else{?>
  <h4 >Please Your Product Subscribe Date has been Expired. Please Subscribe Product Again.GO TO </h4>
  <a href="<?php echo site_url(); ?>/products/"> Product List </a>
  <?php	
      }
    }
   } 
  }
 }else{   ?> 
   <div id="login_details">
   <div style="margin-left: 300px;"><?php if(empty($_REQUEST['GUID'])){?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?ASCEURL=<?php echo base_url(); ?>" style=" font-size:16px; font-weight:600">
  To read your subscription, please Login here.</a><?php }?></div>
	</div>	
    <?php } ?> 
	</div>
	</div>
	</div>
	</div>
	</form>	
  </body>
</html>
<?php  
function limit_text($text, $limit) {
	if (str_word_count($text, 0) > $limit) {
		$words = str_word_count($text, 2);
		$pos = array_keys($words);
		$text = substr($text, 0, $pos[$limit]) . '...';
	}
	return $text;
}
?>