<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<div> 
<?php 
if(!empty($name)){
?>
<p> Dear <?php  echo $name['firstname']; ?>&nbsp;<?php  echo $name['lastname']; ?>,<p>
<p>Thank you for subscribing to <a href="https://asce7.online/">ASCE 7 Online Platform</a>. Your content is now available. As an institutional administrator, 
you will be able to manage and invite additional people to join your account.</p>
<p><strong>How to Manage Users</strong></p>
<p>1. Log in at <a href="https://asce7.online/"> https://asce7.online</a></p>
<p>2. Under "My Account", click on the Admin link.</p> 
<p>3. Click on "Invited Users" to add, remove, and update the people who can access the standard via your account.</p>
<p>If you do not have an ASCE account, you will be prompted to create one when you log in. If you have any questions, please feel free to contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org <a/> or call 1.800.548.2723.</p> 
<p>Sincerely,<br><br>
ASCE Publications<br>
Phone : 1 (800) 548-2723 or(703) 295-6300<br>
Email : <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a><br>
</p>			 
</div>
<?php } ?>
</body>
</html>