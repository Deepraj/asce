<?php  /*echo '<pre>';
print_r($productList);
echo '<pre>';*/
function limit_text($text, $limit) {
	if (str_word_count($text, 0) > $limit) {
		$words = str_word_count($text, 2);
		$pos = array_keys($words);
		$text = substr($text, 0, $pos[$limit]) . '...';
	}
	return $text;
}
?>
<?php
$lvar="http://".$_SERVER['HTTP_HOST'];

?>
<!-- saved from url=(0057)http://asce.adi-mps.com/asce_service/index.php/auth/login -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>http://asce.adi-mps.com/asce</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style-ie-only.css">
</head>
<body><form action="<?php echo $lvar;?>/asce_service/index.php/auth/login" method="post" accept-charset="utf-8">
	<div id="formControl">
		<div class="header">
        
         <div class="container">
         
         <div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">        <img src="./images/Logo_White_145x58.png">
</div>
  <div class="col-md-4 text-right"><?php if(!empty($_REQUEST['GUID'])){?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?logoff=Y&ASCEURL=<?php echo $lvar;?>/reader/" style="color: #FFFFFF; font-size:16px; font-weight:600">Logout</a><?php }?></div>
</div>
         </div>
        
       </div>
		
       
       
        <div id="login_details">
			<div style="margin-top: 149px; margin-left: 459px;"><?php if(empty($_REQUEST['GUID'])){?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?ASCEURL=<?php echo $lvar;?>/reader?ISBN=9780071850131" style=" font-size:16px; font-weight:600">To read your subscription, please Login here.</a><?php }?></div>
            <div class="container">
  <?php
    if(!empty($_REQUEST['GUID'])){
  /*print_r('<pre>');
  print_r($productList); 
  echo base_url();*/
 
						 foreach ($productList as $prod) {
							 if($prod->m_bokisbn==9780071850131 || $prod->m_bokisbn==9971443333334)
							 {
						  $img_url=base_url().'../asce_content/book/'.$prod->m_bokisbn.'/vol-'.$prod->m_volnumber.'/cover_img/'.$prod->m_bokthump;
						 	//echo $img_url;
					?>
  <div class="panel panel-default mt30">
    <div class="panel-body">
    
    <div class="row">
  <div class="col-md-2">. <img src="<?php echo $img_url;?>" class="img-thumb img-responsive" alt="Cinque Terre" width="1600" height="1067"></div>
  <div class="col-md-7">
  
      <p class="mt30"><strong><?php echo $prod->product_name;?>
        
        
        
      </strong></p>
      
      
              <p><?php echo limit_text($prod->product_discription,50);?></p>
              
              
              <p><ul class="list-inline news-v1-info">
							<li><span>By</span></li>
							<li>|</li>
                            
                            <li> <a href="#"><?php echo $prod->m_bokauthorname;?>
</a></li>
						</ul></p>
  </div>
  <div class="col-md-3 text-right mt30">
 
     
    <p><a href='<?php echo $lvar;?>/asce_service/index.php/Authentication/index/PRIMARY/97/97'><button type="button" class="btn btn-primary btn-sm">Read Book &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a></p>
<?php } else {?>

<?php }?>
  </div>
</div>
   
    
    
    </div>
  </div>
         <?php
							 }
              }
              ?>
		</div>
	</div></form>
</body></html>