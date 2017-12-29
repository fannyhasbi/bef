<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Ubah Password</h4>
        </div>
        <div class="card-content">
          
          <!-- Form ubah profil -->
          <form action="" method="post">
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group label-floating">
                  <label class="control-label">Password Baru</label>
                  <input type="password" id="password" class="form-control" name="password">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group label-floating">
                  <label class="control-label">Ulangi Password</label>
                  <input type="password" id="password2" class="form-control" name="password2">
                </div>
              </div>
            </div>

            <input type="submit" id="btn" class="btn btn-primary pull-right" name="ganti" value="Ubah Password">
            <div class="clearfix"></div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>