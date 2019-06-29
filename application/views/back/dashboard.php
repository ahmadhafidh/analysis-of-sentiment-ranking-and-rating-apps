<?php $this->load->view('back/head'); ?>
<?php $this->load->view('back/header'); ?>
<?php $this->load->view('back/leftbar'); ?>      

<div class="content-wrapper">
  <div class="box-body">
    <div class="callout callout-success "><i class='fa fa-bullhorn'></i> Selamat Datang <b><?php echo $this->session->userdata('nama') ?></b>
    </div>
  </div>

  <section class='content'>
    <div class='row'>
     <div class='col-lg-4 col-xs-4'>

        <div class='small-box bg-yellow'>
          <div class='inner'><h3> <br></h3><p>Dataset</p></div>
          <div class='icon'><i class='fa fa-tags'></i></div>
          <a href='<?php echo base_url('admin/seleksi_teks') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
        </div>
        <div class='small-box bg-blue'>
          <div class='inner'><h3> <?php echo $total_konfirmasi ?> </h3><p>Konfirmasi</p></div>
          <div class='icon'><i class='fa fa-user'></i></div>
          <a href='<?php echo base_url('admin/konfirmasi') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
        </div> 
        
        <div class='small-box bg-gray'>
          <div class='inner'><h3> <?php echo $total_user ?> </h3><p>User</p></div>
          <div class='icon'><i class='fa fa-user'></i></div>
          <a href='<?php echo base_url('admin/auth/user') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
        </div>
       <!-- <div class='small-box bg-yellow'>
        <div class='inner'><h3> <?php echo $total_blog ?> </h3><p>Blog</p></div>
        <div class='icon'><i class='fa fa-newspaper-o'></i></div>
        <a href='<?php echo base_url('admin/blog') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
      </div> -->
      
      <!-- <div class='small-box bg-yellow'>
        <div class='inner'><h3> <?php echo $total_portofolio ?> </h3><p>Portofolio</p></div>
        <div class='icon'><i class='fa fa-newspaper-o'></i></div>
        <a href='<?php echo base_url('admin/portofolio') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
      </div>
      <div class='small-box bg-red'>
        <div class='inner'><h3> <?php echo $total_featured ?> </h3><p>Featured</p></div>
        <div class='icon'><i class='fa fa-credit-card'></i></div>
        <a href='<?php echo base_url('admin/featured') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
      </div> -->
      
      
    </div>
    <div class='col-lg-4 col-xs-4'>
      

      <!-- <div class='small-box bg-purple'>
        <div class='inner'><h3> <?php echo $total_komen ?> </h3><p>Total Komentar</p></div>
        <div class='icon'><i class='fa fa-comments'></i></div>
        <a href='<?php echo base_url('admin/komentar') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
      </div>
      
      <div class='small-box bg-aqua'>
        <div class='inner'><h3> <?php echo $total_komen_pending ?> </h3><p>Komentar Baru</p></div>
        <div class='icon'><i class='fa fa-comment'></i></div>
        <a href='<?php echo base_url('admin/komentar/pending') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
      </div> -->
      
<!--         <div class='small-box bg-red'>
          <div class='inner'><h3> <?php echo $total_featured ?> </h3><p>Featured</p></div>
          <div class='icon'><i class='fa fa-credit-card'></i></div>
          <a href='<?php echo base_url('admin/featured') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
        </div> -->
        

      </div>
      <div class='col-lg-4 col-xs-4'>
        
<!--         <div class='small-box bg-blue'>
          <div class='inner'><h3> <?php echo $total_jenisportofolio ?> </h3><p>Jenis Portofolio</p></div>
          <div class='icon'><i class='fa fa-tags'></i></div>
          <a href='<?php echo base_url('admin/jenisportofolio') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
        </div> -->

  <!--       <div class='small-box bg-gray'>
          <div class='inner'><h3> <?php echo $total_user ?> </h3><p>User</p></div>
          <div class='icon'><i class='fa fa-user'></i></div>
          <a href='<?php echo base_url('admin/auth/user') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
        </div> -->

<!--         <div class='small-box bg-gray'>
        <div class='inner'><h3> <?php echo $total_clientsay ?> </h3><p>Clientsay</p></div>
          <div class='icon'><i class='fa fa-user'></i></div>
          <a href='<?php echo base_url('admin/clientsay') ?>' class='small-box-footer'>Selengkapnya <i class='fa fa-arrow-circle-right'></i></a>
        </div>   -->      
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('back/footer'); ?>      