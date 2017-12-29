<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Tambah Perguruan Tinggi Negeri</h4>
          <p class="category">Silahkan lengkapi data PTN dibawah ini.</p>
        </div>
        <div class="card-content">
          
          <!-- Form ubah profil -->
          <form action="" method="post">
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group label-floating">
                  <label class="control-label">Kode</label>
                  <input type="text" class="form-control" name="kode" required autofocus>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group label-floating">
                  <label class="control-label">Nama PTN</label>
                  <input type="text" class="form-control" name="nama" required>
                </div>
              </div>
            </div>

            <input type="submit" class="btn btn-success pull-left" name="tambah" value="Tambah">
            <div class="clearfix"></div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>