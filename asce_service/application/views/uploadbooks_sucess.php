<html>
<head>
</head><body>
  <div class="message" style="text-align:center; font-size:20px; margin-top:300px;">
   <?php 
	foreach($result as $rec)
		echo "<span style='color:#0C5FA8;'>".$rec. "</span>";
    ?>
 </div>
 <div class="display" style="padding-left:445px;padding-top:20px;">
  <?php echo anchor('book_library/addbook', 'Add Another Book','class="btn btn-primary btn-sm clearfix"') . " | " ; ?>
   <?php echo anchor('book_library/list_book', 'Manage Books','class="btn btn-primary btn-sm clearfix"'); ?>
 </div>
 </body>
 </html>