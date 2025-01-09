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
                            <h3 class="text-center">List of Students</h3>
                            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="new_student">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-striped">
                            <thead style="background-color: #2c3e50; color: #ffffff;">
                                <tr class="text-center">
                                    <th class="text-center">#</th>
                                    <th>ID No.</th>
                                    <th>Full Name</th>
                                    <th>Date of Birth</th>
                                    <th>Grade</th>
                                    <th>Gender</th>
                                    <th class="text-center"/>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $student = $conn->query("SELECT * FROM student ORDER BY name ASC");
                                while ($row = $student->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td><b><?php echo $row['id_no'] ?></b></td>
                                    <td><b><?php echo ucwords($row['name']) ?></b></td>
                                    <td><b><?php echo $row['dob'] ?></b></td>
                                    <td><b><?php echo $row['grade'] ?></b></td>
                                    <td><b><?php echo $row['gender'] ?></b></td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm edit_student" type="button" data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm delete_student" type="button" data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if ($student->num_rows == 0): ?>
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
        color:white;
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

        $('#new_student').click(function(){
            uni_modal("New Student", "manage_student.php", "mid-large");
        });

        $('.edit_student').click(function(){
            uni_modal("Manage Student Details", "manage_student.php?id=" + $(this).attr('data-id'), "mid-large");
        });

        $('.delete_student').click(function(){
            _conf("Are you sure to delete this student?", "delete_student", [$(this).attr('data-id')]);
        });
    });

    function delete_student(id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_student',
            method: 'POST',
            data: { id: id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
