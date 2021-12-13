<div class="adminPopupPanel">
			<div class="heading"><span class="title">CUSTOM BOOK</span></div>
			
				<div class="panelBody">
					<div class="media">
						<div class="media-left">                            
							<form action="<?php echo $this->config->item('base_url'); ?>/index.php/book_library/upload_book_thump" enctype="multipart/form-data" method="post" class="" id="book_thump_form" style="float:left;height: 180px;">
								<a  link="" id="book_thump_preview" class="book_thump_preview" href="javascript:void(0)" style="float:left;margin-top: 10px;">
                                <img class="" src="<?php 
								if($thump_img['value'] != ""){
									echo $thump_img['value'];
								}else{ 
									echo $this->config->item('base_url').$this->config->item('default_cover_image_path');
								} ?>" id="book_thump_uploaded_img" style="float:left;"></a>
								<span class="chnPhotoActive" id="chnPhoto">
									<span class="chnPhototext">choose</span>
								</span>
								<input type="file" class="" id="book_thump_img" size="1" width="1" name="book_thump_img" >
							</form>             
					  	</div>
						<div class="media-body cus_book">
							<?php echo form_open_multipart($this->uri->uri_string());?>
                            	<div class="form-group primary_book row">
                                	<?php echo form_label('Primary Book',$primary_book['id'],array('class'=>'col-sm-3'));?>
                                    <div class="col-sm-9">
                                    	<?php echo form_dropdown($primary_book['name'],$primary_book['value'],$primary_book['selected'],array('class'=>'form-control'));?>
                                    </div>
                                    <div class="error_msg">
                                        <?php echo form_error($primary_book['name']);?> <?php echo isset($errors[$primary_book['name']])?$errors[$primary_book['name']]:'';?>
                                   </div>
                                </div>
                                
                                <div class="form-group cus_book_title row">
                                    <?php echo form_label('Book Title', $cus_book_title['id'],array('class'=>'col-sm-3')); ?>
                                    <div class="col-sm-9">
    	                                <?php echo form_input($cus_book_title); ?> 
                                    </div>                          
                                    <div class="error_msg">
                                        <?php echo form_error($cus_book_title['name']);?> <?php echo isset($errors[$cus_book_title['name']])?$errors[$cus_book_title['name']]:'';?>
                                   </div>
                                </div>
                                
                                <div class="form-group cus_book_des row">
                                    <?php echo form_label('Book Description', $cus_book_des['id'],array('class'=>'col-sm-3')); ?>
                                    <div class="col-sm-9">
    	                                <?php echo form_textarea($cus_book_des); ?> 
                                    </div>                          
                                    <div class="error_msg">
                                        <?php echo form_error($cus_book_des['name']);?> <?php echo isset($errors[$cus_book_des['name']])?$errors[$cus_book_des['name']]:'';?>
                                   </div>
                                </div>
                                
                                <div class="form-group cus_chap_all_select row">
                                    <?php echo form_label('Select Chapter', $cus_chap_all_select['id'],array('class'=>'col-sm-3')); ?>
                                    <div class="col-sm-9">
    	                                <?php echo form_input($cus_chap_all_select); ?> All
                                    </div>
                                </div>
                                
                            	<div class="form-group selected_cusbook_chap row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                    	<?php echo form_dropdown($selected_cusbook_chap['name'],$selected_cusbook_chap['value'],$selected_cusbook_chap,array('class'=>'form-control multiselect'));?>
                                    </div>
                                    <div class="error_msg">
                                        <?php echo form_error($selected_cusbook_chap['name']);?> <?php echo isset($errors[$selected_cusbook_chap['name']])?$errors[$selected_cusbook_chap['name']]:'';?>
                                   </div>
                                </div>                               
                                
                                <div class="form-group cus_book_price row">
                                    <?php echo form_label('Price', $cus_book_price['id'],array('class'=>'col-sm-3')); ?>
                                    <div class="col-sm-9">
    	                                <?php echo form_input($cus_book_price); ?> 
                                    </div>                          
                                    <div class="error_msg">
                                        <?php echo form_error($cus_book_price['name']);?> <?php echo isset($errors[$cus_book_price['name']])?$errors[$cus_book_price['name']]:'';?>
                                   </div>
                                </div>

                                <div class="form-group valid_date_from row">
										<?php echo form_label('Valid Period',$valid_date_from['id'],array('class'=>'col-sm-3')); ?>
                                    <div class="col-sm-9">
                                        <?php echo form_label('From :',$valid_date_from['id']); ?>
    	                                <?php echo form_input($valid_date_from); ?> 
	                                    <?php echo form_label('To :',$valid_date_to['id']); ?>
    	                                <?php echo form_input($valid_date_to); ?> 
                                    </div>                          
                                    <div class="error_msg">
                                        <?php echo form_error($valid_date_from['name']);?> <?php echo isset($errors[$valid_date_from['name']])?$errors[$valid_date_from['name']]:'';?>
                                   </div>
                                    <div class="error_msg">
                                        <?php echo form_error($valid_date_to['name']);?> <?php echo isset($errors[$valid_date_to['name']])?$errors[$valid_date_to['name']]:'';?>
                                   </div>
                                </div>
                                <?php echo form_input($cus_book_img); ?>
                        		<?php echo form_input($oldbook_cover_img); ?>
                        		<?php echo form_input($cus_bookid); ?>
                       
                                <div class="form-group btn-group row">
                                  <label class="control-label col-sm-3"></label>
                                      <div class="col-sm-9">
										 <?php echo anchor('Custombook_library/show_custombook','CANCEL',array('class' => 'cancel_btn')); ?>
                                         <?php echo form_submit('update', 'UPDATE'); ?>
                                         <?php echo form_close(); ?>
                                      </div>
							 </div>
					  </div>
					</div>
				</div>

		</div>
        
        <script type="text/javascript" >
       	$(document).ready(function(e) {
				loadPrimaryBookChapter();
            	$('#book_thump_img').on('change', function(){  
				//$('#book_thump_img').html('En traitement ...');
					$('#book_thump_form').ajaxForm({
					target : '#book_thump_preview',
					success : UploadImagePath4Profile
					}).submit();
				});
			    $('input.datepicker').Zebra_DatePicker({format: 'd-m-Y'});
				
				$('#valid_date_from').Zebra_DatePicker({
					format: 'd-m-Y',
					selectWeek: true,
					inline: true,
					pair: $('#valid_date_to'),
					firstDay: 1,
					direction: true, // add this line
					onSelect: function(view, elements){
						/*var from_date = new Date($(this).val());
            			var to_date = new Date($('#valid_date_to').val());
						if(this.id == 'from_date') {
							if (from_date > to_date) {alert(1)
								$('#to_date').val(from_date);
							}
						}else{
							if (to_date < from_date) {
								$('#from_date').val(to_date);
							}
						}*/
						$('#valid_date_to').val($(this).val());
					}
				});
				
				$('#valid_date_to').Zebra_DatePicker({
					format: 'd-m-Y',
					selectWeek: true,
					direction: true // change 0 to true
				});

				
				$('input#cus_chap_all_select').click(function(){
					if($(this).prop("checked") == true){
		  				$("select[name='selected_cusbook_chap[]'] option").prop("selected", true);
					}else{
		  				$("select[name='selected_cusbook_chap[]'] option").prop("selected", false);
					}
				});
				
				$("select[name='selected_cusbook_chap[]']").click(function(){
					$('input#cus_chap_all_select').prop("checked",false );
				})

				$("select[name='primary_book']").change(function(){
					loadPrimaryBookChapter();
				});
				
        });

function loadPrimaryBookChapter(){
	  var primary_book_id =$("select[name='primary_book']").val();
	  <?php echo $this->config->item('base_url')."/../".$this->config->item('image_path') .$row->m_bokisbn ."/vol-". $row->m_volnumber."/"."cover_img"."/" . $row->m_custbokthumb;?>
	  var selected_chapter = <?php echo json_encode($selected_cusbook_chap['selected']);?>;
		if (primary_book_id != ""){
			var post_url = "<?php echo base_url();?>/index.php/Custombook_library/list_custumchapter/"+primary_book_id;
			$.ajax({
				type: "POST",
				 url: post_url,
				 success: function(chapters) //we're calling the response json array 'cities'
				  {
					$("select[name='selected_cusbook_chap[]']").empty();
					   $.each(chapters,function(id,chapter){
							var opt = $('<option />'); 
							$.each(selected_chapter,function(key,value){
								if(value.t_custchpmchpid == chapter.id){
									opt.prop('selected',true);
								}
							})
							opt.val(chapter.id);
							opt.text(chapter.chapter);							
							$("select[name='selected_cusbook_chap[]']").append(opt); 
					});
				   } //end success
			 }); //end AJAX
		} else {
			$("select[name='selected_cusbook_chap[]']").empty();
		}
}

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
		$('#cus_book_img').val(book_thump_imgPath);
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