<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<div> 
<?php 
//echo "<pre>"; print_r($name); die;
if(!empty($name)){
?>
<p>Dear <?php echo $name[0]->first_name; ?> <?php echo $name[0]->last_name;  ?>,<p>
<p><?php echo $name[0]->m_lablename; ?> has access to <a href ="https://asce7.online/">ASCE 7 Online Platform</a>  and you have been personally invited to join. </p>
<p>Your corporate administrator registered the following email address for you: 
<?php echo $name[0]->email; ?></p>
<p>To access the platform, please log in <a href ="https://asce7.online/"> ASCE 7 Online</a> or create an account using this registered email. You will only be able to access the platform using the email address registered by your corporate administrator.</p>
<p>If you have any questions or wish to use a different email address, please notify your corporate administrator at <?php echo $corporateemail[0]->m_primaryemail; ?>.</p>
<p>Sincerely,<br><br>
ASCE Publications<br>
Email: &nbsp; <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a><br>
</p>			 
</div>
<?php } ?>
</body>
</html>


