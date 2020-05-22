<?php
require_once("../../../wp-load.php");
global $wpdb;
date_default_timezone_set('Asia/Manila');


if($_POST['action'] == 'add'){
	
	 $gradelvl = $_POST['grdlvl'];
	 $gsubject = $_POST['gsubject'];
     $sec_code = $gradelvl.substr($gsubject, 0, 3);	 
	 $date_entered = date("Y-m-d H:i:s");
     $user_logged_in = $_POST['userID'];	

     //echo "grde-".$gradelvl."~subject-".$gsubject."~seccode-".$sec_code."~dateenter-".$date_entered."~user-".$user_logged_in;	 

	 if($wpdb->insert(
		  'gradelevel_subject_tbl',
		  array (
              'grade_level' => $gradelvl,
			  'sub_code' => $sec_code,
			  'subject' => $gsubject,
              'date_entered' => $date_entered,
              'user_logged_in' => $user_logged_in,			  
		  )
		) == false) echo 'error';		
	 else echo 'Added successfully';
	 
}else if($_POST['action'] == 'edit'){
	
	$grsec_id = $_POST['gsid'];
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM gradelevel_subject_tbl WHERE id = $grsec_id" ) );
	echo $result->grade_level."|".$result->subject;	
	
}else if($_POST['action'] == 'editSave'){
	
     $grsec_id = $_POST['gsID'];
	 $gradelvl = $_POST['grdlvl'];
	 $gsubject = $_POST['gsubject'];
	 $sec_code = $gradelvl.substr($gsubject, 0, 3);
     $date_modified = date("Y-m-d H:i:s");
	 $user_logged_in = $_POST['userID'];

	 if($wpdb->update(
		  'gradelevel_subject_tbl',
		  array (
              'grade_level' => $gradelvl,
			  'subject' => $gsubject,
              'sub_code' => $sec_code,
			  'date_modified' => $date_modified,
			  'user_logged_in' => $user_logged_in,
		  ),
		  array('id' => $grsec_id)
		) == false) echo 'error';		
	 else echo 'Updated successfully';
	
}else if($_POST['action'] == 'delSave'){
	
     $grsec_id = $_POST['gsID'];
	 $date_modified = date("Y-m-d H:i:s");
     $user_logged_in = $_POST['userID'];
	 
	 if($wpdb->update(
		  'gradelevel_subject_tbl',
		  array (
			  'deleted' => 1,
			  'date_modified' => $date_modified,
			  'user_logged_in' => $user_logged_in,
		  ),
		  array('id' => $grsec_id)
		) == false) echo 'error';		
	 else echo 'Deleted successfully';
	
}else{
	echo "oppss";
}




?>
