<?php
	//print_r($_POST);
	include("func.php");
	$id = $_POST['id'];
	$value = $_POST['value'];
	$check = $_POST['i'];
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
	   	if(strcmp($check,'true')==0){
				//prevents double adding of days
				if(strpos($duc['DOW'],$newdow)==false){
					foreach($olddow as $testdow){
					   $old.=$testdow.",";
					}
				   $value = $old."$newdow";
				}
				else $value = $old;
				print("<div style=\"float:left; padding:0px 5px 0px 5px;\">$newdow</div>");
    	}
           //remove dow
	   	else{
					$value="";
					foreach($olddow as $testdow){
					   if(strcmp($testdow,$newdow)==0){
								$old="";
					   }
							else {
								$old=$testdow;
							}
						if($old!=""){
								$value.=$old.",";
							}

					}
					print("<div style=\"float:left; padding:0px 5px 0px 5px;\">$newdow</div>");
        }
					// updaate dow
					update_dow($pid,$value);

	}
	elseif(strcmp($modifiedData,"ACTIVE")==0){
		update_active($sid,$check);
		print("<span class=\"$check\">".$suc['NAME']."</span>");
		// print("<div class=\"$value\">".$suc['NAME']."</div>");
	}
	// update data beside Dow
	else {
		update_period($modifiedData,$value,$pid);
		echo $value;
	}
?>
