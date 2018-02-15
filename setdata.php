<?php 
include("inc_db.php");
session_start();
$StaffCode=$_SESSION["UserName"];
$Year=$_SESSION["Year"];
$Semester=$_SESSION["Semester"];
$CourseSectionID = $_GET["CourseSectionID"] ;
$sql="SELECT C.CourseName,C.CourseCode,S.SectionNo,S.Semester,S.YearRegister";
$sql.=" from kuse_courses C ";
$sql.=" INNER JOIN kuse_course_sections S ON C.CourseCode=S.CourseCode";
$sql.=" WHERE S.CourseSectionID=$CourseSectionID";
$course=mysql_fetch_object(mysql_query($sql));
?>
<html>  
      <head>  
           <title>แก้ไขการเก็บคะแนน</title>
           <meta charset="UTF-8">  
           <link rel="stylesheet" href="css/bootstrap.min.css" />  
           <link rel="stylesheet" href="css/font/thsarabunnew.css">
	<link rel="stylesheet" type="text/css" href="css/template1.css">
	 <script type="text/javascript" src="date_time.js"></script>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
	 <script src="http://code.jquery.com/jquery-latest.min.js"></script>

           <script src="jquery.min.js"></script>  
           <script src="bootstrap.min.js"></script>  
      </head>  
      
      <body>  
      <div class="wrapper" style="min-width:1300px;margin-bottom: 10px;min-height: 90%;">

<div class="header">
<div style="float: left; width: 70%;">
	<img class="im_top" src="img/logo32.png">
<div class="tx-top"> KASETSART UNIVERSITY <br> ระบบประกาศคะแนนเก็บ  <br> มหาวิทยาลัยเกษตรศาสตร์ วิทยาเขต เฉลิมพระเกียรติ จังหวัดสกลนคร </div>
</div>
<div style="float: left; width: 30%;">
<div class="menuheader"><img src="img/back.png" onclick="goBack()" class="menuimg" style="margin-right:5px;"><a href="advisor_menu.php"><img src="img/home.png" class="menuimg" style="margin-right:5px;"></a><a href="do_logout.php"><img src="img/out.png" class="menuimg"></a></div>
</div>


<script>
function goBack() {
    window.history.back();
}
</script>


</div>

           <div class="container">  
                <br />  
                <br />  
                <br />  
                <div class="table-responsive"> 
                    <h1 align="center">สร้างกลุ่มคะแนน</h1> 
                     <h3 align="center">ชื่อวิชา <?php print($course->CourseName); ?> รหัสวิชา <?php print($course->CourseCode) ?></h3><br />  
                     <div id="live_data"></div>                 
                     <!--<div id="process_data" style="color: #44B66A; font-size: 28px"></div>    -->             
          

                </div>
      

</div>
      </div>  
<div class="footer" style="min-width:1300px;height: 200px;">
  <div class="tx-footer" style="font-family: sps; font-size: 20px; ">
ระบบนี้รองรับการทำงานด้วยเว็บเบราว์เซอร์  Chrome ,  Firefox และ  Internet Explorer รุ่น 8 ขึ้นไป <br>
Copyright © 2017 มหาวิทยาลัยเกษตรศาสตร์ วิทยาเขตเฉลิมพระเกียรติ จังหวัดสกลนคร All Rights Reserved.</div>


</div> <script>  
 $(document).ready(function(){  
      function fetch_data()  
      {  
           $.ajax({  
                url:"selectmp.php",  
                method:"POST",   
                data:
                {
                  CourseSectionID:<?php print($CourseSectionID);?> ,
                },  
                dataType:"text", 
                success:function(data){  
                     $('#live_data').html(data);  
                }  
           });  
      }  
      fetch_data();  
      $(document).on('click', '#btn_add', function(){  
           var MasterPlanName = $('#MasterPlanName').text();  
           var PlanPercentage = $('#PlanPercentage').text();
           var CourseSectionID = '<?php echo $CourseSectionID ?>';
           var StaffCode = '<?php echo $StaffCode ?>';
           //var CourseSectionID = document.getElementById('secid').value;
          // var StaffCode = document.getElementById('staff').value;
           if(MasterPlanName == '')  
           {  
                alert("กรุณากรอก ชื่อหมวดหมู่");  
                return false;  
           }  
           if(PlanPercentage == '')  
           {  
                alert("กรุณากรอก เปอร์เซ็นการให้คะแนน");  
                return false;  
           }             
           $.ajax({  
                url:"insertmp.php",  
                method:"POST",  
                data:
                {
                  MasterPlanName:MasterPlanName ,
                  PlanPercentage:PlanPercentage,
                  CourseSectionID:CourseSectionID ,
                  StaffCode:StaffCode ,
                },  
                dataType:"text",  
                success:function(data)  
                {  
                     fetch_data();  
                }  
           })  
      });  
      function edit_data(id, text, column_name)  
      {  
           $.ajax({  
                url:"editmp.php",  
                method:"POST",  
                data:{id:id, text:text, column_name:column_name},  
                dataType:"text",  
                success:function(data){  
                     $('#process_data').html(data).show().fadeOut(1900);  
                }  
           });  
      }  
      
      $(document).on('blur', '.MasterPlanName', function(){  
           var id = $(this).data("id1");  
           var MasterPlanName = $(this).text();  
           edit_data(id,MasterPlanName, "MasterPlanName");  
      });  
      $(document).on('blur', '.PlanPercentage', function(){  
           var id = $(this).data("id2");  
           var PlanPercentage = $(this).text();  
           edit_data(id,PlanPercentage, "PlanPercentage");  
      });        
      $(document).on('click', '.btn_delete', function(){ 
          var id = $(this).data("id3"); 
           if(confirm("คุณต้องการลบข้อมูลใช่หรือไม่?"))  
           {  
                $.ajax({  
                     url:"deletemp.php",  
                     method:"POST",  
                     data:{id:id},  
                     dataType:"text",  
                     success:function(data){  
                          alert(data);  
                          fetch_data();  
                     }  
                });  
           }  
      });  
 });  
 </script>

      </body> 

    
 </html>



