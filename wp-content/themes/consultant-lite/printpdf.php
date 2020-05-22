<?php
require_once("../../../wp-load.php");
global $wpdb;



$student = trim($_GET['id']);
//$student = 1;

$htmlStud ='<!doctype html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';

$htmlStud.='</head><body>';
$htmlStud.="<style> 
@font-face { font-family: 'Roboto Regular'; font-weight: normal; src: url(\'fonts/Roboto-Regular.ttf\') format(\'truetype\'); } 
@font-face { font-family: 'Roboto Bold'; font-weight: bold; src: url(\'fonts/Roboto-Bold.ttf\') format(\'truetype\'); } 
body{ font-family: 'Roboto Regular', sans-serif; font-weight: normal; line-height:1.6em; font-size:17pt; }
h1,h2{ font-family: 'Roboto Bold', sans-serif; font-weight: bold; line-height:1.2em; }
</style>";

$htmlStud .= "<table border=\"0\" style=\"font-size: 1rem; margin-bottom: 18px; \">
			 <tr>
				<td rowspan='4'><img src='sjavlogo.png' height='70' width='70' /></td>
				<td style=\"font-size: 1.1rem; padding-bottom: -7px; \" align='right'><strong>ST. JOSEPH ACADEMY OF VALENZUELA</strong></td>
			 </tr>
			 <tr style='line-height: 10px;'>
				<td style='font-size: 0.8rem;' align='right'>#1 San Felipe St., Karuhatan, Valenzuela City </td>
			 </tr>		 
			 <tr style='line-height: 20px;'>
				<td style='font-size: 0.8rem;' align='right'>Contact#. 292-0438 | 277-2063 | 962-4634</td>
			 </tr>
			 <tr style='line-height: 17px;'>
				<td style='font-size: 0.8rem;' align='right'><strong>Certificate of Quarterly Grades</strong></td>
			 </tr>
          </table>";
 

     //load student
	 $resultStud = $wpdb->get_row( $wpdb->prepare("SELECT 
	                                            stud.name,
												stud.grade_level,
												sect.section
												FROM student_tbl AS stud 
												LEFT JOIN gradelevel_section_tbl AS sect 
												ON stud.sec_code = sect.sec_code
												WHERE stud.id = '".$student."'
												AND stud.deleted=0 AND sect.deleted=0")); 
												
												
												
	 
	 $htmlStud .= "<table border=\"0\" style=\"font-size: 1rem; margin-bottom: 18px; \">
					 <tr style='line-height: 17px;'>
						<td width='420px'><strong>Name:</strong> $resultStud->name</td>
					 </tr>
					 <tr style='line-height: 17px;'>
						<td><strong>Grade/Section:</strong> $resultStud->grade_level - $resultStud->section</td>
					 </tr>
		          </table>";
	 
	 //load grades
	 $resultStudGrd = $wpdb->get_results( $wpdb->prepare("SELECT 
	                                            stud.name,
												cgrade.grade_level,
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



	 	 $htmlStud .= "<table border=\"1\" style=\"border: 1px solid #ddd; border-collapse:collapse; font-size: 1rem;\">
		 <tr style='line-height: 20px;'>
		    <td width=\"220px\" style=\"font-size: 0.8rem;\" align='center'><strong>Subjects</strong></td>
			<td style=\"font-size: 0.8rem;\" align='center'><strong>1st</strong></td>
			<td style=\"font-size: 0.8rem;\" align='center'><strong>2nd</strong></td>
			<td style=\"font-size: 0.8rem;\" align='center'><strong>3rd</strong></td>
			<td style=\"font-size: 0.8rem;\" align='center'><strong>4th</strong></td>		 
         </tr>";
	 
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
	                   <td>".$rowStud->subject."</td>
					   <td width='50px' align='center'>".$rowStud->first."</td>
					   <td width='50px' align='center'>".$rowStud->second."</td>
					   <td width='50px' align='center'>".$rowStud->third."</td>
					   <td width='50px' align='center'>".$rowStud->fourth."</td>
					</tr>";									
	 }
	 
       $htmlStud .= "<tr>
	                   <td>Average</td>
					   <td width='50px' align='center'><strong>".$firstGenAve."</strong></td>
					   <td width='50px' align='center'><strong>".$secondGenAve."</strong></td>
					   <td width='50px' align='center'><strong>".$thirdGenAve."</strong></td>
					   <td width='50px' align='center'><strong>".$fourthGenAve."</strong></td>
					</tr>";	  
      	 
	 $htmlStud .= "</body></table></html>";


// Include autoloader 
require_once("dompdf/autoload.inc.php"); 
 
// Reference the Dompdf namespace 
use Dompdf\Dompdf; 
 
// Instantiate and use the dompdf class 
$dompdf = new Dompdf();

// Load HTML content 
$dompdf->loadHtml($htmlStud); 
 
// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'landscape'); 
 
// Render the HTML as PDF 
$dompdf->render(); 
 
// Output the generated PDF to Browser 
$dompdf->stream();




