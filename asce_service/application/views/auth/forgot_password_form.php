<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php  echo $this->config->item('player_url') ?></title>
<link href="<?php  echo $this->config->item('player_url') ?>/vendors/bootstrap/css/bootstrap.min.css?version={ver}" rel="stylesheet">
<link href="<?php  echo $this->config->item('player_url') ?>/vendors/font-awesome/css/font-awesome.min.css?version={ver}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php  echo $this->config->item('player_url') ?>/themes/default/css/style.css?version={ver}">
<link rel="stylesheet" href="<?php  echo $this->config->item('player_url') ?>/themes/default/css/style-ie-only.css?version={ver}">
</head>
<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
<?php echo form_open($this->uri->uri_string()); ?>

	<div id="formControl">
		<div  class="header"><img src="<?php  echo $this->config->item('player_url') ?>/themes/default/images/Logo_White_145x58.png"></div>
		<div  id="forgetPassword" >
			<div  class="middle_table" >
				<div class="middle_cell">
					<div class="form_page" style="padding-top:150px;">
						<table>
							<tr>
								<td><?php echo form_label($login_label, $login['id']); ?></td>
							</tr>
							<tr>
								<td><?php echo form_input($login); ?></td>
							</tr>
							<tr>
								<td class="error_msg"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
							</tr>
						</table>
						<?php echo form_submit('reset', 'Get a new password'); ?>
						<?php echo form_close(); ?>
						<div class="btm"><?php echo anchor('/auth/login/', 'Go to Signin'); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
