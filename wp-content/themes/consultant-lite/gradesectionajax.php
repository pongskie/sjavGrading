<?php
require_once("../../../wp-load.php");
global $wpdb;
date_default_timezone_set('Asia/Manila');


if($_POST['action'] == 'add'){
	
	 $gradelvl = $_POST['grdlvl'];
	 $gsection = $_POST['gsection'];
	 $adviser = $_POST['adviser'];
     $sec_code = $gradelvl.substr($gsection, 0, 3).substr($gsection, -2);	 
	 $date_entered = date("Y-m-d H:i:s");
     $user_logged_in = $_POST['userID'];	

     //echo "grde-".$gradelvl."~section-".$gsection."~seccode-".$sec_code."~dateenter-".$date_entered."~user-".$user_logged_in;	 

	 if($wpdb->insert(
		  'gradelevel_section_tbl',
		  array (
              'grade_level' => $gradelvl,
			  'sec_code' => $sec_code,
			  'section' => $gsection,
			  'adviser' => $adviser,
              'date_entered' => $date_entered,
              'user_logged_in' => $user_logged_in,			  
		  )
		) == false) echo 'error';		
	 else echo 'Added successfully';
	 
}else if($_POST['action'] == 'edit'){
	
	$grsec_id = $_POST['gsid'];
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT teacher.id,sect.grade_level,sect.section,teacher.display_name 
						                              FROM gradelevel_section_tbl AS sect 
													  LEFT JOIN wp_users AS teacher
													  ON sect.adviser  = teacher.id
													  WHERE sect.deleted=0 
													  AND sect.id = '".$grsec_id."'" ));
													  
	echo $result->grade_level."|".$result->section."|"."<option value=$result->id>$result->display_name</option>";	
	
}else if($_POST['action'] == 'editSave'){
	
     $grsec_id = $_POST['gsID'];
	 $gradelvl = $_POST['grdlvl'];
	 $gsection = $_POST['gsection'];
	 $adviser = $_POST['adviser'];
	 $sec_code = $gradelvl.substr($gsection, 0, 3).substr($gsection, -2);
     $date_modified = date("Y-m-d H:i:s");
	 $user_logged_in = $_POST['userID'];

	 if($wpdb->update(
		  'gradelevel_section_tbl',
		  array (
              'grade_level' => $gradelvl,
			  'section' => $gsection,
			  'adviser' => $adviser,
              'sec_code' => $sec_code,
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
		  'gradelevel_section_tbl',
		  array (
			  'deleted' => 1,
			  'date_modified' => $date_modified,
			  'user_logged_in' => $user_logged_in,
		  ),
		  array('id' => $grsec_id)
		) == false) echo 'error';		
	 else echo 'Deleted successfully';
	
}else if($_POST['action'] == 'teacher'){
	
     $html = "";
	 
	 $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_users" ));
	 foreach($result as $row) {
	 
     $html .= "<option value=$row->ID>$row->display_name</option>";	 
		 
	 }	 
	 echo $html;
		
}else{
	echo "oppss";
}




?>
