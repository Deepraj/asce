
<?php echo $error;?>

<?php echo form_open_multipart('upload_xmlfile/do_upload');?>
<form method="post" action="" name="form">

ISBN: <input type="text" name="isbn" /><br />
Volume: <input type="text" name="volumeno" /><br />
Choose file to upload<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

