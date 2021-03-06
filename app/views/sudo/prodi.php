<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <a href="<?= site_url('sudo/add-prodi'); ?>" class="btn btn-success">
        <i class="material-icons">note_add</i> Tambah
      </a>
    </div>

    <div class="col-md-12">
      <div class="card card-plain">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Daftar Program Studi</h4>
        </div>
        <div class="card-content">
          <div class="iframe-container">
            
            <table id="datatable" class="table table-striped">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>PTN</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach($prodi as $item): ?>

                  <tr>
                    <td><?= $item->kode; ?></td>
                    <td><?= $item->nama; ?></td>
                    <td><?= $item->nama_ptn; ?></td>
                    <td>
                      <a href="<?= base_url('sudo/edit-prodi/'. $item->kode); ?>" rel="tooltip" title="Edit prodi" class="btn btn-info btn-simple btn-xs">
                        <i class="material-icons">description</i> Edit
                      </a>
                      <button class="btn btn-danger btn-simple btn-xs" title="Hapus prodi" rel="tooltip" onclick="hapus(<?= $item->kode; ?>)">
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
    var j = confirm("Yakin ingin menghapus?");
    if(j){
      window.location = "<?= site_url('sudo/del-prodi/'); ?>"+ id;
    }
  }
</script>