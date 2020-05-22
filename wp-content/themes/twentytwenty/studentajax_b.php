<?php

require_once("../../../wp-load.php");

global $wpdb;
$stud_id = $_POST['stud_id'];
$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM student_tbl WHERE id = $stud_id" ) );

echo $result->name."|".$result->gender; 

?>
