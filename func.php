<?php
   function myHeader(){
      print("
	<html>
	<head>
	   <title>Belldandy - the Logos bell system!</title>
	   <link rel = \"stylesheet\" type=\"text/css\" href=\"styles.css\"/>
	</head>
	<body>");
   }

   function myFooter(){
      print("</body>
      </html>");
   } //end footer()

   function showBells(){
        $schedules=simplexml_load_file('bells.xml');
        $prepend = 0;
        foreach($schedules as $schedule){
           print("<h1 class=\"$schedule->active\">");
           print($schedule->title);
           print("<table>");
           print("<tr class=\"h\"><td>Period</td><td>Start</td><td>End</td><td>DoW</td><td>Sound</td></tr>");

           foreach($schedule->periods->period as $period){
                print("<tr class=\"c$prepend\">");
                print("<td>".$period->name."</td>");
                print("<td>".$period->starttime."</td>");
                print("<td>".$period->endtime."</td>");
                print("<td>".$period->dow."</td>");
                print("<td>".$period->sound."</td>");
                print("</tr>");

                $prepend++;
                $prepend=$prepend%2;
           }
           print("</table>");
           $prepend = 0;
        }
   }

    function findSchedule($schedules,$key){
           $selection = null;

           foreach($schedules as $schedule){
             if($schedule->sid==$key){
                $selection = $schedule;
             }
           }

           return $selection;
    }

   function findPeriod($schedule,$key){
       $selection = null;
       foreach($schedule as $periods){
       foreach($periods as $period){
          if($period->pid==$key){
		$selection = $period;
	  }
	}
	}

	return $selection;
   }

   function generateTimeSelect($name,$curtimeval){
	 print("<select name=\"".$name."hour\">");
                $stime = explode(":",$curtimeval);
                $shour = $stime[0];
                $smin = $stime[1];
                $selected="";

                for($i=7;$i<24;$i++){
                        if($i<10)$i="0".$i;
                        if($i==$shour) $selected = "selected";
                        print("<option $selected>$i</option>");
                        $selected="";
                }

                for($i=0;$i<7;$i++) print("<option>0$i</option>");
                print("</select>"); //end hour selection

                print(":");
                print("<select name=\"startmin\">");

                for($i=0;$i<60;$i++){
                        if($i<10)$i="0".$i;
                        if($i==$smin) $selected = "selected";
                        print("<option $selected>$i</option>");
                        $selected="";
                }
                print("</select>"); //end min selection

   }

   function generateDOWSelect($name,$curdow,$id){
	$possDOW=array("MON","TUE","WED","THU","FRI","SAT","SUN");
	$curdow = explode(",",$curdow);
	$checked="rgb(220,220,220);";

	foreach($possDOW as $thisDOW){
	   foreach($curdow as $testdow){
		   if(strcmp($testdow,$thisDOW)==0) $checked="green";
	   }

	print("<div style=\"float:left;color:$checked\" class=\"cbox\" id=\"$id.DOW.$thisDOW\">".$thisDOW."&nbsp; </div>");
	$checked="rgb(220,220,220);";
	}

  }
// -----------------get periods from database--------------
  function get_periods($id){
      $db = new SQLite3('bell.db');
      $data=null;
      $results = $db->query('SELECT * FROM PERIODS where ID ='.$id);
      while ($results = $results->fetchArray()) {
        return $data=$results;
      }
  }
  function get_all_periods($sid){
      $db = new SQLite3('bell.db');
   	  return $results = $db->query('SELECT * FROM PERIODS where SCHEDULE_ID='.$sid);
  }
  //-----------get only schedule that have ID = $sid---------------
  function get_schedule($sid){
      $db = new SQLite3('bell.db');
      $data=null;
      $results = $db->query('SELECT * FROM SCHEDULE where ID ='.$sid);
      while ($results = $results->fetchArray()) {
         return $data=$results;
      }
  }
  // ------------------get all schedules---------------
  function get_all_schedules(){
      $db = new SQLite3('bell.db');
    	return $results = $db->query('SELECT * FROM SCHEDULE');
  }
  //------------update period except DOW----------------
  function update_period($modifiedData,$value,$pid){
    $db = new SQLite3('bell.db');
    $results = $db->query('UPDATE PERIODS SET '.$modifiedData.'="'.$value.'" WHERE ID='.$pid);
  }
      //--------update period dow-----------
  function update_dow($pid,$value){
    $db = new SQLite3('bell.db');
    $results = $db->query('UPDATE PERIODS SET DOW="'.$value.'" WHERE ID='.$pid);
  }
    //----------update scheule active---------
  function update_active($sid,$value){
      $db = new SQLite3('bell.db');
      $results = $db->query('UPDATE SCHEDULE SET ACTIVE="'.$value.'" WHERE ID='.$sid);
  }
    //--------------update sound-------------
  function update_sound($pid,$value){
    $db = new SQLite3('bell.db');
    $results = $db->query('UPDATE PERIODS SET SOUND="'.$value.'" WHERE ID='.$pid);
  }
    //------------delete periods--------------
  function delete_period($pid){
    $db = new SQLite3('bell.db');
    $results = $db->query('DELETE FROM PERIODS WHERE ID='.$pid);
  }
  //-----------add period-----------------
  function add_period($sid,$name){
    $db = new SQLite3('bell.db');
    $results = $db->query('INSERT INTO PERIODS (SCHEDULE_ID,NAME,START_DATE,END_DATE,DOW,SOUND) VALUES ('.$sid.',"'.$name.'","00:00","00:00","null","null")');
  }
  //--------------add schedule------------------
  function add_schedule($name){
    $db = new SQLite3('bell.db');
    $db = new SQLite3('bell.db');
    $results = $db->query('INSERT INTO SCHEDULE (NAME,ACTIVE) VALUES ("'.$name.'","false")');
  }

  //------------delete periods--------------
function delete_schedule($sid){
  $db = new SQLite3('bell.db');
  $results = $db->query('DELETE FROM SCHEDULE WHERE ID='.$sid);
  $results = $db->query('DELETE FROM PERIODS WHERE SCHEDULE_ID='.$sid);
}
//--------------update schedule-------------
function update_schedule($sid,$name){
$db = new SQLite3('bell.db');
$results = $db->query('UPDATE SCHEDULE SET NAME="'.$name.'" WHERE ID='.$sid);
}
?>
