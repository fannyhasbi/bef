<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">

    <div class="col-md-12">
      <a href="<?= site_url('sudo/add-admin'); ?>" class="btn btn-success">
        <i class="material-icons">note_add</i> Tambah
      </a>
    </div>

    <div class="col-md-12">
      <div class="card card-plain">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Daftar Admin BEF 2018</h4>
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
                foreach($admin as $item):
                ?>
                  
                  <tr>
                    <td><?= $i; ?></td>
                    <td><?= $item->username; ?></td>
                    <td><?= $item->nama; ?></td>
                    <td>
                      <a href="<?= base_url('sudo/del-admin/'. $item->id); ?>" rel="tooltip" title="Hapus" class="btn btn-danger btn-simple btn-xs">
                        <i class="material-icons">highlight_off</i> Hapus
                      </a>
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
</script>