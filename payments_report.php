<?php
    include 'db_connect.php';
    $month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
?>
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
                            <h3>Wayera Primary Fees Payment Report</h3>
                            <input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control col-sm-3">
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-striped" id='report-list'>
                            <thead style="background-color:  #2c3e50; color: white;"> <!-- Changed to charcoal grey -->
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Date</th>
                                    <th>ID No.</th>
                                    <th>Invoice No.</th>
                                    <th>Name</th>
                                    <th>Amount Paid</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total = 0;
                                $payments = $conn->query("SELECT p.*, s.name as sname, ef.ef_no, s.id_no FROM payments p INNER JOIN student_ef_list ef ON ef.id = p.ef_id INNER JOIN student s ON s.id = ef.student_id WHERE date_format(p.date_created,'%Y-%m') = '$month' ORDER BY unix_timestamp(p.date_created) ASC");
                                if($payments->num_rows > 0):
                                    while($row = $payments->fetch_array()):
                                        $total += $row['amount'];
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td><b><?php echo date("M d, Y H:i A", strtotime($row['date_created'])) ?></b></td>
                                    <td><b><?php echo $row['id_no'] ?></b></td>
                                    <td><b><?php echo $row['ef_no'] ?></b></td>
                                    <td><b><?php echo ucwords($row['sname']) ?></b></td>
                                    <td class="text-right"><b><?php echo number_format($row['amount'], 2) ?></b></td>
                                    <td><b><?php echo $row['remarks'] ?></b></td>
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
                                    <th class="text-right h5"><?php echo number_format($total, 2) ?></th>
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
</div>

<style>
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
        font-size: 1.5rem;
        border-radius: 5px;
        padding: 5px;
    }

    .card-header {
        border-radius: 0.5rem;
        background-color:  #2c3e50;
    }

    .card {
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 2rem;
    }

    .text-center {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

<script>
    $('#month').change(function(){
        location.replace('index.php?page=payments_report&month=' + $(this).val());
    });
    
    $('#print').click(function(){
        var _c = $('#report-list').clone();
        var nw = window.open('', '_blank', 'width=900,height=600');
        nw.document.write('<p class="text-center"><b>Payment Report as of <?php echo date("F, Y", strtotime($month)) ?></b></p>');
        nw.document.write(_c.prop('outerHTML'));
        nw.document.close();
        nw.print();
        setTimeout(() => {
            nw.close();
        }, 500);
    });
</script>