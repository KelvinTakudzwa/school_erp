<!DOCTYPE html>
<html lang="en">

<?php session_start(); ?>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <title><?php echo isset($_SESSION['system']['name']) ? $_SESSION['system']['name'] : 'Takudzwa & Associates'; ?></title>

    <?php
    if (!isset($_SESSION['login_id']))
        header('location:login.php');
    include('./header.php');
    ?>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: white;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #2c3e50;
        color: white;
        padding: 10px 20px;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar .logo {
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .navbar ul {
        display: flex;
        gap: 15px;
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .navbar ul li {
        position: relative;
    }

    .navbar ul li a {
        color: white;
        text-decoration: none;
        font-size: 1rem;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .navbar ul li a:hover {
        background-color: #34495e;
    }

    .navbar ul li a.active {
        background-color: #34495e; /* Highlight active link */
        font-weight: bold; /* Make active link bold */
    }

    .menu-toggle {
        display: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .navbar ul {
            display: none;
            flex-direction: column;
            background-color: #2c3e50;
            width: 100%;
            position: absolute;
            top: 100%;
            left: 0;
        }

        .navbar ul.active {
            display: flex;
        }

        .menu-toggle {
            display: block;
        }
    }

    .modal-dialog.large {
        width: 80% !important;
        max-width: unset;
    }

    .modal-dialog.mid-large {
        width: 50% !important;
        max-width: unset;
    }

    #viewer_modal .btn-close {
        position: absolute;
        z-index: 999999;
        background: unset;
        color: white;
        border: unset;
        font-size: 27px;
        top: 0;
    }

    #viewer_modal .modal-dialog {
        width: 80%;
        max-width: unset;
        height: calc(90%);
        max-height: unset;
    }

    #viewer_modal .modal-content {
        background: black;
        border: unset;
        height: calc(100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #viewer_modal img, #viewer_modal video {
        max-height: calc(100%);
        max-width: calc(100%);
    }
</style>

<body>
    <div class="navbar">
        <div class="logo">Takudzwa & Associates</div>
        <ul id="nav-links">
            <li><a href="index.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="index.php?page=students" class="<?php echo ($page == 'students') ? 'active' : ''; ?>">Students</a></li>
            <li><a href="index.php?page=fees" class="<?php echo ($page == 'fees') ? 'active' : ''; ?>">Fees</a></li>
            <li><a href="index.php?page=courses" class="<?php echo ($page == 'courses') ? 'active' : ''; ?>">Fees Structure</a></li>
            <li><a href="index.php?page=payments" class="<?php echo ($page == 'payments') ? 'active' : ''; ?>">Payments</a></li>
            <li><a href="index.php?page=payments_report" class="<?php echo ($page == 'payments_report') ? 'active' : ''; ?>">Reports</a></li>
        </ul>
        <span class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></span>
    </div>

    <div id="main-content">
        <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
        <?php include $page . '.php'; ?>
    </div>

    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white"></div>
    </div>

    <div id="preloader"></div>
    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='confirm'>Continue</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewer_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                <img src="" alt="">
            </div>
        </div>
    </div>

    <script>
        // Menu toggle for responsive design
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.getElementById('nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        window.start_load = function() {
            document.body.insertAdjacentHTML('afterbegin', '<div id="preloader2"></div>');
        };

        window.end_load = function() {
            const preloader = document.getElementById('preloader2');
            if (preloader) preloader.remove();
        };

        window.viewer_modal = function($src = '') {
            start_load();
            var t = $src.split('.');
            t = t[1];
            var view = (t === 'mp4') ? $("<video src='" + $src + "' controls autoplay></video>") : $("<img src='" + $src + "' />");
            $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove();
            $('#viewer_modal .modal-content').append(view);
            $('#viewer_modal').modal({
                show: true,
                backdrop: 'static',
                keyboard: false,
                focus: true
            });
            end_load();
        };

        window.uni_modal = function($title = '', $url = '', $size = "") {
            start_load();
            $.ajax({
                url: $url,
                error: err => {
                    console.log(err);
                    alert("An error occurred");
                },
                success: function(resp) {
                    if (resp) {
                        $('#uni_modal .modal-title').html($title);
                        $('#uni_modal .modal-body').html(resp);
                        if ($size != '') {
                            $('#uni_modal .modal-dialog').addClass($size);
                        } else {
                            $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md");
                        }
                        $('#uni_modal').modal({
                            show: true,
                            backdrop: 'static',
                            keyboard: false,
                            focus: true
                        });
                        end_load();
                    }
                }
            });
        };

        window._conf = function($msg = '', $func = '', $params = []) {
            $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")");
            $('#confirm_modal .modal-body').html($msg);
            $('#confirm_modal').modal('show');
        };

        window.alert_toast = function($msg = 'TEST', $bg = 'success') {
            $('#alert_toast').removeClass('bg-success bg-danger bg-info bg-warning');

            if ($bg === 'success') $('#alert_toast').addClass('bg-success');
            if ($bg === 'danger') $('#alert_toast').addClass('bg-danger');
            if ($bg === 'info') $('#alert_toast').addClass('bg-info');
            if ($bg === 'warning') $('#alert_toast').addClass('bg-warning');

            $('#alert_toast .toast-body').html($msg);
            $('#alert_toast').toast({ delay: 3000 }).toast('show');
        };

        $(document).ready(function() {
            $('#preloader').fadeOut('fast', function() {
                $(this).remove();
            });
        });
    </script>
</body>
</html>