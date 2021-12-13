<?php
$booktitle = array(
	'name'	=> 'booktitle',
	'id'	=> 'booktitle',
	'value'	=> set_value('booktitle'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'for' => "bookTitle",
	'class' => "form-control",
);
	
$booktitledes = array(
	'name'	=> 'booktitledes',
	'id'	=> 'booktitledes',
	'value'	=> set_value('booktitledes'),
	'for' => "BookSubTitle",
	'class' => "form-control",
);
$authors = array(
	'name'	=> 'authors',
	'id'	=> 'authors',
	'value'	=> set_value('authors'),
	'for' => "Authors",
	'class' => "form-control",
);
$description = array(
	'name'	=> 'description',
	'id'	=> 'description',
	'value'	=> set_value('description'),
	'for' => "Description",
	'class' => "form-control",
);

?>


<div class="adminPopupPanel">
			<div class="heading"><span class="title">UPDATE BOOK</span></div>
			
			<form class="form-horizontal" role="form" method="post" action="<?php echo $this->config->item('base_url'); ?>/index.php/book_library/update_book">
				<div class="panelBody">
					<div class="media">
					  <div class="media-left">
						<a href="#">
						  <img class="media-object" src="<?php echo base_url('assets/images') ; ?>/book.png">
						</a>
					  </div>
                       <?php
					  foreach ($b as $row)
					  {
				   ?>
                   <?php echo form_open_multipart($this->uri->uri_string());?>
					  <div class="media-body">
						<div class="form-group bookTitle">
                        <?php echo form_label('Book Title', $booktitle['id']); ?>
						  <div class="col-sm-9">
                         	<input type="text" class="form-control" name="booktitle" value="<?php echo set_value('booktitle', $row->m_boktitle)?>">
						  </div>
                          
                          <div  class="error_msg"><?php echo form_error($booktitle['name']); ?><?php echo isset($errors[$booktitle['name']])?$errors[$booktitle['name']]:'';?></div>
						</div>
                        <div class="form-group bookSubTitle">
                        <?php echo form_label('Book Sub Title :', $booktitledes['id']); ?>
						  <div class="col-sm-9">
                          <input class="form-control" value="<?php echo set_value('booktitledes', $row->m_boksubtitle)?>" type="text" name="booktitledes" />
                          <!--<input type="text" class="form-control" name="booktitledes" value="<?php //echo $row->m_boksubtitle;?>">-->
						  </div>
                           <div  class="error_msg">
						  		<?php echo form_error($booktitledes['name']); ?><?php echo isset($errors[$booktitledes['name']])?$errors[$booktitledes['name']]:''; ?></div>
						</div>
                        <div class="form-group author">
                        <?php echo form_label('Authors :', $authors['id']); ?>
						  <div class="col-sm-9">
                        
							<input type="text" class="form-control" name="authors" value="<?php echo set_value('authors',$row->m_bokauthorname)?>">
						  </div>
                           
                           <div  class="error_msg">
						  		<?php echo form_error($authors['name']); ?><?php echo isset($errors[$authors['name']])?$errors[$authors['name']]:''; ?>
                              </div>    
						</div>
                        <div class="form-group Description">
                        <?php echo form_label('Description :', $description['id']); ?>
						  <div class="col-sm-9">
                          
							<textarea class="form-control"  name="description" rows="4" style="height:100px"><?php echo set_value('description',$row->m_bokdesc)?></textarea>
						  </div>
                          <div  class="error_msg">
						  		<?php echo form_error($description['name']); ?><?php echo isset($errors[$description['name']])?$errors[$description['name']]:''; ?>
                              </div>  
                       </div>
                       <input type="hidden" class="form-control" name="isbn" value="<?php echo $row->m_bokisbn;?>">
                       <?php } ?>
						<div class="form-group btn-group col-sm-12">
						  <label class="control-label col-sm-3"></label>
							  <div class="col-sm-9">
								<!--<button class="btn btn-primary cancel">CANCEL</button>-->
								<!--<input type="submit" name="submit" value="update" />-->
                               <?php echo form_button('cancel', 'cancel'); ?>
								<?php echo form_submit('update', 'UPDATE'); ?>
                                <?php echo form_close(); ?>
								<!--<button class="btn btn-primary publich">PUBLISH</button>-->
							  </div>
						</div>
					  </div>
					</div>
				</div>
			</form>
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