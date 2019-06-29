<?php $this->load->view('back/head'); ?>
<?php $this->load->view('back/header'); ?>
<?php $this->load->view('back/leftbar'); ?>      

<div class="content-wrapper">
  <section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><?php echo $module ?></li>
      <li class="active"><a href="<?php echo current_url() ?>"><?php echo $title ?></a></li>
    </ol>
  </section>
  <section class='content'>
    <div class='row'>    
      <?php echo form_open_multipart($action);?>
        <div class="col-md-12"> <?php echo validation_errors() ?> </div> 
        <!-- kolom kiri -->
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-body">
              <div class="form-group"><label>Judul Blog</label>
                <?php echo form_input($judul_blog);?>
              </div>
              <div class="form-group"><label>Isi blog</label>
                <?php echo form_textarea($isi_blog);?>
              </div>
            </div>
          </div>
        </div>

        <!-- kolom kanan -->
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-4"><label>Author</label>
                  <?php echo form_input($author);?>
                </div>
                <div class="col-xs-4"><label>Kategori</label>
                  <?php echo form_dropdown('', $get_combo_kategori, '', $kategori); ?>
                </div>
                <div class="col-xs-4"><label>Status Publish</label>
                  <?php echo form_dropdown('', $publish, '', $publish_css); ?>
                </div>
              </div><br>
              <div class="form-group"><label>Gambar</label>
                <input type="file" class="form-control" name="userfile" id="userfile" onchange="tampilkanPreview(this,'preview')"/>
                <br><p><b>Preview Gambar</b><br>
                <img id="preview" src="" alt="" width="350px"/>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submit" class="btn btn-success"><?php echo $button_submit ?></button>
              <button type="reset" name="reset" class="btn btn-danger"><?php echo $button_reset ?></button>
            </div>
          </div>
        </div>

      <?php echo form_close(); ?>
    </div>
  </section>
</div>

<script type="text/javascript">
function tampilkanPreview(userfile,idpreview)
{ //membuat objek gambar
  var gb = userfile.files;
  //loop untuk merender gambar
  for (var i = 0; i < gb.length; i++)
  { //bikin variabel
    var gbPreview = gb[i];
    var imageType = /image.*/;
    var preview=document.getElementById(idpreview);            
    var reader = new FileReader();
    if (gbPreview.type.match(imageType)) 
    { //jika tipe data sesuai
      preview.file = gbPreview;
      reader.onload = (function(element) 
      {
        return function(e) 
        {
          element.src = e.target.result;
        };
      })(preview);
      //membaca data URL gambar
      reader.readAsDataURL(gbPreview);
    }
      else
      { //jika tipe data tidak sesuai
        alert("Tipe file tidak sesuai. Gambar harus bertipe .png, .gif atau .jpg.");
      }
  }    
}
</script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
function ajaxfilemanager(field_name, url, type, win) 
{
 var ajaxfilemanagerurl = "<?php echo base_url() ?>assets/plugins/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
 switch (type) {
  case "image":
   break;
  case "media":
   break;
  case "flash": 
   break;
  case "file":
   break;
  default:
   return false;
 }
  tinyMCE.activeEditor.windowManager.open(
  {
      url: "<?php echo base_url() ?>assets/plugins/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
      width: 782,
      height: 440,
      inline : "yes",
      close_previous : "no"
  },
  {
      window : win,
      input : field_name
  });
}
</script>

<script type="text/javascript">
tinyMCE.init(
{

// General options
mode : "textareas",
elements : "ajaxfilemanager",
file_browser_callback : 'ajaxfilemanager',

theme : "advanced",
plugins : "fullscreen,safari,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,print,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

// Theme options
theme_advanced_buttons1 : "fullscreen,undo,redo,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect,insertfile,insertimage",
theme_advanced_buttons3 : "sub,sup,search,replace,|,bullist,numlist,|,outdent,indent,emotions,iespell,media,advhr",
theme_advanced_buttons4 : "image,charmap,preview,forecolor,backcolor,hr,removeformat,link,unlink,anchor,cite,visualaid",
theme_advanced_buttons5 : "tablecontrols",

theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
relative_urls : false,
remove_script_host : false,
});
</script>

<?php $this->load->view('back/footer'); ?>      