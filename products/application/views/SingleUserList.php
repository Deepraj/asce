 <?php
        $MasterCustomerId=$this->session->userdata('MasterCustomerId');
		$userType=$this->session->userdata('LicenceInfo');
		$GUID=$this->session->userdata('GUID');
		 if(isset($userType)){
			if($userType=='SINGLE'){
				$reader_url=$this->config->item('single_reader_url');
			}
			else if($userType=='MULTI'){
				$reader_url=$this->config->item('multi_reader_url');
			}
			else if($userType=='IPBASED'){
				$reader_url=$this->config->item('ipbased_reader_url');
			}
		else{
			 $reader_url=$this->config->item('reader_url');
		}
		
	 }
	 
?>
 <script type="text/javascript">
        $(document).ready(function(){

            // Check if the current URL contains '#'
            if(document.URL.indexOf("#")==-1)
            {
                // Set the URL to whatever it was plus "#".
                url = document.URL+"#";
                location = "#";

                //Reload the page
                 location.reload(true);
            }
        });
		
</script>
   <?php if(!empty($GUID)){  ?>
    <div class="col-md-12 text-right mt30" style="padding-right: 100px;">
				<a href='<?php echo base_url()."?GUID=".$GUID;?>'>
				<button type="button" class="btn btn-primary btn-sm">
							Back to book list &nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
				</button>
				</a>
	</div>
	<?php } ?>
	
   <div id="login_details" style="padding-top: 50px;">
	<div class="container" >
	<?php 
	  if(!empty($this->session->userdata('MasterCustomerId'))){
	  echo "<p id='mydiv' style='color:red;text-align:center;padding-top:20px;'><strong>".$this->session->flashdata('message')."</strong></p>"; 
	  
	  }
	  $GUID=$this->session->userdata('GUID');
		/*---------------------------Subscribed Product List----------------------------*/
		//echo "<pre>"; print_r( $subscribedBookList); die;
			if (isset ( $subscribedBookList )) {
				foreach ( $subscribedBookList as $subsBook ){		   
					$img_url = base_url () . '../asce_content/book/' . $subsBook->m_bokisbn . '/vol-' . $subsBook->m_volnumber . '/cover_img/' . $subsBook->m_bokthump;
					?>
			
  <div class="panel panel-default mt30">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">
					<img src="<?php echo $img_url;?>"
							class="img-thumb img-responsive" alt="Cinque Terre" width="1600"
							height="1067">
					</div>
					<div class="col-md-7">
						<p>
							<strong><?php echo $subsBook->m_boktitle;?>
                          </strong>
						</p>
						<p style="text-align: justify;"><?php echo substr($subsBook->m_bokdesc,50);?></p>
						<p>
						 <ul class="list-inline news-v1-info">
							<li><span>By</span> | <?php echo substr($subsBook->m_bokauthorname,20);?></li>
							<li></li>
						</ul>
						</p>
					</div>
				<div class="col-md-3 text-right">
						<!-- <div class=""><select name="Subscription Type
" class="countries form-control" id="Subscription">
                    <option selected="selected">Subscription Type
</option>
                    <option value="1" countryid="1">Single User</option>
                    </select></div>
    <h4>$130.00 </h4> -->
	                   <p> <?php  echo DateInterval($subsBook ->end_date); ?></p>
						<p>
						<?php  
						//$url=$subsBook->m_bokid.'/'.$subsBook->m_bokid.'/'. $MasterCustomerId;    
						?>
						<a 	href='<?php echo $reader_url; ?><?php echo $subsBook->m_bokid;?>/<?php echo $subsBook->m_volid; ?>/<?php echo $this->session->userdata('MasterCustomerId');?>'>
						<button type="button"  class="btn btn-primary btn-sm">
							   Read Book &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
						</button></a>
						</p>
						<?php if (!empty ($MasterCustomerId)){
				?>
						<p>	<a
								href='<?php echo site_url('/Description?id='.$subsBook->m_bokid."&isbn=".$subsBook->m_bokisbn)?>'><button
									type="button" class="btn btn-primary btn-sm">
									More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
								</button></a>
						</p>
                     <?php }else{ ?>
					    <p>
							<a href='<?php echo site_url('/Description?id='.$subsBook->m_bokid)?>'><button
							  type="button" class="btn btn-primary btn-sm">
							   More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
							</button></a>
						</p>
				<?php } ?>
					</div>
				</div>
			</div>
		</div>
        <?php
		     }
			}
		?>
            <!-----------------------------------------End---------------------------------->
		<!-----------------------------------Un-Subscribed Product List----------------->
  <?php
   
   //echo "<pre>"; print_r($SingleUser); die;
  	foreach( $productList as $prod ){
	     	  // echo "<pre>"; print_r($prod->book_id); die;
			$img_url = base_url () . '../asce_content/book/' . $prod->m_bokisbn . '/vol-' . $prod->m_volnumber . '/cover_img/' . $prod->m_bokthump;
			?>
  <div class="panel panel-default mt30">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">
						 <img src="<?php echo $img_url;?>"
							class="img-thumb img-responsive" alt="Cinque Terre" width="1600"
							height="1067">
					</div>
					<div class="col-md-7">
						<p>
							<strong><?php echo $prod->m_boktitle;?>
                     </strong>
						</p>
						<p style="text-align: justify;"><?php echo substr($prod->m_bokdesc,50);?></p>
						<p>
						<ul class="list-inline news-v1-info">
							<li><span>By</span> | <?php echo $prod->m_bokauthorname;?></li>
							<li></li>
						</ul>
						</p>
					</div>
			 <div class="col-md-3 text-right">
          <?php
			
			if (!empty ( $GUID )) {
				?>
                        <p><a
								href='<?php echo site_url('/Description?id='.$prod->m_bokid)?>'><button
									type="button" class="btn btn-primary btn-sm">
									More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
								</button></a>
						</p>
            <?php
			} else {
				?>
                    <p>
							<a 	href='<?php echo site_url('/Description?id='.$prod->m_bokid)?>'><button
									type="button" class="btn btn-primary btn-sm">
									More Info &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
								</button></a>
					</p>

<?php
			}
			?>
      </div>
				</div>
			</div>
		</div>
  <?php
    
	
   }
  ?>
  <!---------------------------------------------------End-------------------------------------------------------------->
	</div>
</div>
</form>
<script>
$(document).ready(function(){ 
    setTimeout(function() {
    $('#mydiv').fadeOut('fast');
   }, 10000);
});

</script>
</body>
</html>