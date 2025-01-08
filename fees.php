<?php include('db_connect.php');?>
<style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.3); /* IE */
        -moz-transform: scale(1.3); /* FF */
        -webkit-transform: scale(1.3); /* Safari and Chrome */
        -o-transform: scale(1.3); /* Opera */
        transform: scale(1.3);
        padding: 10px;
        cursor: pointer;
    }
    
    td {
        vertical-align: middle !important;
    }
    
    td p {
        margin: unset;
    }
    
    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-header bg-gradient text-light" id="header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="text-center">STUDENT FEES DETAILS</h3>
                            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="new_fees">
                                <i class="fa fa-plus"></i> 
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="bg-primary text-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="h5">Student Number</th>
                                    <th class="h5">Receipt No.</th>
                                    <th class="h5">Full Name</th>
                                    <th class="h5">Total Fee</th>
                                    <th class="h5">Paid</th>
                                    <th class="h5">Balance</th>
                                    <th class="text-center h5">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $fees = $conn->query("SELECT ef.*,s.name as sname,s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id ORDER BY s.name ASC");
                                while($row = $fees->fetch_assoc()):
                                    $paid = $conn->query("SELECT SUM(amount) as paid FROM payments WHERE ef_id=".$row['id']);
                                    $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : '';
                                    $balance = $row['total_fee'] - $paid;
                                ?>
                                <tr class="h6">
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td><b><?php echo $row['id_no'] ?></b></td>
                                    <td><b><?php echo $row['ef_no'] ?></b></td>
                                    <td><b><?php echo ucwords($row['sname']) ?></b></td>
                                    <td class="text-center"><b><?php echo number_format($row['total_fee'], 2) ?></b></td>
                                    <td class="text-center"><b><?php echo number_format($paid, 2) ?></b></td>
                                    <td class="text-center"><b><?php echo number_format($balance, 2) ?></b></td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm view_payment" type="button" data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-warning btn-sm edit_fees" type="button" data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm delete_fees" type="button" data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <p class="text-center mt-4">© 2025 Takudzwa and Associates. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>

<script>
    $(document).ready(function(){
        $('table').dataTable();
    });

    $('.view_payment').click(function(){
        uni_modal("Payment Details", "view_payment.php?ef_id=" + $(this).attr('data-id') + "&pid=0", "mid-large");
    });

    $('#new_fees').click(function(){
        uni_modal("Enroll Student", "manage_fee.php", "mid-large");
    });

    $('.edit_fees').click(function(){
        uni_modal("Manage Student's Enrollment Details", "manage_fee.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_fees').click(function(){
        _conf("Are you sure to delete this fees?", "delete_fees", [$(this).attr('data-id')]);
    });

    function delete_fees($id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_fees',
            method: 'POST',
            data: {id: $id},
            success: function(resp){
                if(resp == 1){
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>

<style>
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: white; 
    }
    .table-striped tbody tr:nth-of-type(even) {
        background-color: #E5E4E2; /* Light gray */
    }

    label {
        font-size: 1rem;
    }

    .dataTables_info {
        font-size: 1.00rem;
    }

    select {
        background-color: white;
    }
    
    input {
        width: 50%; /* Full width */
        padding: 15px; /* Increase padding for height */
        font-size: 1.25rem; /* Larger font size */
        border: 1px solid black; /* Border */
        border-radius: 5px; /* Rounded corners */
    }
</style>