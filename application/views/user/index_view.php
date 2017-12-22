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
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
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
            <i class="material-icons">person</i>
            <p>Profil</p>
          </a>
        </li>
        <li class="active">
          <a href="<?= site_url('ganti_password'); ?>">
            <i class="material-icons">vpn_key</i>
            <p>Ganti Password</p>
          </a>
        </li>
        <li class="active">
          <a href="<?= site_url('cetak'); ?>">
            <i class="material-icons">print</i>
            <p>Cetak Kartu</p>
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
          <a class="navbar-brand" href="#"> Profil </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="<?= site_url('logout'); ?>" title="Keluar">
                <i class="material-icons">exit_to_app</i>
                <p class="hidden-lg hidden-md">Keluar</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="content">
      <?php $this->load->view('user/'.$view_name); ?>
    </div>

    <footer class="footer">
      <div class="container-fluid">
        <nav class="pull-left">
          <ul>
            <li><a href="<?= site_url(); ?>">Home</a></li>
          </ul>
        </nav>
        <p class="copyright pull-right">&copy; Panitia Brebes Education Fair 2018</p>
      </div>
    </footer>
  </div>
</div>
</body>
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
<!-- Material Dashboard javascript methods -->
<script src="<?= base_url(); ?>/assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?= base_url(); ?>/assets/js/demo.js"></script>
<!-- Validate -->
<script src="<?= base_url(); ?>/assets/js/register.js"></script>

</html>