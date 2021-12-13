<?php $sortBy=$tabValue=$this->input->get('sortby', TRUE);
?>
<?php
$lvar="http://".$_SERVER['HTTP_HOST'];
//echo $lvar; die;
$bookdelete=$lvar.'/asce_service/index.php/book_library/deletebooks';
//echo $bookdelete; die;
?>


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
	

<style>

.list-box {
    background-color: #FFF;
    box-shadow: 0 0 4px #cfcfcf;
    padding: 15px;
	min-height: 182px;
    <!--margin-bottom: 15px;--->
}

.padding-lr0{padding:2px 0px}



.card-image img {
    display: block;
    border-radius: 2px 2px 0 0;
    position: relative;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background-color: #454578;
    /* overflow: hidden; */
    background-size: cover;
    background-position: center;
    width: 100%;
    max-width: 100%;
    height: 182px;
    /* object-fit: cover; */
}

.l-m-heading {
    font-size: 18px;
    color: #337ab7;word-spacing: normal;
    padding: 5px 0px;
    margin: 3px;
}
.l-s-heading {
    font-size: 16px;
    padding: 2px 0px;

    
    
}


.icon-list{
    font-size: 22px;
    padding: 5px;
}

.border-left {
    border-left: 1px solid #BDBDBD;
    padding: 8px 1px 0px 0px;
    margin-left: 2px;
}
.mt10{ margin-top:10px;}
.mt5{ margin-top:5px;}
.mb10{ margin-bottom:10px;}

.border-btm{border-bottom: 1px solid #eee;}
</style>


</head>
<body>

  <div id="adminHomePage" class="">
    <div class="manageAdminTool"> 
      
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
              <p class="heading-add-inst">BOOK LIST</p>
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
       <form action ="<?php echo $this->config->item('base_url'); ?>/index.php/Book_library/list_book" method="post" name='instituteListForm' onsubmit="return formvalidetion();">
          <div class="row">
         <div class="col-sm-3">
              <div class="form-group">
            <input type="text" id="booktitlesearch" name="booktitlesearch" placeholder="Search By Book Title" class="form-control" value="<?php echo $search;?>" autocomplete="off">
        <p id="error" style="color:red">   </p>
		</div>
            </div>
    <div class="col-sm-3">
              <div class="form-group">
            <input type="text" name="search_from_date" id="search_from_date" placeholder="From Created Date" class="form-control datepicker" value="<?php echo $search_from_date;?>" autocomplete="off">
         <p id="error1" style="color:red">   </p>
		 </div>
            </div> 
        <div class="col-sm-3">
              <div class="form-group">
           <input type="text" name="search_to_date" id="search_to_date" placeholder="To Created Date" class="form-control datepicker" value="<?php echo $search_to_date;?>" autocomplete="off">
          <p id="error2" style="color:red">   </p>
		 </div>
            </div>
        <div class="col-sm-3 pull-right text-left">
              <input name="submit" id="submit_id" type="submit" class="btn btn-primary btn-sm" value="Search" autocomplete="off">
              <a href="<?php echo site_url('book_library/list_book')?>" class="btn btn-default btn-sm">Clear</a> </div>
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
                  <li class="<?php echo ($val == $sortBy) ? 'active' : ''; ?>"><a href="<?php echo site_url('book_library/list_book?sortby='.$val)?>"><?php echo $val;?></a></li>
                  <?php }?>
                  <li class="<?php echo ($sortBy!='') ? 'active': ''; ?>active"><a href="<?php echo site_url('book_library/list_book')?>"><strong>All</strong></a></li>
                </ul>
          </nav>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 ">
              <div class="col-sm-12 bg-green">
                <p id="mydiv" style="color: green; text-align: center; padding-top: 20px; display: none;"><strong></strong></p>
              </div>
            </div>
            <div class="col-sm-12 ">
              <div class="col-sm-12 bg-blue"> </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-6">
             
            </div>
            <div class="col-sm-6 pull-right">
              <aside class="pull-right clearfix">  <a href="<?php echo site_url('book_library/addbook') ; ?>" class="btn btn-primary btn-sm clearfix"><i class="fa fa-plus-circle"></i> Create new Book</a> </aside>
            </div>
          </div>
          
      
		<div class="">
		<table id="example" class="table  dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
		<thead style="display: none;">
                    <tr>
					<th class="" tabindex="0" aria-controls="example"></th>
					<th class="" tabindex="0" aria-controls="example"></th>
					</tr>
                  </thead>		
		<?php $i=1;
					  foreach ($books as $row) {  
					  //	$status=$row->institution_status=='1' ? 'Active' : 'Inactive';
					  	$cls=$i%2==0 ? 'even':'odd';
					  	?>
				 	
						
			<tr role="row" class="<?php //echo $cls;?>">			
           <div class="row">
		   <td style="width:18%">
            <div class="col-md-12 padding-lr0">
            
           <div class="list-box">
           
           <div class="card-image">
								<img src="<?php echo $thumb_img_path ."/". $row->m_bokisbn ."/vol-". $row->m_volnumber."/"."cover_img"."/" . $row->m_bokthump ; ?>" class="img-responsive" alt="">
								
							</div>
           
           </div>
             
             
              </div>
          </td>
           <td> 
            <div class="col-md-12 padding-lr0"> 
            
            <div class="list-box">
            <div class="row"> 
           <div class="col-sm-10">
           
           <h2 class="l-m-heading"><?php echo $row->m_boktitle;?></h2>
           
           </div>
           <div class="col-sm-2 text-right">
		   
		   <a href='<?php echo site_url('book_library/addbook/'.$row->m_bokid.'') ; ?>' class=""><i class="fa fa-pencil-square-o icon-list" aria-hidden="true"></i><span class="border-left"></span></a>
		   
		   
                   <a onclick="return  show_confirm(<?php echo $row->m_bokid;?>)" href='#delete' data-toggle="tooltip" title="Delete "id="book_link" class=""><i class="fa fa-trash-o" aria-hidden="true" style='font-size: 22px;padding-right: 10px; color:red;'></i></a>
		   
		  
		   
		 
		   
		  </div>
          
          <div class="col-sm-12 ">
          <h4 class="l-s-heading"><?php echo $row->m_boksubtitle;?></h4>
         
         <p><strong>Description</strong></p>
         <p><?php echo $row->m_bokdesc;?> </p>
          </div>
          
           </div> 
           
           <div class="row"> 
           
          
           <div class="col-sm-12 ">
            <div class="mb10 border-btm"> </div>
           
           </div>
           <div class="col-sm-4">
           
           <div class="mt5"><i class="fa fa-user text-primary" aria-hidden="true"></i> <?php echo $row->m_bokauthorname;?></div>
           
           </div>
		   
		 
		   
		   
		   
		   
		   
		   
           <div class="col-sm-8 text-right"><a href='<?php echo site_url('Authentication/index/PRIMARY/'. $row->m_bokid."/".$row->m_volid ) ; ?>' class="btn btn-default">READ BOOK</a>
<a href='<?php echo site_url('book_library/updateContent/'.$row->m_bokid.'') ; ?>'><span class="btn btn-primary" >UPDATE CONTENT</span></a></div>
          
         
          
           </div>
           
            </div>
             
              
              </div>
            
            
            
          </td>
             </tr>
			 <?php 
					  $i++;}?>
           
           </table>
          
            
           </div>  
            
            
            </div>  
       
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){ 
    setTimeout(function() {
    $('#mydiv').fadeOut('fast');
   }, 10000);
});
</script> 
<script type="text/javascript">
 $(document).ready (function(){
                $("#success-alert").alert();
                $("#success-alert").fadeTo(2000, 100).slideUp(500, function(){
               $("#success-alert").alert('close');  
            });
//                $('#search_from_date').Zebra_DatePicker({
//					format: 'Y-m-d',
//					selectWeek: true,
//					inline: true,
//					pair: $('#search_to_date'),
//					firstDay: 1,
//					//direction: true, // add this line
//					onSelect: function(view, elements){
//						$('#search_to_date').val('');
//						/*var from_date = new Date($(this).val());
//            			var to_date = new Date($('#valid_date_to').val());
//						if(this.id == 'from_date') {
//							if (from_date > to_date) {alert(1)
//								$('#to_date').val(from_date);
//							}
//						}else{
//							if (to_date < from_date) {
//								$('#from_date').val(to_date);
//							}
//						}*/
//						//$('#valid_date_to').val($(this).val());
//					}
//				});
//				
//				$('#search_to_date').Zebra_DatePicker({
//					format: 'Y-m-d',
//					selectWeek: true,
//					//direction: true // change 0 to true
//				});
                
 });
 
  function formvalidetion()
 {
//	var aa =  $('#booktitlesearch').val();
//	if(aa == "")
//	{
//		$('#error').html("Please insert book title");
//		return false;
//	}
//	var bb = $('#search_from_date').val();
//	if(bb == "")
//	{
//	$('#error1').html("Please insert from date");
//		return false;	
//	}
//	var cc = $('#search_to_date').val();
//
//	if(cc == "")
//	{
//		$('#error2').html("Please insert to date");
//	return false;
//	}
 }
 </script> 
<script>
	function show_confirm(id){
                if(confirm("Are you sure to delete this book?")){
		//alert(id);
		var urlRef="http://beta.asce.mpstechnologies.com/asce_service/index.php/book_library/deletebooks"+'/'+id;
		//alert(urlRef);
	$.ajax({
			type: "POST",
			url: urlRef,
			data: { id:id },
			async: false,
			success: function(data)
			{
			//alert(data);
			if(data==1){
				   alert("This book is use in product so can not delete:");
				   return false;
			        }
			   else{
					//if(confirm('Do you want to delete selected book ?'))
					//{
					 //window.location='http://asce.mpstechnologies.com/asce_service/index.php/'+'book_library/delete_book/'+id;
					 window.location='http://beta.asce.mpstechnologies.com/asce_service/index.php/book_library/list_book';
					//}
			   }
			}
		})
	}else{
            return false;
        }
    }
	</script> 
