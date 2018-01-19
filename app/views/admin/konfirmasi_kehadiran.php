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
</head>

<body>
<div class="wrapper">  
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header" data-background-color="green">
            <h4 class="title">Berhasil Konfirmasi Kehadiran</h4>
          </div>
          <div class="card-content">
            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                <img src="<?= base_url().'foto/peserta/'.$profil->foto; ?>">
              </div>
            </div>
            <hr/>
            
            <table class="table table-striped">
              <tr>
                <th>No. Peserta</th>
                <td>
                  <?php
                    $q = $this->db->get_where("peserta_fix", ['id_pendaftar' => $profil->id_pendaftar]);
                    $q = $q->row()->no_peserta;
                    $n1 = substr($q, 0, 4);
                    $n2 = substr($q, 4, 2);
                    $n3 = substr($q, 6, 4);

                    echo $n1.'-'.$n2.'-'.$n3;
                  ?>
                </td>
              </tr>
              <tr>
                <th>Nama Lengkap</th>
                <td><?= $profil->nama; ?></td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td><?= $profil->alamat; ?></td>
              </tr>
              <tr>
                <th>Telepon</th>
                <td><?= $profil->telp; ?></td>
              </tr>
              <tr>
                <th>Tanggal Lahir</th>
                <td><?= $profil->ttl; ?></td>
              </tr>
              <tr>
                <th>Jenis Kelamin</th>
                <td><?= $profil->gender == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
              </tr>
              <tr>
                <th>Tiket</th>
                <td>
                  <?php
                    switch($profil->tiket){
                      case '1': echo 'Silver IPA'; break;
                      case '2': echo 'Silver IPS'; break;
                      case '3': echo 'Silver IPC'; break;
                      case '4': echo 'Gold IPA'; break;
                      case '5': echo 'Gold IPS'; break;
                      case '6': echo 'Gold IPC'; break;
                      // case '7': echo 'Gold';
                      default: echo 'Unknown'; break;
                    }
                  ?>
                </td>
              </tr>
              <tr>
                <th>NIS/NISN</th>
                <td><?= $profil->nis; ?></td>
              </tr>
              <tr>
                <th>Sekolah</th>
                <td><?= $profil->sekolah; ?></td>
              </tr>
              <tr>
                <th>Jurusan</th>
                <td><?= $profil->jurusan; ?></td>
              </tr>
              <tr>
                <th>Pilihan 1</th>
                <td><?= $profil->prodi1 == null ? 'Tidak memilih' : $profil->prodi1; ?></td>
              </tr>
              <tr>
                <th>Pilihan 2</th>
                <td><?= $profil->prodi2 == null ? 'Tidak memilih' : $profil->prodi2; ?></td>
              </tr>
              <tr>
                <th>Pilihan 3</th>
                <td><?= $profil->prodi3 == null ? 'Tidak memilih' : $profil->prodi3; ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>