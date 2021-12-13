<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php  echo $this->config->item('player_url') ?></title>
<link href="<?php  echo $this->config->item('player_url') ?>/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php  echo $this->config->item('player_url') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php  echo $this->config->item('player_url') ?>/themes/default/css/style.css">
<link rel="stylesheet" href="<?php  echo $this->config->item('player_url') ?>/themes/default/css/style-ie-only.css">
</head>
<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'placeholder'=>'E-mail / User Name'
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
	'placeholder'=>'Password'
	
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
	<div id="formControl">
		<div  class="header"><img src="<?php  echo $this->config->item('player_url') ?>/themes/default/images/Logo_White_145x58.png"></div>
		<div  id="login_details" >
			<div  class="middle_table" >
				<div class="middle_cell">
					<div class="form_page" style="padding-top: 150px;">
						<h2>LOGIN</h2>
						<div>
							<table>
								<tr>
									<td colspan="3"><?php echo form_input($login); ?></td>
								</tr>
								<tr>
									<td colspan="3"><?php echo form_password($password); ?></td>
								</tr>
								<tr>
									<td class="error_msg"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
								</tr>
								<tr>
									<td class="error_msg"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
								</tr>
								<tr>
									<td class="remember"><?php echo form_checkbox($remember); ?><?php echo form_label('Remember me', $remember['id']); ?></td>
								</tr>                            
							</table>
							<?php echo form_submit('submit', 'Login'); ?>
							<?php echo form_close(); ?>
							<div class="btm">
								<?php //if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?>
								<?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
