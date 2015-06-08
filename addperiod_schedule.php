<?php
include("func.php");
  if (isset($_POST["addperiod"])) {
    $name = $_POST['period_name'];
    $sid = $_POST['sid'];
    add_period($sid,$name);
  }else if(isset($_POST["addschedule"])){
    $sname = $_POST['schedule_name'];
    add_schedule($sname);
  }
  else if(isset($_POST["updateschedule"])){
    $sname = $_POST['sname'];
    $sid = $_POST['sid'];
    update_schedule($sid,$sname);
  }
  else{
    echo 'please submit button!!';
  }
  header("Location: index.php");
?>
