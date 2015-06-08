<?php
	//print_r($_POST);
	include("func.php");
	$id = $_POST['id'];
	$value = $_POST['value'];

	$data = explode(".",$id);
	$sid = $data[0];
	$pid = $data[1];
	$modifiedData = $data[2];

	$suc = get_schedule($sid);
	$duc = get_periods($pid);

	//ECHO $modifiedData;

	if(strcmp($modifiedData,"DOW")==0){
		$newdow=$data[3];
	  $olddow=explode(",",$duc['DOW']);
	  $possDOW=array("MON","TUE","WED","THU","FRI","SAT","SUN");
			//insert dow
	   	if(strcmp($value,'true')==0){
				//prevents double adding of days
				if(strpos($duc['DOW'],$newdow)==false){
				   $value = $duc['DOW'].",$newdow";
				}
				else $value = $duc['DOW'];
				print("<div style=\"float:left;color:green;\">$newdow&nbsp;</div>");
    	}
           //remove dow
	   	else{
					$value="";
					foreach($olddow as $testdow){
					   if(strcmp($testdow,$newdow)==0){
								$testdow='';
					   }
					   $value.=$testdow.",";
					}
					print("<div style=\"float:left;color:rgb(220,220,220);\">$newdow&nbsp;</div>");
        }
					// updaate dow
					update_dow($pid,$value);

	}
	elseif(strcmp($modifiedData,"ACTIVE")==0){
		update_active($sid,$value);
		print("<span class=\"$value\">".$suc['NAME']."</span>");
		// print("<div class=\"$value\">".$suc['NAME']."</div>");
	}
	// update data beside Dow
	else {
		update_period($modifiedData,$value,$pid);
		echo $value;
	}
?>
