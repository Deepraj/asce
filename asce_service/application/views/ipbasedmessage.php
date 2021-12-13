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
if(!empty($name)){
?>
<p> Dear <?php  echo $name['firstname']; ?><?php  echo $name['lastname']; ?>,<p>
<p>Thank you for subscribing to <a href="https://asce7.online/">ASCE 7 Online Platform</a>. Your content is now available. As an institutional administrator,
you will be able to perform and manage the following tasks. </p>
<p>1. Print Usage Reports</p>
<p>2. View your license details.</p> 
<p>3. View your IP range.</p> 
<p>4. View your book list.</p>
<p>If you have any questions, please contact Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723.</p>
<p>Sincerely,<br><br>
ASCE Publications<br>
Phone :  1 (800) 548-2723 or (703) 295-6300<br>
Email : <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a><br>
</p>			 
</div>
<?php } ?>
</body>
</html>