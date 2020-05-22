<?php
require_once("../../../wp-load.php");
global $wpdb;
date_default_timezone_set('Asia/Manila');


if($_POST['action'] == 'gradelevel'){
	
     $grade_level = $_POST['grade_level'];
	 $user_logged_in = $_POST['userID'];
     $htmlSect = "";
	 $htmlStud = "";
	 $htmlSubj = "";
	 
	 //load section
	 $resultSect = $wpdb->get_results( $wpdb->prepare( "SELECT sec_code, section 
	                                                    FROM gradelevel_section_tbl 
														WHERE grade_level = $grade_level 
														AND adviser = $user_logged_in
														AND deleted=0" ));
	 foreach($resultSect as $rowSect) {
       $htmlSect .= "<option value=$rowSect->sec_code>$rowSect->section</option>";	  
	 }															
	 	 
     //load student
	 $resultStud = $wpdb->get_results( $wpdb->prepare( "SELECT id,name FROM student_tbl WHERE grade_level=$grade_level AND deleted=0" ));
	 
	 foreach($resultStud as $rowStud) {
       $htmlStud .= "<option value=$rowStud->id>$rowStud->name</option>";	  
	 }	 
         
	 echo $htmlSect."~".$htmlStud;
		
}else if($_POST['action'] == 'section'){
	
     $grade_level = $_POST['grade_level'];
	 $section = $_POST['section'];
	 $htmlStud = "";

     //load student
	 $resultStud = $wpdb->get_results( $wpdb->prepare("SELECT id,name FROM student_tbl WHERE grade_level='".$grade_level."' AND sec_code='".$section."'  AND deleted=0"));
	 foreach($resultStud as $rowStud) {
       $htmlStud .= "<option value=$rowStud->id>$rowStud->name</option>";	  
	 }
	 
	 echo $htmlStud;
	 
}else if($_POST['action'] == 'student'){
	
	 $student = $_POST['studentID'];
	 //$quarter = $_POST['quarter'];
	 $htmlStud = "<tr>
		    <td align='center' style='font-weight: bold;'>Subject</td>
			<td align='center' style='font-weight: bold;'>1st</td>
			<td align='center' style='font-weight: bold;'>2nd</td>
			<td align='center' style='font-weight: bold;'>3rd</td>
			<td align='center' style='font-weight: bold;'>4th</td>		 
         </tr>";

     //load grades
	 $resultStudGrd = $wpdb->get_results( $wpdb->prepare("SELECT
                                                stud.name,
												stud.grade_level,
                                                sect.section,												
												subj.subject,
												MAX(cgrade.1st_Qtr) AS first,
                                                MAX(cgrade.2nd_Qtr) AS second,
                                                MAX(cgrade.3rd_Qtr) AS third,
                                                MAX(cgrade.4th_Qtr) AS fourth
												FROM classgrades_tbl AS cgrade 
												LEFT JOIN student_tbl AS stud 
												ON cgrade.student_id = stud.id
												LEFT JOIN gradelevel_section_tbl AS sect 
												ON cgrade.sec_code = sect.sec_code
 												LEFT JOIN gradelevel_subject_tbl AS subj 
												ON cgrade.sub_code = subj.sub_code
												WHERE cgrade.student_id = '".$student."'
												AND cgrade.deleted = 0 AND sect.deleted = 0 AND subj.deleted = 0
                                                GROUP BY cgrade.sub_code
												ORDER BY FIELD (cgrade.sub_code,'2Fil','2Eng','2Mat','2Sci','2Hek')"));
	 $divider1 = 1;
	 $divider2 = 1;
	 $divider3 = 1;
	 $divider4 = 1;	 
	 foreach($resultStudGrd as $rowStud) {
	  if($rowStud->first > 0)
	  {
		$firstAve += $rowStud->first;
        $firstGenAve = $firstAve / $divider1;
        $divider1++;		
	   }else{
		  $rowStud->first = '--'; 
	   }	   

	  if($rowStud->second > 0)
	  {
		$secondAve += $rowStud->second;
        $secondGenAve = $secondAve / $divider2;
        $divider2++;		
	   }else{
		  $rowStud->second = '--'; 
	   }	   
	   
	  if($rowStud->third > 0)
	  {
		$thirdAve += $rowStud->third;
        $thirdGenAve = $thirdAve / $divider3;
        $divider3++;		
	   }else{
		  $rowStud->third = '--'; 
	   }
	   
	  if($rowStud->fourth > 0)
	  {
		$fourthAve += $rowStud->fourth;
        $fourthGenAve = $fourthAve / $divider4;
        $divider4++;		
	   }else{
		  $rowStud->fourth = '--'; 
	   }	   
       $htmlStud .= "<tr>
	                   <td width='180px'>$rowStud->subject</td>
					   <td align='center'>$rowStud->first</td>
					   <td align='center'>$rowStud->second</td>
					   <td align='center'>$rowStud->third</td>
					   <td align='center'>$rowStud->fourth</td>
					</tr>";
       $name = 	$rowStud->name;
       $grsec = $rowStud->grade_level."-".$rowStud->section;	   
	 }

       $htmlStud .= "<tr>
	                   <td>Average</td>
					   <td width='50px' align='center' style='font-weight: bold;'>".$firstGenAve."</td>
					   <td width='50px' align='center' style='font-weight: bold;'>".$secondGenAve."</td>
					   <td width='50px' align='center' style='font-weight: bold;'>".$thirdGenAve."</td>
					   <td width='50px' align='center' style='font-weight: bold;'>".$fourthGenAve."</td>
					</tr>";	 	 
	 
	 
	 echo $htmlStud."~".$name."~".$grsec;
	 
}else{
	echo "oppss";
}




?>
