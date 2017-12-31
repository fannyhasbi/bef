<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Lengkapi Pilihan Program Studi</h4>
          <p class="category">Silahkan lengkapi data-data dibawah ini.</p>
        </div>
        <div class="card-content">
          
          <!-- Form ubah profil -->
          <form action="<?= site_url('profil'); ?>" method="post" enctype="multipart/form-data">
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">Foto</label>
                  <input type="file" class="form-control" name="foto" style="opacity: 1; position: inherit;" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group label-floating">
                  <label class="control-label">NIS/NISN <small>(salah satu)</small></label>
                  <input type="text" class="form-control" name="nis" required>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group label-floating">
                  <label class="control-label">Sekolah</label>
                  <input type="text" class="form-control" name="sekolah" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group label-floating">
                  <label class="control-label">Jurusan</label>
                  <select class="form-control" name="jurusan">
                    <option value="IPA">IPA</option>
                    <option value="IPS">IPS</option>
                    <option value="Kejuruan">Kejuruan</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pilihan Universitas 1</label>
                  <select id="univ1" class="form-control" name="univ1" onchange="$(this).getProdi('1')">
                    <option value="0">--- Pilih Universitas ---</option>
                    <?php foreach($ptn as $item): ?>
                      <option value="<?= $item->kode; ?>"><?= $item->nama; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pilihan Prodi 1</label>
                  <select id="prodi1" class="form-control" name="prodi1" disabled>
                    <option value="0">--- Pilih Prodi ---</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pilihan Universitas 2</label>
                  <select id="univ2" class="form-control" name="univ2" onchange="$(this).getProdi('2')">
                    <option value="0">--- Pilih Universitas ---</option>
                    <?php foreach($ptn as $item): ?>
                      <option value="<?= $item->kode; ?>"><?= $item->nama; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pilihan Prodi 1</label>
                  <select id="prodi2" class="form-control" name="prodi2" disabled>
                    <option value="0">--- Pilih Prodi ---</option>
                    <option value="1">Teknik Sipil</option>
                    <option value="2">Sastra Inggris</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pilihan Universitas 3</label>
                  <select id="univ3" class="form-control" name="univ3" onchange="$(this).getProdi('3')">
                    <option value="0">--- Pilih Universitas ---</option>
                    <?php foreach($ptn as $item): ?>
                      <option value="<?= $item->kode; ?>"><?= $item->nama; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pilihan Prodi 3</label>
                  <select id="prodi3" class="form-control" name="prodi3" disabled>
                    <option value="0">--- Pilih Prodi ---</option>
                    <option value="1">Teknik Sipil</option>
                    <option value="2">Sastra Inggris</option>
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

<script>
$(document).ready(function(){
  $.fn.getProdi = function(no_form){
    var ptn = $("#univ"+no_form).val();

    $.ajax({
      type: "post",
      url: "<?= site_url('api/v1/prodi'); ?>",
      dataType: "json",
      data: {
        "ptn": ptn,
      },
      success: function(res){
        $("#prodi"+no_form).prop("disabled", false);
        $("#prodi"+no_form).html(res.prodi);
      }
    });
  }
})


</script>