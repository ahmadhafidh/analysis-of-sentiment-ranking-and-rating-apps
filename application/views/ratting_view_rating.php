
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
<!-- &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
-->
<!-- <div align="center"> -->

<div class="col-md-12">
   <div class="row">
     <div class="col-md-2"></div>
     <div class="col-md-4">
      <?php
        $aff = $this->db->query('SELECT `nilai` FROM `nilai` WHERE id=1')->result_array();

        foreach ($aff as $value) {
            foreach ($value as $value1) {
                $kk = $value1;

                echo "<font color='white'>Hasil nilai Ratingnya adalah</font>"." ". "<font color='white'>".$kk."</font>";
            }
        }

        ?>

        <?php $percentage = floor(($kk*4))*5;?>
        <?php $convert_persen = $percentage/20?>

        <div class="star-rating-stars" style="width: <?php echo $convert_persen*16?>px">
            <?php echo ($percentage/100)*5 ?>/5
        </div>
    </div>

    
     <div class="col-md-4">
         
         <font color="white"><u>Ingin Melakukan Crawling Lagi??</u>
                <button type="button" class="btn btn-danger" ><a href="<?php echo base_url('Home')?>"><font color="white">Klik disini</font></a></button>
            </font>
     </div>
     <div class="col-md-2"></div>

   </div>
</div>


</div>

</div>

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
<!-- <div class="container">
<div class="row">
<div class="col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3 col-sm-12 col-xs-12">
    <div class="area-title text-center wow fadeIn">
        <h2>welcome to <span>app features</span></h2>
        <span class="icon-and-border"><i class="material-icons">phone_android</i></span>
        <p>Rapidiously monetize state of the art ROI rather than quality. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim neque aliquid.</p>
    </div>
</div>
</div>
<div class="row">
<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
    <div class="qs-box relative mb50 center wow fadeInUp" data-wow-delay="0.2s">
        <div class="qs-box-icon">
            <i class="material-icons">cloud_off</i>
        </div>
        <h3>Premium Quality</h3>
        <p>Lorem Ipsum is a simply dummy texts of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
        <a href="#" class="read-more">Learn More</a>
    </div>
</div>
<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
    <div class="qs-box relative mb50 center  wow fadeInUp" data-wow-delay="0.3s">
        <div class="qs-box-icon">
            <i class="material-icons">forum</i>
        </div>
        <h3>Chat with love</h3>
        <p>Lorem Ipsum is a simply dummy texts of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
        <a href="#" class="read-more">Learn More</a>
    </div>
</div>
<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
    <div class="qs-box relative mb50 center  wow fadeInUp" data-wow-delay="0.4s">
        <div class="qs-box-icon">
            <i class="material-icons">3d_rotation</i>
        </div>
        <h3>3d Display</h3>
        <p>Lorem Ipsum is a simply dummy texts of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
        <a href="#" class="read-more">Learn More</a>
    </div>
</div>
</div>
</div> -->
</section>
