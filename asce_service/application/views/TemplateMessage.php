<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<div> 
<?php ///echo "<pre>";  print_r($name); 
//echo $name[0]->m_firstname; die;
  ?>
<p> Dear <?php echo $name[0]->first_name; ?> <?php echo $name[0]->last_name;  ?>,<p>
<p><?php echo $name[0]->m_firstname; ?><?php echo $name[0]->m_lastname; ?> has access to ASCE 7 Online Platform and you have been personally invited to join. To access the platform, please log in <a href="https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?ASCEURL=http://asce.mpstechnologies.com/products/">Login</a> or create an account.</p>
<p>If you have any questions, please feel free to contact your <b> <?php echo $name[0]->m_firstname; ?><b> at <b><?php echo $name[0]->m_primaryemail; ?><b>.</p>
<p style="color:#0C5FA8;font-weight:bold;">Sincerely,<br><br>
 Your ASCE 7 Online Team</p>			 
</div>
</body>
</html>