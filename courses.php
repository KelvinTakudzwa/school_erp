<?php include('db_connect.php'); ?>
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
                            <h3>List of Different Fees</h3>
                            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="new_course">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-striped">
                            <thead style="background-color: #2c3e50; color: white;">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Description</th>
                                    <th>Grade</th>
                                    <th>Total Fee</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $course = $conn->query("SELECT * FROM courses ORDER BY course ASC");
                                while ($row = $course->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td><b><?php echo $row['course'] . " - " . $row['level']; ?></b></td>
                                    <td><small><i><b><?php echo $row['description']; ?></b></i></small></td>
                                    <td class="text-right"><b><?php echo number_format($row['total_amount'], 2); ?></b></td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm edit_course" type="button" data-id="<?php echo $row['id']; ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm delete_course" type="button" data-id="<?php echo $row['id']; ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if ($course->num_rows == 0): ?>
                                <tr>
                                    <td class="text-center" colspan="5">No data available.</td>
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
        background-color:  #2c3e50;
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
    $(document).ready(function () {
        $('table').DataTable();
    });

    $('#new_course').click(function () {
        uni_modal("New Course and Fees Entry", "manage_course.php", 'mid-large');
    });

    $('.edit_course').click(function () {
        uni_modal("Manage Course and Fees Entry", "manage_course.php?id=" + $(this).attr('data-id'), 'mid-large');
    });

    $('.delete_course').click(function () {
        _conf("Are you sure to delete this course?", "delete_course", [$(this).attr('data-id')]);
    });

    function delete_course($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_course',
            method: 'POST',
            data: { id: $id },
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
