<?php include 'db_connect.php'; ?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-header bg-gradient text-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>Payments</h3>
                            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="new_payment">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-striped">
                            <thead style="background-color: #2c3e50; color: white;"> <!-- Changed to charcoal grey -->
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Date of Transaction</th>
                                    <th>Birth Certificate / ID No.</th>
                                    <th>Receipt No.</th>
                                    <th>Full Name</th>
                                    <th>Paid Amount</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $payments = $conn->query("SELECT p.*, s.name as sname, ef.ef_no, s.id_no 
                                                           FROM payments p 
                                                           INNER JOIN student_ef_list ef ON ef.id = p.ef_id 
                                                           INNER JOIN student s ON s.id = ef.student_id 
                                                           ORDER BY UNIX_TIMESTAMP(p.date_created) DESC");

                                if($payments->num_rows > 0):
                                    while($row = $payments->fetch_assoc()):
                                        $paid = $conn->query("SELECT SUM(amount) as paid FROM payments WHERE ef_id=".$row['id']);
                                        $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : '';
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td><b><?php echo date("M d, Y H:i A", strtotime($row['date_created'])) ?></b></td>
                                    <td><b><?php echo $row['id_no'] ?></b></td>
                                    <td><b><?php echo $row['ef_no'] ?></b></td>
                                    <td><b><?php echo ucwords($row['sname']) ?></b></td>
                                    <td class="text-right"><b><?php echo number_format($row['amount'], 2) ?></b></td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm view_payment" data-id="<?php echo $row['id'] ?>" data-ef_id="<?php echo $row['ef_id'] ?>">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-warning btn-sm edit_payment" data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm delete_payment" data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php else: ?>
                                <tr>
                                    <th class="text-center" colspan="7">No data available.</th>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <p class="text-center mt-4">© 2025 Takudzwa and Associates. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* General Styling */
    .table th, .table td {
        vertical-align: middle;
        font-size: 1rem;
        padding: 12px;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table th {
        text-align: center;
        font-weight: bold;
    }

    .btn {
        font-size: 1.5rem; /* Adjusted for icon visibility */
        border-radius: 5px;
        padding: 5px;
    }

    /* Header */
    .card-header {
        border-radius: 0.5rem;
        background-color: #2c3e50;
    }

    /* Container & Card */
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 2rem;
    }

    /* Footer */
    .text-center {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

<script>
    $(document).ready(function(){
        $('table').DataTable();

        $('#new_payment').click(function(){
            uni_modal("New Payment", "manage_payment.php", "mid-large");
        });

        $('.view_payment').click(function(){
            uni_modal("Payment Details", "view_payment.php?ef_id=" + $(this).attr('data-ef_id') + "&pid=" + $(this).attr('data-id'), "mid-large");
        });

        $('.edit_payment').click(function(){
            uni_modal("Manage Payment", "manage_payment.php?id=" + $(this).attr('data-id'), "mid-large");
        });

        $('.delete_payment').click(function(){
            _conf("Are you sure to delete this payment?", "delete_payment", [$(this).attr('data-id')]);
        });
    });

    function delete_payment(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_payment',
            method: 'POST',
            data: {id: id},
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