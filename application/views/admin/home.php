<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="orange">
          <i class="material-icons">assignment</i>
        </div>
        <div class="card-content">
          <p class="category">Pendaftar</p>
          <h3 class="title"><?= $count->pendaftar; ?> <small>siswa</small></h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Beberapa menit yang lalu
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="green">
          <i class="material-icons">assignment_ind</i>
        </div>
        <div class="card-content">
          <p class="category">Peserta</p>
          <h3 class="title"><?= $count->peserta; ?> <small>peserta</small></h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Beberapa menit yang lalu
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header card-chart" data-background-color="blue">
          <div class="ct-chart" id="dailySalesChart"></div>
        </div>
        <div class="card-content">
          <h4 class="title">Grafik <span class="text-danger">Pendaftar</span> & <span class="text-success">Peserta</span></h4>
          <p class="category">
            Data pendaftaran peserta tiap hari.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
