#!/usr/bin/php
<?php
        //the command that will play the bell sound
	$command = "/usr/bin/mpg321";
        //user to run the command as
	$user = "root";
        //installation directory (where to find bells.xml)
	$source_dir = "/var/www/belldandy/";

        //read all of the schedules
	$schedules=simplexml_load_file($source_dir.'bells.xml');

        //where to store the temporary cron formatted stub file we generate
	$filename="bell.stub";
	$fh = fopen("/tmp/".$filename,"w");

	foreach($schedules as $schedule){
	if($schedule->active =='true'){
           //write a nice comment saying the name of the schedule
	   fwrite($fh,"### ".$schedule->title." ###\n");

	   foreach($schedule->periods->period as $period){
		$name = $period->name;
		$start = $period->starttime;
		$end = $period->endtime;
		$dow = $period->dow;
		$sound = $period->sound;
		
		$stime = explode(":",$start);
		$etime = explode(":",$end);
		
		$shour = $stime[0];
		$sminute = $stime[1];
		
		$ehour = $etime[0];
		$eminute = $etime[1];
		
		//print out the actual cron statements, formatted nicely
		fwrite($fh,"\n    #- $name -#\n");
		fwrite($fh,"$sminute $shour * * $dow $user\t $command $source_dir$sound\n");
		fwrite($fh,"$eminute $ehour * * $dow $user\t $command $source_dir$sound\n");

	   }
	   fwrite($fh,"\n");
	   }
	}
	fclose($fh);


?>
