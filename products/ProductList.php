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
<body>
<form action="<?php echo $lvar;?>/asce_service/index.php/auth/login" method="post" accept-charset="utf-8">
	<div id="formControl">
		<div class="header">
         <div class="container">
         <div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">        
  <img src="./images/Logo_White_145x58.png">
</div>
  <div class="col-md-4 text-right"><?php if(empty($_REQUEST['GUID'])){?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?ASCEURL=<?php echo $lvar; ?>/products/" style="color: #FFFFFF; font-size:16px; font-weight:600">Login</a><?php }else {?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?logoff=Y&ASCEURL=<?php echo $lvar; ?>/products/" style="color: #FFFFFF; font-size:16px; font-weight:600">Logout</a><?php }?></div>
</div>
         </div>
        
       </div>
        <div id="login_details">
			
            <div class="container">
			
  <?php
 foreach ($productList as $prod) {
$img_url=base_url().'../asce_content/book/'.$prod->m_bokisbn.'/vol-'.$prod->m_volnumber.'/cover_img/'.$prod->m_bokthump;
?>
  <div class="panel panel-default mt30">
    <div class="panel-body">
    <div class="row">
  <div class="col-md-2">. 
  <img src="<?php echo $img_url;?>" class="img-thumb img-responsive" alt="Cinque Terre" width="1600" height="1067"></div>
  <div class="col-md-7">
      <p class="mt30"><strong><?php echo $prod->m_boktitle;?>
      </strong></p>
              <p style="text-align:justify;"><?php echo limit_text($prod->m_bokdesc,50);?></p>
              <p><ul class="list-inline news-v1-info">
							<li><span>By</span> | <?php echo limit_text($prod->m_bokauthorname,20);?></li>
							
                            
                            <li></li>
						</ul></p>
  </div>
  <div class="col-md-3 text-right mt30">
  <!-- <div class=""><select name="Subscription Type
" class="countries form-control" id="Subscription">
                    <option selected="selected">Subscription Type
</option>
                    <option value="1" countryid="1">Single User</option>
                    </select></div>
    <h4>$130.00 </h4> -->
     <?php if(!empty($_REQUEST['GUID']))
	 {
		 ?>
    <p><a href='<?php echo site_url('/Description?id='.$prod->m_bokid.'&GUID='.$_REQUEST['GUID'])?>'><button type="button" class="btn btn-primary btn-sm">More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a></p>
   <?php 
    }
	else 
	{
		?>
<p><a href='<?php echo site_url('/Description?id='.$prod->m_bokid)?>'><button type="button" class="btn btn-primary btn-sm">More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a></p>

<?php 
}
?>
  </div>
</div>
</div>
</div>
  <?php
   }
  ?>
</div>
	</div>
</form>
</body></html>