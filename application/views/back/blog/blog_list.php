<?php $this->load->view('back/head'); ?>
<?php $this->load->view('back/header'); ?>
<?php $this->load->view('back/leftbar'); ?>      

<div class="content-wrapper">
  <section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><?php echo $module ?></li>
      <li class="active"><a href="<?php echo current_url() ?>"><?php echo $title ?></a></li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-primary">
      <div class="box-body table-responsive padding">
        <a href="<?php echo base_url('admin/blog/create') ?>">
          <button class="btn btn-success"><i class="fa fa-plus"></i> Tambah blog Baru</button>
        </a> 
        
        <h4 align="center"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
        
        <hr/>
        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th style="text-align: center">No.</th>
              <th style="text-align: center">Judul Blog</th>
              <th style="text-align: center">Kategori</th>
              <th style="text-align: center">Img</th>
              <th style="text-align: center">Author</th>
              <th style="text-align: center">Uploader</th>
              <th style="text-align: center">Tgl</th>
              <th style="text-align: center">Publish</th>
              <th style="text-align: center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no=0;
            foreach ($blog_data as $blog){ $no++;?>
            <tr>
              <td style="text-align:center"><?php echo $no; ?></td>
              <td style="text-align:left"><?php echo $blog->judul_blog ?></td>
              <td style="text-align:center"><?php echo $blog->kategori ?></td>
              <td style="text-align:center">
                <?php 
                if(empty($blog->userfile)) {echo "<img src='".base_url()."assets/images/no_image_thumb.png' width='100'>";}  
                else { echo " <img src='".base_url()."assets/images/blog/".$blog->userfile.'_thumb'.$blog->userfile_type."' width='100'> ";}
                ?>
              </td>
              <td style="text-align:center"><?php echo $blog->author ?></td>
              <td style="text-align:center"><?php echo $blog->uploader ?></td>
              <td style="text-align:center"><?php echo $blog->time_upload ?></td>
              <td style="text-align:center"><?php echo $blog->publish ?></td>
              <td style="text-align:center">
              <?php 
              echo anchor(site_url('admin/blog/update/'.$blog->id_blog),'<i class="glyphicon glyphicon-pencil"></i>','title="Edit", class="btn btn-sm btn-warning"'); echo ' ';
              echo anchor(site_url('admin/blog/delete/'.$blog->id_blog),'<i class="glyphicon glyphicon-trash"></i>','title="Hapus", class="btn btn-sm btn-danger", onclick="javasciprt: return confirm(\'Apakah Anda yakin ?\')"');  
              ?>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- DATA TABLES SCRIPT -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
function confirmDialog() {
 return confirm('Apakah anda yakin?')
}
  $('#datatable').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aaSorting": [[0,'desc']],
    "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "Semua"]]
  });
</script>

<?php $this->load->view('back/footer'); ?>      