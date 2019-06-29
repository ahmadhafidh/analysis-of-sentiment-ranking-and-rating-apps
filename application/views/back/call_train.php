

<?php $this->load->view('back/head'); ?>
<?php $this->load->view('back/header'); ?>
<?php $this->load->view('back/leftbar'); ?>      

<div class="content-wrapper">
  <section class="content-header">
    <h1>Tambah Dataset dan Training data</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home &nbsp > &nbsp Dataset &nbsp > &nbsp Tambah Dataset dan Training Data</a></li>
    </ol>
  </section>
  <section class='content'>
    <div class='row'>    
    <?= form_open_multipart(site_url('admin/seleksi_teks/upload_train'))?>

        <div class="col-md-12"> 
    <?= $_alert ?>
         </div> 
        <!-- kolom kiri -->
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-body">
              <div class="form-group">
                <label> Upload Dataset</label>
        <input type="file" name="fileImport" id="txtFileImport">
              </div>
            </div>
            <div class="box-footer">
        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                <!-- 
              <button type="submit" name="submit" class="btn btn-success"><?php echo $button_submit ?></button> -->
              <!-- <button type="reset" name="reset" class="btn btn-danger"><?php echo $button_reset ?></button> -->
            </div>
          </div>
        </div>

    <?= form_close()?>     

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-body">
              <div class="form-group">
                <label> Training Data</label>
                <br>
                <br>
                      

              </div>
            </div>
            <div class="box-footer">
                <input type="button" class="btn btn-success" value="TRAIN" onclick="window.location.href='<?= base_url() ?>admin/seleksi_teks/train'" /> 
                <!-- 
              <button type="submit" name="submit" class="btn btn-success"><?php echo $button_submit ?></button> -->
              <!-- <button type="reset" name="reset" class="btn btn-danger"><?php echo $button_reset ?></button> -->
            </div>
          </div>
        </div>
    </div>
  </section>
</div>