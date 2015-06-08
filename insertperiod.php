<?php
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('bell.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      INSERT INTO PERIODS (SCHEDULE_ID,NAME,START_DATE,END_DATE,SOUND,DOW)
      VALUES (1, 'Homeroom Warning','08:00','08:05','bell.mp3','MON  TUE  WED  THU  FRI ');
      INSERT INTO PERIODS (SCHEDULE_ID,NAME,START_DATE,END_DATE,SOUND,DOW)
      VALUES (2, 'Homeroom Warning','08:00','08:05','bell.mp3','MON  TUE  WED  THU  FRI ');
      INSERT INTO PERIODS (SCHEDULE_ID,NAME,START_DATE,END_DATE,SOUND,DOW)
      VALUES (3, 'Homeroom Warning','08:00','08:05','bell.mp3','MON  TUE  WED  THU  FRI ');
      INSERT INTO PERIODS (SCHEDULE_ID,NAME,START_DATE,END_DATE,SOUND,DOW)
      VALUES (4, 'Homeroom Warning','08:00','08:05','bell.mp3','MON  TUE  WED  THU  FRI ');



EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Records created successfully\n";
   }
   $db->close();
?>
