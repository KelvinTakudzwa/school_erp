<?php include('db_connect.php');?>

<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.3); /* IE */
  -moz-transform: scale(1.3); /* FF */
  -webkit-transform: scale(1.3); /* Safari and Chrome */
  -o-transform: scale(1.3); /* Opera */
  transform: scale(1.3);
  padding: 10px;
  cursor:pointer;
}
</style>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header bg-dark text-light">

					
						<h3 class="text-center">List of Students </h3>
						<span class="float:right"><a class="btn btn-info btn-block btn-m col-sm-2 float-right" href="javascript:void(0)" id="new_student">
					<i class="fa fa-plus"></i>  Add New Student
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed  table-striped table-hover">
							<thead >
								<tr class="text-center h5 ">
									<th class="text-center ">#</th>
									<th class="">ID No.</th>
									<th class=""> FULL NAME</th>
			                        <th class=""> D.OB</th>
									<th class=""> GRADE</th>
									<th class=""> GENDER</th>
									
									<th class="text-center">ACTION</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$student = $conn->query("SELECT * FROM student order by name asc ");
								while($row=$student->fetch_assoc()):
								?>
								<tr   class="text-center h6 " >
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p> <b><?php echo $row['id_no'] ?></b></p>
									</td>
									<td>
										<p> <b><?php echo ucwords($row['name']) ?></b></p>
									</td>


									<td>
										<p> <b><?php echo ucwords($row['dob']) ?></b></p>
									</td>
									
									<td>
										<p> <b><?php echo ucwords($row['grade']) ?></b></p>
									</td>
									<td>
										<p> <b><?php echo ucwords($row['gender']) ?></b></p>
									</td>
									
									<td class="text-center">
										<button class="btn btn-m btn-outline-dark edit_student" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-m btn-outline-dark delete_student" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
							
						</table>
						<p>&copy; 2025 Fermet IT Consultancy. All rights reserved.</p>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#new_student').click(function(){
		uni_modal("New Student ","manage_student.php","mid-large")
		
	})
	$('.edit_student').click(function(){
		uni_modal("Manage Student  Details","manage_student.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_student').click(function(){
		_conf("Are you sure to delete this Student ?","delete_student",[$(this).attr('data-id')])
	})
	function delete_student($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_student',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>




<style>
 

 
 .table-striped tbody tr:nth-of-type(odd) {
            background-color: white; /* Light gray */
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #E5E4E2; /* Light blue */
        }



td{

}



label{
	font-size:1rem;
  }


	.paginate_button{
		
		color:white;

	}
	
	a{
		font-size: 1.00rem;

	}

  
        .dataTables_info{
			font-size: 1.00rem;
		}
	  



    select{
		background-color: white;
	}
      a{
		font-size: 1.25rem;
		
	  }  
	   
	    input{
			width: 50% /* Full width */
            padding: 15px; /* Increase padding for height */
            font-size: 1.25rem; /* Larger font size */
            border: 1px solid black ; /* Blue border */;
            border-radius: 5px; /* Rounded corners */
		}
      
    </style>