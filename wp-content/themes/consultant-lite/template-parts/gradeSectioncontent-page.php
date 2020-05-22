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
$user = wp_get_current_user();
$user_logged_in = $user->ID;
?>	
	<div class="entry-content">
		<input type="button" id="btnAdd" value="Add New" class="addbtn" />
 
		<!------------ DATATABLES --------------->
			   <table id='myTable' class='display' border="0" style="font-size: 15px;">
				  <thead>
					  <tr>		  
						  <th style="display:none;">id</th>
						  <th>Grade Level</th>
						  <th>Section</th>
						  <th>Adviser</th>
						  <th width="200px">Action</th>				  
					  </tr>
				 </thead>
				 <tbody>
				   <?php
						$result = $wpdb->get_results("SELECT sect.id, sect.grade_level,sect.section,teacher.display_name 
						                              FROM gradelevel_section_tbl AS sect 
													  LEFT JOIN wp_users AS teacher
													  ON sect.adviser  = teacher.id
													  WHERE sect.deleted=0
													  ORDER BY sect.id DESC");
						   // output data of each row
						   foreach($result as $row) {
					?>
								<tr>
								<td style="display:none;"><?php echo $row->id ?></td>
								<td align="center" style="width: 17%"><?php echo $row->grade_level ?></td>
								<td align="center"><?php echo $row->section ?></td>
								<td align="center"><?php echo $row->display_name ?></td>
								<td align="center"><input type='button' value='edit' class='editbtn'  id='btnEdit' onclick="editgs(<?php echo $row->id ?>)" /> | <input type='button' value='delete' class='deletebtn'  id='btnDelete' onclick="delgs(<?php echo $row->id ?>)" /></td>
								</tr>
							 <?php	
							}
						?>
			   </tbody>
			</table>			
		<!------------ END DATATABLES --------------->
			
		<!-------- POPUP MODAL  ------->	
		<div id="divInfo" class="hover_bkgr_fricc">
			<span class="helper"></span>
			<div style="padding-top: 30px; padding-left: 35px; background-color: #E5E7E9 ;">
				<div class="popupCloseButton">&times;</div>
			    <p id="record_del" style="font-size: 1.5rem; display:none; "></p>
				<table id="tblinfo" border="0" style="font-size: 1.5rem; text-align: left;">
				 <tr>
				   <td colspan="4" style='margin-bottom:10px; background-color: #5DADE2;' align="center"><span id="spMsg"></span></td>	   
				 </tr>
                 <tr><td></td><tr><tr><td></td><tr><tr><td></td><tr><tr><td></td><tr><tr>				 
				 <tr>
				   <td>Grade Level:</td>
				   <td style="padding-bottom: 15px;"> <select id="grdlvl">
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
				   <td>Section:</td>
				   <td><input type="text" id="gsection" name="gsection" size="10" /></td>			   
				 </tr>	
                 <tr>
				 <td>Adviser</td>
				 <td colspan="3">
                   <select id="adviser">
				       <option value=""></option>
                      <?php
						 // get student based on latest grade level and section
						 $resultteacher = $wpdb->get_results($wpdb->prepare("SELECT 
																			id,
																			display_name 
																			FROM wp_users"));
						 foreach($resultteacher as $row) {
						?>
							<option value=<?php echo $row->id ?>><?php echo $row->display_name ?></option>
						<?php	
						}
					   ?>		   
				</select>					 
				 </td>
				 
                 </tr>				 
				</table> 
				
				<table id="tblbtn" style='padding-top: 30px; padding-bottom: 10px;'> 
				 <tr>
				   <td><input type="button" id="btnSave" class='saveCancelbtn' value="Save"> &nbsp; &nbsp; &nbsp; <input type="button" id="btncancel" class='saveCancelbtn' value="Cancel" onclick="cancelButtton()"></td>
				 </tr>		 
				</table>
			</div>
		</div>
		<!-------- END POPUP MODAL  ------->

		<!-------- HIDDEN ELEMENTS -------->
		<input type="hidden" id="hidrefresh" name="hidrefresh" value="f">
		<input type="hidden" id="hidgsID" name="hidgsID" value="">
		<input type="hidden" id="hidaction" name="hidaction" />
		<input type="hidden" id="hiduser" name="hiduser" value=<?php echo $user_logged_in; ?> />
        <!-------- END HIDDEN ELEMENTS -------->	
				
	</div><!-- .entry-content -->
	
<script>
$(document).ready(function(){	
	$('#myTable').DataTable( {
	   "order": [[ 0, "desc" ]],
	}); 
    //add button
	$('#btnAdd').click(function(){
	   $('#hidaction').val('add');
	   $('#tblinfo').attr("style", "visibility: show; font-size: 1.5rem; text-align: left");
       $('#record_del').attr("style","display: none");

	   $('#grdlvl').val('');
	   $( "#gsection" ).val('');
       $( "#adviser" ).val('');	   
	   $('.hover_bkgr_fricc').show();
	   
	});

    //save function
	$('#btnSave').click(function(){
	   var action = $('#hidaction').val();
       if(action == 'edit')
	   {
		  action = 'editSave';  
	   }
	   var gsID = $('#hidgsID').val();
	   var grdlvl = $('#grdlvl').val();
	   var gsection = $( "#gsection" ).val();
	   var adviser = $('#adviser').val();
	   var userID = $('#hiduser').val();
	   
       $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/gradeSectionajax.php",
		{
		  action: action,
		  gsID: gsID, 
		  grdlvl: grdlvl,
		  gsection: gsection,
		  adviser: adviser,
		  userID: userID,
		},   
		function(data, status){	
           //alert(data);		
		   if(action == 'delSave')
		   {
			 $('#record_del').html(data);
		   }
		   $('#spMsg').html(data);
		   $('#hidrefresh').val('t');
		    if(data != 'error')
			{		
		      $('#tblbtn').html('<tr><td><input type="button" id="btnOk" class="saveCancelbtn" value="Ok" onclick="refreshPage()"></td></tr>');
			}					  
	    });	   
	});

 });
 
  //edit button
  function editgs(gsId){

	 $('#tblinfo').attr("style", "visibility: show; font-size: 1.5rem; text-align: left");
     $('#record_del').attr("style","display: none");	  
	  
	 $('#hidgsID').val(gsId);
	 $('#hidaction').val('edit');
	 
     var action = 'edit';
     var userID = $('#hiduser').val();     	 
     $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/gradeSectionajax.php",
		{
		  action: action,
		  gsid: gsId,
		  userID: userID,
		},   
		function(data, status){
          //alert(data);			
		  var gs = data.split("|");          
		  $("#grdlvl").val(gs[0]);	 		  	  
		  $( "#gsection" ).val(gs[1]);
		  $( "#adviser" ).html(gs[2]);
          $('.hover_bkgr_fricc').show();		  
	});	    	  
  }
  //delete button
  function delgs(gsId){
	 $('#hidgsID').val(gsId);
     var action = 'edit'; 
	 var userID = $('#hiduser').val();
     $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/gradeSectionajax.php",
		{
		  action: action,
		  gsid: gsId,
		  userID: userID,
		},   
		function(data, status){	
		  var gs = data.split("|");
		  $('#tblinfo').css("display", "none");
          $('#record_del').attr("style","display: block; font-size: 1.5rem;");          
          $('#record_del').html('Are you sure you want to delete '+gs[0]+' - '+gs[1]+'?');		  
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


  $('.popupCloseButton').click(function()
  {
     $('.hover_bkgr_fricc').hide();
	   if($('#hidrefresh').val() == 't')
	     {	  
	      location.reload(true);
	     }
  });
  

   //load teachers on edit
   $('#adviser').focus(function(){
	  var action = 'teacher';
       $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/gradesectionajax.php",
		{
		  action: action,	  
	    },
		function(data, status){	
		   $('#adviser').html('');
		   $('#adviser').html(data);				  
	    });
   }); 
 

// set allowance space between 'show entries' and datatable
setTimeout("$('#myTable_length').attr('style', 'height: 70px !important')" , 1000);
  
</script>
</article><!-- #post-<?php the_ID(); ?> -->
