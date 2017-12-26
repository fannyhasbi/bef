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
          <form action="" method="post" enctype="multipart/form-data">
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama" value="<?= $profil->nama; ?>" required disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Foto</label>
                  <input type="file" class="form-control" name="foto" style="opacity: 1; position: inherit;" required>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label">NIS/NISN <small>(salah satu)</small></label>
                  <input type="text" class="form-control" name="nis" value="<?= $profil->nis; ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label">Sekolah</label>
                  <input type="text" class="form-control" name="sekolah" value="<?= $profil->sekolah; ?>" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pilihan Universitas (1)</label>
                  <select class="form-control" name="univ1">
                    <option value="1">Universitas Diponegoro</option>
                    <option value="2">Universitas Negeri Semarang</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pilihan Universitas (2)</label>
                  <select class="form-control" name="univ2">
                    <option value="1">Universitas Diponegoro</option>
                    <option value="2">Universitas Negeri Semarang</option>
                  </select>
                </div>
              </div>
            </div>

            <input type="submit" class="btn btn-primary pull-right" name="simpan" value="Simpan">
            <div class="clearfix"></div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>