 <?php if($this->tank_auth->is_user_admin()){
	?> 
	
	<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<style>

.content2 {
	padding: 20px 15px;
	background-color: #fff;
}
.color-white{
	color:#FFF;
}

.mt15{
	    margin-top: -15px;
}

.mt20{
	    margin-top: 20px;
}


.th-bg1{
	background:#337ab7;
	
	}
.th-bg2{
	background:#5cb85c;
	
	}	
.th-bg3{
	background:#f0ad4e;
	
	}	
.th-bg4{
	background:#5bc0de;
	
	}
</style>

<section class="container"> 
<?php //print_r($bookDetails);
foreach ($bookDetails as $book){
$totalBook=$book->totalBook;
}
foreach ($productDetails as $prod){
	$totalProduct=$prod->totalProduct;
}
foreach ($individualProduct as $individualProduct){
	$totalIndividual=$individualProduct->individualCount;
}
foreach ($institutionalProduct as $institutionalProduct){
	$totalInstitutional=$institutionalProduct->institutionalCount;
}
/*  foreach ($subscribedInstitute as $totalInstitutes){
	$totalSubsInstitute=$totalInstitutes->institutionsCount;
}  */
/* foreach ($totalIPBased as $ipCount){
	$totalIPSubs=$ipCount->countIP;
} */
//print_r($totalIPBased); die;
/*  foreach ($emailBased as $emailCount){
	$totalEmailSubs=$emailCount->countEmail;
}  */
/* foreach ($InstituteUser as $InstituteUserCount){
	$totalInsUsers=$InstituteUserCount->InstituteusersCount;
} */
/* foreach ($subscribedUser as $userCount){
	$totalIndUsers=$userCount->usersCount;
} */
 $totalUsers=$subscribedUser+$InstituteUser; 
  $subscribedInstitute=$emailBased+$totalIPBased;
//echo $totalUsers;
//print_r($subscribedUser);
//echo $bookDetails['totalBool'];

foreach($emailipBased as $emailip)
{
	$emailip = $emailip->countEmail;
	//echo $emailip; die;
}
?>

<div class="row">
  <div class="col-sm-12"><h2>DASHBOARD</h2>
</div>

  <div class="col-sm-12">
  <div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th  width="33%" class="color-white th-bg1">Total Book count
</th>
        
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><a href='<?php echo site_url('book_library/list_book') ; ?>' data-toggle="tooltip" title="Total Book  = <?php echo $totalBook;?> " ><?php echo $totalBook;?></a></td>
      </tr>
    
    </tbody>
  </table>
  </div>
  </div>
  
    <div class="col-sm-12 text-right mt15">
     <a href='<?php echo site_url('book_library/list_book') ; ?>'><button type="button" class="btn btn-primary btn-sm">More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a>
    </div>
    
<div class="col-sm-12 mt20">
  <div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th width="33%" class="color-white th-bg2">Total Product count</th>
        <th width="33%" class="color-white th-bg2">Available for Individual User</th>
        <th width="33%" class="color-white th-bg2">Available for Institutional User

</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><a href='<?php echo site_url('addProduct/productlist') ; ?> 'data-toggle="tooltip" title="Available for Individual User = <?php echo $totalIndividual;?> Available for Institutional User = <?php echo $totalInstitutional;?>" ><?php echo $totalProduct;?></a></td>
        <td><a href='<?php echo site_url('addProduct/productlist/1') ; ?>'><?php echo $totalIndividual;?></a></td>
        <td><a href='<?php echo site_url('addProduct/productlist/2') ; ?>'><?php echo $totalInstitutional;?></a></td>
      </tr>
    
    </tbody>
  </table>
  </div>
  </div>
  
    <div class="col-sm-12 text-right mt15">
     <a href='<?php echo site_url('addProduct/productlist') ; ?>'><button type="button" class="btn btn-success btn-sm">More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a>
    </div>
    
    
    <div class="col-sm-12 mt20">
  <div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th width="25%" class="color-white th-bg3">Total Institution Subscribed</th>
        <th width="25%" class="color-white th-bg3">IP Based</th>
        <th width="25%" class="color-white th-bg3">Multi User

</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td><a href='<?php echo site_url('institutePage/InstituteList/4')?>' data-toggle="tooltip"  title="IP Based=<?php echo $totalIPBased;?>, Multi User=<?php echo $emailBased;?>"><?php echo $subscribedInstitute;?></a></td>
        <td><a href='<?php echo site_url('institutePage/InstituteList/1')?>'><?php echo $totalIPBased;?></a></td>
        <td><a href='<?php echo site_url('institutePage/InstituteList/2')?>'><?php echo $emailBased;?></a></td>
		
      </tr>
    
    </tbody>
  </table>
  </div>
  </div>
  
    <div class="col-sm-12 text-right mt15">
    <a href='<?php echo site_url('institutePage/InstituteList')?>'> <button type="button" class="btn btn-warning btn-sm">More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a>
    </div>
    
    
    
    <div class="col-sm-12 mt20">
  <div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th width="33%" class="color-white th-bg4">Total User count</th>
        <th width="33%" class="color-white th-bg4">Individual User</th>
        <th width="33%" class="color-white th-bg4">Institutional User

</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><a href='<?php echo site_url('userPage/listUser/3')?>' data-toggle="tooltip"  title="Individual User = <?php echo $subscribedUser;?>, Institutional User =<?php echo $InstituteUser;?>"><?php echo $totalUsers;?></td>
        <td><a href='<?php echo site_url('userPage/listUser/1')?>'><?php echo $subscribedUser;?></a></td>
        <td><a href='<?php echo site_url('institutePage/InstituteList')?>'><?php echo $InstituteUser;?></a></td>
      </tr>
    
    </tbody>
  </table>
  </div>
  </div>
  
    <div class="col-sm-12 text-right mt15">
    <a href='<?php echo site_url('userPage/listUser')?>'> <button type="button" class="btn btn-info btn-sm">More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
</button></a>
    </div>
</div>




</section>
<!-- dashboard end -->
			
              			  
			</div>
		</div>
</div></body>
		<?php }else{ redirect(site_url('book_library/list_book')) ; }?>
		
		
