<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $title ?></title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.4 -->
  <link href="<?php echo base_url()?>assets/template/backend/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="<?php echo base_url()?>assets/template/backend/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/fav.ico" />
</head>
<body class="login-page">
  <div class="col-md-12">
    <!-- </section> -->
    <section class='content'>
      <!-- <div class='row'>     -->
        <?php echo form_open($action);?>
        <br><br><br>
        <!-- kolom kiri -->
        <div class="col-md-4">
        </div>
        <div class="col-md-4"> <?php echo validation_errors() ?>

          <font color="black">
            <div align="center">
              
            <h4><u>KONFIRMASI PEMBAYARAN</u></h4>
            <div><b>
              <!-- Terima kasih telah melakukan Crawling pada Aplikasi ini. <br> -->
              Bila Anda telah melakukan pembayaran secara BANK TRANSFER,
              konfirmasikan pembayaran Anda disini agar dapat kami proses segera.<br>
              Terima kasih 
              <b></div>
              </font>
            </div>

              <div class="box box-primary">
                <div class="box-body">
                  <div class="form-group"><label>Bank Tujuan</label>
                    <select name="bank_tujuan" class="form-control">
                      <option value=""> -- Pilih Bank --</option>
                      <option value="bca">BCA</option>
                      <option value="bni">BNI</option>
                      <option value="bri">BRI</option>
                      <option value="mandiri">MANDIRI</option>
                    </select>
                  </div>
                  <div class="form-group"><label>Bank Anda</label>
                    <?php echo form_input($bank_anda);?>
                  </div>
                  <div class="form-group"><label>Rekening Atas Nama</label>
                    <?php echo form_input($rekening_atas_nama);?>
                  </div>
                  <div class="form-group"><label>Metode Transfer</label>
                    <select name="metode_transfer" class="form-control">
                      <option value=""> -- Pilih Metode Transfer --</option>
                      <option value="atm">ATM</option>
                      <option value="e-Banking">E-Banking</option>
                      <option value="setoran tunai">Setoran Tunai</option>
                      <option value="m-banking">M-Banking</option>
                      <option value="sms-banking">SMS-Banking</option>
                    </select>
                  </div>
                  <div class="form-group"><label>Nominal Transfer</label>
                    <?php echo form_input($nominal_transfer);?>
                  </div>
                  <div class="form-group"><label>Tanggal Transfer</label>
                    <input type="date" class="form-control" name="tanggal_transfer"></input>
            </div><!-- 
            <div class="col-xs-4"><label>Metode Transfer</label>
                <?php echo form_dropdown('', $get_combo_jenisportofolio, '', $jenis_portofolio); ?>
              </div> -->
            </div>
            <div class="box-footer">
              <button type="submit" name="submit" class="btn btn-success"><?php echo $button_submit ?></button>
              <button type="reset" name="reset" class="btn btn-danger"><?php echo $button_reset ?></button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
        </div>



        <?php echo form_close(); ?>
      </div>
    </section>
  </div>

  <!-- jQuery 2.1.4 -->
  <script src="<?php echo base_url()?>assets/template/backend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="<?php echo base_url()?>assets/template/backend/css/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url()?>assets/template/backend/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
</body>
</html>


<?php $this->load->view('back/head'); ?>
<!--  -->