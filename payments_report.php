<?php
    include 'db_connect.php';
    $month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
?>
<div class="container-fluid justify-content-center pt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
          
            <div class="row justify-content-center pt-3">
            
                <label for="" class="mt-2">Month</label>
                <div class="col-sm-3">
                    <input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <table class="table table-condensed  table-striped table-hover" id='report-list'>
                  
                    <thead   class="bg-dark text-light">
                    <h4  class="text-center">Wayera Primary Fees Payment Report</h4>
                        <tr class="h5">
                            <th class="text-center ">#</th>
                            <th class="">Date</th>
                            <th class="">ID No.</th>
                            <th class="">Invoice No.</th>
                            <th class="">Name</th>
                            <th class="">Amount Paid</th>
                            <th >Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
			          <?php
                      $i = 1;
                      $total = 0;
                      $payments = $conn->query("SELECT p.*,s.name as sname, ef.ef_no,s.id_no FROM payments p inner join student_ef_list ef on ef.id = p.ef_id inner join student s on s.id = ef.student_id where date_format(p.date_created,'%Y-%m') = '$month' order by unix_timestamp(p.date_created) asc ");
                      if($payments->num_rows > 0):
			          while($row = $payments->fetch_array()):
                        $total += $row['amount'];
			          ?>
			          <tr class="h6">
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td>
                            <p> <b><?php echo date("M d,Y H:i A",strtotime($row['id_no'])) ?></b></p>
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

                        <td class="text-right">
                            <p> <b><?php echo $row['remarks'] ?></b></p>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                        else:
                    ?>
                    <tr>
                            <th class="text-center" colspan="7">No Data.</th>
                    </tr>
                    <?php 
                        endif;
                    ?>
			        </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right h5">Total</th>
                            <th class="text-right h5"><?php echo number_format($total,2) ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                <hr>
                <div class="col-md-12 mb-4">
                    <center>
                        <button class="btn btn-success btn-m col-sm-3" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                    </center>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<noscript>
	<style>
		table#report-list{
			width:100%;
			border-collapse:collapse
		}
		table#report-list td,table#report-list th{
			border:1px solid
		}
        p{
            margin:unset;
        }
		.text-center{
			text-align:center
		}
        .text-right{
            text-align:right
        }
	</style>
</noscript>
<script>
$('#month').change(function(){
    location.replace('index.php?page=payments_report&month='+$(this).val())
})
$('#print').click(function(){
		var _c = $('#report-list').clone();
		var ns = $('noscript').clone();
            ns.append(_c)
		var nw = window.open('','_blank','width=900,height=600')
		nw.document.write('<p class="text-center"><b>Payment Report as of <?php echo date("F, Y",strtotime($month)) ?></b></p>')
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(() => {
			nw.close()
		}, 500);
	})
</script>



<style>
 .card-header{
	background-color: #d9edf7;
 }

 
 .table-striped tbody tr:nth-of-type(odd) {
            background-color: white; /* Light gray */
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #E5E4E2;; /* Light blue */
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