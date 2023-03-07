<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style="background-image: url('./assets/admin/img/bg-login.jpg');background-size: cover;background-repeat: no-repeat;">
<div class="login-box" >
  <!-- /.login-logo -->
  <div class="card card-outline card-primary shadow">
    <div class="card-header text-center">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>
         <form action="<?php echo site_url('Api_gmp/login'); ?>" method="post">
   <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="UserName" name="user_name" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="user_email" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url() ?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/admin/js/adminlte.min.js"></script>




<script>

$(document).ready(function() {
  // Jalankan fungsi saat tombol login diklik
  $('#btn-login').click(function(e) {
    e.preventDefault();

    // Ambil data input dari form login
    var username = $('#username').val();
    var password = $('#password').val();

    // Kirim data ke API login menggunakan Ajax
    $.ajax({
      url: 'http://localhost/Api_gmp/login',
      type: 'POST',
      dataType: 'json',
      data: {
        user_name: username,
        password: password
      },
      success: function(response) {
        if (response.success) {
          // Jika otentikasi berhasil, tampilkan halaman dashboard
          window.location.href = 'http://localhost/Api_gmp/dashboard';
        } else {
          // Jika otentikasi gagal, tampilkan pesan error
          alert(response.message);
        }
      },
      error: function(xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });
});

</script>
</body>
</html>
