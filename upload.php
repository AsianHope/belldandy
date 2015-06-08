<?php

include("func.php");
$id=$_GET['id'];

$data = explode(".",$id);
$sid = $data[0];
$pid = $data[1];
$modifiedData = $data[2];

$duc = get_periods($pid);


if($id==0){
  $name = $_FILES['upload']['name'];
  $valid_file_extensions = array(".mp3");
  $file_extension = strrchr($_FILES["upload"]["name"], ".");
  // Check that the uploaded file is actually a mp3
    if (in_array($file_extension, $valid_file_extensions)) {
      $to = "uploads/" . $name;
      //move it to the right folder if is.
      move_uploaded_file($_FILES["upload"]["tmp_name"], $to);
//update_sound($pid,$name);
      echo $name;
    }
    else {
        echo 'File not support!';
      }
}
else{
  $name = $_FILES['upload']['name'];
  $valid_file_extensions = array(".mp3");
  $file_extension = strrchr($_FILES["upload"]["name"], ".");
  // Check that the uploaded file is actually a mp3
    if (in_array($file_extension, $valid_file_extensions)) {
      $to = "uploads/" . $name;
      //move it to the right folder if is.
      move_uploaded_file($_FILES["upload"]["tmp_name"], $to);
      update_sound($pid,$name);
      echo $name;
    }
    else {
        echo 'File not support!';
      }
}


?>
