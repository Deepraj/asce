<style>
    .black_overlay{
        display: none;
        position: fixed;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index:1001;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
    }
     .white_content {
         display: none;
      
         width: 51%;

         height: 200px;
        border: 9px solid #337ab7;
        background-color: white;
        z-index:1002;
        overflow: hidden;
		 position: fixed;
        top: 45%;
        left: 33%;
       margin-top: -50px;
       margin-left: -100px;
    }
</style>
<?php $sortBy=$tabValue=$this->input->get('sortby', TRUE);
?>
<?php echo $this->session->flashdata('msg'); ?>

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
            //"infoEmpty": "No data available in table",
            "infoFiltered": "(filtered from _MAX_ total records)",
	       
        }
		
    } );
	 
} );
	</script>
	<script>
	function show_confirm(id){
		if(confirm('Do You Realy Want To Delete Selected Product'))
		{
			window.location='<?php echo site_url();?>/'+'addProduct/deleteProduct/'+id;
		}
	}
	</script>
	
	<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
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
            <p class="heading-add-inst">PRODUCT LIST</p>
          </div>
            </div>
      </div>
      <!-- ----------------------------Success Message will shown here -->
	<!-- <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong>
    Product have added to your wishlist.
</div> -->
<!-- -----------------------------------------End----------------------->
<div id="fade" class="black_overlay"></div>
      <form action ="<?php echo $this->config->item('base_url'); ?>/index.php/AddProduct/productlist" method="post" id="searchProduct" name='instituteListForm'>
          <div class="row">
        <div class="col-sm-3">
              <div class="form-group">
			    <input type="text" name="booknamesearch" id="booknamesearch" placeholder="Product Id" class="form-control" value="<?php echo $booknamesearch ;?>" autocomplete="off" maxlength="20" >
                <div  id="fb-errorid"></div>
		 </div>
            </div>
        <div class="col-sm-3">
              <div class="form-group">
            <input type="text" name="productnamesearch" id="productnamesearch" placeholder="Product Name" class="form-control" value="<?php echo $productnamesearch ;?>" autocomplete="off"  >
		   <div id="fb-errorname"></div>
		   </div>
		  
            </div>
			<div class="col-sm-3">
              <div class="form-group">
             <input type="text" name="productcodesearch" id="productcodesearch" placeholder="Product Code" class="form-control" value="<?php echo $productcodesearch ;?>"  autocomplete="off" maxlength="20">
		      <div  id="fb-errorcode"></div>
			  </div>
			  
            </div>
        
        <div class="col-sm-3 pull-right text-left">
              <input name="submit" id="submit_id" type="submit" class="btn btn-primary btn-sm" value="Search" autocomplete="off">
              <a href="<?php echo site_url('AddProduct/productList')?>" class="btn btn-default btn-sm">Clear</a> </div>
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
                  <li class="<?php echo ($val == $sortBy) ? 'active' : ''; ?>"><a href="<?php echo site_url('addProduct/productlist?sortby='.$val)?>"><?php echo $val;?></a></li>
                  <?php }?>
                  <li class="<?php echo ($sortBy!='') ? 'active': ''; ?>active"><a href="<?php echo site_url('addProduct/productlist')?>"><strong>All</strong></a></li>
                </ul>
          </nav>
            </div>
        </br>
      </div>
       <div class="row">
        <div class="col-sm-12">
              <nav>
            
          </nav>
            </div>
        <div class="col-sm-12 pull-right"><!---change here------->
              <aside class="pull-right clearfix"> <a href="<?php echo site_url('addProduct'); ?>" class="btn btn-primary btn-sm clearfix"><i class="fa fa-plus-circle"></i> Create product</a> </aside>
            </div>
      </div>
	  <div id ="notice" align="center" style="width:35%;  background:#dff0d8;border:1px ;text-align:center; margin-left:35%; border-radius: 5px;font-family: verdana;color:#3c763d;  font-weight: 700; "> 
                <?php  echo $this->session->flashdata('message'); ?> </div> 	 
			 	   
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
                    <tr role="row"><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 148px;"> Product Id</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 148px;"> Product Code</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 233px;">Product Name</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 108px;">Book Name</th>
					<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 99px;">Action</th></tr>
                  </thead>
                      <tfoot>
                    <!-- <tr><th rowspan="1" colspan="1">Product Id</th><th rowspan="1" colspan="1">Product Code</th><th rowspan="1" colspan="1">Product Name</th><th rowspan="1" colspan="1">Book Name</th><th rowspan="1" colspan="1">Action</th></tr>-->
                  </tfoot>
                      <tbody>  
					  
					  <?php //echo '<pre>'; print_r($list); die;
					  ?>
					  <?php
					 $i =1;
					  foreach($list as $row)
					  {                      
					  ?>
					  <?php //echo !empty($row->Booktitle)?$row->Booktitle:'N/A'; ?>
                        <tr role="row" class="odd">
                          <td class=""><?php echo !empty($row->master_product_id)?$row->master_product_id:'N/A'; ?> </td>
                          <td class=""><?php echo !empty($row->product_code)?$row->product_code:'N/A'; ?></td>
                          <td class=""><?php echo !empty($row->product_name)?$row->product_name:'N/A'; ?></td>
	
                          <td class="">
						  <a href = "javascript:void()" id="product_id" onclick = "show_message('<?php echo $row->product_id; ?>'); ">View Book</a>
						  <div id="<?php echo $row->product_id; ?>" class="white_content">
						   <a href = "javascript:void()" onclick = "document.getElementById('<?php echo $row->product_id; ?>').style.display='none';document.getElementById('fade').style.display='none'" style="margin-left: 92%;">Close</a>
						   
						   <div id="book<?php echo $row->product_id; ?>"> </div>
		
						  </div>
                           </td>
                     
                  <td class=""><a href='<?php echo site_url('AddProduct/index/'.$row->product_id.'') ; ?>' data-toggle="tooltip" title="Edit "><i class="fa fa-pencil-square-o" style="font-size: 19px;padding-right: 10px;"></i></a>
				 <a href='javascript:show_confirm(<?php echo $row->product_id;?>)' data-toggle="tooltip" title="Delete "><i class="fa fa-trash-o" style='font-size: 19px;padding-right: 10px; color:red;'></i></a></td>
                        </tr>
                            <?php ?>
						
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
      </form>
      <!--Ashwani table start--> 
      
    </div>
</div>
  <script type="text/javascript">
 $(document).ready (function(){
               
                $("#notice").fadeTo(5000, 100).slideUp(500, function(){
              
            });
 });
 </script>
 <script type="text/javascript">
	function show_message(id){
		 $.ajax({ 
				  type:'POST',
				  url:"<?php echo site_url('addProduct/booklist'); ?>",
				  data:{product_id:id},
					success : function(res) {
						//alert(res);
				  $('#book'+id).html(res);
				}
							  
			}); 
     document.getElementById(id).style.display='block';
	 document.getElementById('fade').style.display='block';
         } 
      
 </script>
 <script type="text/javascript">
 $(document).ready(function(){
  $("#submit_id").click(function(){
    var productCode= $("#booknamesearch").val();
	var productnamesearch= $("#productnamesearch").val();
	var productcodesearch= $("#productcodesearch").val();
	  var expr = /[0-9 ]/;
	  var re = /^[a-zA-Z0-9-\s]*$/;
	  
    if(!expr.test(productCode) && productCode!=""){
        $("#fb-errorid").html("<span style='color:red;'>Fill Correct Product id</span>");
        return false;
		
       }
	 
	  if(!re.test(productnamesearch) && productnamesearch!=""){
        $("#fb-errorname").html("<span style='color:red;'>Fill Correct Product Name</span>");
         return false;
    }
	
    if(!expr.test(productcodesearch) && productcodesearch!=""){
        $("#fb-errorcode").html("<span style='color:red;'>Fill Correct Product Code</span>");
          return false;
    } 
   return true;
  });
 });
 </script>
 </body>
</html>
