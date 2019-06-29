<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<!-- 
<link href="<?php echo base_url()?>assets/loader/loader.css" rel="stylesheet" />   -->
    <!-- <div id="loader"></div>
    <div style="display:none;" id="myDiv" class="animate-bottom"> -->
        
<script type="text/javascript">
    $(function() {
        $('#colorselector').change(function(){
            $('.colors').hide();
            $('#' + $(this).val()).show();
        });
    });
</script>






<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

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
                            <button class="btn btn-default">LOGIN</button>
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
    <div class="welcome-text-area white">
        <div class="area-bg"></div>
        <div class="welcome-area">
            <div class="container">
                <div class="row flex-v-center">
                    <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                        <div class="welcome-mockup center">
                            <img src="<?php echo base_url('assets/img/home/web_scraping_spider.png'); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                        <!-- <div class="welcome-text"> -->
                       <!--      <h1>Welcome To Massive App Store.</h1>

                       -->                    
                       <Select class="form-control" style="color:black" id="colorselector">
                         <option style="color:black" value="">--Pilih Sesuai Kebutuhan--</option>
                         <option style="color:black"value="S">Sentimen</option>
                         <option style="color:black"value="R">Rating</option>
                         <option style="color:black"value="SR">Sentimen dan Ranking</option>
                         <option style="color:black"value="RR">Rating dan Ranking</option>
                     </Select>
                     <div id="S" class="colors" style="display:none"> S

                       <form method="post" action="<?php echo site_url('Crawling/showResultSentimen');?>">
                            <!-- <select class="form-control">
                                <option>--Pilih </option>
                                <option>Sentimen</option>
                                <option>Sentimen and Ranking</option>
                                <option>Rating</option>
                            </select> -->

                            <input style="height: 50px" type="text" name="search" placeholder="Search Here" class="form-control"><br>

                            <button type="submit" style="height: 50%; width: 20%" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <div id="R" class="colors" style="display:none"> R 
                        <form method="post" action="<?php echo site_url('Crawling/showResult');?>">
                            <!-- <select class="form-control">
                                <option>--Pilih </option>
                                <option>Sentimen</option>
                                <option>Sentimen and Ranking</option>
                                <option>Rating</option>
                            </select> -->

                            <input style="height: 50px" type="text" name="search" placeholder="Search Here" class="form-control"><br>
                            
                            <input type="radio" name="selected_rating" value="1"> Jasa Pengiriman<br>
                            <input type="radio" name="selected_rating" value="2"> Pariwisata<br>
                            <input type="radio" name="selected_rating" value="3"> Organisasi<br><br>

                            <button type="submit" style="height: 50%; width: 20%" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <div id="SR" class="colors" style="display:none"> SR

                       <form method="post" action="<?php echo site_url('Crawling/showResultSentimenRanking');?>">
                            <!-- <select class="form-control">
                                <option>--Pilih </option>
                                <option>Sentimen</option>
                                <option>Sentimen and Ranking</option>
                                <option>Rating</option>
                            </select> -->

                            <input style="height: 50px" type="text" name="search" placeholder="Search Here" class="form-control"><br>

                            <input style="height: 30px" type="text" name="searchRival1" placeholder="Masukkan Rival" class="form-control" required>
                            <input style="height: 30px" type="text" name="searchRival2" placeholder="Masukkan Rival" class="form-control" required>
                            <input style="height: 30px" type="text" name="searchRival3" placeholder="Masukkan Rival" class="form-control" required>
                            <input style="height: 30px" type="text" name="searchRival4" placeholder="Masukkan Rival" class="form-control" required><br>

                            <button type="submit" style="height: 50%; width: 20%" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <div id="RR" class="colors" style="display:none"> RR
                        <form method="post" action="<?php echo site_url('Crawling/showResultRatingRanking');?>">
                            <!-- <select class="form-control">
                                <option>--Pilih </option>
                                <option>Sentimen</option>
                                <option>Sentimen and Ranking</option>
                                <option>Rating</option>
                            </select> -->

                            <input style="height: 50px" type="text" name="search" placeholder="Cari disini" class="form-control"><br>
                            
                            <!-- iki nif -->
                            <input style="height: 30px" type="text" name="searchRival1" placeholder="Masukkan Rival" class="form-control" required>
                            <input style="height: 30px" type="text" name="searchRival2" placeholder="Masukkan Rival" class="form-control" required>
                            <input style="height: 30px" type="text" name="searchRival3" placeholder="Masukkan Rival" class="form-control" required>
                            <input style="height: 30px" type="text" name="searchRival4" placeholder="Masukkan Rival" class="form-control" required>
                            <br>
                            <input type="radio" name="selected_rating" value="1"> Jasa Pengiriman<br>
                            <input type="radio" name="selected_rating" value="2"> Pariwisata<br>
                            <input type="radio" name="selected_rating" value="3"> Organisasi<br>

                            <button type="submit" style="height: 50%; width: 20%" class="btn btn-primary">Search</button>
                        </form>
                    </div>





                </div>
            </div>
        </div>
    </div>
</div>
</div>
</header>
<!--END TOP AREA-->

<!--FEATURES TOP AREA-->
<section class="features-top-area padding-100-50" id="features">
    <div class="container">
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
    </div>
</section>
<!--FEATURES TOP AREA END-->

