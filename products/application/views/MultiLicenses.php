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
            "infoEmpty": "Number of record zero",
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
			window.location='<?php echo site_url();?>/'+'MuserAdmin/deleteSubUser/'+id;
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
              <div class="pull-left">
            <p class="heading-add-inst">Licenses</p>
          </div>
        </div>
      </div>
     <div id="fade" class="black_overlay"></div>
	 <form action="<?php echo site_url('MultiLicenses/SortbyProduct');  ?>"  method="post" accept-charset="utf-8">
       <div class="row">
        <div class="col-sm-4">
              <div class="form-group">
			    <input type="text" name="productId" id="productId" placeholder="Product Id" class="form-control" value="<?php if(isset($_REQUEST['search'])){echo $_REQUEST['productId'];} ?>" autocomplete="off"  >
                <div  id="fb-errorid"></div>
		     </div>
         </div>
        <div class="col-sm-4">
              <div class="form-group">
            <input type="text" name="productName" id="productName" placeholder="Product Name" class="form-control" value="<?php if(isset($_REQUEST['search'])){echo $_REQUEST['productName'];} ?>" autocomplete="off"  >
		   <div id="fb-errorname"></div>
		   </div>
		  </div>
			<!--<div class="col-sm-4">
              <div class="form-group">
             <!--<input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control" value="<?php //echo $productcodesearch ;?>"  autocomplete="off" maxlength="20">
		      <div  id="fb-errorcode"></div>
			</div>
		</div>-->
        <div class="col-sm-4 pull-right text-left">
              <input name="search" id="submit_id" type="submit" class="btn btn-primary btn-sm" value="Search" autocomplete="off">
              <a href="<?php echo site_url('MultiLicenses')?>" class="btn btn-default btn-sm">Clear</a> </div>
        </div>
		</form>
	  <div class="row">
        <div class="col-sm-12">
              <nav>
            <ul class="pagination pagination-sm nomargin">
            <?php 
            function getAlphaByNumber($n)
            {
            	for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
            		$r = chr($n%26 + 0x41) . $r;
            		return $r;
            }
            for($i=0;$i<=25;$i++){
            	$val=getAlphaByNumber($i);
            
            ?>
                  <li class="<?php echo ($val == $sortBy) ? 'active' : ''; ?>"><a href="<?php echo site_url('MultiLicenses/SortbyProduct/?sortby='.$val)?>"><?php echo $val;?></a></li>
                  <?php }?>
                  <li class="<?php echo ($sortBy!='') ? 'active': ''; ?>active"><a href="<?php echo site_url('MultiLicenses')?>"><strong>All</strong></a></li>
                </ul>
          </nav>
          </div>
        </br>
      </div>
	  <br>
	   <div id="notice"><?php if(!empty($this->session->flashdata('message'))){  echo "<font style='color:green; font-size:14px; padding-left: 300px;'><strong>".$this->session->flashdata('message')."</strong></font>"; } ?></div>
        <div class="row">
        <div class="col-sm-12">
              <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
               <div class="row">
                <div class="col-sm-12">
                <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"></div><div class="row"><div class="col-sm-12">
				<table id="example" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr role="row"><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 15%;">Product Id</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 27%"> Product Name</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 14%;">Start Date</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 14%;">End Date</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 15%;">Concurrent Users </th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 15%;">Negotiated Users </th>
                  </thead>
                <tbody>  
				  <?php
					 $i =1;
					 if(!empty($SubUserList)){
					//echo "<pre>"; print_r($SubUserList);
					  foreach($SubUserList as $row)
					  { 					  
					  ?>
					  <tr role="row" class="odd">
                          <td class=""><?php echo !empty($row['product_id'])?$row['product_id']:'N/A'; ?> </td>
                          <td class=""><?php echo !empty($row['product_name'])?$row['product_name']:'N/A'; ?></td>
                          <td class=""><?php $date=date_create($row['start_date']); echo !empty($row['start_date'])?date_format($date,'m/d/Y'):'N/A'; ?></td>
						  
                          <td class=""><?php $enddate = date_create($row['end_date']); echo !empty($row['end_date'])?date_format($enddate,'m/d/Y'):'N/A'; ?></td>
                          <td class=""><?php echo !empty($row['licence_count'])?$row['licence_count']:'N/A'; ?></td>
						   <td class=""><?php echo !empty($row['Nigotiate_count'])?$row['Nigotiate_count']:'0'; ?></td>
                        </tr>	
				<?php 
				}
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
		<div class="row" style="">
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
			<div class="col-md-4 text-center" style="">
				<a href=" http://www.asce.org/about_asce/" target="blank">About ASCE</a><br>

<a href="http://www.asce.org/contact_us/ " target="blank">Contact Us</a><br>
				<a href="http://ascelibrary.org/" target="blank">ASCE Library</a>
			</div>
			<br>
			<div class="col-md-12 text-center color-white" >
				© 20178 American Society of Civil Engineers
			</div>
		</div>
	</div>	
</footer>
</html>
 
