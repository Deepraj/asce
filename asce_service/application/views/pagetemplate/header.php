<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link 	href="<?php  echo $this->config->item('player_url') ?>/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link 	href="<?php  echo $this->config->item('player_url') ?>/vendors/Zebra_DatePicker/css/Zebra_DatePicker.css"
	rel="stylesheet">
<link 	href="<?php  echo $this->config->item('player_url') ?>/vendors/font-awesome/css/font-awesome.min.css"
	rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" 	href=" <?php echo base_url('assets/css/style.css') ; ?> " />
<script type="text/javascript" 	src="<?php  echo $this->config->item('player_url') ?>/vendors/jquery/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" 	src="<?php  echo $this->config->item('player_url') ?>/vendors/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" 	src='<?php  echo $this->config->item('player_url') ?>/vendors/customalert/js/bootbox.min.js'></script>
<script type="text/javascript" 	src='<?php  echo $this->config->item('player_url') ?>/vendors/Zebra_DatePicker/js/Zebra_DatePicker.min.js'></script>
<script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0086/6567.js" async="async"></script>
<script type="text/javascript" 	src=" <?php echo base_url('assets/js/main.js') ; ?> "></script>
<script type="text/javascript" 	src=" <?php echo base_url('assets/js/jquery.form.js') ; ?> "></script>
<link rel="stylesheet" type="text/css" 	href=" <?php echo base_url('assets/css/jquery.multiselect.css') ; ?> " />
</head>
<body>
 <span id="SecondsUntilExpire" style="display:none;"></span>
	<div id="adminHomePage" class="">
		<header>
			<div class="logo" style="
    width: 0px;">
				<a href='<?php echo site_url('Dashboard/show_dashboard') ; ?>'><img
					src="<?php echo base_url('assets/images') ; ?>/AdminHeaderLogo.png"></a>
			</div>
			<div class="headerbtn" style="margin-left: 275px;">
        <?php
		 if ($this->tank_auth->is_user_admin ()) {
		?>
		 <div class="addBook" title="MANAGE BOOKS">
				<a href='<?php echo site_url('book_library/list_book') ; ?>'><div class="icon"></div></a><span>MANAGE BOOKS</span>
		 </div>
		 <div class="addReport" title="MANAGE PRODUCT">
					<a href='<?php echo site_url('addProduct/productlist') ; ?>'>
						<div class="icon"></div>
						<span style='width: 100px; margin-left: 10px;'>MANAGE PRODUCT</span>
				
				</div>
				<div class="addUser" title="MANAGE USER">
					<a href='<?php echo site_url('userPage/listUser')?>'><div
							class="icon"></div>
						<span>MANAGE USER</span></a>
				</div>
				<div class="addInstitute" title="MANAGE INSTITUTION">
					<a href='<?php echo site_url('institutePage/InstituteList')?>'><div
							class="icon"></div>
						<span style="width: 113px; margin-left: 8px;">MANAGE INSTITUTION</span></a>
				</div>
				<div class="report" title="MANAGE REPORTS">
 <a href='<?php echo site_url('Manage_reports') ; ?>'>
					<div class="icon"></div>
					<span>MANAGE REPORTS</span>

				</div>
				<div class="history" title="MANAGE HISTORY">
  
					<a href='<?php echo site_url('Manage_history') ; ?>'><div
							class="icon"></div>
						<span>MANAGE HISTORY</span></a>
				</div>
			<?php
			} else if ($this->tank_auth->is_user_student ()) {
			?>
			<div class="addUser" title="PROFILE">
					<a href='#'><div class="icon"></div>
						<span>PROFILE</span></a>
			</div>
		<?php				
         } else {
		?>
            <!--<div class="addInstitute" title="ADD INSTITIUE" data-toggle="modal" data-target="#addInstPannel"><div class="icon"></div><span>ADD INSTITIUE</span></div>
			<div class="addUser" title="ADD USER" data-toggle="modal" data-target="#addUserPanel"><div class="icon"></div><span>ADD USER</span></div>
            <div class="addBook" title="ADD BOOKS"><a href='<?php echo site_url('book_library/addbook') ; ?>'><div class="icon"></div></a><span>ADD BOOKS</span></div>
			<div class="report" title="REPORTS"><div class="icon"></div><span>REPORTS</span></div>-->
            <?php
			}
		?>
		</div>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button"
					id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="true">
			    <?php 
				  //echo $_SESSION['adminName'];
				echo $_SESSION['username'];
				//echo $userInfo->username;
				?>

			<span class="caret"></span>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li><?php echo anchor('/auth/logout/', 'Logout'); ?></li>
						
					</ul>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li><?php echo anchor('/auth/logout/', 'Logout'); ?></li>
					
				</ul>
			</div>
		</header>
		<div class="manageAdminTool">

			<!--		<a href='<?php echo site_url('admin') ; ?>'>home </a>  |-->
        <?php
								if ($this->tank_auth->is_user_admin ()) {
									?>
<!-- <a href='<?php echo site_url('Manage_history') ; ?>'>Manage History </a> -->
			<!--<a href='<?php echo site_url('book_library/list_book') ; ?>'>Book Library </a>  |-->
			<!-- <a href='<?php echo site_url('Custombook_library/show_custombook') ; ?>'>Custom Book Library </a>  |
        <a href='<?php echo site_url('Custombook_library/addcustombook')?>'> Custom Book Form</a> |-->
		<?php
								
} else {
									
									?>
      <!--  <a href='<?php echo site_url('book_library/list_book') ; ?>'>Book Library </a>  | <a href='<?php echo site_url('Custombook_library/show_custombook') ; ?>'>Custom Book Library </a>  |-->
        <?php }?>
        
<!--		<a href='<?php echo site_url('upload_xmlfile')?>'> Upload books </a> |-->
 <?php
	if ($this->tank_auth->is_user_admin ()) {
		?>
		<!--<a href='<?php echo site_url('Localization')?>'> Manage Localizaton </a> -->
		<?php
	
} else {
		?>
<!--        <a href='<?php echo site_url('Localization')?>'> Manage Localizaton </a> | <a href='<?php echo site_url('Custombook_library/addcustombook')?>'> Custom Book Form</a> -->
<?php
	}
	?>
        <!--<?php
				if ($this->tank_auth->is_user_admin ()) {
			?>
		| <a href='<?php echo site_url('institutePage/InstituteList')?>'> View Institution </a> 
		<?php }?>-->
		 <?php
			if ($this->tank_auth->is_user_admin ()) {
				?>
		<!--| <a href='<?php echo site_url('RoleManagement/userPermission')?>'> Role Management </a> -->
		<?php }?>
		<!--  <?php
		if ($this->tank_auth->is_user_admin ()) {
			?>
		| <a href='<?php echo site_url('userPage/listUser')?>'> View User </a> 
		<?php }?> -->
		</div>
		<!-- Modal -->
		<div class="modal fade" id="addBookPanel" role="dialog"></div>

		<div class="modal fade" id="addInstPannel" role="dialog"></div>
