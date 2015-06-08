<?php

 function get_periods($sid){
   $db = new SQLite3('bell.db');
	  return $results = $db->query('SELECT * FROM PERIODS where SCHEDULE_ID='.$sid);
	}

  function get_schedule(){
    $db = new SQLite3('bell.db');
 	  return $results = $db->query('SELECT * FROM SCHEDULE');
  }
?>
