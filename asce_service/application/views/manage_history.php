<div class="adminPopupPanel">
	<div class="heading">
		<span class="title">Manage History</span>
	</div>

	<div class="panelBody">
		<div class="media">
			<div class="media-left">
				<?php echo form_open_multipart($this->uri->uri_string());?>
			</div>
			<div class="media-body cus_book">
							
                            	<div class="form-group primary_book row">
                                	<?php echo form_label('Old Book',$old_book['id'],array('class'=>'col-sm-3'));?>
                                    <div class="col-sm-9">
                                    	<?php echo form_dropdown($old_book['name'],$old_book['value'],$old_book['selected'],array('class'=>'form-control','id'=>'old_book'));?>
                                    </div>
					<div class="error_msg">
                                        <?php echo form_error($old_book['name']);?> <?php echo isset($errors[$old_book['name']])?$errors[$old_book['name']]:'';?>
                                   </div>
				</div>
				<div class="form-group primary_book row">
                                	<?php echo form_label('New Book',$primary_book['id'],array('class'=>'col-sm-3'));?>
                                    <div class="col-sm-9">
                                    	<select name="new_book" class="form-control" id="new_book">
</select>
                                    </div>
					<div class="error_msg">
                                        <?php echo form_error($primary_book['name']);?> <?php echo isset($errors[$primary_book['name']])?$errors[$primary_book['name']]:'';?>
                                   </div>
				</div>
				<div class="form-group btn-group row">
					<label class="control-label col-sm-3"></label>
					<div class="col-sm-9">
										 <?php echo anchor('Manage_history','CANCEL',array('class' => 'cancel_btn')); ?>
                                         <?php echo form_submit('make_history', 'Make History'); ?>
                                         <?php echo form_close(); ?>
                                      </div>
				</div>
			</div>
		</div>
	</div>

</div>
<!---------------------------------------------Ajax Call For Fynamic dropdown loading--------------------------------->
<script>
jQuery(document).ready(function(){
    $("#old_book").change(function() {
     var old_book = $('#old_book').val();
      $.ajax({
        type: "POST",
        data:{ book_id:old_book},
        url: '<?php echo site_url('Manage_history') ; ?>/list_depend_books',

        success: function(value){
        	  $("#new_book").html(value);
         }
       });
     });
   });
</script>
<!---------------------------------------------------------------End--------------------------------------------------->