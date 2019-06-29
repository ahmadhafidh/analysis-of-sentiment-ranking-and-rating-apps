jQuery(function($) {
  "use strict";

  $('#MyForm1').ajaxForm({
    beforeSend:function(){

    },
    success:function(){
    },
    complete:function(data)
    {
      $('.modal').modal('hide');
      $('#myModal2').modal('show');

      // $('#example').DataTable().ajax.reload(null, false);
      // swal("Good job!", "You clicked the button!", "success");
    }
  });

  $('#MyForm2').ajaxForm({
    beforeSend:function(){

    },
    success:function(){
    },
    complete:function(data)
    {
      $('.modal').modal('hide');
      $('#myModal3').modal('show');

      // $('#example').DataTable().ajax.reload(null, false);
      // swal("Good job!", "You clicked the button!", "success");
    }
  });

  $('#MyForm3').ajaxForm({
    beforeSend:function(){

    },
    success:function(){
    },
    complete:function(data)
    {
      $('.modal').modal('hide');
      // $('#myModal3').modal('show');
      alert('Berhasil tambah data');
      // swal("Selamat!", "Anda berhasil mendaftar!", "success");
    }
  });

  $('#Message').ajaxForm({
    beforeSend:function(){

    },
    success:function(){
    },
    complete:function(data)
    {
      $('#Message')[0].reset();
      alert('Pesan telah terkirim');
    }
  });

});
