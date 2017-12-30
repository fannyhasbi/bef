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
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $i = 1;
                foreach($bukti as $item):
                ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td><?= $item->username; ?></td>
                    <td><?= $item->nama; ?></td>
                    <td class="text-center">
                      <?php if($item->konfirmasi == 1){ ?>
                        <a href="<?= base_url('foto/bukti/'. $item->bukti); ?>" rel="tooltip" title="Lihat bukti" class="btn btn-info btn-simple btn-xs" target="_blank">
                          <i class="material-icons">search</i> Lihat
                        </a>
                      <?php } else { ?>
                        <?php if($item->bukti != null){ ?>
                          <a href="<?= base_url('foto/bukti/'. $item->bukti); ?>" rel="tooltip" title="Lihat bukti" class="btn btn-info btn-simple btn-xs" target="_blank">
                            <i class="material-icons">search</i> Lihat
                          </a>
                        <?php } ?>

                        <a href="<?= base_url('sudo/confirm/'. $item->refId); ?>" rel="tooltip" title="Konfirmasi" class="btn btn-success btn-simple btn-xs">
                          <i class="material-icons">check_circle</i> Konfirmasi
                        </a>
                      <?php } ?>

                      <button class="btn btn-danger btn-simple btn-xs" title="Hapus peserta" rel="tooltip" onclick="hapus(<?= $item->refId; ?>)">
                        <i class="material-icons">close</i> Hapus
                      </button>
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
      window.location = "<?= site_url('sudo/del-peserta/'); ?>"+ id;
    }
  }
</script>