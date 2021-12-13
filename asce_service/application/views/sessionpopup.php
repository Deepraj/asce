<!DOCTYPE html>
<html>
<head>
<link 	href="<?php  echo $this->config->item('player_url') ?>/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link 	href="<?php  echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
<link 	href="<?php  echo $this->config->item('player_url') ?>/vendors/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
<script type="text/javascript" 	src="<?php  echo $this->config->item('player_url') ?>/vendors/jquery/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" 	src="<?php  echo $this->config->item('player_url') ?>/vendors/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript"> 
    //Call the method on pageload
    $(window).load(function(){
      //Disply the modal popup
        $('#myModal').modal('show');
    });
</script>
</head>
<body>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="popup-custom">
<form  action="<?php echo site_url(); ?>/auth/login" method="post">
<div class="modal-header" id="mod-header">
<a href="<?php echo site_url(); ?>/auth/login"><button type="button" class="close"  aria-hidden="true">&times;</button></a>
<h4 class="modal-title" id="myModalLabel">ASCE</h4>
</div>
<div class="modal-body">
Your session will automatically close due to inactivity.Please close your browser  and login in again.
</div>
<div class="modal-footer" id="mod-footer">
<!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<input  type="submit" class="btn btn-primary" value="OK">
</div>
</form>
</div>
</div>
</div>                      
</body>
</html>
