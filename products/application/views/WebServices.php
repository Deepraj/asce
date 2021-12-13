<div id="login_details">
	<div class="container">
<?php 
 
    echo "<p  style='color:red;text-align:center;padding-top:200px; '><strong>".$this->session->flashdata('message')."</strong></p>";  
     print '<script>
		  setTimeout(function(){ window.location.href="'.base_url().'"; }, 5000);
		  </script>';	
?>
</div>
</div>
</form>
</body>
</html>