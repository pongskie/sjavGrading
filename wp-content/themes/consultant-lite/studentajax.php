<?php
require_once("../../../wp-load.php");
global $wpdb;
date_default_timezone_set('Asia/Manila');


if($_POST['action'] == 'add'){
	
     $name = $_POST['sname'];
     $gender = $_POST['sgender'];
	 $birthdate = $_POST['sbdate'];
	 $sgradelvl = $_POST['sgrdlvl'];
	 $ssection = $_POST['ssection'];
	 $date_entered = date("Y-m-d H:i:s");
     $user_logged_in = $_POST['userID'];	 

	 if($wpdb->insert(
		  'student_tbl',
		  array (
			  'name' => $name,
			  'gender' => $gender,
			  'birthdate' => $birthdate,
			  'gender' => $gender,
			  'birthdate' => $birthdate,
              'grade_level' => $sgradelvl,
              'sec_code' => $ssection,
              'date_entered' => $date_entered,
              'user_logged_in' => $user_logged_in,			  
		  )
		) == false) echo 'error';		
	 else echo 'Added successfully';
	 
}else if($_POST['action'] == 'edit'){
	
	$stud_id = $_POST['stud_id'];
	
	//echo $stud_id;
	
	$result = $wpdb->get_row($wpdb->prepare("SELECT stud.name,
	                                                stud.gender,
													stud.birthdate,
													stud.grade_level,
													sect.section,
													sect.sec_code 
													FROM student_tbl AS stud 
													LEFT JOIN gradelevel_section_tbl AS sect 
													ON sect.sec_code = stud.sec_code 
													WHERE stud.id = $stud_id 
													AND stud.deleted=0 
													AND sect.deleted=0"));
	echo $result->name."|".$result->gender."|".$result->birthdate."|".$result->grade_level."|"."<option value=$result->sec_code>$result->section</option>";	
	
}else if($_POST['action'] == 'editSave'){
	
     $studId = $_POST['studID'];
     $name = $_POST['sname'];
     $gender = $_POST['sgender'];
	 $birthdate = $_POST['sbdate'];
	 $sgradelvl = $_POST['sgrdlvl'];
	 $ssection = $_POST['ssection'];
     $date_modified = date("Y-m-d H:i:s");
	 $user_logged_in = $_POST['userID'];

	 if($wpdb->update(
		  'student_tbl',
		  array (
			  'name' => $name,
			  'gender' => $gender,
			  'birthdate' => $birthdate,
			  'gender' => $gender,
			  'birthdate' => $birthdate,
              'grade_level' => $sgradelvl,
              'sec_code' => $ssection,
			  'date_modified' => $date_modified,
			  'user_logged_in' => $user_logged_in,
		  ),
		  array('id' => $studId)
		) == false) echo 'error';		
	 else echo 'Updated successfully';
	
}else if($_POST['action'] == 'delSave'){
	
     $studId = $_POST['studID'];
	 $date_modified = date("Y-m-d H:i:s");
     $user_logged_in = $_POST['userID'];
	 
	 if($wpdb->update(
		  'student_tbl',
		  array (
			  'deleted' => 1,
			  'date_modified' => $date_modified,
			  'user_logged_in' => $user_logged_in,
		  ),
		  array('id' => $studId)
		) == false) echo 'error';		
	 else echo 'Deleted successfully';
	
}else if($_POST['action'] == 'gradelevel'){
	
     $grade_level = $_POST['grade_level'];
     $html = "";
	 
	 $result = $wpdb->get_results( $wpdb->prepare( "SELECT sec_code,section FROM gradelevel_section_tbl WHERE grade_level = $grade_level AND deleted=0" ));
	 foreach($result as $row) {
	 
     $html .= "<option value=$row->sec_code>$row->section</option>";	 
		 
	 }
	 
	 echo $html;
		
}else{
	echo "oppss";
}




?>
