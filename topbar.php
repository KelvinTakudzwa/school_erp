<style>
	.logo {
    margin: auto;
    font-size: 20px;
    background: white;
    padding: 7px 11px;
    border-radius: 50% 50%;
    color:rgb(223, 17, 17);
    
}

.nav-item{
    color:red;
}



</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
        <a class="navbar-brand" href="#">
        <i class="bi bi-bookshelf lg"></i>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="me-3">
                <div class="form-white input-group" style="width: 250px;">
                  <h6 class="text-light"> Takudzwa and Associates </h6>
                 
                </div>
            </form>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-primary">
                

 
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <span class=''><i class=" "></i></span> 
                    </a>
                </li>


                <li class="nav-item">
                    <a href="index.php?page=fees" class="nav-link nav-fees">
                        <span class='icon-field'><i class="fa fa-money-check "></i></span> Student Fees
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <span class=''><i class=" "></i></span> 
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?page=payments" class="nav-link nav-payments">
                        <span class='icon-field'><i class="fa fa-receipt "></i></span> Payments
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <span class=''><i class=" "></i></span> 
                    </a>
                </li>



                <li class="nav-item">
                    <a href="index.php?page=courses" class="nav-link nav-courses">
                        <span class='icon-field'><i class="fa fa-scroll "></i></span> Fees Structure
                    </a>
                </li>
                

                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <span class=''><i class=" "></i></span> 
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?page=students" class="nav-link nav-students">
                        <span class='icon-field'><i class="fa fa-users "></i></span> Students
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <span class=''><i class=" "></i></span> 
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?page=payments_report" class="nav-link nav-payments_report">
                        <span class='icon-field'><i class="fa fa-th-list"></i></span> Payments Report
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav d-flex flex-row ms-auto me-3">
              
                <li class="nav-item me-3 me-lg-0 dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle" height="22"
                             alt="" loading="lazy" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown1">
                        <li><a class="dropdown-item" href="#">anesuishechiponda@gmail.com</a></li>
                        <li  disabled><a class="dropdown-item" href="#">Update</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="#">logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
  $('#manage_my_account').click(function(){
    uni_modal("Manage Account","manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
  })
</script>

