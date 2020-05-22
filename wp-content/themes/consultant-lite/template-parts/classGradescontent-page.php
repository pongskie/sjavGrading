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
// get latest row inserted
$result = $wpdb->get_row($wpdb->prepare("SELECT cgrade.id,
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
												WHERE cgrade.user_logged_in = $user_logged_in 
												AND cgrade.deleted = 0 AND sect.deleted = 0 AND subj.deleted = 0
												ORDER BY cgrade.id DESC"));

// get student based on latest grade and section
$resultstud = $wpdb->get_results($wpdb->prepare("SELECT name FROM student_tbl WHERE grade_level = $result->grade_level AND sec_code = $result->sec_code AND deleted = 0"));

?>	
	<div class="entry-content">
		
	  	<table border="0" style="font-size: 1rem; text-align: left;">	
		 <tr>
		   <td style="height:20px">Name:</td>
		   <td> <select id="student">
				  <option value=<?php echo $result->StudentID ?>><?php echo $result->name ?></option>
               <?php
					 // get student based on latest grade level and section
					 $resultstud = $wpdb->get_results($wpdb->prepare("SELECT 
					                                                    id,
																		name 
																		FROM student_tbl 
																		WHERE grade_level = '".$result->grade_level."' 
																		AND sec_code = '".$result->sec_code."' AND deleted = 0"));

					 foreach($resultstud as $row) {
					?>
                        <option value=<?php echo $row->id ?>><?php echo $row->name ?></option>
					<?php	
					}
                   ?>		   
				</select>		   		   
		   </td>
		   <td width="100px">Grade Level:</td>
		   <td> <select id="grdlvl">
				  <option value=<?php echo $result->grade_level ?>><?php echo $result->grade_level ?></option>
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				  <option value="5">5</option>
				  <option value="6">6</option>
				  <option value="7">7</option>
				  <option value="8">8</option>
				  <option value="9">9</option>
				  <option value="10">10</option>				  
				</select>		   		   
		   </td>		   
		 </tr>	 
		 <tr>
		   <td style="height:20px" width="80px">Score:</td>
		   <td><input type="text" id="txtscore1" name="txtscore1" style="width:55px; font-size: 1rem;" />
		       <input type="text" id="txtscore2" name="txtscore2" style="width:55px; font-size: 1rem;" />
			   <input type="text" id="txtscore3" name="txtscore3" style="width:55px; font-size: 1rem;" />
		   </td>
		   <td>Section:</td>
		   <td>	<select id="section">
                    <option value=<?php echo $result->sec_code ?>><?php echo $result->section ?></option>
               <?php
					 // get section based on latest grade level
					 $resultsect = $wpdb->get_results($wpdb->prepare("SELECT 
					                                                    sec_code,
																		section 
																		FROM gradelevel_section_tbl 
																		WHERE grade_level = '".$result->grade_level."' AND deleted = 0"));

					 foreach($resultsect as $row) {
					?>
                        <option value=<?php echo $row->sec_code ?>><?php echo $row->section ?></option>
					<?php	
					}
                   ?>
					
				</select>		   		   
		   </td>		   
		 </tr>		 
		 <tr>
		   <td style="height:20px">Grade:</td>
		   <td><input type="text" id="txtgrade" name="txtgrade" style="width:85px; font-size: 1rem;" /></td>
		   <td>Subject:</td>
		   <td> <select id="subject">
                    <option value=<?php echo $result->sub_code ?>><?php echo $result->subject ?></option>
               <?php
					 // get section based on latest grade level
					 $resultsubj = $wpdb->get_results($wpdb->prepare("SELECT 
					                                                    sub_code,
																		subject 
																		FROM gradelevel_subject_tbl 
																		WHERE grade_level = '".$result->grade_level."' AND deleted = 0"));

					 foreach($resultsubj as $row) {
					?>
                        <option value=<?php echo $row->sub_code ?>><?php echo $row->subject ?></option>
					<?php	
					}
                   ?>					
				</select>		   
		   </td>					   
		 </tr>
		 <tr>
		   <td style="height:20px"><input type="button" id="btnCompute" class="computebtn" name="btnCompute" value="Compute" /></td>
		   <td style="padding-left: 30px;"> <input type="button" id="btnSave" class="savebtn" name="btnSave" value="Save" /></td>
		   <td>Quarter:</td>
		   <td> <select id="quarter">
                    <option value=<?php echo $result->Quarter ?>><?php echo $result->Quarter ?></option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                    <option value="3rd">3rd</option>
					<option value="4th">4th</option>
				</select>		   
		   </td>					   
		 </tr>				 
		</table> 					
      <hr style="margin-bottom: 10px;">
	  
    <!-- Searching dropdown on datatables --> 
	
	<?php
	// get all grade levels inserted based on logged in user
	$resultgrdlvl = $wpdb->get_results($wpdb->prepare("SELECT 
													grade_level																					  
													FROM classgrades_tbl                                             												
													WHERE user_logged_in = $user_logged_in 
													AND deleted = 0 
													GROUP BY grade_level"));

	// get all sections inserted based on logged in user
	$resultSection = $wpdb->get_results($wpdb->prepare("SELECT 
													cgrade.sec_code,
													sect.section																							  
													FROM classgrades_tbl AS cgrade 
													LEFT JOIN gradelevel_section_tbl AS sect 
													ON cgrade.sec_code = sect.sec_code                                              												
													WHERE cgrade.user_logged_in = $user_logged_in 
													AND cgrade.deleted = 0 
													GROUP BY cgrade.sec_code"));
	// get all subject inserted based on logged in user
	$resultSubject = $wpdb->get_results($wpdb->prepare("SELECT 
													cgrade.sub_code,
													subj.subject
                                                    FROM classgrades_tbl AS cgrade													
													LEFT JOIN gradelevel_subject_tbl AS subj 
													ON cgrade.sub_code = subj.sub_code                                               												
													WHERE cgrade.user_logged_in = $user_logged_in 
													AND cgrade.deleted = 0 
													GROUP BY cgrade.sub_code"));													
	  ?>
													 
	   <table border="0">
		 <tr>
		   <td width="230px">
			 <select id='searchByGradelvl'>
			   <option value=''>-- Select Grade Level--</option>
			    <?php
					 foreach($resultgrdlvl as $row) {
					?>
                        <option value=<?php echo $row->grade_level ?>><?php echo $row->grade_level ?></option>
					<?php	
					}
                   ?>				   
			 </select>
		   </td>
		   <td width="200px">
			 <select id='searchBySection'>
			   <option value=''>-- Select Section--</option>
			    <?php
					 foreach($resultSection as $row) {
					?>
                        <option value=<?php echo $row->sec_code ?>><?php echo $row->section ?></option>
					<?php	
					}
                   ?>			   
			 </select>
		   </td>
		   <td width="200px">
			 <select id='searchBySubject'>
			   <option value=''>-- Select Subject--</option>
			    <?php
					 foreach($resultSubject as $row) {
					?>
                        <option value=<?php echo $row->sub_code ?>><?php echo $row->subject ?></option>
					<?php	
					}
                   ?>				   
			 </select>
		   </td>
		   <td width="200px">
			 <select id='searchByQtr'>
			   <option value=''>-- Select Quarter--</option>
			   <option value='1st'>1st</option>
			   <option value='2nd'>2nd</option>
			   <option value='3rd'>3rd</option>
			   <option value='4th'>4th</option>				   
			 </select>
		   </td>
		   <td></td>
           <td width="200px">
		     <input type="text" id="txtstudent" name="txtstudent" placeholder="Enter student name" />
           </td>		   
		 </tr>
	   </table>	
  
      <!-- END Searching dropdown on datatables -->   
 
		<!------------ DATATABLES --------------->
			   <table id='myTable' class='display' border="0" style="font-size: 15px;">
				  <thead>
					  <tr>	
                          <th>id</th>					  
						  <th>Student</th>
						  <th>score1</th>
						  <th>score2</th>
						  <th>score3</th>
						  <th>grade</th>
                          <th>action</th>
                          <th>grade_level</th>						  
					  </tr>
				 </thead>
			</table>			
		<!------------ END DATATABLES --------------->
			
		<!-------- HIDDEN ELEMENTS -------->
		<input type="hidden" id="hidrefresh" name="hidrefresh" value="f">
		<input type="hidden" id="hidrecordID" name="hidrecordID" value="">
		<input type="hidden" id="hidaction" name="hidaction" value="add" />
		<input type="hidden" id="hiduser" name="hiduser" value=<?php echo $user_logged_in; ?> />
        <!-------- END HIDDEN ELEMENTS -------->	
		

		<!-------- POPUP MODAL  ------->	
		<div id="divInfo" class="hover_bkgr_fricc">
			<span class="helper"></span>
			<div style="padding-top: 30px; padding-left: 35px; background-color: #E5E7E9 ;">
				<p id="record_del" style="font-size: 1.5rem; display:none; "></p>
				<table id="tblbtn" style='padding-top: 30px; padding-bottom: 10px;'> 
				 <tr>
				   <td><input type="button" id="btnDelSave" id="btnDelSave" class='saveCancelbtn' value="Ok"> &nbsp; &nbsp; &nbsp; <input type="button" id="btncancel" class='saveCancelbtn' value="Cancel" onclick="cancelButtton()"></td>
				 </tr>		 
				</table>
			</div>
		</div>
		<!-------- END POPUP MODAL  ------->
	</div><!-- .entry-content -->
	
<script>
$(document).ready(function(){	
	/*$('#myTable').DataTable( {
	   "order": [[ 0, "desc" ]],
	}); */

  //var user_id = $('#hiduser').val();

  var dataTable = $('#myTable').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'searching': false, // Remove default Search Control
    'ajax': {
       'url':'http://localhost/SJA-grading/wp-content/themes/consultant-lite/classgradesajaxtable.php',
       'data': function(data){
          // Read values
          var gradelevel = $('#searchByGradelvl').val();
		  var section = $('#searchBySection').val();
		  var subject = $('#searchBySubject').val();
		  var quarter = $('#searchByQtr').val();
		  var student_name = $('#txtstudent').val();
		  
		  var user_logged_in = $('#hiduser').val();  
		  
		  //alert(section);

          // Append to data
          data.searchByGradelvl = gradelevel;
		  data.searchBySection = section;
		  data.searchBySubject = subject;
		  data.searchByQtr = quarter;
		  data.txtstudent = student_name;
		  data.hiduser = user_logged_in;
       } 
	    
    },
    'columns': [
       { data: 'id' },
       { data: 'name' },
       { data: 'score1' },
	   { data: 'score2' },
	   { data: 'score3' },
       { data: 'grade' },
	   { data: 'action' },
	   { data: 'grade_level' },
    ],
    'columnDefs': [
       {
         "targets": [ 0 ],
         "visible": false
       },
       {
         "targets": [ 7 ],
         "visible": false
       },	   
    ],	
  });

  $('#searchByGradelvl').change(function(){
    dataTable.draw();
  });

  $('#searchBySection').change(function(){
    dataTable.draw();
  });
  
  $('#searchBySubject').change(function(){
    dataTable.draw();
  });  
  
  $('#searchByQtr').change(function(){
    dataTable.draw();
  });
  
   $('#txtstudent').keyup(function(){
    dataTable.draw();
  }); 
  

    //print button
	$('#btnPrint').click(function(){
	   window.location.href = "http://localhost/SJA-grading/hello?id=kkk";
	});


    //delete save button
	$('#btnDelSave').click(function(){
	  var action = $('#hidaction').val();
	  var recordID = $('#hidrecordID').val();
	  var userID = $('#hiduser').val();

       $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/classgradesajax.php",
		{
		  action: action,
		  recordID: recordID,
		  userID: userID,
		},   
		function(data, status){		   		   
		    if(data == 'updated')
			{
			   $('#record_del').attr("style","display: block; font-size: 1.5rem;");			  
			   $('#record_del').html('Record successfully updated');		  
			   $('.hover_bkgr_fricc').show();				            				
		       $('#tblbtn').html('<tr><td><input type="button" id="btnOk" class="saveCancelbtn" value="Ok" onclick="refreshPage()"></td></tr>');
			  }else{
				   $('#record_del').attr("style","display: block; font-size: 1.5rem;");			  
				   $('#record_del').html(data);		  
				   $('.hover_bkgr_fricc').show();				            				
				   $('#tblbtn').html('<tr><td><input type="button" id="btnOk" class="saveCancelbtn" value="Ok" onclick="cancelButtton()"></td></tr>');				  
			  }	
	    });
	  
	  
	  
	});


    //save function
	$('#btnSave').click(function(){
	   var action = $('#hidaction').val();
       if(action == 'edit')
	   {
		  action = 'editSave';  
	   }
       var recordID = $('#hidrecordID').val();	   
	   var grdlvl = $('#grdlvl').val();
	   var section = $('#section').val();
	   var subject = $('#subject').val();
	   var studID = $('#student').val();  
	   var quarter = $('#quarter').val();
	   
	   var score1 = $('#txtscore1').val();
	   var score2 = $('#txtscore2').val();
	   var score3 = $('#txtscore3').val();
	   var grade = $('#txtgrade').val();

	   var userID = $('#hiduser').val();
	     
       $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/classgradesajax.php",
		{
		  action: action,
		  recordID: recordID,
		  grdlvl: grdlvl,
		  section: section,
		  subject: subject,
		  studID : studID,
		  quarter: quarter,
		  score1: score1,
		  score2: score2,
		  score3: score3,
		  grade: grade,
		  userID: userID,
		},   
		function(data, status){			   		   
		    if(data == 'updated')
			{
			   $('#record_del').attr("style","display: block; font-size: 1.5rem;");			  
			   $('#record_del').html('Record successfully updated');		  
			   $('.hover_bkgr_fricc').show();				            				
		       $('#tblbtn').html('<tr><td><input type="button" id="btnOk" class="saveCancelbtn" value="Ok" onclick="refreshPage()"></td></tr>');
			  }else{
				   $('#record_del').attr("style","display: block; font-size: 1.5rem;");			  
				   $('#record_del').html(data);		  
				   $('.hover_bkgr_fricc').show();				            				
				   $('#tblbtn').html('<tr><td><input type="button" id="btnOk" class="saveCancelbtn" value="Ok" onclick="cancelButtton()"></td></tr>');				  
			  }	
	    });	   
	});	



function gradelvl_action(){
  var grade_level = $('#grdlvl').val();
  var action = 'gradelevel';
  var section = "";
   $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/classgradesajax.php",
	{
	  action: action,
	  grade_level: grade_level,
	  section: section,		  
	},
	function(data, status){	
	   //alert(data);
	   var studsectsubj = data.split("~");
	   $('#student').html(studsectsubj[0]);
	   $('#section').html(studsectsubj[1]);
	   section_action();
	   $('#subject').html(studsectsubj[2]);		   
	});	 	
}

   //grade select change call function gradelvl_action()
   $('#grdlvl').change(function(){
	 gradelvl_action();
   });
   
 
 function section_action(){
  var grade_level = $('#grdlvl').val(); 
  var section = $('#section').val();
  var action = 'section';
   $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/classgradesajax.php",
	{
	  action: action,
	  grade_level : grade_level,
	  section : section,	  
	},
	function(data, status){
	   //alert(data);			
	   $('#student').html(data);
	   
	});	 			 
 }
 
   //section select change call function section_action()
   $('#section').change(function(){
      section_action();
   }); 
   
   
   //compute button
   $('#btnCompute').click(function(){
	 var grade = parseInt($('#txtscore1').val()) + parseInt($('#txtscore2').val()) + parseInt($('#txtscore3').val());
     $('#txtgrade').val(grade);	 
   });
   
  	
 });
 
  //edit button
  function editRecord(recordId){
	  
	 $('#tblinfo').attr("style", "display: block; font-size: 1.5rem; text-align: left");
     $('#record_del').attr("style","display: none");	  
	  
	 $('#hidrecordID').val(recordId);
	 $('#hidaction').val('edit');
     var action = 'edit';
     var userID = $('#hiduser').val();	 
     $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/classgradesajax.php",
		{
		  action: action,
		  recordId: recordId,
		  userID: userID,
		},   
		function(data, status){		
		  var record = data.split("|");          
		  $("#student").html(record[0]);
          $("#grdlvl").html(record[1]);
		  $("#section").html(record[2]);
		  $("#subject").html(record[3]);	  
		  $("#quarter").html(record[4]);
		  
		  $("#txtscore1").val(record[5]);
		  $("#txtscore2").val(record[6]);	  
		  $("#txtscore3").val(record[7]);
          $("#txtgrade").val(record[8]);

          jQuery("html, body").animate({ scrollTop: 150 }, 500);		  
	});	    	  
  }
  //delete button
  function delRecord(recordId){
	 //alert(recordID);
	 $('#hidrecordID').val(recordId);
     var action = 'edit'; 
	 var userID = $('#hiduser').val();
     $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/classgradesajax.php",
		{
		  action: action,
		  recordId: recordId,
		  userID: userID,
		},   
		function(data, status){		
		  var record = data.split("|"); 
		  //$('#tblinfo').css("display", "none");
          $('#record_del').attr("style","display: block; font-size: 1.5rem;");			  
          $('#record_del').html('Are you sure you want to delete record for '+record[9]+'?');		  
          $('.hover_bkgr_fricc').show();
          $('#hidaction').val('delSave');		  
	});	    	  
  }
  //reload page
  function refreshPage()
  {
	 $('#tblbtn').html('<img src="http://localhost/SJA-grading/wp-content/themes/consultant-lite/assets/images/loading1.gif" height="50" width="50" />');		  
     location.reload(true); 	   
  }
  
  //cancel button
  function cancelButtton()
  {
	$('.hover_bkgr_fricc').hide();  
  }

  //div popup show/hide
  $(".trigger_popup_fricc").click(function()
  {
     $('.hover_bkgr_fricc').show();
  });

// set allowance space between 'show entries' and datatable
setTimeout("$('#myTable_length').attr('style', 'height: 70px !important')" , 1000);

  
</script>

</article><!-- #post-<?php the_ID(); ?> -->
