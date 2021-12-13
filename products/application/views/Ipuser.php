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
            "infoEmpty": "No data available in table",
            "infoFiltered": "(filtered from _MAX_ total records)",
	       
        }
		
    } );
	 
} );
</script>
<script>
	function show_confirm(id){
	   //alert(id);
		if(confirm('Do you want delete sub user'))
		{
			window.location='<?php echo site_url();?>/'+'IpuserAdmin/deleteSubUser/'+id;
		}
	}
</script>
<?php 
$sortBy=$tabValue=$this->input->get('sortby', TRUE);
$GUID=$this->session->userdata('GUID'); 
?>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="adminPopupPanel">
    <div class="container bg-shadow">
        <div class="row">
        <div class="col-sm-12">
              <div class="pull-left"><p align='left' style="color:red; margin-left:10px;"><b>To update or add IP ranges, please contact ASCE Customer Service at 800-548-2723 or 703-295-6300, 8:00 am to 5:00 pm ET. </b></p>
            <p class="heading-add-inst">IP LIST</p>
          </div>
        </div>
      </div>
     <div id="fade" class="black_overlay"></div>
	  <div class="row">
	  </div>
	  <br>
	   <div id="notice"><?php if(!empty($this->session->flashdata('message'))){  echo "<font style='color:green; font-size:14px; padding-left: 300px;'><strong>".$this->session->flashdata('message')."</strong></font>"; } ?></div>
        <div class="row">
        <div class="col-sm-12">
              <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
               <div class="row">
                <div class="col-sm-12">
				<div class="col-sm-12 pull-right text-right mt20"> 
              <span class=" pull-left text-left">
            </span>
		<span class=" pull-right text-right">   
		 </span>
		 </div>
                <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"></div><div class="row"><div class="col-sm-12">
				<table id="example" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr role="row"><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 148px;">Minimum IP </th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 148px;">Maximum IP  </th>
					<!--<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 233px;">Middle Name</th>-->
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 108px;">Start date</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 99px;">End date</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 99px;">Status</th>
					</tr>
                  </thead>
                <tbody>  
				  <?php
					 $i =1;
					  foreach($SubUserList as $row)
					  { 
//print_r($row['start_date']); die;					  
					  ?>
					  <tr role="row" class="odd">
                          <td class=""><?php echo !empty($row['low_ip'])?$row['low_ip']:'N/A'; ?> </td>
						  <td class=""><?php echo !empty($row['high_ip'])?$row['high_ip']:'N/A'; ?> </td>
                          <td class=""><?php $date = date_create($row['start_date']); echo !empty($row['start_date'])?date_format($date,'m/d/Y'):'N/A'; ?></td>
                          <!--<td class=""><?php //echo !empty($row->middle_name)?$row->middle_name:'N/A'; ?></td>-->
	                      <td class="">
						   <?php $enddate =date_create( $row['end_date']); echo !empty($row['end_date'])?date_format($enddate,'m/d/Y'):'N/A'; ?>
                           </td>
						    <td class=""><?php 
							if($row['aui_status']==0)
							{
								echo "InActive";
							}
							else
							{
								echo"Active";
							}

								?></td>
						   
                      <!-- <td class=""><a href='<?php echo site_url('MuserAdmin/EditSubUser?id='.$row['product_id'].'') ; ?>' title="Edit "><i class="fa fa-pencil-square-o" style="font-size: 19px;padding-right: 10px;"></i></a>
				        <a href='javascript:show_confirm(<?php echo $row['product_id'];?>)'  title="Delete "><i class="fa fa-times" style='font-size: 19px;padding-right: 10px;'></i></a></td>--->
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
  <script type="text/javascript">
     $(document).ready (function(){
          $("#notice").fadeTo(5000, 100).slideUp(500, function(){
      });
 });
 </script>
  </body>
<footer class="footer-bg " >
	<div class="container">
		<div class="row" >
			<div class="col-md-4 text-left">
			 <a class="" href="http://www.asce.org/" target="blank"><img src="http://asce.adi-mps.com/products/img/footerlogo.png" /><br>
			       1801 Alexander Bell Drive<br>
				   Reston, VA 20191-4400<br>
				   703-295-6300 | 800-548-2723</a><br>
			</div>
			<div class="col-md-4 text-center" >
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
				© 20178 merican Society of Civil Engineers
			</div>
		</div>
	</div>	
</footer>
</html>
