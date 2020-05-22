<?php
//aaaaa
require_once("../../../wp-load.php");
global $wpdb;
date_default_timezone_set('Asia/Manila');


if($_POST['action'] == 'add'){
	
	 $gradelvl = $_POST['grdlvl'];
	 $section = $_POST['section'];
     $subject = $_POST['subject'];	 
	 $studID = $_POST['studID'];	 
	 $quarter = $_POST['quarter'];
	 
	 $score1 = $_POST['score1'];
	 $score2 = $_POST['score2'];
	 $score3 = $_POST['score3'];
	 $grade = $_POST['grade'];	 
	 $qtr_grade = $quarter."_Qtr";
	 $date_entered = date("Y-m-d H:i:s");
     $user_logged_in = $_POST['userID'];


     //check duplicate entry
	 $resultduplicate = $wpdb->get_row( $wpdb->prepare("SELECT * FROM classgrades_tbl WHERE student_id='".$studID."' AND sub_code='".$subject."' AND Quarter='".$quarter."' AND user_logged_in = '".$user_logged_in."' AND deleted=0"));
     if($resultduplicate->id)
	   {
		 echo "Duplicate Entry, Please check your record.";
         exit();		 
	   }

	 if($wpdb->insert(
		  'classgrades_tbl',
		  array (
			  'grade_level' => $gradelvl,
			  'sec_code' => $section,
			  'sub_code' => $subject,
			  'student_id' => $studID,
			   $qtr_grade => $grade,
              'Quarter' => $quarter,
              'score1' => $score1,
			  'score2' => $score2,
			  'score3' => $score3,
			  'grade' => $grade,
              'date_entered' => $date_entered,
              'user_logged_in' => $user_logged_in,			  
		  )
		) == false) echo 'Error in saving..';		
	 else echo 'updated';
	 
}else if($_POST['action'] == 'edit'){
	
	$recordID = $_POST['recordId'];
	$result = $wpdb->get_row( $wpdb->prepare("SELECT cgrade.id,
                                                cgrade.grade_level,
												cgrade.sec_code,
                                                sect.section,
                                                cgrade.sub_code,
                                                subj.subject,
                                                cgrade.Quarter,	
                                                stud.id as StudentID,												
											    stud.name,												
											    cgrade.score1, 
												cgrade.score2,
                                                cgrade.score3,												
												cgrade.grade,
                                                cgrade.date_entered													  
												FROM classgrades_tbl AS cgrade 
												LEFT JOIN student_tbl AS stud 
												ON cgrade.student_id = stud.id
												LEFT JOIN gradelevel_section_tbl AS sect 
												ON cgrade.sec_code = sect.sec_code
 												LEFT JOIN gradelevel_subject_tbl AS subj 
												ON cgrade.sub_code = subj.sub_code                                               												
												WHERE cgrade.id = '".$recordID."'
												AND cgrade.deleted=0
												AND stud.deleted=0
												AND sect.deleted=0
												AND subj.deleted=0"));
	echo "<option value=$result->StudentID>$result->name</option>".
	 "|"."<option value=$result->grade_level>$result->grade_level</option>".
	 "|"."<option value=$result->sec_code>$result->section</option>".
	 "|"."<option value=$result->sub_code>$result->subject</option>".
	 "|"."<option value=$result->Quarter>$result->Quarter</option>".
	 "|".$result->score1.
	 "|".$result->score2.
	 "|".$result->score3.
	 "|".$result->grade.
     "|".$result->name;	 
	
}else if($_POST['action'] == 'editSave'){
	
	 $recordID = $_POST['recordID']; 
	 $quarter = $_POST['quarter'];
	 $score1 = $_POST['score1'];
	 $score2 = $_POST['score2'];
	 $score3 = $_POST['score3'];
	 $grade = $_POST['grade'];	 
	 $qtr_grade = $quarter."_Qtr";
	 $date_modified = date("Y-m-d H:i:s");
     $user_logged_in = $_POST['userID'];

	 if($wpdb->update(
		  'classgrades_tbl',
		  array (
              'score1' => $score1,
			  'score2' => $score2,
			  'score3' => $score3,
			  'grade' => $grade,
			  $qtr_grade => $grade,
              'date_modified' => $date_entered,
              'user_logged_in' => $user_logged_in,	
		  ),
		  array('id' => $recordID)
		) == false) echo 'Error in saving..';		
	 else echo 'updated';
	
}else if($_POST['action'] == 'delSave'){
	
     $recordID = $_POST['recordID'];
	 $date_modified = date("Y-m-d H:i:s");
     $user_logged_in = $_POST['userID'];
	 
	 if($wpdb->update(
		  'classgrades_tbl',
		  array (
			  'deleted' => 1,
			  'date_modified' => $date_modified,
			  'user_logged_in' => $user_logged_in,
		  ),
		  array('id' => $recordID)
		) == false) echo 'Error in deleting..';		
	 else echo 'updated';
	
}else if($_POST['action'] == 'gradelevel'){
	
     $grade_level = $_POST['grade_level'];
     $htmlSect = "";
	 $htmlStud = "";
	 $htmlSubj = "";
	 
     //load student
	 $resultStud = $wpdb->get_results( $wpdb->prepare( "SELECT id,name FROM student_tbl WHERE grade_level=$grade_level $sectionSearch AND deleted=0" ));
	 foreach($resultStud as $rowStud) {
       $htmlStud .= "<option value=$rowStud->id>$rowStud->name</option>";	  
	 }	 
         
	 //load section
	 $resultSect = $wpdb->get_results( $wpdb->prepare( "SELECT sec_code,section FROM gradelevel_section_tbl WHERE grade_level = $grade_level AND deleted=0" ));
	 foreach($resultSect as $rowSect) {
       $htmlSect .= "<option value=$rowSect->sec_code>$rowSect->section</option>";	  
	 }	 
	 
     //load subject
	 $resultSubj = $wpdb->get_results( $wpdb->prepare( "SELECT sub_code,subject FROM gradelevel_subject_tbl WHERE grade_level = $grade_level AND deleted=0" ));
	 foreach($resultSubj as $rowSubj) {
       $htmlSubj .= "<option value=$rowSubj->sub_code>$rowSubj->subject</option>";	  
	 }	 

	 echo $htmlStud."~".$htmlSect."~".$htmlSubj;
		
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
	 
}else{
	echo "oppss";
}




?>
