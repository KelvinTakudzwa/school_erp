<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM student where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage-student">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class="form-group"></div>
        <div class="form-group">
            <label for="" class="control-label h6">Birth Certificate No./Id No.</label>
            <input type="text" class="form-control" name="id_no"  value="<?php echo isset($id_no) ? $id_no :'' ?>" required placeholder="Enter Student ID or Birth Certificate Number">
        </div>
        <div class="form-group">
            <label for="" class="control-label h6"> Full Name of Pupil:</label>
            <input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required  placeholder="Enter the Pupils Full name i.e First Name and Surname">
        </div>
        <div class="form-group">
        <label for=""  class="control-label h6">Date of Birth:</label>
        <input type="date" id="dob" name="dob"    class="form-control"  value="<?php echo isset($dob) ? $dob :'' ?>" required placeholder="Enter Date of Birth">
    </div>
  
        <div class="form-group">
            <label for="" class="control-label h6">Gender of Pupil:</label>
            <select class="form-control" name="gender"  value="<?php echo isset($gender) ? $gender :'' ?>" required placeholder="Enter Gender">
            <option value="" >Select a gender </option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                
            </select>
        </div>
        
        <div class="form-group">
            <label for="" class="control-label h6">Grade of Pupil:</label>
            <select class="form-control" name="grade"  value="<?php echo isset($grade) ? $grade :'' ?>" required>
            <option value="" >What grade is the Student ? </option>
            <option value="ECD A">ECD A</option>
                <option value="ECD B">ECD B</option>
                <option value="Grade 1">Grade 1</option>
                <option value="Grade 2">Grade 2</option>
                <option value="Grade 3">Grade 3</option>
                <option value="Grade 4">Grade 4</option>
                <option value="Grade 5">Grade 5</option>
                
                <option value="Grade 6">Grade 6</option>
                <option value="Grade 7">Grade 7</option>
            </select>
        </div>
        <div class="form-group">
            <label for="" class="control-label"> Parent's Contact</label>
            <input type="tel" class="form-control h6" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required placeholder="070-0000-000">
        </div>
        <div class="form-group">
            <label for="" class="control-label h6">Parent's/Guardian's Full Name:</label>
            <input type="text" class="form-control" name="parent"  value="<?php echo isset($parent) ? $parent:'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label h6"> Current Home Address:</label>
            <textarea name="address" id="" cols="30" rows="3" class="form-control" required=""><?php echo isset($address) ? $address :'' ?></textarea>
        </div>
    </form>
</div>
<script>
    $('#manage-student').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#manage-student').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url:'ajax.php?action=save_student',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully saved.",'success')
                        setTimeout(function(){
                            location.reload()
                        },1000)
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">ID # already exist.</div>')
                end_load()
                }   
            }
        })
    })

    $('.select2').select2({
        placeholder:"Please Select here",
        width:'100%'
    })
</script>