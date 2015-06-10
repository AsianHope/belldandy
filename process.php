#!/usr/bin/php
<?php
	$db = new SQLite3('bell.db');
        //the command that will play the bell sound
	$command = "/usr/bin/mpg321";
        //user to run the command as
	$user = "root";
        //installation directory (where to find bells.xml)
	$source_dir = "./";
        //read all of the schedules
	$schedules = $db->query('SELECT * FROM SCHEDULE');
  //where to store the temporary cron formatted stub file we generate
	$filename="bell.stub";
	$fh = fopen("".$source_dir.$filename,"w");
	while ($schedule = $schedules->fetchArray()) {
		if($schedule['ACTIVE'] =='true'){
	           //write a nice comment saying the name of the schedule
		   fwrite($fh,"### ".$schedule['NAME']." ###\n");
			// get periods
			$periods = $db->query('SELECT * FROM PERIODS where SCHEDULE_ID='.$schedule['ID']);
				while ($period = $periods->fetchArray()) {
					$name = $period['NAME'];
					$start = $period['START_DATE'];
					$end = $period['END_DATE'];
					$dow = trim($period['DOW'], ",");
					$sound = $period['SOUND'];
					$stime = explode(":",$start);
					$etime = explode(":",$end);

					$shour = $stime[0];
					$sminute = $stime[1];

					$ehour = $etime[0];
					$eminute = $etime[1];

					//print out the actual cron statements, formatted nicely
					if($dow!=""){
						fwrite($fh,"\n    #- $name -#\n");
						fwrite($fh,"$sminute $shour * * $dow $user\t $command $source_dir$sound\n");
						fwrite($fh,"$eminute $ehour * * $dow $user\t $command $source_dir$sound\n");
					}


				}
		   	fwrite($fh,"\n");
		  }
	}
	fclose($fh);


?>
