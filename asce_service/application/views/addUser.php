<?php error_reporting(0);?>
<?php 
if(count($subscriptions)>0)
	$subsCount=count($subscriptions);
else $subsCount=1;
$prod='';
foreach($prodList as $key=>$value){
	$prod.="<option value='$key'class='form-control'>$value</option>";
}
?>
<script type="text/javascript">
<!--Function for Adding Subscriptions-->
var subsRowCount=<?php echo $subsCount;?>;
function add_subs()
{
	subsRowCount++;
	prodList="<?= $prod;?>";
	document.getElementById('no_of_subs').value=10;
	var html = '<tr id="subsrow'+subsRowCount+'"><td> <select name="product'+subsRowCount+'" class="form-control" required>'+prodList+'</select></td><td><select name="currency'+subsRowCount+'" class="form-control" required><option value="1">US</option><option value="2">AU</option></select></td><td> <input type="text" name="price'+subsRowCount+'" value="" id="price" for="Subscription Price" class="form-control" required></td><td> <select name="subsStatus'+subsRowCount+'" class="form-control" required><option value="1">Active</option><option value="0">InActive</option></select></td><td> <input type="date" name="startDate'+subsRowCount+'" value="" id="startDate'+subsRowCount+'" for="valid Start Date" class="form-control datepicker" maxlength="5" size="13" required></td><td> <input type="date" name="endDate'+subsRowCount+'" value="" id="endDate" for="Valid End Date" class="form-control datepicker" maxlength="5" size="13" required></td><td><a href="javascript:remoove_subs('+subsRowCount+')" id="trash0" data-row="0" class="btn btn-danger btn-xs subsdelete"><i class="fa fa-trash-o "></i></a></td></tr>';
	$("#subs_Table").append(html);
}
<!--------------End--------------------->
<!----------------------------Function For Remooving Subscription--------------------------------->
function remoove_subs()
{
	$('#subsrow'+subsRowCount).remove();
	subsRowCount--;	
	document.getElementById('no_of_subs').value=subsRowCount;
	alert(document.getElementById('no_of_subs').value);
}
<!--------------------------------------------End------------------------------------------------->
</script>
<div class="adminPopupPanel">
	<div class="heading">
		<span class="title">
          <?php
										if ($subscriptions != 0)
											echo "MANAGE USER";
										else
											echo "ADD USER";
										?>    
		  <br>
		<br>
		</span>
	</div>
	<div class="container">

		<div class="row">
<div class="col-sm-3"></div>
<div class="col-sm-7">
<!-- ----------------------------Success Message will shown here -->
	<!-- <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong>
    Product have added to your wishlist.
</div> -->
<!-- -----------------------------------------End----------------------->
</div>
			<div class="col-sm-12">


				<div class="row tab-v3">
					<div class="col-sm-3  ">
						<ul class="nav nav-pills nav-stacked">
							<li class="active" id="step_1"><a href="#regStep_1"
								data-toggle="tab" aria-expanded="true">User Details</a></li>
							<?php
							
						//if($m_licence_type=='SINGLE')
						//{?>
						
						
							<li class="" id="addSubscriptionsTab"><a href="#addSubscription" data-toggle="tab"
								aria-expanded="true">View Subscriptions</a></li>
								<?php
						//}
						?>
						</ul>
					</div>
					<div class="col-sm-9">
						
							<div class="tab-content">
							<!-- -----------Tab One -->
								<div class="tab-pane fade active in" id="regStep_1">
									<div class="form-group  row">
										<div class="col-sm-6">
											<label class="control-label "> Master Customer ID : </label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $masterid;?>" readonly="readonly">
											
										</div>
										<div class="col-sm-6">
											<label class="control-label ">Sub Customer ID : </label>
											<input type="text" name="sub_id" class="form-control" value="<?php echo $sub_id;?>" readonly="readonly">
											
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6">
											<label class="control-label "> Customer Type :</label>
											<input type="text" name="cust_type" class="form-control" value="<?php echo $cust_type;?>" readonly="readonly">
											
										</div>
										<div class="col-sm-6">
											<label class="control-label "> Label Name : </label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $lablename;?>" readonly="readonly">
											
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6">
											<label class="control-label "> First Name :</label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $firstname;?>" readonly="readonly">
											
										</div>
										<div class="col-sm-6">
											<label class="control-label "> last Name : </label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $lastname;?>" readonly="readonly">
											
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6">
											<label class="control-label "> Primary Emailid :</label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $primarymail;?>" readonly="readonly">
											
										</div>
										<div class="col-sm-6">
											<label class="control-label "> Online Emailid : </label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $onlinemale;?>" readonly="readonly">
											
										</div>
										<div class="col-sm-6">
											<label class="control-label "> status : <input type="checkbox" name="ip_add" id="ip_add" disabled="disabled" class="form-check" <?php if($adminstatus=='A'){echo "checked";}?>></label>
											
											
										</div>
									</div>
									<div class="col-sm-12 pull-left pad0  ">
									<?php	if($m_licence_type=='SINGLE')
										{
											?>
									
										<input type="submit" name="addInstitutenext"
											id="addInstitutenext" value="Next ">
											
										<?php
										}
										?>
											
										<?php	if($m_licence_type!='SINGLE')
										{
											if(empty($Ipids))
											{
											?>
										<a href='<?php echo site_url('InstitutePage/addInstitute/'.$id.'/'.$m_licence_type) ; ?>' data-toggle="tooltip" title="Go To Institutions "><input type="submit" name="addInstitutenext"
											 value="Go To Institutions "></a>
											 
											 
											 
											 
											<?php
											}
											else{
												?>
												<a href='<?php echo site_url('InstitutePage/addInstitute/'.$Ipids.'/'.$m_licence_type) ; ?>' data-toggle="tooltip" title="Go To Institutions "><input type="submit" name="addInstitutenext"
											 value="Go To Institutions "></a>
												
												
											<?php }
										}
												
											?>
											
								</div>
									<br>
									<br>
								</div>
								<!-- --------End Tab One Start Tab 2 -->
							
								<!-- ---------------------------End Tab 2 Start Tab 3 -->
								<div class="tab-pane fade <?php echo $active4;?>" id="addSubscription">
                               
				<div class="box-body table-responsive">
					<table class="table table-bordered" id='subs_Table'>
						<tbody>
						<tr>
								<th width="20%">Order ID</th>
								<!--<th width="5%">Concurrent users </th>-->
								<th >Product ID</th>
								<th >Product Name</th>
								<th >Status</th>
								<th >Start Date</th>
								<th >End Date</th>
								<th >Licence Type</th>
								<th >Concurrent Users</th>
							</tr>
							<!-- -------For Edit Subscription       -->
							<?php 
							if($subscriptions){
								$totSubscriptions=count($subscriptions);
							for($i=0;$i<$totSubscriptions;$i++){
								$col=$i+1;
								$prod_id=$subscriptions[$i]['product_id'];
								$curr_id=$subscriptions[$i]['currency_id'];
								$status_id=$subscriptions[$i]['status'];
								?>
							
							 <tr id="subsrow<?php echo $col;?>">
								<td><input style="width:115px;" type="text" name="order<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['order_id']?>"  readonly="readonly"></td>
								<td><input style="width:115px;" type="text" name="prodname<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['product_id']?>"  readonly="readonly"></td>
								<td><input style="width:325px;" type="text" name="prodname<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['product_name']?>"  readonly="readonly"></td>
								<td><input style="width:100px;" type="text" name="prodname<?php echo $col;?>" class="form-control" value="<?php echo ($subscriptions[$i]['line_status']=='A')? 'Active':'Cancelled';?>"  readonly="readonly"></td>
								
								<td>
								<input style="width:100px;" type="text" name="startDate<?php echo $col;?>" value="<?php $date=date_create($subscriptions[$i]['start_date']); echo date_format($date,'m/d/Y'); ?>" class="form-control datepicker" readonly="readonly">
								
								</td>
								<td>
								<input style="width:100px;" type="text" name="endDate<?php echo $col;?>" value="<?php 
								$enddate=date_create($subscriptions[$i]['end_date']);
								echo date_format($enddate,'m/d/Y');?>" id="insEndDate<?php echo $col;?>" for="End Date" class="form-control datepicker"  readonly="readonly">
								
								</td>
								<td><input style="width:116px;" type="text" name="prodname<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['licence_type']?>"  readonly="readonly"></td>
								<td><input style="width:auto;" type="text" name="prodname<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['licence_count']?>"  readonly="readonly"></td>
								
								
							</tr>
							<?php
							}
						} else {?>
							<!-- ------------End Edit Subscription -->
						  <tr id="subsrow1">
							<td colspan="8">No Subscription Yet</td>	
							</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
                               <br><br>
							</div>
								<!-- -------------------------------------End Tab 3 -->
							</div>
						</form>
					</div>
				</div>
				<br>
				<br>
			</div>
		</div>
		<!--Ashwani Tab end-->
	</div>
</div>
<!-- ---------------------Script Code For All Validations ----------->
<script type="text/javascript">
$("#addInstitutenext").click(function() {
                	  
                	 $( "#step_1" ).removeClass( "active" );
                	  $( "#addSubscriptionsTab" ).addClass( "active" );
                	  $( "#regStep_1" ).removeClass( "active in" );
                	  $( "#addSubscription" ).addClass( "active in" );
                	
                	 
                  });

/*----------------------------------Generating Triggers---------------------------------  */

$("#addSubscriptionsTab" ).click(function() {
	$( "#addInstitutenext" ).trigger( "click" );
	 $( "#registration-page" ).trigger( "click" );
	 if($('#user_Id').val()!=''){
		$( "#step_1" ).removeClass( "active" );
 		$( "#regStep_1" ).removeClass( "active in" );
	 }
         $( "#addSubscription" ).addClass( "active in" );
	 return false;
});
/*-------------------------------------------End Code for Validation-------------------- */
                  /*--------------For Focus Out--------------*/
                  $('.form-control').focusout(function() {
			if($(this).val()!=''){
			$(this).next().html("");
			$(this).css("border"," 1px solid #ccc");
			}
			});
 </script>
 <script type="text/javascript">

 $(document).ready (function(){
                $("#success-alert").alert();
                $("#success-alert").fadeTo(2000, 100).slideUp(500, function(){
               $("#success-alert").alert('close');  
            });
 });
 </script>
<!-----------------------------------End Script Validation--------------------------->
</body>
</html>