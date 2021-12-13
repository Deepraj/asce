<?php $sortBy=$tabValue=$this->input->get('sortby', TRUE);
?>
<?php echo $this->session->flashdata('msg'); ?>
<style type="text/css">

</style>
<!--<script type="text/javascript" src="./addInstitute_files/jquery-1.11.3.min.js"></script>-->
	<!--<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.12.0.min.js">
	</script>-->
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
	
	</head>
	<body>
	
<div id="adminHomePage" class="">
      <div class="manageAdminTool"> 
    
    <!--		<a href='http://localhost/americanSociety/ASCE_services/index.php/admin'>home </a>  |--> 
    
    
    
    <!--		<a href='http://localhost/americanSociety/ASCE_services/index.php/upload_xmlfile'> Upload books </a> |--> 
   </div>
      <!-- Modal -->
      <div class="modal fade" id="addBookPanel" role="dialog"> </div>
      <div class="modal fade" id="addInstPannel" role="dialog"> </div>
      <div class="adminPopupPanel"> 
    
    <!--Ashwani table start-->
    <div class="clearfix"></div>
    <div class="container bg-shadow">
          <div class="row">
        <div class="col-sm-12">
              <div class="pull-left">
			  <p class='heading-add-inst'>
			  <?php 
			   $userType = end($this->uri->segment_array());
			  if($userType==2)
			  {
				  echo " Institution List";
			  }
			  else
			  {
				  echo "User List";
			  }
			  
			  ?>
           </p>
          </div>
            </div>
      </div>
        <!-- ----------------------------Success Message will shown here -->
        <?php
         echo $this->session->flashdata('msg');
         //echo $msg;
        if(!empty($msg)){
        ?>
	<div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong>
   <?php echo $msg;?>
</div>
<?php }?>
<!-- -----------------------------------------End----------------------->
      <form action ="<?php echo $this->config->item('base_url'); ?>/index.php/userPage/listUser" method="post" name='userListForm'>
          <div class="row">
        <div class="col-sm-3">
              <div class="form-group">
            <input type="text" name="userNameSearch" id="userNameSearch" placeholder="Master Customer ID" class="form-control" value="<?php echo $userNameSearchValue;?>" autocomplete="off">
          </div>
            </div>
        <div class="col-sm-3">
              <div class="form-group">
            <input type="text" name="userEmailSearch" id="userEmailSearch" placeholder="Primary Email" class="form-control" value="<?php echo $userEmailSearchValue;?>" autocomplete="off">
          </div>
            </div>
        <div class="col-sm-3">
              <div class="form-group">
			  <input type="text" name="userStatus" id="userStatus" placeholder="Label Name" class="form-control" value="<?php echo $userStatusValue;?>" autocomplete="off">
          
          </div>
            </div>
        <div class="col-sm-3 pull-right text-left">
              <input name="submit" id="submit_id" type="submit" class="btn btn-primary btn-sm" value="Search" autocomplete="off">
              <a href="<?php echo site_url('userPage/listUser')?>" class="btn btn-default btn-sm">Clear</a> </div>
      </div>
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
                  <li class="<?php echo ($val == $sortBy) ? 'active' : ''; ?>"><a href="<?php echo site_url('userPage/listUser?sortby='.$val)?>"><?php echo $val;?></a></li>
                  <?php }?>
                  <li class="<?php echo ($sortBy!='') ? 'active': ''; ?>active"><a href="<?php echo site_url('userPage/listUser')?>"><strong>All</strong></a></li>
                </ul>
          </nav>
            </div>
        
      </div>
          <br>
          <div class="row">
        <div class="col-sm-12 ">
              <div class="col-sm-12 bg-blue">
            
          </div>
            </div>
      </div>
          <br>
          <div class="row">
        <div class="col-sm-12">
              <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            
            <div class="row">
                  <div class="col-sm-12">
                <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"></div><div class="row"><div class="col-sm-12"><table id="example" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                      <thead>
                    <tr role="row"><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 148px;">Master Customer ID</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 233px;">Label Name</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 233px;">Name</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 233px;">Type</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 48px;">Primary Email</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 99px;">Action</th></tr>
                  </thead>
                      <tfoot>
                    <!--<tr><th rowspan="1" colspan="1">Master Customer ID</th><th rowspan="1" colspan="1">Lable Name</th><th rowspan="1" colspan="1">Name</th><th rowspan="1" colspan="1">Order ID</th><th rowspan="1" colspan="1">Primary Email</th><th rowspan="1" colspan="1">Action</th></tr>-->
                  </tfoot>
                      <tbody>  
                       <?php $i=1;
					  foreach ($users as $row) {  
					  	
					  	$cls=$i%2==0 ? 'even':'odd';
					  	?>
                  <tr role="row" class="<?php echo $cls;?>">
                          <td class=""><?php echo $row->m_masterid;?></td>
						  <td class=""><?php echo $row->m_lablename;?></td>
                          <td class=""><?php echo $row->m_firstname.' '.$row->m_lastname;?></td>
						    <td class=""><?php echo $row->m_custtype;?></td>
						  
                          <td class=""><?php echo $row->m_primaryemail;?></td>
                          <td class=""><a href='<?php echo site_url('userPage/User/'.$row->id.'/'.$row->m_licence_type) ; ?>'><i class="fa fa-pencil-square-o" style="font-size: 19px;padding-right: 10px;"></i></a></td>
                          
                        </tr>
                        <?php 
					  $i++;}?>
						</tbody>
                    </table></div></div></div>
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
      </form>
      <!--Ashwani table start--> 
      
    </div>
</div>
<script>
	$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script type="text/javascript">

 $(document).ready (function(){
                $("#success-alert").alert();
                $("#success-alert").fadeTo(2000, 100).slideUp(500, function(){
               $("#success-alert").alert('close');  
            });
 });
 </script> 