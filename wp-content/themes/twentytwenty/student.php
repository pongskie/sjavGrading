<?php
/**
  Template Name: Student
 */
get_header();

$user = wp_get_current_user();
echo "Teacher ID: ".$user->ID;


?>


<main id="site-content" role="main">

<input type="button" id="btnAdd" value="Add New" class="trigger_popup_fricc" />

<input type="button" id="btnPrint" value="Print" onclick="testprint()" />

<!------------ DATATABLES --------------->
	
	<div style='border:2px solid black; padding:10px;' >
	   <table id='myTable' class='display'>
	      <thead>
	          <tr>		  
	              <th>id</th>
	              <th>name</th>
	              <th>gender</th>
	              <th>birth_date</th>
	              <th>date_entered</th>
				  <th>date_entered</th>
	          </tr>
	     </thead>
	     <tbody>
           <?php
                $result = $wpdb->get_results("SELECT * FROM student_tbl WHERE deleted = 0");
		           // output data of each row
		           foreach($result as $row) {
            ?>
						<tr>
						<td><?php echo $row->id ?></td>
						<td><?php echo $row->name ?></td>
						<td><?php echo $row->gender ?></td>
						<td><?php echo $row->birth_date ?></td>
						<td><input type='button' value='edit'  id='btnEdit' onclick="editStud(<?php echo $row->id ?>)" /></td>
						<td><input type='button' value='delete'  id='btnDelete' onclick="delStud(<?php echo $row->id ?>)" /></td>
						</tr>
	   		         <?php	
		            }
                ?>
	</tbody>
	</table>
    </div>
	
<!------------ END DATATABLES --------------->


<!-------- POPUP MODAL  ------->	
<div id="divInfo" class="hover_bkgr_fricc">
    <span class="helper"></span>
    <div>
        <div class="popupCloseButton">&times;</div>
	    <table id="tblinfo" border="0" width="100%">
		 <tr>
		   <td colspan="2" ><span id = "spMsg"></span></td>	   
		 </tr>		
		 <tr>
		   <td>Name: <input type="text" id="sname" name="sname" size="30" /></td>
		   <td>Gender: <input type="text" id="sgender" name="sgender" size="20" /></td>		   
		 </tr>
		</table> 
		<table id="tblbtn"> 
		 <tr>
		   <td><input type="button" id="btnSave" value="Save"></td>
           <td><input type="button" id="btncancel" value="Cancel" onclick="cancelButtton()"></td>
		 </tr>		 		 
		</table>
    </div>
</div>
<!-------- END POPUP MODAL  ------->

<!-------- HIDDEN ELEMENTS -------->
<input type="hidden" id="hidrefresh" name="hidrefresh" value="f">
<input type="hidden" id="hidstudID" name="hidstudID" value="">
<input type="hidden" id="hidaction" name="hidaction" size="10" />
<!-------- END HIDDEN ELEMENTS -------->
</main><!-- #site-content -->

<?php
get_footer();
?>

<script>
$(document).ready(function(){	
	$('#myTable').DataTable( {
	   "order": [[ 0, "asc" ]],
	}); 
    //add button
	$('#btnAdd').click(function(){
	   $('#hidaction').val('add');
	});

    //print button
	$('#btnPrint').click(function(){
	   window.location.href = "http://localhost/sja-grading/hello?id=kkk";
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
	   
       $.post("http://localhost/SJA-grading/wp-content/themes/twentyseventeen/studentajax.php",
		{
		  action: action,
		  studID : studID,
		  sname: sname,
		  sgender: sgender
		},   
		function(data, status){	
		   if(action == 'delSave')
		   {
			 $('#tblinfo').html(data);
		   }
		   $('#spMsg').html(data);
		   $('#hidrefresh').val('t');
		    if(data != 'error')
			{		
		      $('#tblbtn').html('<tr><td><input type="button" id="btnOk" value="Ok" onclick="refreshPage()"></td></tr>');
			}					  
	    });	   
	});	
 });
  //edit button
  function editStud(studId){
	 $('#hidstudID').val(studId);
	 $('#hidaction').val('edit');
     var action = 'edit';	
     $.post("http://localhost/SJA-grading/wp-content/themes/twentyseventeen/studentajax.php",
		{
		  action: action,
		  stud_id: studId
		},   
		function(data, status){	
		  var stud = data.split("|");          
		  $("#sname").val(stud[0]);
          $("#sgender").val(stud[1]);
          $('.hover_bkgr_fricc').show();		  
	});	    	  
  }
  //delete button
  function delStud(studId){
	 $('#hidstudID').val(studId);
     var action = 'edit';	
     $.post("http://localhost/SJA-grading/wp-content/themes/twentyseventeen/studentajax.php",
		{
		  action: action,
		  stud_id: studId
		},   
		function(data, status){	
		  var stud = data.split("|");          
          $('#tblinfo').html('Are you sure you want to delete '+stud[0]+'?');		  
          $('.hover_bkgr_fricc').show();
          $('#hidaction').val('delSave');		  
	});	    	  
  }
  //reload page
  function refreshPage()
  {
     $('.hover_bkgr_fricc').hide();
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

  $('.popupCloseButton').click(function()
  {
     $('.hover_bkgr_fricc').hide();
	   if($('#hidrefresh').val() == 't')
	     {	  
	      location.reload(true);
	     }
  });	
</script>
