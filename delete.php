<?php
  include("func.php");
  $title=$_GET['title'];
  if($title=='schedule'){
    $sid = $_GET['sid'];
    delete_schedule($sid);
  }
  else if($title=='period'){
    $pid = $_GET['pid'];
    delete_period($pid);
  }
  header("Location: index.php");
?>
