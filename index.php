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

<link href='http://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>

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
  //   $(".cbox").editable("save.php", {
  //       type      : 'checkbox',
  //       submit    : 'OK',
  //       cancel    : 'Cancel',
	// checkbox: { trueValue: 'true', falseValue: 'false'}
  //   });
 });
 </script>
 <script type="text/javascript">
     <!--
     function updateTime() {
         var currentTime = new Date();
         var hours = currentTime.getHours();
         var minutes = currentTime.getMinutes();
         var seconds = currentTime.getSeconds();
        //  var day = currentTime.getDay();
         var weekday = new Array(7);
            weekday[0] = "SUNDAY";
            weekday[1] = "MONDAY";
            weekday[2] = "TUESDAY";
            weekday[3] = "WEDNESDAY";
            weekday[4] = "THURSDAY";
            weekday[5] = "FRIDAY";
            weekday[6] = "SATURDAY";
            var d = new Date();
          var months = new Array();
          months[0] = "January";
          months[1] = "February";
          months[2] = "March";
          months[3] = "April";
          months[4] = "May";
          months[5] = "June";
          months[6] = "July";
          months[7] = "August";
          months[8] = "September";
          months[9] = "October";
          months[10] = "November";
          months[11] = "December";
        var month = months[currentTime.getMonth()];
        var day = weekday[currentTime.getDay()];
        var date = currentTime.getDate();
        var year = currentTime.getFullYear();
         if (minutes < 10){
             minutes = "0" + minutes;
         }
         if (seconds < 10){
             seconds = "0" + seconds;
         }
         var v = hours ;
         if(hours > 11){
             v+="";
         } else {
             v+=""
         }

       	if(hours < 10){
       	   hours = "0" + hours;
       	}
   var x;
  if(date==1 || date == 21 || date == 31){
    x="st";
  }
  if(date==2 || date == 22){
    x="nd";
  }
  else{
    x="th";
  }
         setTimeout("updateTime()",1000);
         document.getElementById('time').innerHTML=hours;
         document.getElementById('minutes').innerHTML=minutes;
         document.getElementById('day').innerHTML=day;
         document.getElementById('date').innerHTML=date;
         document.getElementById('month').innerHTML=month;
         document.getElementById('year').innerHTML=year;
         document.getElementById('x').innerHTML=x;
     }
     updateTime();
     //-->
 </script>
 </head>
 <body>
   <div class="hole">
    <div class="time" id="changebg"/>
      <div class="clock">
        <div class="date">
          <span id="day"></span>
          <p><span id="month"></span>&nbsp; &nbsp;<span id="date"></span><span id="x"></span>&nbsp; &nbsp;<span id="year"></span></p>
        </div>
        <div class="clock_left">
          <h1><span id="time" style=""/></h1>
        </div>
        <div class="divider"></div>
        <div class="clock_right">
          <h1><span id="minutes"/></h1>
        </div>
        <div class="sms">
          <p id="message">International slap a pencake day in Sweden<p>
        </div>

      </div>
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
        $true="false";
        if($schedule['ACTIVE']=='true'){
          $true="true";
        }
        print("<h1 class=\"\">");
            print("<span class=\"cboxactive ".$true."\" id=\"$sid.ACTIVE\">".$schedule['NAME']."</span>");
            $true="false";
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
         	print("<td class=\"edit_area period_name\" id=\"$elementID.NAME\">".$period['NAME']."</td>");
         	print("<td class=\"timepicker start_date\"id=\"$elementID.START_DATE\">".$period['START_DATE']."</td>");
         	print("<td class=\"timepicker end_date\" id=\"$elementID.END_DATE\">".$period['END_DATE']."</td>");
          print("<td>");
          print("<div class=\"dow\" style=\"display:none;\">".trim($period['DOW'],',')."</div>");
                generateDOWSelect($period['NAME'],$period['DOW'],$elementID);
                print("</td>");
         		    print("<td class=\"ajaxupload\"id=\"$elementID.SOUND\">".$period['SOUND']."</td>");
          print("</tr>");

       		$prepend++;
       		$prepend=$prepend%2;



       	}

         echo "
             <script type=\"text/javascript\">
              function updatebgcolor() {
                var weekday = new Array(7);
                   weekday[0] = 'SUN';
                   weekday[1] = 'MON';
                   weekday[2] = 'TUE';
                   weekday[3] = 'WED';
                   weekday[4] = 'THU';
                   weekday[5] = 'FRI';
                   weekday[6] = 'SAT';
                var start_date= document.getElementsByClassName('start_date');
                var end_date= document.getElementsByClassName('end_date');
                var dow= document.getElementsByClassName('dow');
                var period_name= document.getElementsByClassName('period_name');
                var currentTime = new Date();
                var chours = currentTime.getHours();
                var cminute = currentTime.getMinutes();
                var cday = weekday[currentTime.getDay()];

                for (var i = 0; i < start_date.length; i++) {
                  var start_dates = start_date[i].innerHTML.split(':');
                  var end_dates = end_date[i].innerHTML.split(':');
                  var start_h = start_dates[0];
                  var start_m = start_dates[1];
                  var end_h = end_dates[0];
                  var end_m = end_dates[1];
                  var dows = dow[i].innerHTML;
                  var pname =period_name[i].innerHTML.toLowerCase();
                  var bgcolor='#00BFFF';
                  if(pname=='pink'){
                    bgcolor='#FF69B4';
                  }
                  else if(pname=='purple'){
                    bgcolor='#800080';
                  }
                  else if(pname=='gray'){
                    bgcolor='#A9A9A9';
                  }
                  else if(pname=='blue'){
                    bgcolor='#00BFFF';
                  }
                  else if(pname=='red'){
                    bgcolor='#FF0000';
                  }
                  else if(pname=='green'){
                    bgcolor='#00FF00';
                  }
                  else if(pname=='orange'){
                    bgcolor='#FF8C00';
                  }
                  else if(pname=='yellow'){
                    bgcolor='#FFFF00';
                  }
                  else if(pname=='black'){
                    bgcolor='#000000';
                  }
                  else if(pname=='brown'){
                    bgcolor='#8B4513';
                  }
                  if(chours>=start_h && chours<=end_h && cminute>=start_m && cminute<=end_m && dows.indexOf(cday) >= 0){
                    document.getElementById('changebg').style.backgroundColor =bgcolor;
                  }
                    console.log(chours);


                }
              }
              setInterval(function(){updatebgcolor()},1000);

             </script>
         ";


        print("</tbody>");
        print("</table>");
       	  $prepend = 0;
      print("<table style=\"text-align:right; float:right;\" class=\"tbladd\">");
        print("<tr style=\"display:none;\" class=\"hideaddperiod\" id=\"show".$schedule['ID']."\">");
          print("<form action=\"addperiod_schedule.php\" method=\"POST\">");
          print("<td>Period Name</td><td>:</td>");
          print("<td><input type=\"text\" name=\"period_name\" value=\"\"/><input type=\"hidden\" name=\"sid\" value=\"".$schedule['ID']."\"></input></td>");
          print("<td><button name=\"addperiod\" type='submit' class='btn btn-primary'>Save</button></td>");
          print("</form>");

        print("</tr>");
        print("<tr>");
          print("<td><button id=\"".$schedule['ID']."\" class='btn btn-success addperiod'><span class=\"glyphicon glyphicon-plus addperiod\"></span> &nbsp;Add period</button></td>");;
        print("<tr>");
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
    function showPeriod(){
      document.getElementById("hide").style.display="block";
      document.getElementById("button").style.display="none";
    }
    $(document).ready(function() {
      $('.pen').click(function() {
          var thisid =$(this).attr('id');
          // console.log("got a click!");
          $('#edithide'+thisid).slideDown('slow');

      });
      $('.addperiod').click(function() {
          var thisid =$(this).attr('id');
          $(this).hide();
          $('#show'+thisid).slideDown('slow');

      });
      $('.cbox').click(function(e){
          // $(this).toggleClass('check');
          var elem = $(this)
          if (elem.hasClass('check')) {
              elem.removeClass('check').addClass("uncheck");
          } else {
              elem.removeClass().addClass("check" )
          }
          var e = $(this).css("color");
       var id = $(this).attr("id");
       var value = $(this).html();
       var i = true;
       if($(this).css("color")=='rgb(220, 220, 220)'){
         i=false;
       }
       else{
         i=true;
       }
       $.ajax({
          url: "save.php", //This is the page where you will handle your SQL insert
          type: "POST",
          data: {'id': id, 'value': value,'i':i},
          // data: "id=" + id +'&value='+value+'&i='+i, //The data your sending to some-page.php
          success: function(){
              console.log(e+i);
          },
          error:function(){
              console.log("AJAX request was a failure");
          }
        });
      });

      $('.cboxactive').click(function(e){
      var elem = $(this)
      if (elem.hasClass('true')) {
          elem.removeClass('true').addClass("false");
      } else {
          elem.removeClass().addClass("true" )
      }
       var id = $(this).attr("id");
       var value = $(this).html();
       var i = false;
       if($(this).css("color")=='rgb(0, 128, 0)'){
         i=true;
       }
       else{
         i=false;
       }
       $.ajax({
          url: "save.php",
          type: "POST",
          data: {'id': id,'value': value,'i':i},
          success: function(){
              console.log();
          },
          error:function(){
              console.log("AJAX request was a failure");
          }
        });
      });
});
  </script>
</body>
</html>
