<html>
<head>
<title>Upload Form</title>
</head>
<body>
<?php echo $error;?>

<?php echo form_open_multipart('Upload_Pages/doupload');?>
<form method="post" action="" name="form">
<input name="userfile[]" id="userfile" type="file" multiple="" />
<input type="submit" value="upload" />
<?php echo form_close() ?>
    </form>
</body>
</html>
