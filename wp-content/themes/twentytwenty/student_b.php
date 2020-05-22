<?php
/**
  Template Name: Student
 */
get_header();
?>

<!------------- ADDIING NEW RECORD -------------->

<main id="site-content" role="main">

    <?php
     
	 if($_POST['Submit']) {
		 
	  global $wpdb;
     
      $action = $_POST['stest'];
	  
	  $name = $_POST['sname'];
      $gender = $_POST['sgender'];	  
	  
	  
	     if($action == ""){
			 if($wpdb->insert(
				  'student_tbl',
				  array (
					  'name' => $name,
					  'gender' => $gender
				  )
				) == false) wp_die('Database insertion failed!');
				
			 else echo 'Added successfully';	 
		}else if($action == "update"){
			       $studId = $_POST['studid'];
				   
				   $result = $wpdb->get_results("SELECT * FROM student_tbl WHERE id = $studId");
					 if($wpdb->update(
						  'student_tbl',
						  array (
							  'name' => $name,
							  'gender' => $gender
						        ),
						  array('id' => $studId)	  	
						) == false) wp_die('update failed!');
						
					 else echo 'update successfully';				   
    
		}		
	 }
	 ?>
	 <form action="" method="post" id="addstudent">
	 
	 <label>action:<input type="text" id="stest" name="stest" size="10" /> </label>
	 <label>studid:<input type="text" id="studid" name="studid" size="10" /> </label>
	 
	 <label>Student Name:<input type="text" id="sname" name="sname" size="30" /> </label>
	 <label>Gender:<input type="text" id="sgender" name="sgender" size="30" /> </label>

    <input type="submit" name="Submit" id="addStudSubmit" value="Save" />
	</form>

    <!------------ END ADDIING NEW RECORD -------------->	
	
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

                $result = $wpdb->get_results("SELECT * FROM student_tbl");

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


	<?php get_template_part( 'template-parts/pagination' ); ?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
?>

<script>
$(document).ready(function(){
	
	$('#myTable').DataTable( {
	   "order": [[ 1, "asc" ]],
	});  
	
});

  function editStud(studId){
     $('#stest').val('update');
	 $('#studid').val(studId);
     $.post("http://localhost/SJA-grading/wp-content/themes/twentytwenty/studentajax.php",
		{
			stud_id: studId
		},
   
		function(data, status){
		  //alert(data);	
		  var stud = data.split("|");
          
		  $("#sname").val(stud[0]);
          $("#sgender").val(stud[1]);		  
	});	  
      	  
  }
  
  
  function DelStud(x){
	  alert(x);  
  }
</script>
