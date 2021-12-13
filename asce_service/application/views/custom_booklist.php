<?php
$this->userid = $this->session->userdata('user_id');
?>
<script>
	function show_confirm(id){
		if(confirm('Do You Want To Delete Selected Book ?'))
		{
			window.location='<?php echo site_url();?>/'+'Custombook_library/delete_custumbook/'+id;
		}
	}
	</script>
		<div class="searchToolSec">
			<form action ="<?php echo $this->config->item('base_url'); ?>/index.php/Custombook_library/show_custombook" class="form-inline" role="form" method="post">
            
				<div class="panel panel-default">
					<div class="panel-heading srchBookTitle">SEARCH BOOK(S)</div>
					<div class="form-group search_container">
                            
						<div class="srchRow srchBook">
							<label class="control-label text-right col-sm-3" for="book">SEARCH A BOOK TITLE :</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="custom_titlesearch" name="custom_titlesearch" placeholder="Search for..." value='<?php echo $search;?>'>
                              <input type="text" name="search_from_date" id="search_from_date" class="form-control datepicker" placeholder="From" value='<?php echo $search_from_date;?>'>
                              <input type="text" name="search_to_date" id="search_to_date" class="form-control datepicker" placeholder="To" value='<?php echo $search_to_date;?>'>	
 								<input name="submit" type="submit" value="Search" id="submit" class="btn btn-primary" />
							</div>
						</div>  
						<!--<div class="srchRow selectBook">
							<label for="sel1" class="col-sm-3 text-right">SELECT A BOOK TITLE :</label>
							<div class="col-sm-9 ">
					
                                <select class="form-control" id="sel1">
                     <?php /*?>			  <?php
								  foreach ($books as $row)
								  {
							  	 ?>
								<option><?php echo $row->m_custboktitle; ?></option>
                                    <?php }?><?php */?>
								</select>
                                   
								<label for="from">From : </label>
								<input type="text" id="from" class="form-control" placeholder="SEARCH">
								<label  for="to">To : </label>
								<input type="text" id="to" class="form-control" placeholder="SEARCH">	
 								<input type="submit" value="Search" id="submit" class="btn btn-primary" />
 								<!--<button type="button" class="btn btn-primary">SEARCH</button>
							</div>
                         
						</div>-->
					</div>
				</div>
			</form>
			<div class="panel panel-default searchResultSec">
              <?php
				  if(isset($_POST['submit']) && ($_POST['custom_titlesearch'])) {
					echo "<div class='panel-heading selectBookTitle'>SEARCH RESULTS</div>"; // Search Result
				  }
			  ?>
			  <div class="panel-body">
                    <?php
						 foreach ($books as $row) {
							 
					?>
					<div class="bookList">
					<div class="bookArea">

                              <img src="<?php 
							  if($row->m_custbokthumb != ""){echo $this->config->item('base_url')."/../".$this->config->item('image_path') .$row->m_bokisbn ."/vol-". $row->m_volnumber."/"."cover_img"."/" . $row->m_custbokthumb ;
							  }else{
								echo $this->config->item('base_url').$this->config->item('default_cover_image_path');
							}?>"/>
                            
                            <!--<span class="edit"><button type="button" class="btn btn-primary">EDIT</button></span>-->
							</div>
							<div class="bookDetails">
								<div class="BookMainDetails" >
                                	<h3><?php echo $row->m_custboktitle;?></h3>
                                    <h4><?php echo $row->m_boktitle;?></h4>
									<h6>DESCRIPTION</h6>
									<p><?php echo $row->m_custbokdescription;?>
									</p>
                               </div>
								<div class="updateBtn-grp">
								<span class="edit"><a href='<?php echo site_url('Authentication/index/COSTOM/'. $row->m_custbokid) ; ?>' class="btn btn-primary">READ BOOK</a></span>
                                
									<!--<span class="updateBtn"><button type="button" class="btn btn-primary">UPDATE CONTENT</button></span>
									<span class="updateBtn"><button type="button" class="btn btn-primary">UPDATE PERMISSIONS</button></span>
									<span class="updateBtn"><button type="button" class="btn btn-primary">PRICING</button></span>-->
								</div>
							</div>
							<div class="btn-area">
                            <?php
							if($this->tank_auth->is_user_admin()){
							
							?>
								<span class="edit"><a href='<?php echo site_url('Custombook_library/addcustombook/'.$row->m_custbokid.'') ; ?>' class="btn btn-primary">EDIT</a></span>
                               <span class="edit"><a href='javascript:show_confirm(<?php echo $row->m_custbokid;?>)' class="btn btn-primary">DELETE</a></span>
								<span class="amount"><button type="button" class="btn btn-primary">$<?php echo $row->m_custbokprice;?></button></span>
                            <?php
							}
							else
							{
							?>
                          <!--  <span class="edit" style="display:none"><a href='<?php echo site_url('Custombook_library/addcustombook/'.$row->m_custbokid.'') ; ?>' class="btn btn-primary">EDIT</a></span>
                                <span class="edit" style="display:none"><a href='<?php echo site_url('Custombook_library/delete_custumbook/'.$row->m_custbokid.'') ; ?>' class="btn btn-primary">DELETE</a></span>
								<span class="amount" style="display:none"><button type="button" class="btn btn-primary"><?php echo $row->m_custbokprice;?></button></span>-->
                                <?php
							}
							?>
                           </div>	
                            
					</div>
              <?php
              }
			  if (count($books) < 1) {
   				 echo '<h3 align="center">No results found. Please try your search again, or try <a href="show_custombook">another search</a>.</h3>';
			}
			  ?>
			  </div>
			</div>
		</div>
</div>	

<script type="text/javascript">

	$(document).ready(function(e) {
		$('#search_from_date').Zebra_DatePicker({
			format: 'Y-m-d',
			selectWeek: true,
			inline: true,
			pair: $('#search_to_date'),
			firstDay: 1,
			//direction: true, // add this line
			onSelect: function(view, elements){
				$('#search_to_date').val($(this).val());
			}
		});
		
		$('#search_to_date').Zebra_DatePicker({
			format: 'Y-m-d',
			selectWeek: true,
			//	direction: true // change 0 to true
		});

	});

</script>
