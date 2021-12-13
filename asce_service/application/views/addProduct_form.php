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
<script type="text/javascript">
$( document ).ready(function() {
$( "button" ).addClass( "frmbutton" );
});
</script>
<div class="adminPopupPanel">
	<div class="heading">
		<span class="title">
         <?php
			//echo "<pre>".$id;print_r($this->input->get()); 
		 if(isset($id) && $id>0){ echo "MANAGE";} else{ echo "ADD";}?>  PRODUCT  
		  <br>
		<br>
		</span>
	</div>
	<div class="container">
	<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-7">
    </div>
	<div class="col-sm-12">
     <div class="row tab-v3">
		<div class="col-sm-12">
		<form action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="tab-content">
							<!-- -----------Tab One -->
			<div style="color:red"><p>* All field are mandatory</p></div>
			<div class="tab-pane fade active in" id="regStep_1">
			<div class="form-group  row">
			<?php 	// echo '<pre>'; print_r($productdetail);die;?>
			<div class="col-sm-6">
           <label class="control-label ">
		   <span class="required-field">*</span> Master Product Id :</label>
	        <input type="text" name="product_id" value="<?php echo isset($productdetail['master_product_id'])?$productdetail['master_product_id']:set_value('product_id');?>" 
			id="masterproductid" maxlength="50" size="30" for="username" class="form-control" placeholder="Enter Master Product Id"  />
			<div class="error_msg"><?php echo form_error('product_id'); ?></div>
			<input type="hidden" name="duplimaster" id="duplimaster" value="<?php echo isset($productdetail['master_product_id'])?$productdetail['master_product_id']:set_value('duplimaster');?>" />
			<input type="hidden" name="bookname" id="bookname" value="<?php echo isset($productdetail['book_id'])?$productdetail['book_id']:set_value('bookname');?>" />
			</div>
           <div class="col-sm-6">
           <label class="control-label ">
		   <span class="required-field">*</span> Master Product Code :</label>
		  <input type="text" name="product_code" value="<?php echo isset($productdetail['product_code'])?$productdetail['product_code']:set_value('product_code');?>"
		  id="masterproductcode" maxlength="50" size="30" for="username" class="form-control" placeholder="Enter Master Product Code"  />
		<div class="error_msg"><?php echo form_error('product_code'); ?></div>
		</div>
	    <div class="col-sm-6">
        <label class="control-label ">
  <span class="required-field">*</span> 		Product Name : </label>
         <input type="text" id="productname" name="ProductName" value="<?php echo isset($productdetail['product_name'])?$productdetail['product_name']:set_value('ProductName');?>" id="ProductName" maxlength="80" size="30" for="username" class="form-control" placeholder="Enter Product Name"  />
		 <div id="fb-errorname"></div>
      </div>
	  <?php // if(isset($productdetail['rate_id'])){$bb =$productdetail['rate_id'];}  ?>
	<?php
    //echo '<pre>'; print_r($_REQUEST);	?>
    <div class="col-sm-6">
    <label class="control-label "> 
	  <span class="required-field">*</span> Subscription Type: </label>
    <select name="Subscription" onchange =""   class="form-control" id="ProductName" >
     <option value=""> --- Select ProductType --- </option>	
	 <?php
	foreach ($h as $row) { ?>
   <option value="<?php echo $row->license_id;?>" <?php   if(isset($productdetail['license_id'])){$aa =$productdetail['license_id'];}
   else {$aa = set_value('Subscription');} if($aa == $row->license_id ){echo "selected";} ?>><?php echo $row->license_type;?> </option>
   <?php }    ?>
   </select>
   <div class="error_msg">
   <?php echo form_error('Subscription'); ?>
    </div>
    </div>
     <input type="hidden" name="RateCode" id="RateCode">							
	
	<div class="col-sm-6">
	
	<?php 
  
  //print_r($book);
   $bookidarray=array();
 // print_r($bookid); 
   foreach($bookid as $booklist){
  array_push($bookidarray,$booklist->book_id);
   }
      $optiongroup=array();
  if(!empty($_REQUEST['basicOptgroup'])){
	  
	
    // print_r($_REQUEST['basicOptgroup']);
	
     $optiongroup=$_REQUEST['basicOptgroup'];
	 $bookidarray=array();
	 
  }
 ?>
   <label class="control-label ">
  <span class="required-field">*</span>    Select Book : </label>
   <select name="basicOptgroup[]" multiple="multiple" >
   <?php
       foreach ($book as $row)  
                                           {  
                                                ?>
 <option value="<?php echo $row->m_bokid;?>"<?php  if(isset($productdetail['book_id'])){$cc = $productdetail['book_id'];} else {$cc = set_value('bookname');} echo in_array($row->m_bokid,$bookidarray)?'selected':''; ?><?php if(!empty($_REQUEST['basicOptgroup'])){ echo in_array($row->m_bokid,$optiongroup)?'selected':''; } ?>><?php echo $row->m_boktitle; ?></option>
               <?php  
               }
               ?>
 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src=" <?php echo base_url('assets/js/jquery.multiselect.js') ; ?> " ></script>
<script>
$('select[multiple]').multiselect({
    columns: 1,
    placeholder: 'Select options'
});
</script>
</select>
<div class="error_msg">
<?php echo form_error('basicOptgroup'); ?>
</div>
</div>
<div class="col-sm-6">
<label class="control-label ">
  <span class="required-field">*</span> Price: </label>
<input type="text" name="NonMemberPrice" value="<?php echo isset($productdetail['nonmember_price'])?$productdetail['nonmember_price']:set_value('NonMemberPrice');?>" id="NonMemberPrice" maxlength="8" size="30" for="username" class="form-control" placeholder="Enter Non Member Price"  />
<div class="error_msg">
<?php echo form_error('NonMemberPrice'); ?>
</div>
</div>
</div>
<div class="form-group row">
<div class="col-sm-6">
<label class="control-label ">
  <span class="required-field">*</span> Member Price: </label>
<input type="text" name="MemberPrice" value="<?php echo isset($productdetail['member_price'])?$productdetail['member_price']:set_value('MemberPrice');?>" id="MemberPrice" maxlength="8" size="30" for="username" class="form-control" placeholder="Enter Member Price"  />
<div class="error_msg">
<?php echo form_error('MemberPrice'); ?>
</div>

<div class="col-sm-6">
<label class="control-label " style="padding-top: 12px;"> Available On Book Store  :
 <input type="checkbox" name="status" value="1" <?php if (isset($productdetail['status'])){if($productdetail['status']==1){echo "checked";}}?> <?php if(!empty($_REQUEST['status'])){echo "checked"; }  ?> > </label>
	<br>
	</div>
</div>
<div class="col-sm-6">
<label class="control-label "> 
  <span class="required-field">*</span> Product Description: </label>
 <textarea name="ProductDiscription" value=""  id="description" class="form-control" rows="3"><?php echo isset($productdetail['product_discription'])?$productdetail['product_discription']:set_value('ProductDiscription');?></textarea> 
<div class="error_msg">
<?php echo form_error('ProductDiscription'); ?>
</div>
</div>
</div>
</div>
<div class="col-sm-12 pull-left pad0  ">
 <?php //echo anchor('Custombook_library/show_custombook','CANCEL',array('class' => 'cancel_btn')); ?>
 <a href="<?php echo site_url('addProduct/productlist') ; ?>"> <span class="cancel_btn">Cancel</span></a>
  <input type="submit" name="submit" id="submit_id" value="Submit">
</div>
<br><br>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>