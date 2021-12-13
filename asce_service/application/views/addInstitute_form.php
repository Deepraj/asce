 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<?php error_reporting(0);?>
 <?php
$lvar="http://".$_SERVER['HTTP_HOST'];
//echo $lvar; die;
$urls=$lvar.'/asce_service/index.php/institutePage';
//echo $bookdelete; die;
?>
<?php 
 ###################For Generating Dynamic URL's
$this->load->helper('url');
$url=current_url();
$urlparts = explode('/', $url); // explode on slash
array_pop($urlparts); // remove last part
$url = implode($urlparts, '/');
//$urls="https://localhost/americanSociety/asce_service/index.php/institutePage";
$urlInstituteId=$url.'/checkInstituteID';
$urlInstitueemail=$urls.'/deleteInstituteemail';
$editeurlInstitueemail=$urls.'/editeurlInstitueemail';
$urlInstituteAdminEmail=$url.'/checkInstituteEmailID';
$checkurlInstituteAdminEmail=$url.'/checkediteInstituteEmailID';
$urlInstituteAdminUserName=$url.'/checkInstituteUserName';
$urlInstituteIPRange=$url.'/checkIPRange';
$urlInstituteIPRange=str_replace('/addInstitute', '', $urlInstituteIPRange);
####################For Getting All Products
$prod='';
foreach($prodList as $key=>$value){
								$prod.="<option value='$key'class='form-control'>$value</option>";
								 }
####################################################Getting Tab Values
$tabValue=$this->input->get('tab', TRUE);
if(isset($tabValue))
{
	$tab1=($tabValue == '1') ? 'active' : '';
	$active1=($tabValue == '1') ? 'active in' : '';
	$tab2=($tabValue == '2') ? 'active' : '';
	$active2=($tabValue == '2') ? 'active in' : '';
	$tab3=($tabValue == '3') ? 'active' : '';
	$active3=($tabValue == '3') ? 'active in' : '';
	$tab4=($tabValue == '4') ? 'active' : '';
	$active4=($tabValue == '4') ? 'active in' : '';
	$tab5=($tabValue == '5') ? 'active' : '';
	$active5=($tabValue == '5') ? 'active in' : '';
	$tab6=($tabValue == '6') ? 'active' : '';
	$active6=($tabValue == '6') ? 'active in' : '';
	$tab7=($tabValue == '7') ? 'active' : '';
	$active7=($tabValue == '7') ? 'active in' : '';
}
#####################################################End	
 print_r($adminid);						 
if(count($allIPaddres)>0)
$ipCount=count($allIPaddres);
else $ipCount=1;
if(count($subscriptions)>0)
	$subsCount=count($subscriptions);
else $subsCount=1;
if(count($allRefferals)>0)
	$refCount=count($allRefferals);
else $refCount=1;
?>
<!-- ----------Java Script Functions For Adding IP Address Fields -->
<script type="text/javascript" class="init">
	
$.extend( true, $.fn.dataTable.defaults, {
    "searching": false
} );
$(document).ready(function() {
	
	//console.log(data);
	$('#example').DataTable( {
   "ordering": false,
	
       
		
    } );
	 
} );
	</script>
<script>
var rowCount = <?php echo $ipCount;?>;
var refRowCount=<?php echo $refCount;?>;
var subsRowCount=<?php echo $subsCount;?>;
//alert(subsRowCount); die;
function add_ipRow()
{
	rowCount ++;
	document.getElementById('no_of_ips').value=rowCount;
     var html = '<tr id="ipRow'+rowCount+'"><td><select name="insIpVersion'+rowCount+'"  id="insIpVersion'+rowCount+'" data-row="' + rowCount + '" class="form-control ipversion"><option value="4">IPv4</option><option value="6">IPv6</option></select></td><td><input type="text" name="insMinIp'+rowCount+'" value="" id="insMinIp'+rowCount+'" for="Min IP " class="form-control minip" oninput=checkIPStatus("insMinIp'+rowCount+'")></td><td> <input type="text" name="insMaxIp'+rowCount+'" value="" id="insMaxIp" for="Max IP" class="form-control maxip" oninput=checkIPStatus("insMaxIp'+rowCount+'")></td><td> <select name="ipStatus'+rowCount+'" class="form-control"><option value="1">Active</option><option value="0">InActive</option></select></td><td><a href="javascript:remoove_IP('+rowCount+')" id="trash0" data-row="0" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></i></a></td></tr>';
	// alert(html);
     $("#tblIPAddress").append(html);
	   $('input[name="insMinIp' + rowCount + '"]').rules("add", {
                required: true, ipv4: true,notEqualToGroup:['.minip']
            });
            $('input[name="insMaxIp' + rowCount + '"]').rules("add", {
                required: true, ipv4: true, greaterThanIP:'#insMinIp'+rowCount+''
            });

}
function add_refrellRow()
{
	refRowCount++;
	document.getElementById('no_of_refs').value=refRowCount;
	 var html = '<tr id="refRow'+refRowCount+'"><td> <input type="email" name="insEmail'+refRowCount+'" value="" id="insEmail'+refRowCount+'" maxlength="200" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,3}$" size="30" for="Institute Email" class="form-control"></td><td><input type="text" name="insFirstName'+refRowCount+'" value="" id="insFirstName'+refRowCount+'" maxlength="25"  pattern="[a-zA-Z]+" title="Enter Only Alphabets"  size="30" for="First Name" class="form-control"></td><td> <input type="text" name="insMiddleName'+refRowCount+'" value="" id="insMiddleName'+refRowCount+'" maxlength="25"  pattern="[a-zA-Z]+" title="Enter Only Alphabets"  size="30" for="Middle Name" class="form-control"></td><td>  <input type="text" name="insLastName'+refRowCount+'" value="" id="insLastName'+refRowCount+'" maxlength="25"  pattern="[a-zA-Z]+" title="Enter Only Alphabets" size="30" for="Last Name" class="form-control"></td><td>  <input type="text" name="insProductid'+refRowCount+'" value="" id="insProductid'+refRowCount+'" maxlength="25"  pattern="[a-zA-Z]+" title="Enter Only Alphabets" size="30" for="Last Name" class="form-control"></td><td><a href="javascript:remoove_RefURL('+refRowCount+')" id="trash0" data-row="0" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></i></a></td></tr>';
     $("#example").append(html)
}
function add_subs()
{
	subsRowCount++;
	prodList="<?= $prod;?>";
	document.getElementById('no_of_subs').value=subsRowCount;
	var html = '<tr id="subsrow'+subsRowCount+'"><td> <select name="insProducts'+subsRowCount+'" class="form-control">'+prodList+'</select></td><td><select name="insCurrency'+subsRowCount+'" class="form-control"><option value="1">US</option><option value="2">AU</option></select></td><td> <input type="text" name="insPrice'+subsRowCount+'" value="" id="insPrice" for="Subscription Price" class="form-control"></td><td> <select name="subsStatus'+subsRowCount+'" class="form-control"><option value="1">Active</option><option value="0">InActive</option></select></td><td> <input type="date" name="insStartDate'+subsRowCount+'" value="" id="insStartDate'+subsRowCount+'" for="valid Start Date" class="form-control datepicker" maxlength="5" size="13"></td><td> <input type="date" name="insEndDate'+subsRowCount+'" value="" id="insEndDate" for="Valid End Date" class="form-control datepicker" maxlength="5" size="13"></td><td><a href="javascript:remoove_subs('+subsRowCount+')" id="trash0" data-row="0" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></i></a>';
	$("#subs_Table").append(html);
}
function remoove_IP(rowid,rowNum)
{
	//alert(rowid);
if(confirm('Are you sure to delete this item?'))
{
 $('#ipRow'+rowNum).remove();
 //rowCount--;
 
  var urlRef="<?php echo $urls;?>/deleteiprow";
	$.ajax({
			type: "POST",
			url: urlRef,
			data: { rowid:rowid },
			success: function(data)
			{
			  location.reload();
				//serializeValue();
				//redirect('institutePage/addInstitute/'.$id.'?tab=5', 'refresh');
			}
		});
 
 
 document.getElementById('no_of_ips').value=rowCount;
 }
 else
 {
 }
}


</script>

<div class="modal fade" id="memberModals1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom">
<div class="modal-header" id="mod-header">
<h4 class="modal-title" id="myModalLabel">ASCE</h4>
</div>
<div class="modal-body">
<script>
function remoove_RefURL(refRow){
	   //alert(id);
	  // window.location='<?php echo site_url();?>/'+'MuserAdmin/deleteSubUser/'+id;
	  $('#memberModals1').modal('show');
	  // $('#myModal').modal('show');
	   $("#okbtn").attr("data-dismiss",refRow);
	}
	function deleteData(obj){
		
		
		var refRow=obj.getAttribute("data-dismiss");
		
		$('#refRow'+refRow).remove();
		
		var table = $('#example').DataTable();
        table.rows( '#refRow'+refRow ).remove().draw();
         
		var urlRef="<?= $urlInstitueemail;?>";
	$.ajax({
			type: "POST",
			url: urlRef,
			data: { emailCode:refRow },
			success: function(data)
			{
			   
				serializeValue();
				 $('#memberModals1').modal('hide');
				//alert(data);	
			}
		});
	}
</script>Do you want to delete subuser? 
</div>
<div class="modal-footer" id="mod-footer">
<button type="button" class="btn btn-primary" data-dismiss="" id="okbtn" onclick="deleteData(this);">Ok</button>
<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
</div>
</div>
</div>
</div> 
<script>
function closeFunct(){
	$('#result').hide();
	$('#editeemail').prop("disabled", false);
	 $('#editeemail').removeClass("btn btn-info disabled");	
	$('#editeresult').hide();
	var htmlSave="";
	$('#aaa').val("save");
}
function edite_RefURL(refRow)
{
	
 var urlRef="<?= $editeurlInstitueemail;?>";
 //alert(urlRef);
	$.ajax({
			type: "POST",
			url: urlRef,
			 dataType :'json',
			data: { emailCodes:refRow },
			success: function(data) {
console.log(data);
	debugger;
	
	var html='';
	$.each(data,function(i,e){
		//console.log(data);
		html+='<tr id="refRow">';
			html+='<td><input type="hidden" name="edithrefid" id="edithrefid" value="'+e.http_referer_id+'" maxlength="30"  size="30" for="Institute Email" class="form-control" ></td>';
			
			html+='<td><input type="hidden" name="userid" value="<?php echo $id;?>" size="20" /> </td> ';
			html+='<td><input type="hidden" name="editeorderid" id="editeorderid" value="'+e.order_id+'" maxlength="200"  size="30" for="Institute Email" class="form-control" ></td>';
			
			html+='<td><label>Email</label><input type="email" name="Email" onkeyup="myFunction()" id="Email" value="'+e.email+'" maxlength="200"  size="30" for="Institute Email" class="form-control" title="Invalid Email"></td>';
			
			html+='<td>&nbsp;</td><td><label>First Name</label><input type="text" name="insFirstName1" value="'+e.first_name+'" id="insFirstName1" maxlength="25" title="Enter Only Alphabets" size="30" for="First Name" class="form-control"></td>';
			
			html+='<td>&nbsp;</td><td><label>Last Name</label><input type="text" name="insLastName1" value="'+e.last_name+'" id="insLastName1" maxlength="25" pattern="[a-zA-Z]+" title="Enter Only Alphabets" size="30" for="Last Name" class="form-control"></td>';
			
			html+='</tr>';
					 
		 });
	//alert(html);
	//$('#aaa').val("update");
	$('#editemail tbody').html(html);

	
								
  }
		});
 

// alert(aa);
 }
function myFunction()
{
	var editemail=$('#Email').val();
	var hrefid=$('#edithrefid').val();
	var editeorderid=$('#editeorderid').val();
	//alert(editeorderid);
	var urlRef="<?php echo $urls;?>/checkediteInstituteEmailID";
	//alert(urlRef);
	$.ajax({
			type: "POST",
			url: urlRef,
			data: { editemail:editemail,hrefid:hrefid,editeorderid:editeorderid },
			success: function(data)
			{
				//console.log(data);
				if(data==true)
				{
					$('#editeemail').prop("disabled", true);
	                $('#editeemail').addClass("btn btn-info disabled");
					//$('#result12').html('Institute Code Already Exist...');
					//$('#instituteCode').focus();
					$("#editeresult").text(" Email already exist...");
    //$("#result").css("color", "red");
	                 $("#editeresult").show();
	                   $("#Email").focus(); 
				}	
				else
				{
				$('#editeemail').prop("disabled", false);
	                $('#editeemail').removeClass("btn btn-info disabled");	
					$("#editeresult").hide();
				}
			}
		});
	
}
 function myaddemailFunction()
 {
	var addemail=$('#insEmail').val(); 
	var addemailorderid=$('#ProductNameAddEmail').val().split('#');
	//alert(addemailorderid[0]);
	
	var urlRef="<?php echo $urls;?>/checkaddemailInstituteEmailID";
	//alert(urlRef);
	$.ajax({
			type: "POST",
			url: urlRef,
			data: { addemail:addemail,addorderid:addemailorderid[0] },
			success: function(data)
			{
				//console.log(data);
				if(data==true)
				{
					$('#aaa').prop("disabled", true);
	                $('#aaa').addClass("btn btn-info disabled");
					//$('#aaa').html('Email Already Exist...');
					//$('#instituteCode').focus();
					$("#result").text(" Email already exist...");
    //$("#result").css("color", "red");
	                 $("#result").show();
	                   $("#insEmail").focus(); 
				}	
				else
				{
				$('#aaa').prop("disabled", false);
	                $('#aaa').removeClass("btn btn-info disabled");	
					$("#result").hide();
				}
			}
		});
 }

function remoove_subs()
{
	$('#subsrow'+subsRowCount).remove();
	subsRowCount--;	
	document.getElementById('no_of_subs').value=subsRowCount;
}
////////Ajax Code For Institute Code Checking
function checkInstituteCode(insCode)
{
	var urlRef="<?= $urlInstituteId;?>";
	$.ajax({
			type: "POST",
			url: urlRef,
			data: { instituteCode:insCode },
			success: function(data)
			{
				if(data==true)
				{
					$('#institute_result').html('Institute Code Already Exist...');
					$('#instituteCode').focus();
				}	
				else
				{
					$('#institute_result').html('');
				}
			}
		});
}
///////////////////////End
////////Ajax Code For Institute Institute Admin E-mail Id
function checkInstituteAdminEmailId(email)
{
	var urlRef="<?= $urlInstituteAdminEmail;?>";
	$.ajax({
			type: "POST",
			url: urlRef,
			data: { adminEmail:email },
			success: function(data)
			{
				if(data==true)
				{
					$('#email_result').html('Email Id Already Exist...');
					$('#email').focus();
				}	
				else
				{
					$('#email_result').html('');
				}
			}
		});
}
///////////////////////End
////////Ajax Code For Institute Institute Admin User Name
function checkInstituteAdminUserName(userName)
{
	var urlRef="<?= $urlInstituteAdminUserName;?>";
	
	$.ajax({
			type: "POST",
			url: urlRef,
			data: { adminUserName:userName },
			success: function(data)
			{
				if(data==true)
				{
					$('#userName_result').html('User Name Already Exist...');
					$('#userName').focus();
				}	
				else
				{
					$('#userName_result').html('');
				}
			}
		});
}
/*---------------------------Will Check IP Validation--------------------------*/
function checkIPStatus(obj)
{
	//debugger;
	IPRange=$('#'+obj).val();
	//alert(IPRange);
	var urlIPRange="<?= $urlInstituteIPRange;?>";
	//alert(urlIPRange);
	$.ajax({
			type: "POST",
			url: urlIPRange,
			data: { IPRangeValue:IPRange },
			success: function(data)
			{
				//alert(data);
				if(data==true)
				{
					alert("This IP range is already registered. ");
					$('#'+obj).css("border","1px solid red");
					$('#'+obj).focus();
					$('#'+obj).val("");
					return false;
					
				}	
				else
				{
					
				}
			}
		});
	//$('#'+obj).next().html("Please Enter Street Address.");
}

//$(document).ready(function(){
 //   $('[data-toggle="tooltip"]').tooltip();
//});

///////////////////////End

function checkipbstatus()
{
$('#submitipaddress').val('Processing.....');
$('#submitipaddress'). attr('disabled', true);
productid =$('#ProductNameAddEmail1').val();
masterid =$('#usermaster1').val();
MinIPRange=$('#MinIp').val();
MaxIPRange =$('#MaxIp').val();

setTimeout(function(){ 
    $('#submitipaddress').val('Submit');
    $('#submitipaddress'). attr('disabled', false); 
},4000);

var flagvalue=true;
debugger;
	//alert(IPRange);
	var urlIPRange="<?php echo $urls;?>/checkIPPopupRange";
	//alert(urlIPRange);
	$.ajax({
			type: "POST",
			url: urlIPRange,
			data: { MinIPRange:MinIPRange,MaxIPRange:MaxIPRange,productid:productid,masterid:masterid },
			success: function(data)
			{
				//alert(data);
			if(data==true)
				{
					
					$("#result12").text( "This IP range is already registered."); 
	                 $("#result12").show();
					$('#MinIp').val("");
                    $('#MaxIp').val("");   
                    $('#ipStatus1').val('');
                    $('#submitipaddress').val('Submit');
                                        $('#submitipaddress'). attr('disabled', false);
					flagvalue= false;
					
				}	
				else
				{
					flagvalue= true;
				}
			}
		});
		return flagvalue;

}

function checkipblank()
{
	

productname =	$('#ProductNameAddEmail1').val();
MinIPRange=$('#MinIp').val();
MaxIPRange =$('#MaxIp').val();
ipStatus =$('#ipStatus1').val();
	if(MinIPRange=="")
{
	$("#result12").text( "Please Fill The Minimum IP-Address");  
	 $("#result12").show();
	 return false;
}
   if(MaxIPRange=="")
{
$("#result12").text( "Please Fill The Maximum IP-Address");  
	 $("#result12").show();
	 return false;
	
}
  if(productname=="")
 {
$("#result12").text( "Please Select The Licence Type / Status");  
	 $("#result12").show();
	 return false;
	
 }
  if(ipStatus=="")
 {
$("#result12").text( "Please Select The Licence Type / Status");  
	 $("#result12").show();
	 return false;
	
 }

}

</script>
<div class="adminPopupPanel">
			<div class="heading"><span class="title">
          <?php  
			
				echo "MANAGE INSTITUTION DETAIL";
			
			if($ip_detail=='IPBASED') $ipcls=''; else $ipcls='hidden_this';
			if($email_detail=="MULTI") $refcls=''; else $refcls='hidden_this';
			if($accessToken['value']==1) $tokencls=''; else $tokencls='hidden_this';
		  ?>    
		  <br><br>        
		  </span></div>
		  
          
          
    <!--Ashwani Tab start-->     
 <div class="container">
  <div class="row">
  <div class="col-sm-12">
  <div class="row tab-v3">
						<div class="col-sm-3  ">
							<ul class="nav nav-pills nav-stacked">
								<li class="<?php echo ($tabValue!='')? $tab1:'active';?>" id='addinstituteTab'><a href="#ADD-Institute" data-toggle="tab" aria-expanded="true">Institution Details</a></li>
							    <li class="<?php echo $tab2;?>" id='addinstituteSubsTab'><a href="#Add-Subscriptions" data-toggle="tab" aria-expanded="false">Institution Subscriptions</a></li>
                            	<li class="<?php echo $ipcls;?> <?php echo $tab5;?>" id='ip'><a href="#IP-Address" data-toggle="tab" aria-expanded="false">IP Based Authentication</a></li>
								<li class="<?php echo $refcls;?> <?php echo $tab6;?>" id='refferal_url'><a href="#Refferral" data-toggle="tab" aria-expanded="false">E-Mail Based Authentication</a></li>
                                
							</ul>
						</div>
						<div class="col-sm-9">
				<?php 
				echo form_open_multipart($this->uri->uri_string(),array('id'=>'myvalidationForm'));?>
							<div class="tab-content">                         
								<div class="tab-pane fade <?php echo ($tabValue!='')? $active1:'active in';?>" id="ADD-Institute">					
								<div class="form-group  row">
										<div class="col-sm-6">
											<label class="control-label "> Master Customer ID : </label>
											<input type="text" id="master_id" name="master_id" class="form-control" value="<?php echo $masterid;?>" readonly="readonly">
											
										</div>
										<div class="col-sm-6">
											<label class="control-label ">Sub Customer ID : </label>
											<input type="text" name="sub_id" class="form-control" value="<?php echo $sub_id;?>" readonly="readonly">
											
										</div>
									</div>
									
								<div class="form-group row">
										
										<div class="col-sm-6">
											<label class="control-label "> Label Name : </label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $lablename;?>" readonly="readonly">
											
										</div>
										<div class="col-sm-6">
											<label class="control-label "> Institution Name :</label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $firstname;?>&nbsp;<?php echo $lastname;?>" readonly="readonly">
											
										</div>
									</div>
							
									<div class="form-group row">
										<div class="col-sm-6">
											<label class="control-label "> Primary Email id :</label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $primarymail;?>" readonly="readonly">
											
										</div>
										<div class="col-sm-6">
											<label class="control-label "> Online Email id : </label>
											<input type="text" name="master_id" class="form-control" value="<?php echo $onlinemale;?>" readonly="readonly">
											
										</div>
									</div>
                          <div class="form-group row">
                        		
                          <div class="col-sm-6">
                           	<label class="control-label ">Admin Name : <a href="<?php echo site_url('userPage/User/'.$admin_id)?>"><?php echo $admin_firstname;?></a></label>		 
                               </div> 
							   <div class="col-sm-6 user"><br>
                              <label class="control-label ">Authentication Method :</label>
                             <input type="checkbox" name="ip_add" id="ip_add" disabled="disabled" class="form-check" <?php if($ip_detail=='IPBASED'){echo "checked";}?>> IP-based   <input type="checkbox" name="email_add" id="email_add"  disabled="disabled" class="form-check" <?php if($email_detail=='MULTI'){echo "checked";}?>> E-Mail Based
                             
                              </div>   
                                
                         	  <div class="col-sm-6" style="margin:top:-10px;">
											<label class="control-label ">status : <input type="checkbox" name="ip_add" id="ip_add" disabled="disabled" class="form-check" <?php if($adminstatus=='A'){echo "checked";}?>></label>
											
											
										</div>                       

						</div>
                          
                          <div class="col-sm-12 pull-left pad0  ">
						   <input type="button" id="addInstituteback"   class="cancel_btn" name="addInstituteback" value="Back">
							<input type="submit" name="addInstitutenext" id="addInstitutenext" value="Next ">
                             
							  </div><br><br>
                        
							</div>
<div class="alert alert-danger text-left" id="resultlicencecount" style="display: none;" > </div>								
							<div class="tab-pane fade <?php echo $active4;?>" id="Add-Subscriptions">
						   <br>
				          <div class="box-body table-responsive">
					       <table class="table table-bordered" id='subs_Table'>
						    <tbody>
						     <tr>
								<th >Order ID</th>
								<th >Product ID</th>
								<th>Product Name</th>
								<th >Start Date</th>
								<th >End Date</th>
								<th >Status</th>
								<th >Concurrent Users</th>
								<th >Negotiated Users </th>
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
								<td ><input  style="width:115px;" type="text" id="orderid<?php echo $col;?>" name="order<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['order_id']?>"  readonly="readonly"></td>
								
								<td><input style="width:115px;" type="text" name="prodname<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['product_id']?>"  readonly="readonly"></td>
								
								<td><input style="width:325px;" type="text" name="prodname<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['product_name']?>"  readonly="readonly"></td>
							<td>		
								<input style="width:100px;" type="text" name="startDate<?php echo $col;?>" class="form-control"value="<?php $date=date_create($subscriptions[$i]['start_date']); echo date_format($date,'m/d/Y'); ?>"  readonly="readonly" id="insstartDate"></td>					
								<td>
								<input style="width:100px;" type="text" name="endDate<?php echo $col;?>" class="form-control"value="<?php 
								$enddate=date_create($subscriptions[$i]['end_date']);
								echo date_format($enddate,'m/d/Y');?>"  readonly="readonly" id="insEndDate<?php echo $col;?>">
								
								
								
								
								
								
								
								
								
								
								
								
								
								</td>
								<td>
								<input style="width:100px;" type="text" name="prodname<?php echo $col;?>" class="form-control" value="<?php echo ($subscriptions[$i]['line_status']=='A')? 'Active':'Cancelled';?>" readonly="readonly" >
								
								
								</td>
								<td><input id="lic111" style="width:119px;" disabled type="text" required name="prodname<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['licence_count']?>">
								<?php echo validation_errors(); ?>
								</td>

                               <td>
							   <input <?php echo (isset($subscriptions[$i]['licence_count']) && $subscriptions[$i]['licence_count']!='N')?'disabled':''; ?> id="lic<?php echo $col;?>" style="width:116px;" type="number" required name="prodname<?php echo $col;?>" class="form-control" value="<?php echo $subscriptions[$i]['Nigotiate_count']?>" onchange="updateMultiLicence(<?php echo $col;?>)">
								<?php echo validation_errors(); ?>
								</td>	



								
								 
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
				<br>
				<!--submit button on edit ipbased ------->
				<?php  if($ip_detail=='IPBASED'){ ?>
					<div class="col-sm-12 pull-left pad0">
				     <div class="col-sm-6  pad0">
			          <input type="button" id="addInstituteIPSubscriptionBack"   class="cancel_btn" name="button" value="Back">
					  <input type="submit" name="addInstProdSubscrption" id='ProdSubNext' onclick='update(); return false;'  value="Next">               
					</div>
                   </div>
				   <?php } ?>
				<div class="col-sm-12 pull-left pad0  ">
														<?php if($ip_detail=='IPBased'){?>
														 <input type="button" id="addIPback"   class="cancel_btn" name="addIPback" value="Back">
															<input type="submit" name="addIPnext" id="addIPnext" value="Next ">
														<?php } else if($ip_detail=='' && $email_detail=='Multi'){?>
														<input type="button" id="addIPback"   class="cancel_btn" name="addIPback" value="Back">
															<input type="submit" name="addEmailnext" id="addEmailnext" value="Next ">
													<?php }else{}?>
                                
							
				 </div>
                             
							 <br><br>
							</div>
							
                       <div class="tab-pane fade <?php echo $active5;?>" id="IP-Address">
							<div class="alert alert-error  alert-dismissable" id="resultip" style="border: 1px solid #ff0000;position: relative; display:none">
       <strong>You have changed the status of IP
       </strong>
        <a href="#" class="close-msg btn btn-primary " data-dismiss="alert" aria-label="close" style=" position: absolute; top: 50%;margin-top: -17px;right: 10px;">Close</a></div>	
                                <div class="box addIpAddressTblContainer">
								
								<div>
								<select  name="Subscription1" id="ProductName1" class="form-control" style="width:209px;" onchange="return doipajjax();">
							
							 <option value=""> --- Select Subscription --- </option>	 
							<?php 
							 for($i=0;$i<$totSubscriptions;$i++)
							 {
								 ?>
						         
  <option value=<?php echo $subscriptions[$i]['product_id']; ?>><?php echo $subscriptions[$i]['product_name']?></option>
 
  
							 <?php 	}
	  ?>       
</select>      </div>
                              <div class="box-header text-right">
							  
					<button type="button" class="btn btn-primary btn-sm margin" id="addSubscriptions"  data-toggle="modal" data-target="#addIp">
						<i class="fa fa-plus-circle"></i> &nbsp;Add IP
					</button>
					 <!-- Modal content-->
					 </form>
					  <div class="modal fade" id="addIp"  role="dialog" >
				<div class="modal-dialog" style="background-color:white; border-radius: 5px;">

				<div class="modal-content" >

				<div class="modal-body"  >
				<form action ="<?php echo $urls;?>/insertaddip" method="post" name='instituteListssForm' >
				<div class=" text-left" id="result123" style="font-weight: bold; color:#015cab ;"  > Add IP</div>
				<hr >
			<div class="alert alert-danger text-left" id="result12" style="display: none;" > </div>

				<table>
				
				<tr id="refRow">
				<td>
          <label>&nbsp;&nbsp;	</label>
				<select  name="Subscription1"id="ProductNameAddEmail1" class="form-control" style="
    width: 135px;
">
				<option value=""> Select Subscription  </option>	
							<?php 
							 for($i=0;$i<$totSubscriptions;$i++)
							 {
								 ?>
								 
				<option value=<?php echo $subscriptions[$i]['product_id']; ?>><?php echo $subscriptions[$i]['product_name']?></option>


							 <?php 	}
				?>       
				</select>  </td>  
            <td>&nbsp;</td>				
				<td> 

				<label>IP Version</label>
				<select name='insIpVersionip' id="insIpVersionip"  class="form-control ipversionip" >
								
								<option value="4" selected="" class="form-control">IPv4</option>
								<option value="6" class="form-control">IPv6</option>
								</select>
				</td>
				
				<td>&nbsp;</td>
				<td>
				<label>Minimum IP</label>
				<input type="text" name="MinIp"  value="" id="MinIp" for="Low Ip" class="form-control minip" onblur="return checkIPStatusPop('MinIp');" >
				<input type="hidden" name="usermaster1" id="usermaster1" value="<?php echo $masterid;?>" size="20" />
				</td>
				<td>&nbsp;</td>
				<td>
				<input type="hidden" name="userid" value="<?php echo $id;?>" size="20" />
				</td>
				<td>&nbsp;</td>
				<td>  
				<label>Maximum IP</label>
				<input type="text" name="MaxIp" value="" id="MaxIp" for="Max Ip" class="form-control maxip" onblur="return checkIPStatusPop('MaxIp');">
				</td>
<td>  
				<label>Status</label>
				<select name='ipStatus1' id='ipStatus1' class="form-control" onchange="return checkipbstatus();">
								<option value=""> Select Status  </option>	
								<option value="1" class="form-control">Active</option>
								<option value="0"  class="form-control">InActive</option>
								</select>
				</td>
				</tr>
				</table>

				</div>
				<div class="modal-footer" style="background-color:">
				<input type="submit" id="submitipaddress" name="submit" value="Save" onclick="return checkipblank();" class="btn btn-primary btn-sm" ></button>
				</form>
				<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
				</div>
				</div>
				</div>
				</div>
					
					
					
					
					
					
					
					
					
					
					
					
					
				</div>  
                               <br>
				<div class="box-body table-responsive">
					<table class="table table-bordered" id='tblIPAddress'>
							<thead>
							<tr>
								<th width="20%">IP Version</th>
								<!--<th width="5%">Concurrent users </th>-->
								<th width="18%">Minimum IP</th>
								<th width="18%">Maximum IP</th>
								<th width="12%">Product Id</th>
								<th width="15%">Status</th>
								<th width="1%">Action</th>
							</tr>
							</thead>
							<tbody>
							<!-- --------------------For Edit IP Addresses -->
							<?php 
							if($allIPaddres){
								$totalips=count($allIPaddres);
							for($i=0;$i<$totalips;$i++){
								$col=$i+1;
								$ip_id=$allIPaddres[$i]['ip_version'];
								$status_ip=$allIPaddres[$i]['aui_status'];
								?>
								
							<tr id="ipRow<?php echo $col;?>">
								<td><select name='insIpVersion<?php echo $col;?>' id="insIpVersion<?php echo $col;?>" data-row="<?php echo $col;?>" class="form-control ipversion">
								<?php foreach($ipaddress as $key=>$value){?>
								<option value="<?php echo $key; ?>" <?php echo ($ip_id == $key) ? 'selected' : ''; ?> class='form-control'><?php echo $value;?></option>
								<?php }?>
								</select></td>
								<td><input type="text" name="insMinIp<?php echo $col;?>" value="<?php echo $allIPaddres[$i]['low_ip'];?>" id="insMinIp<?php echo $col;?>" for="Low Ip" class="form-control minip" readonly onchange="return checkIPStatus('insMinIp<?php echo $col;?>');" ></td>
								<td><input type="text" name="insMaxIp<?php echo $col;?>" value="<?php echo $allIPaddres[$i]['high_ip'];?>" id="insMaxIp<?php echo $col;?>" for="Max Ip" class="form-control maxip" readonly onchange="return checkIPStatus('insMaxIp<?php echo $col;?>');"></td>
								
								<td><input type="text" name="insproductid12<?php echo $col;?>" value="<?php echo $allIPaddres[$i]['productid'];?>" id="insproductid12<?php echo $col;?>" for="" class="form-control "></td>
								
								<td><select name='ipStatus<?php echo $col;?>' class="form-control abhi" onchange="status_change(<?php echo $allIPaddres[$i]['ipauth_id'];?>,<?php echo "'".$allIPaddres[$i]['master_id']."'";?>,this.value)">
								<?php foreach($status as $key=>$value){?>
								<option value="<?php echo $key; ?>" <?php echo ($status_ip == $key) ? 'selected' : ''; ?> class='form-control'><?php echo $value;?></option>
								<?php }?>
								</select></td>
								<td>
									<a onclick="javascript:remoove_IP(<?php echo $allIPaddres[$i]['ipauth_id'];?>,<?php echo $col;?>)" id="trash0" data-row="0" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></i></a>
								</td>
							</tr>
							<?php }}else{?>
							<!-- ---------------------------End Edit IP Address -->
                           
								<tr id="ipRow1">
								<td><?php echo form_dropdown($insIpVersion['id'],$insIpVersion['value'],$insIpVersion['title'],array('class'=>'form-control ipversion'));?></td>
								<td><?php echo form_input($insMinIp); ?></td>
								<td> <?php echo form_input($insMaxIp); ?></td>
								<td> <?php echo form_input($insproductid12); ?></td>
								<td> <?php echo form_dropdown($ipStatus['id'],$ipStatus['value'],$ipStatus['title'],array('class'=>'form-control'));?></td>
								<td>
									<a href="javascript:" id="trash0" data-row="0" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></i></a>
								</td>
							</tr>
								
							
							<?php }?>
                                                    </tbody>
					</table>
				</div>
				
				<div class="col-sm-12 pull-left pad0  ">
				     <div class="col-sm-6  pad0">
					 <a href="<?php echo site_url('institutePage/InstituteList') ; ?>">
			         <input type="button" id="11addInstituteIPAddressBack"   class="cancel_btn" name="button" value="Back"></a>
					<input type="submit" name="addInstituteIPAddressnext"  style="display:none" value="Save And Continue" id="saveip">
					</div>
				</div>
                      <br><br>
					  </div>
							</div>      
                         

				
                            <div class="tab-pane fade <?php echo $active6;?>" id="Refferral">
							<?php if(!empty($this->session->flashdata('messageadduser'))) {	?>
							<div class="alert alert-error  alert-dismissable" id="resultip" style="border: 1px solid #ff0000;position: relative; ">
							<strong><?php echo $this->session->flashdata('messageadduser');?>
							</strong>
        <a href="#" class="close-msg btn btn-primary " data-dismiss="alert" aria-label="close" style=" position: absolute; top: 50%;margin-top: -17px;right: 10px;">Close</a></div>
		
							<?php
							}
							?>
							<div>	
							<input type="hidden" id="usermaster1" value="<?php echo $masterid;?>" size="20"  />
							
							<select  name="Subscription"id="ProductName" class="form-control" style="width:209px;" onchange="return doajjax();">
							
							 <option value=""> --- Select Subscription --- </option>	 
							<?php 
							 for($i=0;$i<$totSubscriptions;$i++)
							 {
								  if(isset( $subscriptions[$i]['product_name']) && ($subscriptions[$i]['line_status']!="C") )
								 {
								 ?>
						         
  <option value=<?php echo $subscriptions[$i]['order_id']; ?>><?php echo $subscriptions[$i]['product_name']?></option>
 
  
							 <?php 	}}
	  ?>       
</select>      
</div>
							
							
							
                            <div class="box-header text-right">
							
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" ><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Bulk import </button>
					
			<div class="modal fade" id="myModal" role="dialog" >
			<div class="modal-dialog" style="background-color:white">

			<!-- Modal content-->
			<div class="modal-content">

			<div class="modal-body" >
			<p align='left'>
			<body>

			<form name ="ora" method="POST" action="" enctype="multipart/form-data" >
			<table>
      <tr>

           <td>
              <label>Select Subscription</label>
	                <select  name="Subscription"id="ProductNameBulk" class="form-control" style="width:189px;" onchange="return doajjax();">
							
							 <option value=""> --- Select Subscription --- </option>	 
							<?php 
							 for($i=0;$i<$totSubscriptions;$i++)
							 {
								  if(isset( $subscriptions[$i]['product_name']) && ($subscriptions[$i]['line_status']!="C") )
								 {
								 ?>
						         
                       	<option value="<?php echo $subscriptions[$i]['order_id']."#".$subscriptions[$i]['product_id']."#".$subscriptions[$i]['product_name']?>"><?php echo $subscriptions[$i]['product_name']?></option>
 
  
							 <?php 	}}
	                   ?>       
                      </select>    
            </td>

         <td> 
             <label>File upload</label>
			 <input type="file" name="userfile" id="pop" size="20" /></td>
			</tr>
               </table>

			<div id ="pop1" style="width: 225px; margin-left: -7px; color:red;">
			</div>
			<input type="hidden" name="usermaster" value="<?php echo $masterid;?>" size="20" />
			<br>
			<input type="submit" name="imageupload" onclick="return(check());" value="Submit">
			</form> 



			</body>
			</p>

			</div>
			<p align='left' style="color:red; margin-left:10px;"><b>The following data formats are acceptable to upload bulk emails: .xml, .xlsx, .csv, .txt. Please provide the following fields in the file: email address, first name, and last name of authorized users. Upload file and click Submit. </b></p>
			<div class="modal-footer" style="background-color:">
			<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>

			</div>
			</div>

			</div>
			</div>
		 
					<button type="button" class="btn btn-primary btn-sm margin" id="addSubscription"  data-toggle="modal" data-target="#addEmail">
						<i class="fa fa-plus-circle"></i> &nbsp;Add Sub Users
					</button>
					 <!-- Modal content-->
					 
					  <div class="modal fade" id="addEmail"  role="dialog" >
				<div class="modal-dialog" style="background-color:white; border-radius: 5px;">

				<div class="modal-content" >

				<div class="modal-body"  >
				<form action ="<?php echo $urls;?>/insertaddemail" method="post" name='instituteListForm' >
				<div class=" text-left" id="result12" style="font-weight: bold; color:#015cab ;"  > Add Sub Users</div>
				<hr >
				<div class="alert alert-danger text-left" id="result" style="display: none;" > </div>

				<table id="addemail">
				
				<tr id="refRow">
				<td>
          <label>&nbsp;&nbsp;	</label>
				<select  name="Subscription"id="ProductNameAddEmail" class="form-control" style="
    width: 150px;
">
				<option value=""> Select Subscription  </option>	
							<?php 
							 for($i=0;$i<$totSubscriptions;$i++)
							 {
								  if(isset( $subscriptions[$i]['product_name']) && ($subscriptions[$i]['line_status']!="C") )
								 {
								 ?>
								 
								 
				<option value="<?php echo $subscriptions[$i]['order_id']."#".$subscriptions[$i]['product_id']."#".$subscriptions[$i]['product_name']?>"><?php echo $subscriptions[$i]['product_name']?></option>


							 <?php 	}}
				?>       
				</select>  </td>  
            <td>&nbsp;</td>				
				<td> 

				<label>Email</label>
				<input type="email" name="insEmail"  onkeyup="myaddemailFunction()"id="insEmail" maxlength="30"  size="30" for="Institute Email" class="form-control" title="Invalid Email">
				</td>
				<td>&nbsp;</td>
				<td>
				<label>First Name</label>
				<input type="text" name="insFirstName" value="" id="insFirstName" maxlength="25"   title="Enter Only Alphabets"  size="30" for="First Name"   class="form-control">
				<input type="hidden" name="usermaster" value="<?php echo $masterid;?>" size="20" />
				</td>
				<td>&nbsp;</td>
				<td>
				<input type="hidden" name="userid" value="<?php echo $id;?>" size="20" />
				</td>
				<td>&nbsp;</td>
				<td>  
				<label>Last Name</label>
				<input type="text" name="insLastName" value="" id="insLastName" maxlength="25"  pattern="[a-zA-Z]+" title="Enter Only Alphabets" size="30" for="Last Name" class="form-control">

				</td>

				</tr>
				</table>

				</div>
				<div class="modal-footer" style="background-color:">
				<input type="submit" name="submit" id="aaa" onclick="return emailvalidetion();" value="Save"class="btn btn-primary btn-sm" >
				</form>
				<button type="button" class="btn btn-primary btn-sm " data-dismiss="modal" onclick="closeFunct()">Close</button>
				</div>
				</div>
				</div>
				</div>
	  
	   <!-- Modal content of  update-->
					
					  <div class="modal fade" id="editEmail"  role="dialog" >
				<div class="modal-dialog" style="background-color:white; border-radius: 5px;">

				<div class="modal-content" >

				<div class="modal-body"  >
				<form action ="<?php echo $urls;?>/updateaddemail" method="post" name='editeinstituteListForm' >
				<div class=" text-left" id="result12" style="font-weight: bold; color:#015cab ;"  > Update Email</div>
				<hr >
				<div class="alert alert-danger text-left" id="editeresult" style="display: none;" > </div>

				<table id="editemail">
				
				<tr id="refRow">
			
            <td>&nbsp;</td>				
				<td> 

				<label>Email</label>
				<input type="email" name="insEmail" id="insEmail" maxlength="30"  size="30" for="Institute Email" class="form-control" title="Invalid Email">
				</td>
				<td>&nbsp;</td>
				<td>
				<label>First Name</label>
				<input type="text" name="insFirstName" value="" id="insFirstName" maxlength="25"   title="Enter Only Alphabets"  size="30" for="First Name"   class="form-control">
				<input type="hidden" name="usermaster" value="<?php echo $masterid;?>" size="20" />
				</td>
				<td>&nbsp;</td>
				<td>
				<input type="hidden" name="userid" value="<?php echo $id;?>" size="20" />
				</td>
				<td>&nbsp;</td>
				<td>  
				<label>Last Name</label>
				<input type="text" name="insLastName" value="" id="insLastName" maxlength="25"  pattern="[a-zA-Z]+" title="Enter Only Alphabets" size="30" for="Last Name" class="form-control">

				</td>

				</tr>
				</table>

				</div>
				<div class="modal-footer" style="background-color:">
				<input type="submit" name="submit" id="editeemail" onclick="return editeemailvalidate();"   value="Update"class="btn btn-primary btn-sm" >
				</form>
				<button type="button" class="btn btn-primary btn-sm " data-dismiss="modal" onclick="closeFunct()">Close</button>
				</div>
				</div>
				</div>
				</div>
	  
				</div><br>
				<div class="box-body table-responsive">
				<input type="hidden" value="" id="allgriddata" name="allgriddata" />
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th width="20%">E-Mail</th>
								<!--<th width="5%">Concurrent users </th>-->
								<th width="20%">First Name</th>
								<!--<th width="15%">Middle Name</th>-->
								<th width="20%">Last Name</th>
								<th width="20%">Subscriptions</th>
								<th width="20%">Action</th>
								
							</tr>
							</thead>
							<tbody>
							<!-- ---------For Refferal URL's -->
							<?php if($allRefferals){
								$totalrefferals=count($allRefferals);
							for($i=0;$i<$totalrefferals;$i++){
								$col=$i+1;
								?>
								
							 <tr id="refRow<?php echo $allRefferals[$i]['http_referer_id'];?>">
								<td><input type="email" readonly name="insEmail<?php echo $col;?>" value="<?php echo $allRefferals[$i]['email'];?>" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" required id="insEmail<?php echo $col;?>" for="" class="form-control"></td>
								<td><input type="text" readonly name="insFirstName<?php echo $col;?>" value="<?php echo $allRefferals[$i]['first_name'];?>"  pattern="[a-zA-Z]+" title="Enter Only Alphabets" id="insFirstName<?php echo $col;?>" for=""  class="form-control" ></td>						
								<td><input type="text" readonly name="insLastName<?php echo $col;?>" value="<?php echo $allRefferals[$i]['last_name'];?>" pattern="[a-zA-Z]+" title="Enter Only Alphabets" id="insLastName<?php echo $col;?>" for="" class="form-control"></td>
								<td><input type="text" readonly name="insProductid<?php echo $col;?>"  value="<?php echo $allRefferals[$i]['product_name'];?>" pattern="[a-zA-Z0-9]+" title="Enter Only Alphabets" id="insProductid<?php echo $col;?>" for="" class="form-control"></td>
								<td>
								<a onclick="remoove_RefURL(<?php echo $allRefferals[$i]['http_referer_id'];?>)" data-toggle="tooltip" title="Delete" id="trash0" data-row="0" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></i></a>
								
								<a onclick="edite_RefURL(<?php echo $allRefferals[$i]['http_referer_id'];?>)" data-toggle="modal" data-target="#editEmail" title="Edite" id="trash0" data-row="0" ><i class="fa fa-pencil-square-o"style="font-size: 22px;padding-right: 10px;"></i></a>
								
							
								
								
								</td>
								
							</tr>
							<?php }}else{?>
							<!-- ------------------End-------------->
							
                                <tr id="subsrow0">
								<td> <?php echo form_input($insemail); ?></td>
								<td><?php echo form_input($insFirstName); ?></td>
								<td> <?php echo form_input($insLastName); ?></td>
								<td> <?php echo form_input($insProductid); ?></td>
								<td>
								<a href="javascript:" id="trash0" data-row="0" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></a>
								</td>
							  </tr>
							<?php }?>
                         </tbody>
					</table>
				</div>
				<div class="col-sm-6  pad0">
				<a href="<?php echo site_url('institutePage/InstituteList') ; ?>"> <input type="button" id="cancel"   class="cancel_btn" name="button" value="Back"></a>
					<input onclick="return serializeValue();" type="hidden" name="addInstituteRefferalnext" id="addInstituteRefferalnext"  value="Save And Continue">
                </div>
				<br><br>
				</div>   
                <div class="tab-pane fade <?php echo $active7;?>" id="Access-tokens">                     
                        <div class="form-group row">                     
                        <div class="col-sm-12">
                 		 <div class="box addSubscriptionTblContainer">
                 	    <div class="row">
        <div class="col-sm-3">
              <div class="form-group">
            <?php echo form_input($noOfTokens); ?>
          </div>
            </div>
        <div class="col-sm-3">
              <div class="form-group">
            <?php echo form_input($tokenExpiryDate); ?>
          </div>
       
            </div>
				
				
				
			</div>
                              </div>
                        
                             </div>
                         <input type='hidden' name='is_ip' id='is_ip' value='0'/>
                         <input type='hidden' name='is_refferal' id='is_refferal' value='0'/>
                          <input type='hidden' name='is_accessToken' id='is_accessToken' value='0'/>
                         <input type='hidden' name='no_of_subs' id='no_of_subs' value='<?php echo ($subsCount > 1) ? $subsCount : '1'; ?>'/>  
                         <input type='hidden' name='no_of_ips' id='no_of_ips' value='<?php echo ($ipCount > 1) ? $ipCount : '1'; ?>'/>  
                         <input type='hidden' name='no_of_refs' id='no_of_refs' value='<?php echo ($refCount > 1) ? $refCount : '1'; ?>'/>    
                        <input type='hidden'  name='ins_id' id='ins_Id' value='<?php echo $id;?>'/>
						<input type='hidden'  name='ip_subs' id='ip_subs' value='<?php echo $ip_detail;?>'/>
						<input type='hidden'  name='email_subs' id='email_subs' value='<?php echo $email_detail;?>'/>
                         <?php echo form_close(); ?>  
                      
                      
               
							  
						</div>
                            
							</div>
						</div>
					</div> 
                     
    </div>          
 </div>     
</div>

    <!--Ashwani Tab end-->     	
  </div>
</div>
        
<script type="text/javascript">

function update(){
	$('#resultlicencecount').hide();
	    var insstartDate= $('#insstartDate').val();
	    var endDate= $('#insEndDate1').val();
		var lic111= $('#lic111').val();
		var master_id= $('#master_id').val();
		var urlIPRange='<?php echo base_url(); ?>/index.php/InstitutePage/UpdateLicense';
		//alert(urlIPRange);
		$.ajax({
			type: "POST",
			url: urlIPRange,
			data: {master_id :master_id,startDate:insstartDate,endDate:endDate,licence_count:lic111},
			success: function(data)
				{
				 //alert(data);
				  if(data==1){
				     $( "#addinstituteSubsTab" ).removeClass( "active" );
                	 $( "#ip" ).addClass( "active" );
                	 $( "#Add-Subscriptions" ).removeClass( "active in" );
                	 $( "#IP-Address" ).addClass( "active in" );
                	   return false;
				  } 
                }
             });
		}

		function updateMultiLicence(id){
		//alert(id);
		var lic112= $('#lic'+id).val();
		//alert(lic112); die;
		//reg='/^|[1-9]/';
		
		var master_id= $('#master_id').val();
		var orderid= $('#orderid'+id).val();
		//alert(orderid); 
		var urlIPRange='<?php echo base_url(); ?>/index.php/InstitutePage/UpdateLicense';
		//alert(urlIPRange);
		$.ajax({
			type: "POST",
			url: urlIPRange,
			data: {master_id :master_id,orderid:orderid,licence_count:lic112},
			success: function(data)
				{
				 //alert(data);
				  if(data==1){
				  $("#resultlicencecount").text( "Successfully  change the license count.");  
	 $("#resultlicencecount").show();
				     $( "#addinstituteSubsTab" ).addClass( "active" );
                	// $( "#ip" ).addClass( "active" );
                	// $( "#Add-Subscriptions" ).removeClass( "active in" );
                	// $( "#IP-Address" ).addClass( "active in" );
                	   return false;
				  } 
                }
             });
		}

		
      $(document).ready(function(e) {
        
            	 /*--------------------------Java Script Code For Switching Tabs--------------------*/
                  $("#addInstitutenext").click(function() {
                	 
                	 $( "#addinstituteTab" ).removeClass( "active" );
                	  $( "#addinstituteSubsTab" ).addClass( "active" );
                	  $( "#ADD-Institute" ).removeClass( "active in" );
                	  $( "#Add-Subscriptions" ).addClass( "active in" );
                	 
                	  return false;
                  });
				  
                  $("#addIPnext").click(function() {
                	 
                	  $( "#addinstituteSubsTab" ).removeClass( "active" );
                	  $( "#ip" ).addClass( "active" );
                	  $( "#Add-Subscriptions" ).removeClass( "active in" );
                	  $( "#IP-Address" ).addClass( "active in" );
                  	  return false;
                  });
				  
                  $("#addEmailnext").click(function() {
                	 if(document.getElementById('email_subs').value=='Multi' && document.getElementById('ip_subs').value==''){
						 $( "#addinstituteSubsTab" ).removeClass( "active" );
                	     $( "#refferal_url" ).addClass( "active" );
                	     $( "#Add-Subscriptions" ).removeClass( "active in" );
                	     $( "#Refferral" ).addClass( "active in" );
                  	  return false;
					 }else{
                	  $( "#ip" ).removeClass( "active" );
                	  $( "#refferal_url" ).addClass( "active" );
                	  $( "#IP-Address" ).removeClass( "active in" );
                	  $( "#Refferral" ).addClass( "active in" );
                  	  return false;
					 }
                  });
				  
				  
				 
            	 /*-------------------------------------------End---------------------------------------- */
            	
            	 /*-------------------------------------------End Code for Validation-------------------- */
        });
	
		
		$('.form-control').focusout(function() {
			if($(this).val()!=''){
			$(this).next().html("");
			$(this).css("border"," 1px solid #ccc");
			}
			});
		
       </script>
	     <script type="text/javascript">
	   	$(document).ready(function(e) {
				/* var sub = $('#addInstituteRefferalnext');
					sub.prop("disabled", true);
	                sub.addClass("btn btn-info disabled") */
					
			$('#myvalidationForm').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
         /* $('#ProductName').on('change', function() {
             var sub = $('#addInstituteRefferalnext');
               var sel1 = $('#ProductName');
                 if (sel1.val()) {
             sub.prop("disabled", false);
	         sub.removeClass("btn btn-info disabled")
           }else{
  	         sub.prop("disabled", true);
	         sub.addClass("btn btn-info disabled")
             }
          }); */
             	 /*--------------------------Java Script Code For Switching Tabs--------------------*/
                  $("#addInstituteback").click(function() {
                	 //alert("dfygjgh");
					window.location = "<?php echo site_url('institutePage/InstituteList') ; ?>";
                	               	 
                	  return false;
                  });
                  $("#addIPback").click(function() {
                	   $( "#addinstituteSubsTab" ).removeClass( "active" );
					  $( "#addinstituteTab" ).addClass( "active" );
					  $( "#ADD-Institute" ).addClass( "active in" );
                	  $( "#Add-Subscriptions" ).removeClass( "active in" );
						return false;
                  });
                  $("#addInstituteIPAddressBack").click(function() {
					  
                	  $( "#addinstituteSubsTab" ).addClass( "active" );
                	  $( "#ip" ).removeClass( "active" );
                	  $( "#Add-Subscriptions" ).addClass( "active in" );
                	  $( "#IP-Address" ).removeClass( "active in" );
					
                  });
				  $("#addInstituteIPSubscriptionBack").click(function() {
					  $( "#addinstituteTab" ).addClass( "active" );
                	  $( "#addinstituteSubsTab" ).removeClass( "active" );
                	  $( "#ADD-Institute" ).addClass( "active in" );
                	  $( "#Add-Subscriptions" ).removeClass( "active in" );
					
                  });
            	 /*-------------------------------------------End---------------------------------------- */
            	
            	 /*-------------------------------------------End Code for Validation-------------------- */
                 
                 $('#ProductNameAddEmail1').change(function(){
                    checkipbstatus();
                 })
                 
                 
        });	   
	  </script> 
	  
	  <script type="text/javascript" src=" <?php echo base_url('assets/js/jquery-validate.min.js') ; ?> " ></script>
	   <script type="text/javascript" src=" <?php echo base_url('assets/js/additional-methods.js') ; ?> " ></script>
	   <script type="text/javascript">
        $(function() {
		 //alert($("#insIpVersion1").val());
			/////////////valid IP////////////////////////////////////////
        $.validator.addMethod('validIP', function (value) {
        var split = value.split('.');
        if (split.length != 4)
            return false;

        for (var i = 0; i < split.length; i++) {
            var s = split[i];
            if (s.length == 0 || isNaN(s) || s < 0 || s > 255)
                return false;
        }
        return true;
    }, ' Invalid IP Address');
	/////////valid IPV4 Address////////////////////////////////////////
	$.validator.addMethod("ipv4", function (a, b) {
        return this.optional(b) || /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/i.test(a)
    }, "Please enter a valid IP v4 address.");
	////////////////////////Valid IPV6 Address////////////////////////////////
    $.validator.addMethod("ipv6", function (a, b) {
        return this.optional(b) || /^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))$/i.test(a)
    }, "Please enter a valid IP v6 address.");
	//////////////////////greaterThan IP////////////////////////////////////////
	$.validator.addMethod("greaterThanIP", function (value, element, params) {
        var ipval = $(params).val();
        ipval = ipval.replace(/\./gi, '');
        value = value.replace(/\./gi, '');
        return isNaN(value) && isNaN(ipval)
                || (Number(value) >= Number(ipval));
    }, 'Must be greater than Minimum IP.');
	
	///////////////////////////////////////////////////////////////////////////////////
	jQuery.validator.addMethod("notEqualToGroup", function (value, element, options) {
// get all the elements passed here with the same class
        var elems = $(element).parents('form').find(options[0]);
// the value of the current element
        var valueToCompare = value;
// count
        var matchesFound = 0;
// loop each element and compare its value with the current value
// and increase the count every time we find one
        jQuery.each(elems, function () {
            thisVal = $(this).val();
            if (thisVal == valueToCompare) {
                matchesFound++;
            }
        });
// count should be either 0 or 1 max
        if (this.optional(element) || matchesFound <= 1) {
            //elems.removeClass('error');
            return true;
        } else {
            //elems.addClass('error');
        }
    }, "Please enter a another value.");
	
///////////////////////////////////////////////////////////////////////////
            $('#myvalidationForm').validate({
               submitHandler: function (form) { 
				return true;
            
        }
            });
			
			
	$(document).on('change', '.ipversion', function () {
		//debugger;
            var row = $(this).attr('data-row');
			//alert(row);
            var toipfield = 'input[name="insMinIp' + row + '"]';
			//alert(toipfield);
            var fromipfield = 'input[name="insMaxIp' + row + '"]';
			//alert(fromipfield);
            if ($(this).val() == '4') {
                $(toipfield).rules("remove", "ipv6");
                $(fromipfield).rules("remove", "ipv6");
                $(toipfield).rules("add", {
                    ipv4: true
                });
                $(fromipfield).rules("add", {
                    ipv4: true
                });
            } else {
                $(toipfield).rules("remove", "ipv4");
                $(fromipfield).rules("remove", "ipv4");
                $(toipfield).rules("add", {
                    ipv6: true
                });
                $(fromipfield).rules("add", {
                    ipv6: true
                });
            }
        });
		
	
		
	$(".addIpAddressTblContainer > .box-body >table > tbody > tr").each(function () {
		//debugger;
            var rowid = $(this).attr('id');
			//alert(rowid);
            if (typeof rowid !== 'undefined') {
                var rowcount = rowid.split('Row');
                var count = rowcount[1];
                if (count > 0) {
                    var ipversion = $('#insIpVersion' + count + '').val();
                    if (ipversion == 6) {
                        $('#insMinIp' + count + '').rules("add", {
                            required: true, ipv6: true,notEqualToGroup:['.minip']
                        });
                        $('#insMaxIp' + count + '').rules("add", {
                            required: true, ipv6: true,greaterThanIP:'#insMinIp'+count+''
                        });
                    } else {
                        $('#insMinIp' + count + '').rules("add", {
                            required: true, ipv4: true,notEqualToGroup:['.minip']
                        });
                        $('#insMaxIp' + count + '').rules("add", {
                            required: true, ipv4: true,greaterThanIP:'#insMinIp'+count+''
                        });
                    }
                }
            }
      
    });
	
 });	

function checkIPStatusPop(obj)
{
	//debugger
	var ipversion=$('#insIpVersionip').val();
	
	MinIPRange=$('#MinIp').val();
	MaxIPRange=$('#MaxIp').val();
	
	//alert(MaxIPRange);
	if(MaxIPRange!="")
	{
		Checkmaxip(MaxIPRange,ipversion,MinIPRange);
	}
	//alert(MinIPRange);
	if(ipversion=="4" && MinIPRange!="" && MaxIPRange=="" )
	{
		//alert("ww");
	  var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/i; 
   if(ipformat.test(MinIPRange) )  
 {  
 
  return true;
 }  
 else  
 { 
       $('#MinIp').val(""); 
 $("#result12").text( "You have entered an invalid IP address!");  
	 $("#result12").show();
	 return false;
 //alert("You have entered an invalid IP address!");  
           
 }
}
if(ipversion=="6")
{
	var ipformat = /^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))$/i;
	if(ipformat.test(MinIPRange) )  
 {  
 //alert("You have entered valid IP address!.");
   return true;
 }  
 else  
 {  
$("#result12").text( "You have entered an invalid IP address!");  
	 $("#result12").show();
	 return false; 
           
 }
	
}	
  }  
function Checkmaxip(MaxIPRange,ipversion,MinIPRange)
{
//alert(MaxIPRange);
debugger;
if(ipversion=="4"  )
	{
	//	alert("ww");
	  var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/i; 
   if(ipformat.test(MaxIPRange) )  
 {  
//var from = "10.16.250.12";
 // var to = "10.16.250.10";
  var fromArr = MaxIPRange.split(".");
  var toArr = MinIPRange.split(".");
  for(i=0;i<4;i++)
  {
	  
   if(fromArr[i]>=toArr[i])
   {
	   continue;
       return true;
   }
	else{
		$("#result12").text( "Must be greater than Minimum IP.");  
	 $("#result12").show();
	 return false;
		
	}
  }
 }  
 else  
 {
   $('#MaxIp').val('');	 
   $("#result12").text( "You have entered an invalid IP address!");  
	 $("#result12").show();
	 return false;
           
 }
}	
}

function status_change(rowsid,masterid,auivalue)
{
	//var auivalue = $('.abhi').val();
	//alert(auivalue);
	$.ajax({
			type: "POST",
			url: "<?php echo $urls;?>/rowupdate",
			data: {auivalue :auivalue,rowsid:rowsid},
			success: function(data)
				{
				// alert(data);
				//debugger;
				  if(data!=""){
	//			    $("#resultip").text( "You have Changed The Status Of Ip!");  
	 $("#resultip").show();
	 return false;
				  } 
                }
             });
	
}

function doajjax(aa)
{
	
var productid = $('#ProductName').val();
var masterid = $('#usermaster1').val();
$.ajax({
  type: "POST",
  url: "<?php echo $urls;?>/search",
  dataType :'json',
  data: {productid: productid,masterid: masterid},
  success: function(data) {
//	console.log(data);
	//debugger;
	var html='';
	$.each(data,function(i,e){
			html+='<tr id="refRow'+i+'" role="row" class="odd">';
			html+='<td><input type="email" readonly name="insEmail1" required value="'+e.email+'" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" id="insEmail1" for="" class="form-control valid" aria-invalid="false" style="border: 1px solid rgb(204, 204, 204);"></td>';
			
			html+='<td><input type="text" readonly name="insFirstName1" required value="'+e.first_name+'" pattern="[a-zA-Z]+" title="Enter Only Alphabets" id="insFirstName1" for="" class="form-control valid" aria-invalid="false" style="border: 1px solid rgb(204, 204, 204);"></td>';
			html+='<td><input type="text" readonly name="insLastName1" required value="'+e.last_name+'" pattern="[a-zA-Z]+" title="Enter Only Alphabets" id="insLastName1" for="" class="form-control valid" aria-invalid="false" style="border: 1px solid rgb(204, 204, 204);"></td>';
			html+='<td><input type="text" readonly name="insProductid" readonly value="'+e.product_name+'"  id="insProductid" for="" class="form-control valid" aria-invalid="false" style="border: 1px solid rgb(204, 204, 204);"></td>';
			html+='<td><a onclick="javascript:remoove_RefURL('+e.http_referer_id+')" data-toggle="tooltip" title="Delete" id="trash0" data-row="0" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></i></a>&nbsp;';
			html+='<a onclick="edite_RefURL('+e.http_referer_id+')" data-toggle="modal" data-target="#editEmail" title="Edite" id="trash0" data-row="0" ><i class="fa fa-pencil-square-o"style="font-size: 22px;padding-right: 10px;"></i></a></td>'
			html+='</tr>';
					 
		 });
	//alert(html);
	$('#example tbody').html(html);

	
								
  }
 
});
}
 
 
 
 
 
 
 
 
 function doipajjax(aa)
{
//alert(aa)	
var productid = $('#ProductName1').val();
//alert(productid);
var masterid = $('#usermaster1').val();

$.ajax({
  type: "POST",
  url: "<?php echo $urls;?>/searchips",
  dataType :'json',
  data: {productid: productid,masterid: masterid},
  success: function(data) {
	 //alert(data);
	console.log(data);
	//debugger;
	var html='';
	//var i=1;
	$.each(data,function(i,e){
		i = i+1;
			html+='<tr id="ipRow'+i+'">';
			html+='<td><select name="insIpVersion'+i+'"  id="insIpVersion1" data-row="' + i + '" class="form-control ipversion"><option value="4">IPv4</option><option value="6">IPv6</option></select></td>';
			
			html+='<td><input type="text" name="insMinIp'+i+'" readonly value="'+e.low_ip+'" id="insMinIp" for="Min IP " class="form-control minip" oninput=checkIPStatus("insMinIp'+i+'")></td>';
			
			
			html+='<td> <input type="text" name="insMaxIp'+i+'" readonly value="'+e.high_ip+'" id="insMaxIp" for="Max IP" class="form-control maxip" oninput=checkIPStatus("insMaxIp1")></td>';
			
			
			html+='<td><input type="text" name="insproductid12'+i+'"  value="'+e.productid+'" id="insproductid121" for="" class="form-control "></td>';
			if(e.aui_status==1)
			{
			

            html+='<td><select name="ipStatus'+i+'" class="form-control abhi valid" onchange="status_change('+e.ipauth_id+',\''+e.master_id+'\',this.value)" aria-invalid="false" style="border: 1px solid rgb(204, 204, 204);"> <option value="1" selected="" class="form-control">Active</option><option value="0" class="form-control">InActive</option></select></td>'

				
			}
			else{
				html+='<td> <select name="ipStatus'+i+'" class="form-control abhi valid" onchange="status_change('+e.ipauth_id+',\''+e.master_id+'\',this.value)" aria-invalid="false" style="border: 1px solid rgb(204, 204, 204);"><option value="1"  class="form-control">Active</option><option value="0" selected="" class="form-control">InActive</option></select></td>';
			}
				
			html+='<td><a onclick="javascript:remoove_IP('+e.ipauth_id+')" id="trash0" data-row="0" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash-o " style="font-size: 19px;padding-right: 10px; color:red;"></i></a></td>';
			
			html+='</tr>';
			// i++;		 
		 });
		 //var i ++;
	//alert(html);
	$('#tblIPAddress').html('<tr><th width="20%">IP Version</th> <th width="18%">Minimum IP</th><th width="18%">Maximum IP</th><th width="12%">Product Id</th><th width="15%">Status</th><th width="1%">Action</th></tr>'+html);

	
								
  }
 
});
}
 //var your_selected_value = $('#select option:selected').val();

 
 
 
 
 
 
function check()
{
	var ProductName = $("#ProductNameBulk").val();
	var aa = $("#pop").val();
	var ext = aa.split('.').pop();
	//alert(ext);
		if(ProductName=="")
		{
		$("#pop1").html("Please Select  The Product Name");	
		return false;
		}
	else
	{
	if(!((ext == 'xml') || (ext == 'csv') || (ext == 'xlsx') || (ext == 'xls') || (ext == 'txt')))
	{
		$("#pop1").html("The File Extension Does Not Match");
		return false;
	}
	
	}
	
	
}	
function serializeValue(){
     var productid = $('#insProductid1').val();
	if(productid=="")
	{
	  alert("Please  Go To Add Email");
       return false;	  
	}
	var table = $('#example').DataTable();
	//table.ajax.reload();
	var data = table.$('input, select').serialize();
	//alert(data);
	
	$("#allgriddata").val(data);
	//return false;
	//alert($("#allgriddata").val())
}

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function validatefirstname(insFirstName)
{
	var res =/^[a-zA-Z]+$/;
	return res.test(insFirstName);
}

function validatelastname(insLastName)
{
	var res2 =/^[a-zA-Z]+$/;
	return res2.test(insLastName);
}
function emailvalidetion()
{
	$("#result").text("");
  var email = $("#insEmail").val();
   var ProductAddEmail = $("#ProductNameAddEmail").val();
  if(ProductAddEmail=="")
  {
	 $("#result").text( "Please Select  The Product Name");  
	 $("#result").show();
	$("#ProductNameAddEmail").focus(); 
	return false;
  }
  if(email == "")
   {
	 $("#result").text(" Please Fill Out this Field");
    //$("#result").css("color", "red");
	 $("#result").show();
	$("#insEmail").focus(); 
   return false;	
  }
  else{
	  
  if (!validateEmail(email)) {
    $("#result").text(email + " Is Not Valid Email Id");
   // $("#result").css("color", "red");
    $("#result").show();
	$("#insEmail").focus();
	return false;
  }
 
  }
var insFirstName = $("#insFirstName").val();
  if(insFirstName == "")
  {
	 $("#result").text( " Please Fill Out this Field");
   // $("#result").css("color", "red");
    $("#result").show();
	$("#insFirstName").focus(); 
   return false;	
  }
  else
  {
	 var insFirstName = $("#insFirstName").val();
 if(!validatefirstname(insFirstName))
 {
	 //$("#result").text(insFirstName + " Is Not Valid First Name");
	 $("#result").text(insFirstName + " Is Not Valid First Name");
	  $("#result").show();
  //  $("#result").css("color", "red");
	$("#insFirstName").focus();
	return false; 
 }
  }//
     
var insLastName = $("#insLastName").val();
//alert(insLastName);
  if(insLastName == "")
  {
	 $("#result").text("Please Fill Out this Field");
   // $("#result").css("color", "red");
    $("#result").show();
	$("#insLastName").focus(); 
   return false;	
  }
  else
  {
	 var insLastName = $("#insLastName").val();
 if(!validatelastname(insLastName))
 {
	 $("#result").text(insLastName + " Is Not Valid Last Name");
   // $("#result").css("color", "red");
    $("#result").show();
	$("#insLastName").focus();
	return false; 
 }
  }//

}


////////edite email validation /////////////////////////////////////
function editevalidateEmail(Email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(Email);
}
function editevalidatefirstname(insFirstName1)
{
	var res =/^[a-zA-Z]+$/;
	return res.test(insFirstName1);
}

function editevalidatelastname(insLastName1)
{
	var res2 =/^[a-zA-Z]+$/;
	return res2.test(insLastName1);
}
function editeemailvalidate()
{
	$("#editeresult").text("");
  var Email = $("#Email").val();
  //alert(Email);
  if(Email == "")
   {
	   alert("dsds");
	 $("#editeresult").text(" Please Fill Out this Field");
    //$("#result").css("color", "red");
	 $("#editeresult").show();
	$("#Email").focus(); 
   return false;	
  }
  else{
	  
  if (!editevalidateEmail(Email)) {
    $("#editeresult").text(Email + " Is Not Valid Email Id");
   // $("#result").css("color", "red");
    $("#editeresult").show();
	$("#Email").focus();
	return false;
  }
 
  }
var insFirstName1 = $("#insFirstName1").val();
//alert(insFirstName1); 
  if(insFirstName1 == "")
  {
	 $("#editeresult").text( " Please Fill Out this Field");
   // $("#result").css("color", "red");
    $("#editeresult").show();
	$("#insFirstName1").focus(); 
   return false;	
  }
  else
  {
	 var insFirstName1 = $("#insFirstName1").val();
 if(!editevalidatefirstname(insFirstName1))
 {
	 //$("#result").text(insFirstName + " Is Not Valid First Name");
	 $("#editeresult").text(insFirstName1 + " Is Not Valid First Name");
	  $("#editeresult").show();
  //  $("#result").css("color", "red");
	$("#insFirstName1").focus();
	return false; 
 }
  }//
     
var insLastName1 = $("#insLastName1").val();
//alert(insLastName);
  if(insLastName1 == "")
  {
	 $("#editeresult").text("Please Fill Out this Field");
   // $("#result").css("color", "red");
    $("#editeresult").show();
	$("#insLastName1").focus(); 
   return false;	
  }
  else
  {
	 var insLastName1 = $("#insLastName1").val();
 if(!editevalidatelastname(insLastName1))
 {
	 $("#editeresult").text(insLastName + " Is Not Valid Last Name");
   // $("#result").css("color", "red");
    $("#editeresult").show();
	$("#insLastName1").focus();
	return false; 
 }
  }//

}

</script>

<?php if(!empty($this->session->flashdata('message'))){	?>

	<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom" style="
    width: 142%;">

<div class="modal-header" id="mod-header">

<h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
</div>
<div class="modal-body">
<?php echo $this->session->flashdata('message');?>
</div>
<div class="modal-footer" id="mod-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

</div>

</div>
</div>
</div> 




</body>

<script>
  $(window).on('load',function(){
        $('#memberModal').modal('show');
    });
</script>
<?php }	?>
<script>
$('div.alert').delay(8000).slideUp(300);
</script>

</body></html>
