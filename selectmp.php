<?php  
session_start();
$StaffCode=$_SESSION["UserName"];
$CourseSectionID=$_POST["CourseSectionID"];
include 'inc_db.php';
$output='';
		$sql = "SELECT CourseSectionID,MasterPlanID,`MasterPlanName`,`PlanPercentage` FROM point_master_plans WHERE CourseSectionID=$CourseSectionID ORDER BY  `MasterPlanID` ASC  ";  
 		$result = mysql_query($sql,$dblink); 
	//	print($sql);
 		$output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                	 <th width="10%" style="display:none;">ID</th>  
                     <th width="10%">ลำดับ</th> 
                     <th width="30%">ชื่อหมวดหมู่</th>  
                     <th width="10%">เปอร์เซ็นคะแนน</th>
                     <!--<th width="10%">คะแนนย่อย</th>   -->
                     <th width="5%">ลบ</th>  
                </tr>';  
                $order = 0;
		 if(mysql_num_rows($result) > 0)  
		 {  
		      while($row = mysql_fetch_array($result))  
		      {  
		      	 $order++;
		           $output .= '  

		                <tr>
		                	 <td style="display:none;">'.$row["MasterPlanID"].'</td>   
		                     <td>'.$order.'</td>
		                     <td class="MasterPlanName" data-id1="'.$row["MasterPlanID"].'" contenteditable>'.$row["MasterPlanName"].'</td>  
		                     <td class="PlanPercentage" data-id2="'.$row["MasterPlanID"].'" contenteditable>'.$row["PlanPercentage"].'</td>
		                     <!--<td><a href="detail.php?CourseSectionID='.$row["CourseSectionID"].'&id='.$row["MasterPlanID"].'&staffid='.$StaffCode.'">แก้ไข</a></td>  -->
		                     <td><button type="button" name="delete_btn" data-id3="'.$row["MasterPlanID"].'" class="btn btn-xs btn-danger btn_delete">ลบ</button></td>  
		                </tr>  
		           ';  

		      }  
		      $output .= '  
		           <tr>
		           		<td style="display:none;"></td>  
		                <td ></td>  
		                <td id="MasterPlanName" contenteditable></td>  
		                <td id="PlanPercentage" contenteditable></td>  
		                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">เพิ่มกลุ่มคะแนน</button></td>  
		           </tr>  
		           
		      '; 
			 }  
			 else  
			 {  
			      $output .= '
							<tr>  
			                <td colspan="5">Data not Found</td>
			                </tr>
			      			<tr>  
							<td style="display:none;"></td>  
							<td ></td>  
							<td id="MasterPlanName" contenteditable></td>  
							<td id="PlanPercentage" contenteditable></td>  
							<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">add</button></td>  

							</tr>';  
			 }  
			 $output .= '</table> 
							      </div>';  
			 echo $output.'<br>';
 ?>
