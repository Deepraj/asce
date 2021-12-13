<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("sweanujdubey@gmail.com","My subject",$msg);
mail("rovindra.kumar@adi-mps.com","Hello","test");
$headers = "From: information@adi-mps.com";
//mail('rahulsaxena.indian@gmail.com','Hello ','test',$headers);
if(@mail('rovindra.kumar@adi-mps.com','Hello ','test',$headers))
{
  echo "Mail Sent Successfully";
}else{
  echo "Mail Not Sent";
}
echo "Done";
?>
