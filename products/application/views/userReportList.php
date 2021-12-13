

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
<?php

$LicenceInfo = $this->session->userdata ( 'LicenceInfo' );
?>
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
	  
	<form name ="ora" method="POST" action="User_reports/downloadReport" enctype="multipart/form-data" >
			
			<input type="hidden" name="licence" value="<?php  echo $LicenceInfo;?>" >
			
      		
      	
      
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
				<td>List of unique sessions per month </td>
               
                <td>
								
									
				<div class="datediv" style=" float: left;padding: 0 0px;">								
				<input type="text" name="search_from_date" id="search_from_date" placeholder="From Date" style="width:100px"  class="form-control datepicker" value="" autocomplete="off">
					</div>
                  <div class="datediv" style="float: left;padding: 0 13px;">					
						<input type="text" name="search_to_date" id="search_to_date" placeholder="To Date" style="width:100px"  class="form-control datepicker" value="" autocomplete="off">
						</div>			
	<div class="datesdiv" style="float: left;padding: 0 0px;">								
<input type="submit" name="submit"  value="Download"  class="btn btn-primary " ></div>							
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
		
     <footer class="footer-bg " style="margin-top:20%" >
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
				© 2018 American Society of Civil Engineers
			</div>
		</div>
	</div>	
</footer>
