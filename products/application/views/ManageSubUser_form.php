<style>
.required-field{
    color:red;  
    font-size:12px;
    /*position:absolute;
    top:-50;*/
}
#fb-errorname{
    color: red;
    padding-top: 9px;
    text-align: right;
    margin-bottom: -15px;
}
</style>
<div class="adminPopupPanel">
	<div class="heading">
		<span class="title">
		MANAGE SUBUSER LIST 
		</span>
	</div>
 <div class="container">
	<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-7">
    </div>
	<?php foreach($getSubUser as $user){ ?>
	<div class="col-sm-12">
     <div class="row tab-v3">
		<div class="col-sm-12">
		<form action="<?php echo site_url('MuserAdmin'); ?>"  method="post" accept-charset="utf-8">
			<div class="tab-content">
			<!-- -----------Tab One -->
			<div style="color:red"><p>* All field are mandatory</p></div>
			<div class="tab-pane fade active in" id="regStep_1">
			<div class="form-group  row">
			<input type="hidden" name="id"  value="<?php echo $_REQUEST['id']; ?>" >
		    <div class="col-sm-12">
            <label class="control-label "><span class="required-field">*</span> Email Id :</label>
	        <input type="text" name="email" value="<?php if(isset($user)){echo $user->email;} ?>" 
			 id="email" maxlength="50" size="30" for="username" class="form-control" placeholder="Enter Email Id " />
			 <div id="fb-errorename"></div>
		   </div><div class="clearfix"></div>
		   <div class="clearfix"></div><br>
           <div class="col-sm-12">
           <label class="control-label ">
		   <span class="required-field">*</span> First Name :</label>
		   <input type="text" name="first_name" value="<?php if(isset($user)){echo $user->first_name; }?>"
		    id="Fname" maxlength="50" size="30" for="username" class="form-control" placeholder="Enter First Name"  />
		   <div id="fb-errorfname"></div>
		  </div><div class="clearfix"></div>
		 <div class="clearfix"></div><br>
	     <!--<div class="col-sm-12">
         <label class="control-label ">
         <span class="required-field">*</span> Middle Name : </label>
         <input type="text"  name="middle_name" value="<?php // if(isset($user)){echo $user->middle_name;} ?>" id="Mname" maxlength="80" size="30" for="username" class="form-control" placeholder="Enter Middle Name"  />
		 <div id="fb-errormname"></div>
         </div>-->
		 <div class="clearfix"></div>
		 <div class="clearfix"></div><br>
 	   <div class="col-sm-12">
	   <label class="control-label ">
	   <span class="required-field">*</span> Last Name: </label>
	   <input type="text" name="last_name" value="<?php if(isset($user)){echo $user->last_name;} ?>" id="Lname" maxlength="50" size="30" for="username" class="form-control" placeholder="Enter Last Name"  />
	   <div id="fb-errorlname"> </div>
	 </div>
   </div>
  </div>
  <div class="col-sm-12 pull-left pad0  ">
  <a href="<?php echo site_url('MuserAdmin') ; ?>"> <span class="cancel_btn">Cancel</span></a>
  <input type="submit" name="submit" id="submit_id" value="Update">
  </div>
 <br><br>
</div>
</form>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
<script type="text/javascript">
 $(document).ready(function(){
  $("#submit_id").click(function(){
   //alert('dgfdgfgfg'); exit;
    var email= $("#email").val();
	var fname= $("#Fname").val();
	var mname= $("#Mname").val();
	var lname= $("#Lname").val();
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var charregex = /^[a-zA-Z ]*$/;
    if (!regex.test(email)){
	     $("#fb-errorename").html("<span style='color:red;float:right;'>Fill valid email id</span>");
          return false;   
      }else if(email==''){
	  $("#fb-errorename").html("<span style='color:red;float:right;'>Fill  email id</span>");
          return false;  
	  }else if(fname==''){
	     $("#fb-errorfname").html("<span style='color:red;float:right;'>Fill  first name</span>");
	    return false; 
	  }else if(!charregex.test(fname)){
	  $("#fb-errorfname").html("<span style='color:red;float:right;'>Fill  first name only alphabetic character</span>");
	    return false; 
	  }else if(mname=='' ){
	  $("#fb-errormname").html("<span style='color:red;float:right;'>Fill  middle name</span>");
	    return false;
	  }else if(!charregex.test(mname)){
	  $("#fb-errormname").html("<span style='color:red;float:right;'>Fill  middle name only alphabetic character</span>");
	    return false;
	  }else if(lname==''){
	  $("#fb-errorlname").html("<span style='color:red;float:right;'>Fill  last name</span>");
	    return false;
	 }else if(!charregex.test(lname)){
	  $("#fb-errorlname").html("<span style='color:red;float:right;'>Fill  last name only alphabetic character</span>");
	    return false;
	 }
	 else{
	 return true;
	 }
   });
 });
 </script>
</body>
</html>