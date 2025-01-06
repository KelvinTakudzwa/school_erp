<?php include('db_connect.php');?>
<style>





 .table-striped tbody tr:nth-of-type(odd) {
            background-color: white; /* Light gray */
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #E5E4E2; /* Light blue */
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
            border: 1px solid  black /* Blue border */;
            border-radius: 5px; /* Rounded corners */
		}
      
    








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
						<h3 class="text-center">List of Different Fees </h3>
						<span class="float:right"><a class="btn btn-info btn-block btn-m col-sm-2 float-right" href="javascript:void(0)" id="new_course">
					<i class="fa fa-plus"></i> New Entry
				</a></span>
					
					</div>
					<div class="card-body">
						<table class="table table-condensed  table-striped table-hover">
							<thead class="bg-dark">
								<tr class="h5 text-light">
									<th class="text-center">#</th>
									<th class="">Description</th>
									<th class="">Grade</th>
									<th class="">Total Fee</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$course = $conn->query("SELECT * FROM courses  order by course asc ");
								while($row=$course->fetch_assoc()):
								?>
								<tr class="h6">
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p> <b><?php echo $row['course'] . " - " . $row['level'] ?></b></p>
									</td>
									<td class="">
										 <p><small><i><b><?php echo $row['description'] ?></i></small></p>
									</td>
									<td class="text-center">
										<p> <b><?php echo number_format($row['total_amount'],2) ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-m btn-outline-dark edit_course" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-m btn-outline-dark delete_course" type="button" data-id="<?php echo $row['id'] ?>" >Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
							
						</table>
						<a href="https://www.example.com" class="info" style="text-decoration: solid;" >

						<p class="h6">&copy; 2025 Fermet IT Consultancy. All rights reserved.</p>
								</a>
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
	$('#new_course').click(function(){
		uni_modal("New Course and Fees Entry","manage_course.php",'large')
		
	})

	$('.edit_course').click(function(){
		uni_modal("Manage Course and Fees Entry","manage_course.php?id="+$(this).attr('data-id'),'large')
		
	})
	$('.delete_course').click(function(){
		_conf("Are you sure to delete this course?","delete_course",[$(this).attr('data-id')])
	})
	
	function delete_course($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_course',
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

