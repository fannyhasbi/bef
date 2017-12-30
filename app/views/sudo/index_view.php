<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$load = $this->db->query("SELECT COUNT(id) AS total FROM pendaftar WHERE id NOT IN (SELECT id_pendaftar FROM konfirmasi)");
$label = $load->row()->total;
?>
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
  <link href="<?= base_url(); ?>/assets/css/material-dashboard.css" rel="stylesheet" />
  <!--     Fonts and icons     -->
  <link href="<?= base_url(); ?>/assets/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

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
  <script src="<?= base_url(); ?>/assets/js/material-dashboard.js"></script>
  <!-- Validate -->
  <script src="<?= base_url(); ?>/assets/js/register.js"></script>

  <!-- DataTable -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/datatables.min.css"/>
  <script src="<?= base_url(); ?>/assets/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>/assets/js/datatables.min.js"></script>

</head>

<body>
<div class="wrapper">
  <div class="sidebar" data-color="blue">
    <div class="logo">
      <a href="<?= site_url(); ?>" class="simple-text">BEF 2018</a>
    </div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        <li <?= uri_string() == 'sudo' ? 'class="active"' : ''; ?>>
          <a href="<?= site_url('sudo'); ?>">
            <i class="material-icons">dashboard</i>
            <p>Dashboard</p>
          </a>
        </li>
        <li <?= uri_string() == 'sudo/konfirmasi' ? 'class="active"' : ''; ?>>
          <a href="<?= site_url('sudo/konfirmasi'); ?>">
            <i class="material-icons">check_circle</i>
            <p>Konfirmasi &nbsp; <span class="label <?= $label==0 ? 'label-success' : 'label-danger' ?>"><?= $label; ?></span></p>
          </a>
        </li>
        <li <?= uri_string() == 'sudo/ganti_password' ? 'class="active"' : ''; ?>>
          <a href="<?= site_url('sudo/ganti_password'); ?>">
            <i class="material-icons">vpn_key</i>
            <p>Ubah Password</p>
          </a>
        </li>
        <li <?= uri_string()=='sudo/admin'||uri_string()=='sudo/add-admin' ? 'class="active"' : ''; ?>>
          <a href="<?= site_url('sudo/admin'); ?>">
            <i class="material-icons">account_circle</i>
            <p>Admin</p>
          </a>
        </li>
        <li <?= uri_string()=='sudo/ptn'||uri_string()=='sudo/add-ptn' ? 'class="active"' : ''; ?>>
          <a href="<?= site_url('sudo/ptn'); ?>">
            <i class="material-icons">gavel</i>
            <p>PTN</p>
          </a>
        </li>
        <li <?= uri_string()=='sudo/prodi'||uri_string()=='sudo/add-prodi' ? 'class="active"' : ''; ?>>
          <a href="<?= site_url('sudo/prodi'); ?>">
            <i class="material-icons">label</i>
            <p>Prodi</p>
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
          <a class="navbar-brand" href="#"> Super Admin </a>
        </div>
      </div>
    </nav>

    <div class="content">
      <?php $this->load->view('sudo/'.$view_name); ?>
    </div>

    <footer class="footer">
      <div class="container-fluid">
        <nav class="pull-left">
          <ul>
            <li><a href="<?= site_url(); ?>">Beranda</a></li>
          </ul>
        </nav>
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
      timer: 3000,
      placement: {
        from: 'top',
        align: 'center'
      }
    });
  }
});

<?php if(uri_string() == 'sudo'){ ?>

dataDailySalesChart = {
  labels: [
    <?php
      $d_tgl = array();
      foreach($grafik['pendaftar'] as $tgl){
        $t = explode('-', $tgl->tanggal);
        $d_tgl[] = '"'.$t['0'].'"';
      }
      echo implode(",", $d_tgl);
    ?>
  ],
  series: [
    [
      <?php
        $d_peserta = array();
        foreach($grafik['peserta'] as $peserta){
          $d_peserta[] = $peserta->jumlah;
        }
        echo implode(",", $d_peserta);
      ?>
    ],
    [
      <?php
        $d_pendaftar = array();
        foreach($grafik['pendaftar'] as $pendaftar){
          $d_pendaftar[] = $pendaftar->jumlah;
        }
        echo implode(",", $d_pendaftar);
      ?>
    ]
  ]
};

optionsDailySalesChart = {
  lineSmooth: Chartist.Interpolation.cardinal({
    tension: 0
  }),
  low: 0,
  high: <?= $grafik['highest'] + 10; ?>,
  chartPadding: {
    top: 0,
    right: 0,
    bottom: 0,
    left: -10
  },
}

var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

md.startAnimationForLineChart(dailySalesChart);

<?php } ?>
</script>
</body>
</html>