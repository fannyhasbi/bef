<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$q = $this->db->get_where('peserta_fix', ['id_pendaftar' => $this->session->userdata('id')])
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="green">
          <h4 class="title">Finalisasi</h4>
          <p class="category">Silahkan cek kembali data dibawah ini. Jika terdapat kesalahan, silahkan hubungi CP</p>
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
              <td><?= $q->num_rows() >  0 ? $this->db->get_where('peserta_fix', ['id_pendaftar'=>$this->session->userdata('id')])->row()->no_peserta : 'No. Peserta didapat setelah finalisasi' ?></td>
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

          <a href="<?= site_url('final'); ?>" class="btn btn-success btn-block btn-lg" onclick="return confirm('Jika yakin data sudah benar, maka klik OK');">FINALISASI</a>
          
        </div>
      </div>
    </div>
  </div>
</div>
