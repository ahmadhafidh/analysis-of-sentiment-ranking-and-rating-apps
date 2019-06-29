<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chart Crawler</title>
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css')?>">


</head>

<body>


    <!--- PRELOADER -->
    <div class="preeloader">
        <div class="preloader-spinner"></div>
    </div>

    <!--SCROLL TO TOP-->
    <a href="#home" class="scrolltotop"><i class="fa fa-long-arrow-up"></i></a>

    <!--START TOP AREA-->
    <header class="top-area" id="home">
        <div class="header-top-area">
            <!--MAINMENU AREA-->
            <div class="mainmenu-area" id="mainmenu-area">
                <div class="mainmenu-area-bg"></div>
                <nav class="navbar">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <!-- <a href="#home" class="navbar-brand"><img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="logo"></a> -->
                        </div>
                        <div id="main-nav" class="stellarnav">
                            <div class="search-and-signup-button white pull-right hidden-md hidden-sm hidden-xs">
                                <!--                                 <button data-toggle="collapse" data-target="#search-form-switcher"><i class="fa fa-search"></i></button> -->
                                <!-- <a href="#" class="sign-up">SignUp</a> -->
                            </div>
                            <ul id="nav" class="nav">

                                <li><a href="#features">Produk</a></li>
                                <!-- <li><a href="#video">Video</a></li> -->
                                <!-- <li><a href="#screenshot">Screenshot</a></li> -->
                                <!-- <li><a href="#team">Team</a></li> -->

                                <li><a href="#pricing">Harga</a></li>
                                <button class="btn btn-default">MULAI GRATIS</button>
                                <!-- <li><a href="#contact">START FREE TRIAL</a></li> -->
                                <!-- <li><a href="#contact">Contact</a></li> -->
                            </ul>
                        </div>
                    </div>
                </nav>
                <div id="search-form-switcher" class="search-collapse-area collapse white">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="white">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END MAINMENU AREA END-->
        </div>

        <!-- <div class="welcome-text-area white"> -->
            <div class="area-bg"></div>
            <div class="welcome-area">
                <div class="container">
                    <div class="row flex-v-center">
<!--                   <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                <div class="welcome-mockup center">
                    <img src="<?php echo base_url('assets/img/home/web_scraping_spider.png'); ?>" alt="">
                </div>
            </div> -->
<!--             <div class="row">
<div class="col-md-2 col-md-offset-5"></div>
</div> -->
    
<!--             <form method="get" action="/page2">
<button type="submit">Continue</button>
</form> -->
<!-- </div> -->
</div>
</div>
</div>
</div>
</header>
<!--END TOP AREA-->

<!--FEATURES TOP AREA-->
<section class="features-top-area padding-100-50" id="features">
<!-- kadal -->
  <div class="container">
    <h3 class="page-header" align="center">Bar Chart Sentimen & ranking<code></code></h3>
    <div class="row">
      <div class="col-md-6">
        <canvas id="myChart" width="400" height="400"></canvas>
      </div>
      <div class="col-md-6">
        <!-- <canvas id="myChart" width="400" height="400"> -->
<table class="table table-bordered">
    <!-- <caption>Balsem Gosok</caption> -->
    <thead>
      <tr>
        <th>No</th>
        <th>ID</th>
        <th>Positif</th>
        <th>Negatif</th>
        <th>Hasil Sentimen<br>(positif-negatif)</th>
        <th>Urutan</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $i = 1;
      foreach ($hasil as $key => $hasil): ?>
      <tr>
        <td><?= $i ?></td>
        <td><?= $id[$key] ?></td>
        <td><?= $positif[$key] ?></td>
        <td><?= $negatif[$key] ?></td>
        <td><?= $hasil ?></td>
        <td><?= $i ?></td>
        
      </tr>
      <?php
      $i++;
      endforeach; ?>
    </tbody>
  </table>
  <br>
        <div>
            <font color="black"><u>Ingin Melakukan Crawling Lagi??</u>
                <button type="button" class="btn btn-danger" ><a href="<?php echo base_url('Home')?>"><font color="white">Klik disini</font></a></button>
            </font>
        </div>
<!-- </canvas> -->
      </div>
    </div>
  </div>
  <script src="<?=base_url('assets/js/jquery-3.3.1.min.js')?>"></script>
  <!-- <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script> -->
  <script src="<?=base_url('assets/js/Chart.js')?>"></script>
  <script>
  
    var json_file = <?=file_get_contents(base_url('seleksi_crawling'))?>;
    console.log(json_file);

  var positif = json_file.map(function(e) {
    return (e.positif == 0) ? "0.01" : e.positif;
  });

  var negatif = json_file.map(function(e) {
    return (e.negatif == 0) ? "-0.01" : "-" + e.negatif;
  });

  var id_tes = json_file.map(function(e) {
    return e.id_tes;
  });

  var ctx = document.getElementById("myChart");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: id_tes,
      datasets: [{
          label: 'Positif',
          data: positif,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        },
        {
          label: 'Negatif',
          data: negatif,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255,99,132,1)',
          borderWidth: 1
        }
      ]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: false
          }
        }]
      }
    }
  });
  </script>
</section>
  
</body>

</html>