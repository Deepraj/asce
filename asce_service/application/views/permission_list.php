<?php echo form_open_multipart($this->uri->uri_string());?>
<div class="adminPopupPanel">
			<div class="heading"><span class="title">
          User Permission    
		  <br><br>         </span></div>
          
          
    <!--Ashwani Tab start-->     

 <div class="container">
 
 <div class="row">
 
  
   <div class="col-sm-12">
   
   
   <div class="col-sm-4" style="
    padding-left: 0px;
    padding-right: 0px;
">
 <select name="role" class="form-control" id="role">
<option value=" ">Please Select</option>
<?php foreach($roles as $key=>$value){?>
								<option value="<?php echo $key; ?>" <?php echo ($id == $key) ? 'selected' : ''; ?> class='form-control'><?php echo $value;?></option>
								<?php }?>
</select>
                                <div class="error_msg">
            </div>  
                               </div>
   <?php if($id>0){?>
 <table class="table table-bordered   table-responsive">
	<thead>
		<tr>
			<th bgcolor="#0C5FA8" style="color: #FFF">
				Module
			</th>
			<th bgcolor="#0C5FA8" style="color: #FFF">
			  Privilege
			  </th>
			</tr>
	</thead>
	<?php //print_r($permittedRoles);?>
	<tbody>
	 <?php foreach ($permittedRoles as $key=>$value) { 
	 $keyVal=$key+1;
	 	?>
		<tr>
		  <td>
		    <?php echo $value['title'];?>
		    </td>
		  <td>
          
          <table  border="0">
  <tr>
    <td>
							<input type="checkbox" name='privilege[<?php echo $keyVal;?>][read]'
								<?php echo ($value['read'] == 1)?'checked':''; ?>>View&nbsp; 
						</td>
    <td>
							<input type="checkbox" name="privilege[<?php echo $keyVal;?>][modify]"
								<?php echo ($value['modify'] == 1)?'checked':''; ?>>Modify&nbsp; 
						</td>
  </tr>
</table>

          </td>
		  </tr>
		   <?php }?>
		</tbody>
</table>

   
   <div class="box-footer clearfix text-left">
												<input type="submit" name="SavePrivilages" value="Save">
				</div>
				 <?php }?>
   
   </div>
  
      
</div>

    <!--Ashwani Tab end-->     


		
	
  </div>
</div>
 <?php echo form_close(); ?>  
<script>
$( document ).ready(function() {
    $("#role").change(function(){
        if($(this).val() != ''){
        window.location.href="<?php echo site_url('RoleManagement/userPermission')?>/"+$(this).val();
        }else{
          window.location.href="<?php echo site_url('RoleManagement/userPermission')?>";  
        }
    })
})
</script>