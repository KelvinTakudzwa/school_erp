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
					<div class="card-header bg-dark text-light" id="header">
						<h3 class="text-center">STUDENT FEES DETAILS</h3>
						<span class="float:right"><a class="btn btn-info btn-block btn-m col-sm-2 float-right"  style="margin-right:20px;" href="javascript:void(0)" id="new_fees">
					<i class="fa fa-plus"></i> Add 
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed  table-striped table-hover">
							<thead  class="thead-dark">
								<tr>
									<th class="text-center">#</th>
									<th class="h5">Student Number</th>
									<th class="h5">Reciept No.</th>
									<th class="h5"> Full Name</th>
									<th class="h5">Total Fee</th>
									<th class="h5" type="currency">Paid</th>
									<th class="h5">Balance</th>
									<th class="text-center h5" >Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$fees = $conn->query("SELECT ef.*,s.name as sname,s.id_no FROM student_ef_list ef inner join student s on s.id = ef.student_id order by s.name asc ");
								while($row=$fees->fetch_assoc()):
									$paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
									$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
									$balance = $row['total_fee'] - $paid;
								?>
								<tr class="h6">
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p> <b><?php echo $row['id_no'] ?></b></p>
									</td>
									<td>
										<p> <b><?php echo $row['ef_no'] ?></b></p>
									</td>
									<td>
										<p> <b><?php echo ucwords($row['sname']) ?></b></p>
									</td>
									<td class="text-center">
										<p> <b><?php echo number_format($row['total_fee'],2) ?></b></p>
									</td>
									<td class="text-center">
										<p> <b><?php echo number_format($paid,2) ?></b></p>

									<td class="text-center">
										<p> <b><?php echo number_format($balance,2) ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-m btn-outline-dark view_payment" type="button" data-id="<?php echo $row['id'] ?>">View</button>
										<button class="btn btn-m btn-outline-dark edit_fees" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-m btn-outline-dark delete_fees" type="button" data-id="<?php echo $row['id'] ?>" >Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
							
						</table>
						<a href="https://www.example.com" class="info" style="text-decoration: solid;" >

						<p class="h6">&copy; 2025  Fibonnacci & Fermet IT Consultancy. All rights reserved.</p>
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
	
	$('.view_payment').click(function(){
		uni_modal("Payment Details","view_payment.php?ef_id="+$(this).attr('data-id')+"&pid=0","mid-large")
		
	})
	$('#new_fees').click(function(){
		uni_modal("Enroll Student ","manage_fee.php","mid-large")
		
	})
	$('.edit_fees').click(function(){
		uni_modal("Manage Student's Enrollment Details","manage_fee.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_fees').click(function(){
		_conf("Are you sure to delete this fees ?","delete_fees",[$(this).attr('data-id')])
	})
	function delete_fees($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_fees',
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
            background-color: white; 
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
            border: 1px solid  black /* Blue border */;
            border-radius: 5px; /* Rounded corners */
		}
      
    </style>