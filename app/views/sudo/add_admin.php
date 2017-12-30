<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Ubah Profil</h4>
          <p class="category">Silahkan lengkapi data diri dibawah ini.</p>
        </div>
        <div class="card-content">
          
          <!-- Form ubah profil -->
          <form action="" method="post">
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label">Username</label>
                  <input type="text" class="form-control" name="username" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama" required>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label">Password</label>
                  <input type="password" class="form-control" name="password" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label">Ulangi password</label>
                  <input type="password" class="form-control" name="password2" required>
                </div>
              </div>
            </div>

            <input type="submit" class="btn btn-success pull-right" name="tambah" value="Tambah">
            <div class="clearfix"></div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>