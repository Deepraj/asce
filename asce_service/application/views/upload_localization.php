
<?php echo $error;?>

<?php echo form_open_multipart('Localization/do_upload');?>
<form method="post" action="" name="form">

Choose file to upload<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

