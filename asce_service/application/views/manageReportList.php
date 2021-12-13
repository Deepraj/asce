<style>
.customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

.customers tr:nth-child(even){background-color: #f2f2f2;}

.customers tr:hover {background-color: #ddd;}

.customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #337ab7;
    color: white;
}
</style>

<div class="box">
 <p class="showDay pull-right alert-success"></p>
 

<div class="row" style="
    margin-right: 0px;
">
        <div class="col-sm-12">
              <div class="pull-left">
			  <p class="heading-add-inst" style="
    margin-left: 86px;
">
			  MANAGE REPORTS         </p>
			  
			 
          </div>
            </div>
      </div>
<!-- site report section -->

	<div class="alert alert-error  alert-dismissable" id="resultip" style="border: 1px solid #ff0000;position: relative; width: 1161px; margin-left: 57px; display:none">					
       </div>
	  
	<form name ="ora" method="POST" action="Manage_reports/downloadReport" enctype="multipart/form-data" >
			
			<input type="text" name="licence" value="" >
			
      		
      	
      
     <div class="box-body" style="width: 92%; margin-left: 57px;margin-top: 77px;">
        	<div class="table-responsive">
          <table class="table table-bordered customers">
            <thead class="table_head">
              <tr>
              	<th width="5%">S.No.</th>
                <th width="30%"> Report Type</th>
                <th width="30%"> Description</th>
                <th width="60%"><span class="marLeft20px">Action</span></th>
               
                
              </tr>
            </thead>
            <tbody>
              <tr>         
                 <td>1</td>
              	<td>	
					Number of unique sessions 
	
				</td>
				<td>
				<select name="masterid" id="masterid" aria-controls="year" class="form-control" tabindex="14">				
			    	 <option  selected>All User</option>
                    	<?php
		


        foreach ($alluser as $row) {
			
           print '<option value="'.$row->m_masterid."#".$row->m_primaryemail."#".$row->m_licence_type."#".$row->m_lablename."#" .'1">'.$row->m_lablename.'</option>';
           }

             ?>
			
			</select></td>
               
                <td>
								
									
				<div class="datediv" style=" float: left;padding: 0 0px;">								
				<input type="text" name="search_from_date" id="search_from_date" placeholder="From Date" style="width:100px"  class="form-control datepicker" value="" autocomplete="off">
					</div>
                  <div class="datediv" style="float: left;padding: 0 13px;">					
						<input type="text" name="search_to_date" id="search_to_date" placeholder="To Date" style="width:100px"  class="form-control datepicker" value="" autocomplete="off">
						</div>			
	<div class="datesdiv" style="float: left;padding: 0 0px;">								
<input type="submit" name="submit"  value="Download"  class="btn btn-primary" currentdiv="0" >

</div>							
				</td>
	
                      </tr>
					    <tr>
					  <td>2</td>
					  	<td>
						
					Number of turnaways
	
				</td>
				<td>
				<select name="masterid1" id="masterid1" aria-controls="year" class="form-control" tabindex="14">				
			    	 <option  selected>All User</option>
                    	<?php
		


        foreach ($alluser as $row) {
			if($row->m_licence_type=='IPBASED')
			{
           print '<option value="'.$row->m_masterid."#".$row->m_primaryemail."#".$row->m_licence_type."#".$row->m_lablename."#" .'2">'.$row->m_lablename.'</option>';
           }
		}
             ?>
			
			</select></td>
			
			
			  <td>
								
									
				<div class="datediv" style=" float: left;padding: 0 0px;">								
				<input type="text" name="search_from_date1" id="search_from_date1" placeholder="From Date" style="width:100px"  class="form-control datepicker" value="" autocomplete="off">
					</div>
                  <div class="datediv" style="float: left;padding: 0 13px;">					
						<input type="text" name="search_to_date1" id="search_to_date1" placeholder="To Date" style="width:100px"  class="form-control datepicker" value="" autocomplete="off">
						</div>			
	<div class="datesdiv" style="float: left;padding: 0 0px;">								
<input type="submit" name="submitNT"  value="Download"  class="btn btn-primary" currentdiv="1" ></div>							
				</td>
	
					  </tr>
       <tr>
          <td>3</td>
                  <td>
						
					Number of broken down 
	
				      </td>
                     <td>
				<select name="masterid2" id="masterid2" aria-controls="year" class="form-control" tabindex="14">				
			    	 <option  selected>Book List</option>
                    	<?php
		


        foreach ($books as $row) {
			
           print '<option value="'.$row->m_bokid."#" .'3">'.$row->m_boktitle.'</option>';
           
		}
             ?>
			
			</select>
			
			</td>
			 <td>
								
									
				<div class="datediv" style=" float: left;padding: 0 0px;">								
				<input type="text" name="search_from_date2" id="search_from_date2" placeholder="From Date" style="width:100px"  class="form-control datepicker" value="" autocomplete="off">
					</div>
                  <div class="datediv" style="float: left;padding: 0 13px;">					
						<input type="text" name="search_to_date2" id="search_to_date2" placeholder="To Date" style="width:100px"  class="form-control datepicker" value="" autocomplete="off">
						</div>			
	<div class="datesdiv" style="float: left;padding: 0 0px;">								
<input type="submit" name="submitNB"  value="Download"  class="btn btn-primary" currentdiv="2" ></div>							
				</td>
    </tr>
            </tbody>
          </table>
		  </form>
          </div>
        </div>
		<script>
	function checkvalidation()
     {
	
  var month = $("#month").val();
  if(month=="Choose Month")
  { 
	 $("#resultip").show();
	 $("#resultip").text("Please choose  the month.");
	// var html=
	  $("#resultip").append(' <a href="#" class="close-msg btn btn-primary " data-dismiss="alert" aria-label="close" style=" position: absolute; top: 50%;margin-top: -17px;right: 10px;">Close</a>');
	//$("#ProductNameAddEmail").focus(); 
	return false;
  }
  
}
		
		</script>
		
		<script type="text/javascript">
 $(document).ready (function(){
	 
	 
	 $('.btn-primary').click(function(){
                   var currentRow = $(this).attr('currentdiv');
                   if(currentRow==0){
                    var startdate  = $('#search_from_date').val();
                    var enddateval = $('#search_to_date').val();
                   }else{
                    var startdate  = $('#search_from_date'+currentRow+'').val();
                    var enddateval = $('#search_to_date'+currentRow+'').val();
                   }    
                   if(startdate==''){
                       alert("Please select from date");
                       return false;
                   }
                   if(enddateval==''){
                       alert("Please select to date");
                       return false;
                   }
                    
                });
	 
	 
	 
                $("#success-alert").alert();
                $("#success-alert").fadeTo(2000, 100).slideUp(500, function(){
               $("#success-alert").alert('close');  
            });
                $('#search_from_date').Zebra_DatePicker({
					format: 'Y-m',
					selectWeek: true,
					inline: true,
					pair: $('#search_to_date'),
					firstDay: 1,
					//direction: true, // add this line
					onSelect: function(view, elements){
						$('#search_to_date').val('');
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
						//$('#valid_date_to').val($(this).val());
					}
				});
				
				$('#search_to_date').Zebra_DatePicker({
					format: 'Y-m',
					selectWeek: true,
					//direction: true // change 0 to true
				});
                
 });
 </script>
 
 
 
 
 <script type="text/javascript">
 $(document).ready (function(){
                $("#success-alert").alert();
                $("#success-alert").fadeTo(2000, 100).slideUp(500, function(){
               $("#success-alert").alert('close');  
            });
                $('#search_from_date1').Zebra_DatePicker({
					format: 'Y-m',
					selectWeek: true,
					inline: true,
					pair: $('#search_to_date1'),
					firstDay: 1,
					//direction: true, // add this line
					onSelect: function(view, elements){
						$('#search_to_date1').val('');
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
						//$('#valid_date_to').val($(this).val());
					}
				});
				
				$('#search_to_date1').Zebra_DatePicker({
					format: 'Y-m',
					selectWeek: true,
					//direction: true // change 0 to true
				});
                
 });
 </script>
 
 <script type="text/javascript">
 $(document).ready (function(){
                $("#success-alert").alert();
                $("#success-alert").fadeTo(2000, 100).slideUp(500, function(){
               $("#success-alert").alert('close');  
            });
                $('#search_from_date2').Zebra_DatePicker({
					format: 'Y-m',
					selectWeek: true,
					inline: true,
					pair: $('#search_to_date2'),
					firstDay: 1,
					//direction: true, // add this line
					onSelect: function(view, elements){
						$('#search_to_date2').val('');
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
						//$('#valid_date_to').val($(this).val());
					}
				});
				
				$('#search_to_date2').Zebra_DatePicker({
					format: 'Y-m',
					selectWeek: true,
					//direction: true // change 0 to true
				});
                
 });
 </script>
 