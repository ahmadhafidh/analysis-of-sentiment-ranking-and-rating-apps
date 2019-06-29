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
<!--         <a href="<?php echo base_url('admin/konfirmasi/create') ?>">
          <button class="btn btn-success"><i class="fa fa-plus"></i> Tambah Konfirmasi Baru</button>
        </a>  -->
        
        <h4 align="center"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
        
        <hr/>
        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th style="text-align: center">No.</th>
              <th style="text-align: center">Bank Tujuan</th>
              <th style="text-align: center">Bank Anda</th>
              <th style="text-align: center">Rekening Atas Nama</th>
              <th style="text-align: center">Metode Transfer</th>
              <th style="text-align: center">Nominal Transfer</th>
              <th style="text-align: center">Tanggal Transfer</th>
              <!-- <th style="text-align: center">Aksi</th> -->
            </tr>
          </thead>
          <tbody>
            <?php
            $no=0;
            foreach ($konfirmasi_data as $konfirmasi){ $no++;?>
            <tr>
              <td style="text-align:center"><?php echo $no; ?></td>
              <td style="text-align:center"><?php echo $konfirmasi->bank_tujuan ?></td>
              <td style="text-align:center"><?php echo $konfirmasi->bank_anda ?></td>
              <td style="text-align:center"><?php echo $konfirmasi->rekening_atas_nama ?></td>
              <td style="text-align:center"><?php echo $konfirmasi->metode_transfer ?></td>
              <td style="text-align:center"><?php echo $konfirmasi->nominal_transfer ?></td>
              <td style="text-align:center"><?php echo $konfirmasi->tanggal_transfer ?></td>
              <!-- <td style="text-align:center">
              <?php 
              echo anchor(site_url('admin/kategori/update/'.$kategori->id_kategori),'<i class="glyphicon glyphicon-pencil"></i>','title="Edit", class="btn btn-sm btn-warning"'); echo ' ';
              echo anchor(site_url('admin/kategori/delete/'.$kategori->id_kategori),'<i class="glyphicon glyphicon-trash"></i>','title="Hapus", class="btn btn-sm btn-danger", onclick="javasciprt: return confirm(\'Apakah Anda yakin ?\')"');  
              ?>
              </td> -->
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