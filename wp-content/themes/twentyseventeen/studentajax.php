<?php
require_once("../../../wp-load.php");
global $wpdb;

if($_POST['action'] == 'add'){
	
     $name = $_POST['sname'];
     $gender = $_POST['sgender'];

     $gender1 = 'gender';	 

	 if($wpdb->insert(
		  'student_tbl',
		  array (
			  'name' => $name,
			  $gender1 => $gender
		  )
		) == false) echo 'error';		
	 else echo 'Added successfully';
	 
}else if($_POST['action'] == 'edit'){
	
	$stud_id = $_POST['stud_id'];
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM student_tbl WHERE id = $stud_id" ) );
	echo $result->name."|".$result->gender;	
	
}else if($_POST['action'] == 'editSave'){
	
     $studId = $_POST['studID'];
	 $name = $_POST['sname'];
     $gender = $_POST['sgender'];	

	 if($wpdb->update(
		  'student_tbl',
		  array (
			  'name' => $name,
			  'gender' => $gender
		  ),
		  array('id' => $studId)
		) == false) echo 'error';		
	 else echo 'Updated successfully';
	
}else if($_POST['action'] == 'delSave'){
	
     $studId = $_POST['studID'];

	 if($wpdb->update(
		  'student_tbl',
		  array (
			  'deleted' => 1
		  ),
		  array('id' => $studId)
		) == false) echo 'error';		
	 else echo 'Deleted successfully';
	
}else{
	echo "oppss";
}




?>
