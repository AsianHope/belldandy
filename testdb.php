<?php
$db = new SQLite3('bell.db');
$results = $db->query('SELECT * FROM PERIODS');
while ($schedule = $results->fetchArray()) {
echo $schedule['ID'];

  echo $schedule['NAME'].' ';
  echo $schedule['SCHEDULE_ID'].' \n';


}

?>
