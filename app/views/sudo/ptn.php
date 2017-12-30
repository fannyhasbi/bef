<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <a href="<?= site_url('sudo/add-ptn'); ?>" class="btn btn-success">
        <i class="material-icons">note_add</i> Tambah
      </a>
    </div>

    <div class="col-md-12">
      <div class="card card-plain">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Daftar PTN</h4>
        </div>
        <div class="card-content">
          <div class="iframe-container">
            
            <table id="datatable" class="table table-striped">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach($ptn as $item): ?>

                  <tr>
                    <td><?= $item->kode; ?></td>
                    <td><?= $item->nama; ?></td>
                    <td>
                      <a href="<?= base_url('sudo/edit-ptn/'. $item->kode); ?>" rel="tooltip" title="Edit PTN" class="btn btn-info btn-simple btn-xs">
                        <i class="material-icons">description</i> Edit
                      </a>
                      <button class="btn btn-danger btn-simple btn-xs" title="Hapus PTN" rel="tooltip" onclick="hapus(<?= $item->kode; ?>)">
                        <i class="material-icons">close</i> Hapus
                      </button>
                    </td>
                  </tr>

                <?php endforeach; ?>


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
    var j = confirm("Yakin ingin menghapus? Semua prodi pada PTN ini akan terhapus");
    if(j){
      window.location = "<?= site_url('sudo/del-ptn/'); ?>"+ id;
    }
  }
</script>