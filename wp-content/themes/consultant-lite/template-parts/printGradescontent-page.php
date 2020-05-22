<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultant_Lite
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class("tm-article-post"); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php 
	$post_options = get_post_meta( $post->ID, 'consultant-lite-meta-checkbox', true );
	if (!empty( $post_options ) ) { ?>
		<?php if (has_post_thumbnail()) { ?>
			<div class="tm-post-thumbnail">
				<?php consultant_lite_post_thumbnail(); ?>
			</div>
		<?php } ?>
	<?php } ?>	
<?php 
// get teacher logged in ID
$user = wp_get_current_user();
$user_logged_in = $user->ID;

?>	
	<div class="entry-content">

	  	<table border="0" style="font-size: 1rem; text-align: left;">	
		 <tr>
		   <td width="100px">Grade Level:</td>
		   <td> <select id="grdlvl">
               <?php
					 // get section based on logged in user
					 $resultgradelvl = $wpdb->get_results($wpdb->prepare("SELECT grade_level, grade_level 
																			FROM gradelevel_section_tbl 
																			WHERE adviser = $user_logged_in
																			AND deleted=0"));

					 foreach($resultgradelvl as $row) {
					?>
                        <option value=<?php echo $row->grade_level ?>><?php echo $row->grade_level ?></option>
					<?php	
					}
                   ?>
				</select>	   		   
		   </td>			 

		   <td>Section:</td>
		   <td>	<select id="section">					
				</select>		   		   
		   </td>
		   <td style="height:20px">Name:</td>
		   <td colspan="5"> <select id="student">	   
				</select>		   		   
		   </td>	
		   </tr> 			 
		</table> 					
      <hr style="margin-bottom: 10px;">
	  
	  <table border="1" style="border: 1px solid #ddd; border-collapse:collapse; font-size: 1.2rem;">
	     <tr>
		    <td width="180px" style="font-weight: bold;">Name:</td>
			<td colspan="4" style="padding-left: 10px;"><span id="Spstudent"></span></td>
		 </tr>
	     <tr>
		    <td style="font-weight: bold;">Grade / Section:</td>
			<td colspan="4" style="padding-left: 10px;"><span id="Spgrsec"></span></td>
		 </tr>
      </table>
	  <table id="tblgrades" border="1" style="border: 1px solid #ddd; border-collapse:collapse; font-size: 1.2rem;">
	  </table>
	  
	  

		<!-------- HIDDEN ELEMENTS -------->
		<input type="hidden" id="hidrefresh" name="hidrefresh" value="f">
		<input type="hidden" id="hidrecordID" name="hidrecordID" value="">
		<input type="hidden" id="hidaction" name="hidaction" value="add" />
		<input type="hidden" id="hiduser" name="hiduser" value=<?php echo $user_logged_in; ?> />
        <!-------- END HIDDEN ELEMENTS -------->	
	<hr>
	  <div style="padding: 10px;">
        <input type="button" id="btnPrint" value="Print" class="addbtn" onclick="testprint()" />
	  </div>	
	</div><!-- .entry-content -->
	
<script>
$(document).ready(function(){	

    //print button
	$('#btnPrint').click(function(){
	   var studentID = $('#student').val();
	   window.location.href = "http://localhost/SJA-grading/wp-content/themes/consultant-lite/printpdf.php?id="+studentID;
	});


function grdlvl_action(){
  var userID = $('#hiduser').val();
  var grade_level = $('#grdlvl').val();
  var action = 'gradelevel';
   $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/printgradesajax.php",
	{
	  action: action,
	  grade_level: grade_level,
      userID: userID,	  
	},
	function(data, status){	
	   //alert(data);
	   var studsectsubj = data.split("~");
	   $('#section').html(studsectsubj[0]);
	   $('#student').html(studsectsubj[1]);
	   section_action();
			   
	});	 	
}

grdlvl_action();

   //grade select change
   $('#grdlvl').change(function(){
	  grdlvl_action();
   });
  
function section_action(){

  var grade_level = $('#grdlvl').val(); 
  var section = $('#section').val();
  var action = 'section';
   $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/printgradesajax.php",
	{
	  action: action,
	  grade_level : grade_level,
	  section : section,	  
	},
	function(data, status){	
	   //alert(data);
	   $('#student').html(data);
	   student_action();
	});	 		
	
}  
 
 section_action();
 
   //section select change
   $('#section').change(function(){
	  section_action();
   }); 
 
function student_action(){

  var quarter = $('#quarter').val();	  
  var studentID = $('#student').val();
  var action = 'student';
   $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/printgradesajax.php",
	{
	  action: action,
	  studentID: studentID,
	  quarter: quarter,		  
	},
	function(data, status){
       var record = data.split("~");		
	   $('#tblgrades').html(record[0]);
	   $('#Spstudent').html(record[1]);
	   $('#Spgrsec').html(record[2]);
	});	
	
} 

    //student dropdown
   $('#student').change(function(){
	  student_action();	
   });
  	
 });
 
  
</script>
</article><!-- #post-<?php the_ID(); ?> -->
