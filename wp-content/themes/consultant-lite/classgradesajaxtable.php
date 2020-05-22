<?php
require_once("../../../wp-load.php");
global $wpdb;
date_default_timezone_set('Asia/Manila');

// get teacher logged in ID
//$user = wp_get_current_user();
//$user_logged_in = $_GET['id'];

## Read value
$user_logged_in = $_POST['hiduser'];

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

if($columnName == "id"){
 $columnSortOrder = 'desc';
}

## Custom Field value

$searchByGradelvl = $_POST['searchByGradelvl'];
$searchBySection = $_POST['searchBySection'];
$searchBySubject = $_POST['searchBySubject'];
$searchByQtr = $_POST['searchByQtr'];
$searchBystudent = $_POST['txtstudent'];

## Search 
$searchQueryJoin = "";

if($searchByGradelvl != ''){
	$searchQueryJoin .= " and (cgrade.grade_level='".$searchByGradelvl."') ";
}
if($searchBySection != ''){
	$searchQueryJoin .= " and (cgrade.sec_code='".$searchBySection."') ";
}	
	
if($searchBySubject != ''){
	$searchQueryJoin .= " and (cgrade.sub_code='".$searchBySubject."') ";
}

if($searchByQtr != ''){
	$searchQueryJoin .= " and (cgrade.quarter='".$searchByQtr."') ";
}

if($searchBystudent != ''){
	$searchQueryJoin .= " and (stud.name LIKE '%".$searchBystudent."%') ";
}
	

## Total number of records without filtering
$result1 = $wpdb->get_row( $wpdb->prepare("SELECT 
										   count(*)	as allcount											   
										   FROM classgrades_tbl AS cgrade 
										   LEFT JOIN student_tbl AS stud ON cgrade.student_id = stud.id 
										   WHERE cgrade.deleted=0 AND cgrade.user_logged_in = $user_logged_in"));
$totalRecords = $result1->allcount;


## Total number of records with filtering
$result2 = $wpdb->get_row( $wpdb->prepare( "SELECT 
										   count(*)	as allcount											   
										   FROM classgrades_tbl AS cgrade 
										   LEFT JOIN student_tbl AS stud ON cgrade.student_id = stud.id 
										   WHERE cgrade.deleted=0 AND cgrade.user_logged_in = $user_logged_in ".$searchQueryJoin ));
$totalRecordwithFilter = $result2->allcount;

## Fetch records
$resultTable = $wpdb->get_results($wpdb->prepare("SELECT 
                                                   cgrade.id,
												   stud.name,
												   cgrade.score1,
												   cgrade.score2,
												   cgrade.score3,
												   cgrade.grade,
                                                   cgrade.date_entered,
                                                   cgrade.grade_level												   
												   FROM classgrades_tbl AS cgrade 
                                                   LEFT JOIN student_tbl AS stud ON cgrade.student_id = stud.id 
												   WHERE cgrade.deleted=0 AND cgrade.user_logged_in = $user_logged_in ".$searchQueryJoin." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage));
$columnName = "";

$data = array();

foreach($resultTable as $row) {

    $data[] = array(
	        "id"=>$row->id,
    		"name"=>$row->name,
    		"score1"=>$row->score1,
			"score2"=>$row->score2,
			"score3"=>$row->score3,
    		"grade"=>$row->grade,
			"grade_level"=>$row->grade_level,
			"action"=>"<input type='button' value='Edit' id='btnEdit' class='editbtn' onclick='editRecord($row->id)'/> | <input type='button' value='Delete' id='btnDelete' class='deletebtn' onclick='delRecord($row->id)'/>",
	      );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);



?>
