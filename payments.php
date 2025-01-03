<?php include 'db_connect.php'; ?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3 class="text-center">Payments</h3>
				       
						<span class="float:right"><a class="btn btn-info btn-block btn-m col-sm-2 float-right" href="javascript:void(0)" id="new_payment">
					<i class="fa fa-plus"></i>  Add New Transaction 
				</a></span>
					</div>
					<div class="card-body">
						<table class="able table-condensed  table-striped table-hover">
							<thead>
								<tr class="h5">
									<th class="text-center">#</th>
									<th class="">Date of transaction</th>
									<th class=""> Birth Certificate /ID No.</th>
									<th class="">Reciept No.</th>
									<th class="">Name</th>
									<th class="">Paid Amount</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$payments = $conn->query("SELECT p.*,s.name as sname, ef.ef_no,s.id_no FROM payments p inner join student_ef_list ef on ef.id = p.ef_id inner join student s on s.id = ef.student_id order by unix_timestamp(p.date_created) desc ");
								if($payments->num_rows > 0):
								while($row=$payments->fetch_assoc()):
									$paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
									$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
								?>
								<tr class="h6" >
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p> <b><?php echo date("M d,Y H:i A",strtotime($row['date_created'])) ?></b></p>
									</td>
									<td>
										<p> <b><?php echo $row['id_no'] ?></b></p>
									</td>
									<td>
										<p> <b><?php echo $row['ef_no'] ?></b></p>
									</td>
									<td>
										<p> <b><?php echo ucwords($row['sname']) ?></b></p>
									</td>
									<td class="text-right">
										<p> <b><?php echo number_format($row['amount'],2) ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-m btn-outline-info view_payment" type="button" data-id="<?php echo $row['id'] ?>" data-ef_id="<?php echo $row['ef_id'] ?>">View</button>
										<button class="btn btn-m btn-outline-info edit_payment" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-m btn-outline-info delete_payment" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php 
									endwhile; 
									else:
								?>
								<tr>
									<th class="text-center" colspan="7">No data.</th>
								</tr>
								<?php
									endif;

								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
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
	
	$('#new_payment').click(function(){
		uni_modal("New Payment ","manage_payment.php","mid-large")
		
	})

	$('.view_payment').click(function(){
		uni_modal("Payment Details","view_payment.php?ef_id="+$(this).attr('data-ef_id')+"&pid="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.edit_payment').click(function(){
		uni_modal("Manage Payment","manage_payment.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_payment').click(function(){
		_conf("Are you sure to delete this payment ?","delete_payment",[$(this).attr('data-id')])
	})
	function delete_payment($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_payment',
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
 .card-header{
	background-color: #d9edf7;
 }

 
 .table-striped tbody tr:nth-of-type(odd) {
            background-color: white; /* Light gray */
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #d9edf7; /* Light blue */
        }



th{
	background-color: #d9edf7;
	color:#17a2b8;
	
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
            border: 3px solid  #17a2b8 /* Blue border */;
            border-radius: 5px; /* Rounded corners */
		}
      
    </style>