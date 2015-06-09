<!DOCTYPE html>
<html>
<head>
<title>Belldandy - the Logos bell system!</title>
<link rel = "stylesheet" type="text/css" href="css/styles.css"/>
<script src="js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.jeditable.time.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.jeditable.ajaxupload.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.jeditable.checkbox.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ajaxFileUpload.js" type="text/javascript" charset="utf-8"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.0.6/modernizr.min.js"></script>

<link rel="stylesheet" href="css/bootstrap.min.css">



<script type="text/javascript">
 $(document).ready(function() {
     $('.edit').editable('save.php', {
         indicator : 'Saving...',
         tooltip   : 'Click to edit...'

     });
     $('.edit_area').editable('save.php', {
       onblur:'submit',
       tooltip   : 'Click to edit...',
       width:200+'px',
       height:30+'px',
     });
     $(".timepicker").editable("save.php", {
        indicator : "<img src='img/indicator.gif'>",
        type      : 'time',
        submit    : 'OK',
        tooltip   : "Click to edit..."
    });
    $(".ajaxupload").editable("upload.php", {
        indicator : "<img src='img/indicator.gif'>",
        type      : 'ajaxupload',
        fileElementId: 'upload',
        submit    : 'Upload',
        name: 'upload',
        cancel    : 'Cancel',
        tooltip   : "Click to upload..."
    });
    $(".cbox").editable("save.php", {
        type      : 'checkbox',
        submit    : 'OK',
        cancel    : 'Cancel',
	checkbox: { trueValue: 'true', falseValue: 'false'}
    });
 });
 </script>
 <script type="text/javascript">
     <!--
     function updateTime() {
         var currentTime = new Date();
         var hours = currentTime.getHours();
         var minutes = currentTime.getMinutes();
         var seconds = currentTime.getSeconds();
         if (minutes < 10){
             minutes = "0" + minutes;
         }
         if (seconds < 10){
             seconds = "0" + seconds;
         }
         var v = hours + ":" + minutes + ":" + seconds + " ";
         if(hours > 11){
             v+="";
         } else {
             v+=""
         }

 	if(hours < 10){
 	   hours = "0" + hours;
 	}
         setTimeout("updateTime()",1000);
         document.getElementById('time').innerHTML=v;
 // 	document.getElementById('time').style.left=seconds+"px";
 // 	document.getElementById('time').style.top=minutes*5+"px";
     }
     updateTime();
     //-->
 </script>
 </head>
 <body>
   <div class="hole">
    <div class="time"/>
   	<h1><span id="time" style="position:relative;"/></h1>
   </div>
   <p id="audio">
    <a href="bell.mp3">Listen &raquo;</a>
   </p>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
   <script type="text/javascript">
       $(function () {
           var audioElement = $('#audio'),
           href = audioElement.children('a').attr('href');
           $.template('audioTemplate', '<audio src="${src}" controls>');
           if (Modernizr.audio.mp3) {
               audioElement.empty();
                   $.tmpl('audioTemplate', {src: href}).appendTo(audioElement);
                }
           });
   </script>

  <?php
    include("func.php");
  	$prepend = 0;
    $schedules= get_all_schedules();
    while ($schedule = $schedules->fetchArray()) {
    $sid =$schedule['ID'].".0";
    print("<div class=\"container\">");
        print("<h1 class=\"".$schedule['ACTIVE']."\">");
            print("<span class=\"cbox\" id=\"$sid.ACTIVE\">".$schedule['NAME']."</span>");
            print("&nbsp; &nbsp;<span id=\"".$schedule['ID']."\" class='glyphicon glyphicon-pencil pen'></span> <a href=\"delete.php?sid=" . $schedule['ID'] ."&title=schedule\" onclick=\"return confirm('Are you sure you want to delete schedule?');\"><span class='glyphicon glyphicon-trash'></span></a>");
        print("</h1>");
        print("<div id=\"edithide".$schedule['ID']."\" style=\"padding:10px 0px 10px 0px; display:none;\">");
          print("<table class=\"tbladd\">");
            print("<tr>");
              print("<form action=\"addperiod_schedule.php\" method=\"POST\">");
              print("<td>Schedule Name</td><td>:</td>");
              print("<td><input type=\"text\" name=\"sname\" value=\"".$schedule['NAME']."\"/><input type=\"hidden\" name=\"sid\" value=\"".$schedule['ID']."\"></input></td>");
              print("<td><button name=\"updateschedule\" type='submit' class='btn btn-warning'><span class=\"glyphicon glyphicon-pencil\"></span> &nbsp;Edit schedule</button></td>");
              print("</form>");
            print("</tr>");
          print("</table>");
        print("</div>");
        print("<table class=\"table table-striped table-bordered table-condensed table-hover\">");
        print("<thead>");
    	  print("<tr class=\"h\"><th><span class='glyphicon glyphicon-trash'></span></th><th>Period</th><th>Start</th><th>End</th><th>DoW</th><th>Sound</th></tr>");
        $periods=get_all_periods($schedule['ID']);
        while($period = $periods->fetchArray()){
       	$elementID=$schedule['ID'].".".$period['ID'];
        print("</thead>");
        print("<tbody>");
       	print("<tr class=\"c$prepend\">");
          print("<td><a href=\"delete.php?pid=" . $period['ID'] ."&title=period\" onclick=\"return confirm('Are you sure you want to delete period?');\"><span class='glyphicon glyphicon-trash'></span></a></td>");
         	print("<td class=\"edit_area\" id=\"$elementID.NAME\">".$period['NAME']."</td>");
         	print("<td class=\"timepicker\"id=\"$elementID.START_DATE\">".$period['START_DATE']."</td>");
         	print("<td class=\"timepicker\" id=\"$elementID.END_DATE\">".$period['END_DATE']."</td>");
          print("<td>");
                generateDOWSelect($period['NAME'],$period['DOW'],$elementID);
                print("</td>");
         		    print("<td class=\"ajaxupload\"id=\"$elementID.SOUND\">".$period['SOUND']."</td>");
          print("</tr>");

       		$prepend++;
       		$prepend=$prepend%2;
       	}
        print("</tbody>");
        print("</table>");
       	  $prepend = 0;
      print("<table class=\"tbladd\">");
        print("<tr>");
          print("<form action=\"addperiod_schedule.php\" method=\"POST\">");
          print("<td>Period Name</td><td>:</td>");
          print("<td><input type=\"text\" name=\"period_name\" value=\"\"/><input type=\"hidden\" name=\"sid\" value=\"".$schedule['ID']."\"></input></td>");
          print("<td><button name=\"addperiod\" type='submit' class='btn btn-success'><span class=\"glyphicon glyphicon-plus\"></span> &nbsp;Add period</button></td>");
          print("</form>");
        print("</tr>");

        print("<tr>");
          print("<form action=\"addperiod_schedule.php\" method=\"POST\">");
          print("<td>Schedule Name</td><td>:</td>");
          print("<td><input type=\"text\" name=\"sname\" value=\"".$schedule['NAME']."\"/><input type=\"hidden\" name=\"sid\" value=\"".$schedule['ID']."\"></input></td>");
          print("<td><button name=\"updateschedule\" type='submit' class='btn btn-warning'><span class=\"glyphicon glyphicon-pencil\"></span> &nbsp;Edit schedule</button></td>");
          print("</form>");
        print("</tr>");
      print("</table>");
      print("</div>");
      }
      print("<div class=\"container\">");
        print("<table class=\"tbladdschedule\">");
          print("<tr id=\"hide\">");
            print("<form action=\"addperiod_schedule.php\" method=\"POST\">");
            print("<td>Schedule Name</td><td>:</td>");
            print("<td><input type=\"text\" name=\"schedule_name\" value=\"\"/></td>");
            print("<td><button name=\"addschedule\" type='submit' class='btn btn-primary'>Save</button></td>");
            print("</form>");
          print("</tr>");
          print("<tr>");
            print("<td><button type='submit' id=\"button\" onclick=\"show()\" class='btn btn-success'><span class=\"glyphicon glyphicon-plus\"></span> &nbsp;Add schedule</button></td>");;
          print("<tr>");

        print("</table>");
      print("</div>");
  ?>
  </div>
  <script type="text/javascript">
    function show() {
      document.getElementById("hide").style.display="block";
      document.getElementById("button").style.display="none";
    }
    $(document).ready(function() {
      $('.pen').click(function() {
          var thisid =$(this).attr('id');
          console.log("got a click!");
          $('#edithide'+thisid).slideDown('slow');

      });
      $('#editpen').click(function() {
                $('#edithide').slideDown('slow');
          });
    });
  </script>
</body>
</html>
