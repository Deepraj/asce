<!-- saved from url=(0057)http://asce.adi-mps.com/asce_service/index.php/auth/login -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ASCE</title>
	<link href="<?php echo base_url();?>css/bootstrap.min.css?version={ver}" rel="stylesheet">
	<link href="http://asce.mpstechnologies.com/asce/vendors/font-awesome/css/font-awesome.min.css?version={ver}" rel="stylesheet" type="text/css" />
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
<body>
  <?php 
  $data=array(); 
  $data=( explode('/',$_REQUEST['GUID']));
  ?>
	<div id="formControl">
		<div class="header">
         <div class="container">
         <div class="row">
         <div class="col-md-4"></div>
         <div class="col-md-4 col-xs-6"><img src="<?php echo base_url();?>/images/Logo_White_145x58.png"></div>
  <div class="col-md-4 text-right"><?php if(!empty($_REQUEST['GUID'])){ ?><a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?logoff=Y&ASCEURL=<?php echo base_url(); ?>" style="color: #FFFFFF; font-size:16px; font-weight:600">Logout</a><?php } ?></div>
  </div>
 </div>
</div>
<div class="view" style="text-align:right; padding-right:100px;padding-top:80px;">
  <a href='javascript:window.history.back();'>
 <button type="button" class="btn btn-primary btn-sm">View All Subscribe Product &nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
   </button></a></div>	
		<?php foreach($bookList as $bookdesc){
		
		$img_url=base_url().'../asce_content/book/'.$bookdesc->m_bokisbn.'/vol-'.$bookdesc->m_volnumber.'/cover_img/'.$bookdesc->m_bokthump;
		?>
        <div class="container">
          <div class="panel panel-default mt30">
          <div class="panel-body">
         <div class="row">
       <div class="detail-heading">Book Title: <?php echo $bookdesc->m_boktitle;?>
    </div>
  <span class="col-md-2"><img src="<?php echo $img_url;?>" class=" detail-img-thumb img-responsive" alt=""></span>
    <div class="col-md-7" style="padding-left: 40px;"> 
               <br><br>
               <p><b>Author Name : </b><?php echo $bookdesc->m_bokauthorname; ?> </p>  
               <p style="text-align:justify;"><b>Description : </b> <?php echo $bookdesc->m_bokdesc; ?></p>      
    </div>
  <div class="col-md-3 text-right mt30">
  <?php
    
    //$userdata = $this->session->get_userdata('user_id'); 
   //echo "<pre>Jio";print_r($userdata['user_id']);die;
   //$this->session->get_userdata('user_id')
   ?>
  
   <!-- <h4><input type='radio' name='mem_type' value='member'>Member <input type='radio' name='mem_type' value='non_member'>Non Member</h4>-->
  <p><a href='http://asce.mpstechnologies.com/asce_service/index.php/Authentication/index/PRIMARY/<?php echo $bookdesc->m_bokid; ?>/<?php echo $bookdesc->m_bokid."/".$data[1]; ?>'><button type="button" class="btn btn-primary btn-sm" id='buy_now'>Read Now
 &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a></p>
  </div>
</div>
</div>
</div>
</div>
<?php }?>

<?php
 $guid = $_REQUEST['GUID']; 
 $guids = explode("/",$guid);
 //print_r($guids[0]); die;
 $lvar="http://".$_SERVER['HTTP_HOST'];
		$lvars =$lvar.'/products/'.'?GUID='.$guids[0];		
		    	 
?>
 <div class="view" style="text-align:right; padding-right:100px;">
  <a href=<?php echo $lvars;?>>
 <button type="button" class="btn btn-primary btn-sm">View All Book &nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
   </button></a></div>
 </div>
</div>
</body></html>