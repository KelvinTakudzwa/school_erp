<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
foreach($system as $k => $v){
    $_SESSION['system'][$k] = $v;
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
  
  <!-- Add Bootstrap CSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Add Particles.js -->
  <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      color: white;
      position: relative;
      height: 100vh;
      overflow: hidden;
    }
    #particles-js {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -1; /* Make sure particles are behind the content */
    }
    .card {
      width: 100%;
      max-width: 400px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      background-color: rgba(255, 255, 255, 0.9); /* Slight transparency */
      color: #1d263b;
    }
    .btn-dark {
      background-color: #1d263b;
      color: white;
      border: none;
      transition: 0.3s;
    }
    .btn-dark:hover {
      background-color: #4c83ff;
      color: white;
    }
    .form-control {
      background: #f8f9fa;
      border: none;
      border-radius: 5px;
      height: 45px;
    }
    .form-control:focus {
      box-shadow: 0 0 5px #4c83ff;
      outline: none;
    }
    .card-body h2 {
      margin-bottom: 20px;
    }
    .heading-outside {
      text-align: center;
      margin-top: 50px;
      font-size: 2rem;
      color: #1d263b;
      white-space: nowrap;
      overflow: hidden;
      width: 0;
      animation: typing 5s steps(30) 1s forwards, blink-caret 0.75s step-end infinite;
    }
    
    /* Keyframes for typewriter effect */
    @keyframes typing {
      from {
        width: 0;
      }
      to {
        width: 100%;
      }
    }
    
    /* Blinking cursor */
    @keyframes blink-caret {
      50% {
        border-color: transparent;
      }
    }
  </style>
</head>

<body>
  <!-- Particles Background -->
  <div id="particles-js"></div>

  <!-- Heading outside the form -->
  <div class="heading-outside">
    <h1><b>School Fees Payment System</b></h1>
  </div>

  <main id="main" class="d-flex justify-content-center align-items-center h-100">
    <div class="card bg-light">
      <div class="card-body">
        <h2 class="text-center"><b>Please Login</b></h2>
        <form id="login-form">
          <div class="form-group mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username">
          </div>
          <div class="form-group mb-4">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-dark btn-block w-100">Login</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <!-- Add jQuery before Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Initialize Particles.js -->
  <script src="particles-config.js"></script>

  <script>
    $('#login-form').submit(function(e){
      e.preventDefault();
      $('button').attr('disabled', true).text('Logging in...');
      if ($(this).find('.alert-danger').length > 0) 
          $(this).find('.alert-danger').remove();
      
      $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: err => {
          console.log(err);
          $('button').removeAttr('disabled').text('Login');
        },
        success: function(resp) {
          if (resp == 1) {
            location.href = 'index.php?page=home';
          } else {
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
            $('button').removeAttr('disabled').text('Login');
          }
        }
      });
    });
  </script>
</body>
</html>
