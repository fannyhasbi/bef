<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>/assets/images/apple-icon.png" />
  <link rel="icon" type="image/png" href="<?= base_url(); ?>/assets/images/favicon.png" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>BEF 2018 | Dashboard</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />
  <!-- Bootstrap core CSS     -->
  <link href="<?= base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <!--  Material Dashboard CSS    -->
  <link href="<?= base_url(); ?>/assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
  <!--  CSS for Demo Purpose, don't include it in your project     -->
  <link href="<?= base_url(); ?>/assets/css/demo.css" rel="stylesheet" />
  <!-- Datepicker -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bootstrap-datepicker.min.css">
  <!--     Fonts and icons     -->
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

  <!--   Core JS Files   -->
  <script src="<?= base_url(); ?>/assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="<?= base_url(); ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?= base_url(); ?>/assets/js/material.min.js" type="text/javascript"></script>
  <!--  Charts Plugin -->
  <script src="<?= base_url(); ?>/assets/js/chartist.min.js"></script>
  <!--  Dynamic Elements plugin -->
  <script src="<?= base_url(); ?>/assets/js/arrive.min.js"></script>
  <!--  PerfectScrollbar Library -->
  <script src="<?= base_url(); ?>/assets/js/perfect-scrollbar.jquery.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?= base_url(); ?>/assets/js/bootstrap-notify.js"></script>
  <!-- Bootstrap Date picker -->
  <script src="<?= base_url(); ?>/assets/js/bootstrap-datepicker.min.js"></script>  
  <!-- Material Dashboard javascript methods -->
  <script src="<?= base_url(); ?>/assets/js/material-dashboard.js?v=1.2.0"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?= base_url(); ?>/assets/js/demo.js"></script>
  <!-- Validate -->
  <script src="<?= base_url(); ?>/assets/js/register.js"></script>
</head>

<body>
<div class="wrapper">
  <div class="sidebar" data-color="blue">
    <div class="logo">
      <a href="<?= site_url(); ?>" class="simple-text">BEF 2018</a>
    </div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        <li class="active">
          <a href="<?= site_url('dashboard'); ?>">
            <i class="material-icons">description</i>
            <p>Biodata</p>
          </a>
        </li>
        <li>
          <a href="<?= site_url('keluar'); ?>">
            <i class="material-icons">exit_to_app</i>
            <p>Keluar</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
  <div class="main-panel">
    <nav class="navbar navbar-transparent navbar-absolute">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"> Dashboard </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="<?= site_url('keluar'); ?>" title="Keluar">
                <i class="material-icons">exit_to_app</i>
                <p class="hidden-lg hidden-md">Keluar</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header" data-background-color="purple">
                <h4 class="title">Biodata</h4>
                <p class="category">Silahkan lengkapi biodata dibawah ini.</p>
              </div>
              <div class="card-content">
                
                <!-- Form ubah profil -->
                <form action="<?= site_url('save'); ?>" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group label-floating">
                        <label class="control-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" value="<?= $bio->nama; ?>" disabled>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class='col-md-12'>
                      <div class="form-group">
                      <label class="control-label">Tanggal Lahir</label>
                        <input type="text" id="datepicker" class="form-control" name="ttl">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group label-floating">
                        <label class="control-label">Alamat Tetap</label>
                        <input type="text" class="form-control" name="alamat" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group label-floating">
                        <label class="control-label">Kode Pos</label>
                        <input type="text" class="form-control" name="kodepos" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group label-floating">
                        <label class="control-label">Telepon/HP</label>
                        <input type="text" class="form-control" name="telepon" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label">Jenis Kelamin</label>
                        <div class="radio">
                          <label class="radio-inline"><input type="radio" name="gender" value="L">Laki-laki</label>
                          <label class="radio-inline"><input type="radio" name="gender" value="P">Perempuan</label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label">Pilihan Tiket</label>
                        <select class="form-control" name="tiket">
                          <option value="1">Silver IPA/IPS</option>
                          <option value="2">Silver IPC</option>
                          <option value="3">Gold IPA/IPS</option>
                          <option value="4">Gold IPC</option>
                          <option value="5">Gold</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <input type="submit" class="btn btn-primary pull-right" name="simpan" value="Simpan">
                  <div class="clearfix"></div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="container-fluid">
        <p class="copyright pull-right">&copy; Panitia Brebes Education Fair 2018</p>
      </div>
    </footer>
  </div>
</div>

<script>
$(document).ready(function(){
  var msg = '<?= $message; ?>';
  var type = '<?= $type; ?>';

  if(msg.length != 0){
    $.notify({
      icon: "notifications",
      message: msg
    }, {
      type: type,
      timer: 20000,
      placement: {
        from: 'top',
        align: 'center'
      }
    });
  }
});

$(function () {
  $('#datepicker').datepicker({
    autoclose: true,
    format: "yyyy-mm-d"
  });
});
</script>

</body>
</html>