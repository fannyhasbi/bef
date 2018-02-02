<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// nanti dipindah ke controller, ini karena urgent

$q = "select
  (
    select count(id) from pendaftar
    where tiket in (1, 4)
      and id not in (
        select id_pendaftar from peserta
      )
  ) as semua_ipa,
  (
    select count(id) from pendaftar
    where tiket in (2, 5)
      and id not in (
        select id_pendaftar from peserta
      )
  ) as semua_ips,
  (
    select count(id) from pendaftar
    where tiket in (3, 6)
      and id not in (
        select id_pendaftar from peserta
      )
  ) as semua_ipc,
  (
    select count(id) from pendaftar
    where tiket is null
      and id not in (
        select id_pendaftar from peserta
      )
  ) as belum_memilih,
  (
    select count(d.id)
    from pendaftar d
    inner join peserta p
      on d.id = p.id_pendaftar
    where d.tiket in (1, 4)
  ) as ipa_lunas,
  (
    select count(d.id)
    from pendaftar d
    inner join peserta p
      on d.id = p.id_pendaftar
    where d.tiket in (2, 5)
  ) as ips_lunas,
  (
    select count(d.id)
    from pendaftar d
    inner join peserta p
      on d.id = p.id_pendaftar
    where d.tiket in (3, 6)
  ) as ipc_lunas,
  (select count(no_peserta) from p_ipa) as ipa,
  (select count(no_peserta) from p_ips) as ips,
  (select count(no_peserta) from p_ipc) as ipc,
  (select count(distinct(id_pendaftar)) from kehadiran_to) as hadir_to,
  (select count(distinct(id_pendaftar)) from kehadiran_ts) as hadir_ts,
  (select count(distinct(id_pendaftar)) from kehadiran_expo) as hadir_expo
  ";

$r = $this->db->query($q)->row();

$konfirmasi = $this->db->query("select count(distinct(id_pendaftar)) as jumlah from peserta")->row()->jumlah;
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-4">
      <div class="card card-stats">
        <div class="card-header" data-background-color="red">
          <i class="material-icons">content_paste</i>
        </div>
        <div class="card-content">
          <p class="category">Kehadiran Try Out</p>
          <h3 class="title"><?= $r->hadir_to ?> <small>peserta</small></h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Beberapa menit yang lalu - <a href="<?= site_url('me/download-hadir/tryout'); ?>" class="text-success">Download</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card card-stats">
        <div class="card-header" data-background-color="blue">
          <i class="material-icons">keyboard_voice</i>
        </div>
        <div class="card-content">
          <p class="category">Kehadiran Talk Show</p>
          <h3 class="title"><?= $r->hadir_ts ?> <small>peserta</small></h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Beberapa menit yang lalu - <a href="<?= site_url('me/download-hadir/talkshow'); ?>" class="text-success">Download</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card card-stats">
        <div class="card-header" data-background-color="default">
          <i class="material-icons">content_paste</i>
        </div>
        <div class="card-content">
          <p class="category">Kehadiran Expo</p>
          <h3 class="title"><?= $r->hadir_expo ?> <small>peserta</small></h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Beberapa menit yang lalu - <a href="<?= site_url('me/download-hadir/expo'); ?>" class="text-success">Download</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
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
    <div class="col-sm-4">
      <div class="card card-stats">
        <div class="card-header" data-background-color="green">
          <i class="material-icons">check_circle</i>
        </div>
        <div class="card-content">
          <p class="category">Terkonfirmasi</p>
          <h3 class="title"><?= $konfirmasi ?> <small>pendaftar</small></h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Beberapa menit yang lalu
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card card-stats">
        <div class="card-header" data-background-color="purple">
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
    <div class="col-lg-12">
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
  
  <div class="row">
      <div class="col-lg-6 col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="blue">
          <h4 class="title">Jumlah TIket Keseluruhan</h4>
        </div>
        <div class="card-content table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th></th>
                <th class="text-warning">Belum Lunas</th>
                <th class="text-success">Lunas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>SAINTEK</th>
                <td><?= $r->semua_ipa; ?></td>
                <td><?= $r->ipa_lunas; ?></td>
              </tr>
              <tr>
                <th>SOSHUM</th>
                <td><?= $r->semua_ips; ?></td>
                <td><?= $r->ips_lunas; ?></td>
              </tr>
              <tr>
                <th>IPC</th>
                <td><?= $r->semua_ipc; ?></td>
                <td><?= $r->ipc_lunas; ?></td>
              </tr>
              <tr>
                <th>Belum Memilih</th>
                <td><?= $r->belum_memilih; ?></td>
                <td>-impossible-</td>
              </tr>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="blue">
          <h4 class="title">Jumlah TIket <small>Sudah Finalisasi</small></h4>
        </div>
        <div class="card-content table-responsive">
          <table class="table table-hover">
            <table class="table table-hover">
              <tr>
                <th>SAINTEK</th>
                <td><?= $r->ipa; ?></td>
                <td>
                  <a href="<?= site_url('me/detail/saintek'); ?>" class="btn btn-info btn-simple btn-xs" target="_blank">
                    <i class="material-icons">info</i> Detail
                  </a>
                </td>
              </tr>
              <tr>
                <th>SOSHUM</th>
                <td><?= $r->ips; ?></td>
                <td>
                  <a href="<?= site_url('me/detail/soshum'); ?>" class="btn btn-info btn-simple btn-xs" target="_blank">
                    <i class="material-icons">info</i> Detail
                  </a>
                </td>
              </tr>
              <tr>
                <th>IPC</th>
                <td><?= $r->ipc; ?></td>
                <td>
                  <a href="<?= site_url('me/detail/ipc'); ?>" class="btn btn-info btn-simple btn-xs" target="_blank">
                    <i class="material-icons">info</i> Detail
                  </a>
                </td>
              </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
  
</div>
