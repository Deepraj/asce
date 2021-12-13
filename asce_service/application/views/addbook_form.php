<div class="adminPopupPanel">
			<div class="heading"><span class="title">
          <?php  
			if($bookid['value'] !=0 ) 
				echo "MANAGE BOOK";
			else 
				echo "ADD BOOK";
		  ?>
            </span></div>
				<div class="panelBody">
					<div class="media">
					  <div class="media-body">
						<?php echo form_open_multipart($this->uri->uri_string());?>
						<div class="form-group bookTitle row">
                        <label class="control-label col-sm-3">Book Title :</label>
						  <div class="col-sm-9">
							<?php echo form_input($booktitle); ?>
						  </div>
                          <div  class="error_msg"><?php echo form_error($booktitle['name']); ?><?php echo isset($errors[$booktitle['name']])?$errors[$booktitle['name']]:''; ?></div>
						</div>
                        <div class="form-group row">
                        <label class="control-label col-sm-3" >Book Sub Title :</label>
                              <div class="col-sm-9">
                                <?php echo form_input($booktitledes); ?>
                              </div>
                         	 <div  class="error_msg">
						  		<?php echo form_error($booktitledes['name']); ?><?php echo isset($errors[$booktitledes['name']])?$errors[$booktitledes['name']]:''; ?></div>
						</div>
                        <div class="form-group row">
                        		<label class="control-label col-sm-3" >ISBN :</label>
                              <div class="col-sm-9">
                                <?php echo form_input($isbn); ?>
                              </div>
                         	 <div  class="error_msg">
						  		<?php echo form_error($isbn['name']); ?><?php echo isset($errors[$isbn['name']])?$errors[$isbn['name']]:''; ?>
                              </div>                        

						</div>
                        
						<div class="form-group row">
                        		<label class="control-label col-sm-3" >Volume :</label>
                              <div class="col-sm-9">
                                <?php echo form_input($volumeno); ?>
                              </div>
                         	 <div  class="error_msg">
						  		<?php echo form_error($volumeno['name']); ?><?php echo isset($errors[$volumeno['name']])?$errors[$volumeno['name']]:''; ?>
                              </div> 
                                                      
						</div>
                        
                        <div class="form-group row">
                        
                        		<label class="control-label col-sm-3" >Authors :</label>
                              <div class="col-sm-9">
                                <?php echo form_input($authors); ?>
                              </div>
                         	 <div  class="error_msg">
						  		<?php echo form_error($authors['name']); ?><?php echo isset($errors[$authors['name']])?$errors[$authors['name']]:''; ?>
                              </div>                         

						</div>
                        <div class="form-group Description row">
                        
                        		<label class="control-label col-sm-3" >Description :</label>
                              <div class="col-sm-9">
                                <?php echo form_textarea($description); ?>
                              </div>
                         	 <div  class="error_msg">
						  		<?php echo form_error($description['name']); ?><?php echo isset($errors[$description['name']])?$errors[$description['name']]:''; ?>
                              </div>                            

                          </div>
                        <?php  if($bookid['value'] ==0 ) { ?>
						<div class="form-group row Select_xml">
                        		<label class="control-label col-sm-3" >Select ZIP :</label>
                              <div class="col-sm-9">
                                <?php echo form_input($userfile); ?>
                              </div>
                         	 <div  class="error_msg">
						  		<?php echo form_error($userfile['name']); ?><?php echo isset($errors[$userfile['name']])?$errors[$userfile['name']]:''; ?>
                              </div>                         

						</div>
                        <?php } ?>
					    <?php echo form_input($old_book_img); ?>
                        <?php echo form_input($bookid); ?>
                       <div class="media-left" style="padding-left: 270px;">
                        <?php  
						if($bookid['value'] !=0) 
						{ 
						?>
						<a  link="" id="book_thump_preview" class="book_thump_preview" href="javascript:void(0)" style="float:left;margin-top: 10px;">
						<img class="" src="<?php echo $thump_img['value'] ; ?>" id="book_thump_uploaded_img" width="100" height="100" >
						<input type="file" class="" id="book_thump_img"  name="book_thump_img" >
						</a>
						<?php } ?>
					  </div>
						<div class="form-group btn-group row">
						  <label class="control-label col-sm-3"></label>
							  <div class="col-sm-9">
								<?php echo anchor('book_library', 'CANCEL',array('class' => 'cancel_btn')); ?>
								<?php echo form_submit('publish', 'PUBLISH'); ?>
							  </div>
						</div>
						<?php echo form_close(); ?>
					  </div>
					</div>
				</div>
		</div>
        
       <script type="text/javascript" >
       	$(document).ready(function(e) {
            	$('#book_thump_img').on('change', function(){  
				//$('#book_thump_img').html('En traitement ...');
					$('#book_thump_form').ajaxForm({
					target : '#book_thump_preview',
					success : UploadImagePath4Profile
					}).submit();
				});
                                
                                
                                
        $("#userfile").change(function () {
            var fileExtension = ['zip'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                 alert("Only zip format is allowed");
                 $("#userfile").val('');
            }
        });                       
                                
                                
                                
                                
                                
                                
        });

function UploadImagePath4Profile()
{	
	/*if ($.browser.msie) {
            $('#book_thump_img').remove();
			$('#chnPhoto').next().append('<input width="1" type="file" name="book_thump_img" size="1" id="book_thump_img" class=""');
			setInputUploadEvent();	
      }
      else {
            $('#book_thump_img').val("");
      }*/
	$('#book_thump_img').val("");
	var book_thump_imgPath = $('#book_thump_uploaded_img').attr('file_path');
	var ProfileSmallImgPath = $('#ProfileSmallUploadedImg').attr('src');
	var ProfileUploadError = $('#book_thump_preview').text().trim();
	if(ProfileUploadError=="")
	{	
		$('#book_img').val(book_thump_imgPath);
	}
	else if(ProfileUploadError == "SIZE-EXCEEDS")
	{
		alert("file size sould be lesser then 1 mb");
	}
	else if(ProfileUploadError == "NOT-SUPPORTABLE-FORMAT")
	{
		alert("Invalid file format ! please upload image format only ");
	}
	else if(ProfileUploadError == "EMPTY")
	{
		alert(ProfileUploadError);
	}
}		
		
		
       </script>