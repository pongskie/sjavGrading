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
						  <th>Full name</th>
						  <th>Birthdate</th>
						  <th>Gender</th>
						  <th>Grade Level</th>
						  <th>Section</th>
						  <th>Action</th>				  
					  </tr>
				 </thead>
				 <tbody>
				   <?php
						$result = $wpdb->get_results("SELECT stud.id,stud.name,stud.gender,stud.birthdate,stud.grade_level,sect.section AS section FROM student_tbl AS stud LEFT JOIN gradelevel_section_tbl AS sect ON stud.sec_code = sect.sec_code WHERE stud.deleted=0");
						   // output data of each row
						   foreach($result as $row) {
					?>
								<tr>
								<td style="display:none;"><?php echo $row->id ?></td>
								<td align="center"><?php echo $row->name ?></td>
								<td align="center"><?php echo $row->birthdate ?></td>
								<td align="center"><?php echo $row->gender ?></td>
								<td align="center" style="width: 10%"><?php echo $row->grade_level ?></td>
								<td align="center"><?php echo $row->section ?></td>						
								<td align="center"><input type='button' value='edit' class='editbtn'  id='btnEdit' onclick="editStud(<?php echo $row->id ?>)" />  |  <input type='button' value='delete'  id='btnDelete' class='deletebtn' onclick="delStud(<?php echo $row->id ?>)" /></td>
								</tr>
							 <?php	
							}
						?>

        <tfoot>
            <tr>
                <th style="display:none">1</th>
                <th style="visibility:hidden">2</th>
                <th style="visibility:hidden">3</th>
                <th>4</th>
                <th>5</th>
				<th>6</th>
            </tr>
        </tfoot>						
						
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
				   <td>Name:</td>
				   <td colspan="3"><input type="text" id="sname" name="sname" size="40" placeholder="Last name, First name MI"  /></td>		   
				 </tr>	 
				 <tr>
				   <td width="110px">Birthdate:</td>
				   <td><input type="date" id="sbdate" name="sbdate" /></td>
				   <td>Grade Level:</td>
				   <td> <select id="sgrdlvl">
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
				   <td>Gender:</td>
				   <td>
						<select id="sgender">
						  <option value="male">Male</option>
						  <option value="female">Female</option>
						</select>		   		   
				   </td>
				   <td>Section:</td>
				   <td>		   
						<select id="ssection">
						  <option value="g1a">sec grade1a</option>
						  <option value="g1b">sec grade1b</option>
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
		<input type="hidden" id="hidstudID" name="hidstudID" value="">
		<input type="hidden" id="hidaction" name="hidaction" />
		<input type="hidden" id="hiduser" name="hiduser" value=<?php echo $user_logged_in; ?> />
        <!-------- END HIDDEN ELEMENTS -------->		
		
	</div><!-- .entry-content -->
	

<script>
$(document).ready(function(){	
	$('#myTable').DataTable( {
	   "order": [[ 0, "desc" ]],
	   
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }


	   

	});

    //add button
	$('#btnAdd').click(function(){
	   $('#hidaction').val('add');
	   $('#tblinfo').attr("style", "display: block; font-size: 1.5rem; text-align: left");
       $('#record_del').attr("style","display: none");

	   $('#sname').val('');
	   $('#sgender').val('');
	   $('#sbdate').val('');
	   $('#sgrdlvl').val('');
	   $( "#ssection").val('');
	   
	   $('.hover_bkgr_fricc').show();
	   
	});

    //save function
	$('#btnSave').click(function(){
	   var action = $('#hidaction').val();
       if(action == 'edit')
	   {
		  action = 'editSave';  
	   }
	   var studID = $('#hidstudID').val();
	   var sname = $('#sname').val();
	   var sgender = $('#sgender').val();
	   var sbdate = $('#sbdate').val();
	   var sgrdlvl = $('#sgrdlvl').val();
	   var ssection = $("#ssection").val();
	   var userID = $('#hiduser').val();
	  	   	   
       $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/studentajax.php",
		{
		  action: action,
		  studID : studID,
		  sname: sname,
		  sgender: sgender,
		  sbdate: sbdate,
		  sgrdlvl: sgrdlvl,
		  ssection: ssection,
		  userID: userID,
		},   
		function(data, status){				
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

   //grade select change
   $('#sgrdlvl').change(function(){
	  var grade_level = $('#sgrdlvl').val();
	  var action = 'gradelevel';
       $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/studentajax.php",
		{
		  action: action,
		  grade_level : grade_level,	  
	    },
		function(data, status){	
		   $('#ssection').html(data);				  
	    });	 		
   });
   //load sections based on grade level on edit
   $('#ssection').focus(function(){
	  var grade_level = $('#sgrdlvl').val();
	  var action = 'gradelevel';
       $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/studentajax.php",
		{
		  action: action,
		  grade_level : grade_level,	  
	    },
		function(data, status){	
		   $('#ssection').html('');
		   $('#ssection').html(data);				  
	    });
   });
	
 });
 
  //edit button
  function editStud(studId){

	 $('#tblinfo').attr("style", "display: block; font-size: 1.5rem; text-align: left");
     $('#record_del').attr("style","display: none");	  
	  
	 $('#hidstudID').val(studId);
	 $('#hidaction').val('edit');
     var action = 'edit';
     var userID = $('#hiduser').val();	 
     $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/studentajax.php",
		{
		  action: action,
		  stud_id: studId,
		  userID: userID,
		},   
		function(data, status){	
          //alert(data);		
		  var stud = data.split("|");          
		  $("#sname").val(stud[0]);
          $("#sgender").val(stud[1]);
		  $("#sbdate").val(stud[2]);
		  $("#sgrdlvl").val(stud[3]);
          //alert(stud[5]);	
          //$("#ssection").val(stud[5]);		  
		  $("#ssection").html(stud[4]);
		  
          $('.hover_bkgr_fricc').show();		  
	});	    	  
  }
  //delete button
  function delStud(studId){
	 $('#hidstudID').val(studId);
     var action = 'edit'; 
	 var userID = $('#hiduser').val();
     $.post("http://localhost/SJA-grading/wp-content/themes/consultant-lite/studentajax.php",
		{
		  action: action,
		  stud_id: studId,
		  userID: userID,
		},   
		function(data, status){		
		  var stud = data.split("|"); 
		  $('#tblinfo').css("display", "none");
          $('#record_del').attr("style","display: block; font-size: 1.5rem;");			  
          $('#record_del').html('Are you sure you want to delete '+stud[0]+'?');		  
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

// set allowance space between 'show entries' and datatable
setTimeout("$('#myTable_length').attr('style', 'height: 70px !important')" , 1000);
  
</script>
</article><!-- #post-<?php the_ID(); ?> -->
