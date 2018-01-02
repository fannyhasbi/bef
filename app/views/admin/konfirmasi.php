<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-plain">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Konfirmasi Peserta</h4>
          <p class="category">Silahkan konfirmasi peserta yang sudah mengirimkan bukti pembayaran berikut.</p>
        </div>
        <div class="card-content">
          <div class="iframe-container">
            
            <table id="datatable" class="table table-striped">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>Jenis</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $i = 1;
                foreach($bukti as $item):
                ?>
                  <tr<?php if($item->konfirmasi==1){echo ' style="color:#fff;background-color:#5cb85c"';}?>>
                    <td><?= $i; ?></td>
                    <td><?= $item->username; ?></td>
                    <td><?= $item->nama; ?></td>
                    <td>
                      <?php
                      switch($item->tiket){
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
                    <td class="text-center">
                      <?php if($item->konfirmasi == 1){ ?>
                        
                      <?php } else { ?>
                        <?php if($item->bukti != null){ ?>
                          <a href="<?= base_url('foto/bukti/'. $item->bukti); ?>" rel="tooltip" title="Lihat bukti" class="btn btn-info btn-simple btn-xs" target="_blank">
                            <i class="material-icons">search</i> Lihat
                          </a>
                        <?php } ?>

                        <a href="<?= base_url('me/confirm/'. $item->refId); ?>" rel="tooltip" title="Konfirmasi" class="btn btn-success btn-simple btn-xs">
                          <i class="material-icons">check_circle</i> Konfirmasi
                        </a>
                      <?php } ?>

                      <?php if($this->db->get_where('peserta_fix', ['id_pendaftar' => $item->refId])->num_rows() == 0){ ?>
                        <button class="btn btn-danger btn-simple btn-xs" title="Hapus peserta" rel="tooltip" onclick="hapus(<?= $item->refId; ?>)">
                          <i class="material-icons">close</i> Hapus
                        </button>
                      <?php } else { ?>
                        <p>Finalisasi</p>
                      <?php } ?>
                    </td>
                  </tr>
                <?php
                $i++;
                endforeach;
                ?>

              <tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    var x = (window.innerWidth > 768) ? false : true;
    $("#datatable").DataTable({
        "scrollX": x,
        "pagingType": "numbers"
    });
  });

  function hapus(id){
    var j = confirm("Yakin ingin menghapus?");
    if(j){
      window.location = "<?= site_url('me/del-peserta/'); ?>"+ id;
    }
  }
</script>