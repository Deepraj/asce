<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js">
</script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js">
</script>
<script type="text/javascript" class="init">
$.extend( true, $.fn.dataTable.defaults, {
    "searching": false
} );
$(document).ready(function() {
	$('#example').DataTable( {
	
        "language": {
            "lengthMenu": "Show entry _MENU_ ",
            "zeroRecords": "No data available in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Number of record zero",
            "infoFiltered": "(filtered from _MAX_ total records)",
	       
        }	
    } );
	 
} );
</script>
<script>
	
	
	
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
  if(email == "")
   {
	 $("#result").text(" Please fill out this field");
    //$("#result").css("color", "red");
	 $("#result").show();
	$("#insEmail").focus(); 
   return false;	
  }
  else{ 
  if (!validateEmail(email)) {
    $("#result").text(email + " Is not valid email id");
   // $("#result").css("color", "red");
    $("#result").show();
	$("#insEmail").focus();
	return false;
  }
 }
var insFirstName = $("#insFirstName").val();
  if(insFirstName == "")
  {
	 $("#result").text( " Please fill out this field");
   // $("#result").css("color", "red");
    $("#result").show();
	$("#insFirstName").focus(); 
   return false;	
  }else{
 var insFirstName = $("#insFirstName").val();
 if(!validatefirstname(insFirstName))
 {
	 //$("#result").text(insFirstName + " Is Not Valid First Name");
	 $("#result").text(insFirstName + " Is not valid first name");
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
	 $("#result").text("Please fill out this field");
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
	 $("#result").text(insLastName + " Is not valid middle name");
   // $("#result").css("color", "red");
    $("#result").show();
	$("#insLastName").focus();
	return false; 
 }
  }//

}	
function doajjax(aa)
{
var productid = $('#ProductName').val();
var masterid = $('#usermaster').val();
//alert(masterid);
//alert(productid+masterid);
$.ajax({
  type: 'POST',
  url: '<?php echo base_url();?>MuserAdmin/search',
  dataType :'json',
  data: {productid: productid,masterid: masterid},
  success: function(data) {
	 //alert(data);
//console.log(data);
	//debugger;
	 var html='';
	$.each(data,function(i,e){
			html+='<tr role="row" class="odd">';
			html+='<td class="sorting_1">'+e.email+'</td>';
			html+='<td class="">'+e.first_name+'</td>';
			html+='<td class="">'+e.last_name+'</td>';
			html+='<td class="">'+e.product_name+'</td>';
			html+='<td class=""><a href="<?php echo site_url(); ?>/MuserAdmin/EditSubUser?id='+e.http_referer_id+'" title="Edit "><i class="fa fa-pencil-square-o" style="font-size: 19px;padding-right: 10px;"></i></a> <a href="javascript:show_confirm('+e.http_referer_id+')" title="Delete "><i class="fa fa-trash-o" style="font-size: 19px;padding-right: 10px; color:red;"></i></a><a href=\'javascript:sendmail_confirm("'+e.email+'")\' title="Send invitations"><i class="fa fa-envelope" aria-hidden="true" style="font-size: 19px;padding-right: 10px;"></i> </a></td>';
			html+='</tr>';		 
		 });
	//alert(html);
	$('#example tbody').html(html);	
  }
});
}
</script>
<style>
.modal-body {
    background-color: #ffffff;
}
.modal-footer{
    background-color: #ffffff;
}

.modal-content {
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: none;
    /* border: 1px solid rgba(0, 0, 0, .2); */
    border-radius: 6px;
    outline: 0;
    -webkit-box-shadow: none;
    /* box-shadow: 0 3px 9px rgba(0, 0, 0, .5); */
}
</style>
 <?php
$lvar="http://".$_SERVER['HTTP_HOST'];
//echo $lvar; die;
$urls=$lvar.'/MuserAdmin';
//echo $urls; die;
?>
<?php 
$sortBy=$tabValue=$this->input->get('sortby', TRUE);
$GUID=$this->session->userdata('GUID');
$aa=$this->session->userdata('çarporationmasterid');
if(isset($aa))
{
	$masterid=$this->session->userdata('çarporationmasterid');
}	
else{
$masterid=$this->session->userdata('MasterCustomermainId'); 
} 
//$masterid=$this->session->userdata('MasterCustomermainId'); 
?>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="adminPopupPanel">
    <div class="container bg-shadow">
        <div class="row" >
        <div class="col-sm-12">
		<?php
          $msg = $this->session->flashdata('message'); 
		 if(isset($msg)){ ?>
		 <div class="alert alert-error  alert-dismissable" style="border: 1px solid #ff0000;position: relative;">
        <a href="#" class="close-msg btn btn-primary " data-dismiss="alert" aria-label="close" style=" position: absolute; top: 50%;margin-top: -17px;right: 10px;">Close</a>

           <strong ><?php echo $msg; ?></strong>
        </div> 
		<?php } ?>
          <div class="pull-left">
		
            <p class="heading-add-inst">SUB USER LIST</p>
			<p align='left' style="color:red; margin-left:10px;"><b>Invite Sub Users to Access Your Account<br></b></p>

		      <p>	1. Click “+ Invite Sub Users” to select subscription and provide email address, first name, and last name.<br>
            2. Click Save to send the email.<br>
			3. If you need to resend an invite, click on the envelop icon next to each person’s name to send a personal invitation.
			</p>
          </div>
        </div>
      </div>
     <div id="fade" class="black_overlay"></div>
	 <form action="<?php echo site_url('MuserAdmin/SortbyUser');  ?>"  method="post" accept-charset="utf-8">
       <div class="row">
        <div class="col-sm-4">
             
         </div>
        <div class="col-sm-4">
		

           <!--  <div class="form-group">
            <input type="text" name="first_name" id="name" placeholder="First Name" class="form-control" value="<?php if(isset($_REQUEST['search'])){echo $_REQUEST['first_name'];} ?>" autocomplete="off"  >
		   <div id="fb-errorname"></div>
		   </div> --->
		  </div>
			<!--<div class="col-sm-4">
              <div class="form-group">
             <!--<input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control" value="<?php //echo $productcodesearch ;?>"  autocomplete="off" maxlength="20">
		      <div  id="fb-errorcode"></div>
			</div>
		</div>-->
         <div class="col-sm-4 pull-right text-left">
             <!-- <input name="search" id="submit_id" type="submit" class="btn btn-primary btn-sm" value="Search" autocomplete="off">
              <a href="<?php echo site_url('MuserAdmin')?>" class="btn btn-default btn-sm">Clear</a>---> </div>
        </div>
		</form>
	 
	  <div class="row">
	    <div class="col-sm-12 pull-right text-right mt20"> 
              <span class=" pull-left text-left">
             <select  name="Subscription"id="ProductName" class="form-control" style="width:207px;" onchange="return doajjax();" >
			 <option value=""> --- Select Subscription --- </option>	
			<?php
			if($subscriptions){
				
							$totSubscriptions=count($subscriptions);
							 for($i=0;$i<$totSubscriptions;$i++)
							 {
								 ?>		
			<option value=<?php echo $subscriptions[$i]['order_id']; ?>><?php echo $subscriptions[$i]['product_name']?></option>						
			<?php
			}
			}					
		?>
	    </select></span>
		<span class=" pull-right text-right">
		<a href="#" class="btn btn-primary btn-sm" id="addSubscription"  data-toggle="modal" data-target="#myModal2">
			<i class="fa fa-plus-circle"></i> &nbsp;Bulk import 
		   </a>
		
		
		  <a href="#" class="btn btn-primary btn-sm" id="addSubscription"  data-toggle="modal" data-target="#addEmail">
			<i class="fa fa-plus-circle"></i> &nbsp;Invite Sub Users
		   </a></span>
		 </div>
	  </div>
  	    <div class="modal fade" id="addEmail"  role="dialog"  >
       <div class="modal-dialog" style="background-color:white; border-radius: 5px;">
        <div class="modal-content" style="
    margin-left: -46px;
    width: 741px;
" >
          <div class="modal-body"  >
		  <form action ="<?php echo site_url();?>/MuserAdmin/insertaddemail" method="post" name='instituteListForm' >
		  <div class=" text-left" id="result12" style="font-weight: bold; color:#015cab ;" > Invite Sub Users</div>
		   <hr>
		  <div class="alert alert-danger text-left" id="result" style="display: none;" > </div>
		  <table>
			<tr id="refRow">
			<td>
			 <label>Select Subscription</label>
			<select  name="Subscription"id="ProductName" class="form-control" style="width:207px;" >
			 <option value=""> --- Select Subscription --- </option>	
			<?php
			if($subscriptions){
							$totSubscriptions=count($subscriptions);
							 for($i=0;$i<$totSubscriptions;$i++)
							 {
						?>		
		<option value="<?php echo $subscriptions[$i]['order_id']."#". $subscriptions[$i]['product_id']."#".$subscriptions[$i]['product_name']; ?>"><?php echo $subscriptions[$i]['product_name']?></option>								
		<?php
			}
		}					
		?>
			</select>
			</td>
			<td>&nbsp;</td>
			<td> 
			<label>Email</label>
			<input type="email" name="insEmail" id="insEmail" maxlength="256"   for="Institute Email" class="form-control" title="Invalid Email">
			</td>
			<td>&nbsp;</td>
			<td>
			<label>First Name</label>
			<input type="text" name="insFirstName" value="" id="insFirstName" maxlength="256"   title="Enter Only Alphabets"   for="First Name"   class="form-control">
			<input type="hidden" name="usermaster" id="usermaster" value="<?php echo $masterid ;?>" size="20" />
			</td>
			<td>&nbsp;</td>
			<td>
			<input type="hidden" name="userid" value=""  />
			</td>
			<td>&nbsp;</td>
			<td>  
			<label>Last Name</label>
			<input type="text" name="insLastName" value="" id="insLastName" maxlength="256"  pattern="[a-zA-Z]+" title="Enter Only Alphabets"  for="Last Name" class="form-control">
			
			</td>
			<td>&nbsp;</td>
			</tr>
			</table>
		  </div>
        <div class="modal-footer" style="background-color:">
		<input type="submit" name="submit" onclick="return emailvalidetion();" value="Save"class="btn btn-primary btn-sm" ></button>
		</form>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
	    </div>
      </div>
	  </div>
	  </div>
	  
	  
	


 <div class="modal fade" id="myModal2" role="dialog" >
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
	  






	
	  
	  
	  
	  <br>
	   <div id="notice"><?php //if(!empty($this->session->flashdata('message'))){  echo "<font style='color:green; font-size:14px; padding-left: 300px;'><strong>".$this->session->flashdata('message')."</strong></font>"; } ?></div>
        <div class="row">
        <div class="col-sm-12">
              <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
               <div class="row">
                  <div class="col-sm-12">
                <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"></div><div class="row"><div class="col-sm-12">
				<table id="example" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr role="row"><th class="" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 262px;"> E-Mail</th>
					<th class="" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 236px;"> First Name</th>
					<!--<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 233px;">Middle Name</th>-->
					<th class="" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 236px;">Last Name</th>
					<th class="" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 323px;">Subscriptions</th>
					<th class="" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 135px;">Action</th></tr>
                  </thead>
                <tbody>  
				  <?php
					 $i =1;
					  foreach($SubUserList as $row)
					  {  
					  ?>
					  <tr role="row" class="odd">
                          <td class=""><?php echo !empty($row->email)?$row->email:'N/A'; ?> </td>
                          <td class=""><?php echo !empty($row->first_name)?$row->first_name:'N/A'; ?></td>
                          <!--<td class=""><?php //echo !empty($row->middle_name)?$row->middle_name:'N/A'; ?></td>-->
	                      <td class=""> <?php echo !empty($row->last_name)?$row->last_name:'N/A'; ?> </td>
					      <td class=""> <?php echo !empty($row->product_name)?$row->product_name:'N/A'; ?></td>
                         <td class=""><a href='<?php echo site_url('MuserAdmin/EditSubUser?id='.$row->http_referer_id.'') ; ?>' title="Edit "><i class="fa fa-pencil-square-o" style="font-size: 19px;padding-right: 10px;"></i></a>
				         <a href='javascript:show_confirm(<?php echo $row->http_referer_id;?>)'  title="Delete "><i class="fa fa-trash-o" style='font-size: 19px;padding-right: 10px; color:red;'></i></a>
						 <a href='javascript:sendmail_confirm("<?php echo $row->email;?>")'  title="Send invitations  ">
						 <i class="fa fa-envelope" aria-hidden="true" style='font-size: 19px;padding-right: 10px;'></i>
						 </a>
						</td>
                        </tr>	
				<?php 
				}
              ?>					                           
         </tbody>
       </table>
	</div>
	</div>
	</div>
   </div>
  </div>
  <div class="row">
   <div class="col-sm-7">
    <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
       </div>
     </div>
     </div>
    </div>
   </div>
   </div>
  </div>
  </div>
  </div>
 <!--<script type="text/javascript">
     $(document).ready (function(){
          $("#notice").fadeTo(5000, 100).slideUp(500, function(){
      });
 });
 </script> -->
 <?php
          $msg1 = $this->session->flashdata('bulkimportmessage'); 
		 // 
		 if(isset($msg1)){ 
		 
		// echo $msg1; die;
		 ?>
		 
  <div class="modal fade" id="memberModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom">

<div class="modal-header" id="mod-header">

<h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
</div>
<div class="modal-body">
  <strong ><?php echo $msg1; ?></strong>
</div>
<div class="modal-footer" id="mod-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>

</div>

</div>
</div>
</div> 

<script>
  $(window).on('load',function(){
        $('#memberModal1').modal('show');
    });
</script>
 <?php
		 }
		 ?>
 
 
 
 
 
 
 
 
 
 
 
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom">

<div class="modal-header" id="mod-header">

<h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
</div>
<div class="modal-body">
<script>
function show_confirm(id){
	  // alert(id);
	  // window.location='<?php echo site_url();?>/'+'MuserAdmin/deleteSubUser/'+id;
	   $('#myModal').modal('show');
	   $("#okbtn").attr("data-dismiss",id);
	}
	function deleteData(obj){
		//debugger
		var id=obj.getAttribute("data-dismiss");
		//alert(id)
		window.location='<?php echo site_url();?>/'+'MuserAdmin/deleteSubUser/'+id;
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
 
 <!----------------------->
 
 <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom">

<div class="modal-header" id="mod-header">

<h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
</div>
<div class="modal-body">
<script>
function sendmail_confirm(email){
	 //  alert(email);
	  // window.location='<?php echo site_url();?>/'+'MuserAdmin/deleteSubUser/'+id;
	   $('#myModal1').modal('show');
	   $("#okbtn1").attr("data-dismiss",(email));
	}
	function deleteData1(obj){
		debugger
		var email=obj.getAttribute("data-dismiss");
		
			window.location='<?php echo site_url();?>/'+'MuserAdmin/sendmailSubUser/'+email;
	}
</script>Do you want to send invitation to this email address? 
</div>
<div class="modal-footer" id="mod-footer">
<button type="button" class="btn btn-primary" data-dismiss="" id="okbtn1" onclick="deleteData1(this);">Ok</button>
<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>

</div>

</div>
</div>
</div> 
 </body>
 <footer class="footer-bg "  style="
    margin-top: 150px;
" >
	<div class="container">
		<div class="row" >
			<div class="col-md-4 text-left" >
			 <a class="" href="http://www.asce.org/" target="blank"><img src="http://asce.adi-mps.com/products/img/footerlogo.png" /><br>
			       1801 Alexander Bell Drive<br>
				   Reston, VA 20191-4400<br>
				   703-295-6300 | 800-548-2723</a><br>
			</div>
			<div class="col-md-4 text-center"  >
				<a href="https://asce7hazardtool.online/" target="blank">ASCE 7 Hazard Tool</a><br>
				<a href="http://www.asce.org/asce-7/" target="blank">ASCE 7 Related Products</a><br>
<a href="<?php echo base_url();?>index.php/TermsOfUse" target="blank">Terms of Use</a><br>
<a href="<?php echo base_url();?>index.php/AboutASCE7Online" target="blank">FAQs</a>

			</div>
			<div class="col-md-4 text-center">
				<a href=" http://www.asce.org/about_asce/" target="blank">About ASCE</a><br>

<a href="http://www.asce.org/contact_us/ " target="blank">Contact Us</a><br>
				<a href="http://ascelibrary.org/" target="blank">ASCE Library</a>
			</div>
			<br>
			<div class="col-md-12 text-center color-white" >
				© 2018 American Society of Civil Engineers
			</div>
		</div>
	</div>	
</footer>
</html>
