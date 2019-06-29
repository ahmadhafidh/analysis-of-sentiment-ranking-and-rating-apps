<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//error_reporting(0);
//require ("util.php");
require ("lib/simple_html_dom.php");
ini_set('max_execution_time', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
error_reporting(0);

class Crawler extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();


        $this->load->database();
        //$this->load->model("model_textprocessing");
        $this->load->helper(array("url", "form"));

    }

    //crawling proses
    public function showResult()
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $tanggal = getdate();
        $tanggal1= $tanggal['year'];
         $id_crawl1 = 1;
        $id_crawl2 = 2;
        $id_crawl3 = 3;
        $id_crawl4 = 4;
        $id_crawl5 = 5;

    
        $selected_rating = $this->input->post('selected_rating'); 

        $keyword1 = $this->input->post('search');
        $keyword = $keyword1." ".$tanggal1;

//        if ($prefix = "kinerja" || "jasa"){
//            $string = strpos($keyword, $prefix) + strlen($prefix);
//            $str = substr($keyword, $string);
//        }

        $search_query = str_replace(' ', '+', $keyword);
        $total = 1;
        

        $this->db->truncate('data_crawling');
        $crawling = array();
        $resultALL = []; //menampung semua kata dari semua blog
        $dataResult = [];
        $totalResult = 0;
        //for ($i=0;$i<10;$i++){
        for ($i=0;$i<3;$i++){
            //GET DATA FROM GOOGLE CUSTOM SEARCH ENGINE
            $start= ($total*$i) + 1;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCqjhiFcTF4jyqDb-Cre5U_Ko255fe5aZ0&cx=009697247467493233773:yzx7ibazkgk&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCcomXXfI2KsOdURy-YGEOnVA4dLw7336E&cx=013263571767881537586:w2jkjyd8pis&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCcomXXfI2KsOdURy-YGEOnVA4dLw7336E&cx=013263571767881537586:udbtjd8w4ss&q=".$search_query;
            $google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBNM_gH2j4PvFz7_jsdVzxKS4xcr0sGJ8c&cx=007816592670394136699:zcn0ssfp0ig=".$search_query;
            $google_data = file_get_contents($google_url, false, stream_context_create($arrContextOptions));
            $dataku = json_decode($google_data);
            //GET DATA FROM GOOGLE CUSTOM SEARCH ENGINE
            $no = $start;
            $konten = array();

            foreach ($dataku->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keyword)."','".$this->db->escape_str($id_crawl1)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }
        }

            $data_crawling["dataku"] = $crawling;
            //$asf["datanya"] = $row;
        $data['title'] = '';
        $data['header'] = '';
        $data['content'] = $this->load->view('home_view', $data_crawling, true);
        $data['script'] = '';
        $this->load->view('template/header');
        $this->load->view('template/footer');
        redirect('/Text_preprocessing');


    }

    //crawling proses sentimen
    public function showResultSentimen()
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $tanggal = getdate();
        $tanggal1= $tanggal['year'];
         $id_crawl1 = 1;
        $id_crawl2 = 2;
        $id_crawl3 = 3;
        $id_crawl4 = 4;
        $id_crawl5 = 5;

    
        $selected_rating = $this->input->post('selected_rating'); 

        $keyword1 = $this->input->post('search');
        $keyword = $keyword1." ".$tanggal1;

//        if ($prefix = "kinerja" || "jasa"){
//            $string = strpos($keyword, $prefix) + strlen($prefix);
//            $str = substr($keyword, $string);
//        }

        $search_query = str_replace(' ', '+', $keyword);
        $total = 1;
        

        $this->db->truncate('data_crawling');
        $crawling = array();
        $resultALL = []; //menampung semua kata dari semua blog
        $dataResult = [];
        $totalResult = 0;
        //for ($i=0;$i<10;$i++){
        for ($i=0;$i<3;$i++){
            //GET DATA FROM GOOGLE CUSTOM SEARCH ENGINE
            $start= ($total*$i) + 1;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCqjhiFcTF4jyqDb-Cre5U_Ko255fe5aZ0&cx=009697247467493233773:yzx7ibazkgk&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCcomXXfI2KsOdURy-YGEOnVA4dLw7336E&cx=013263571767881537586:w2jkjyd8pis&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCcomXXfI2KsOdURy-YGEOnVA4dLw7336E&cx=013263571767881537586:udbtjd8w4ss&q=".$search_query;
            $google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBNM_gH2j4PvFz7_jsdVzxKS4xcr0sGJ8c&cx=007816592670394136699:zcn0ssfp0ig=".$search_query;
            $google_data = file_get_contents($google_url, false, stream_context_create($arrContextOptions));
            $dataku = json_decode($google_data);
            //GET DATA FROM GOOGLE CUSTOM SEARCH ENGINE
            $no = $start;
            $konten = array();

            foreach ($dataku->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keyword)."','".$this->db->escape_str($id_crawl1)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }
        }

            $data_crawling["dataku"] = $crawling;
            //$asf["datanya"] = $row;
        $data['title'] = '';
        $data['header'] = '';
        $data['content'] = $this->load->view('home_view', $data_crawling, true);
        $data['script'] = '';
        $this->load->view('template/header');
        $this->load->view('template/footer');
         redirect('/piechart');


    }

    //crawling proses sentimen ranking
    public function showResultSentimenRanking()
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $tanggal = getdate();
        $tanggal1= $tanggal['year'];
        $id_crawl1 = 1;
        $id_crawl2 = 2;
        $id_crawl3 = 3;
        $id_crawl4 = 4;
        $id_crawl5 = 5;

    
        $selected_rating = $this->input->post('selected_rating'); 

        $keyword1 = $this->input->post('search');

        $getstring = substr($keyword1, 0);
        $textWithoutLastWord = preg_replace('/\W\w+\s*(\W*)$/', '$1', $getstring); 

        $keyword = $keyword1." ".$tanggal1;

        $keywordSearchRival1 = $this->input->post('searchRival1');
        $keywordSearchRival2 = $this->input->post('searchRival2');
        $keywordSearchRival3 = $this->input->post('searchRival3');
        $keywordSearchRival4 = $this->input->post('searchRival4');

        $keywordrival = $textWithoutLastWord." ".$keywordSearchRival1." ".$tanggal1;
        $keywordrival2 = $textWithoutLastWord." ".$keywordSearchRival2." ".$tanggal1;
        $keywordrival3 = $textWithoutLastWord." ".$keywordSearchRival3." ".$tanggal1;
        $keywordrival4 = $textWithoutLastWord." ".$keywordSearchRival4." ".$tanggal1;

//        if ($prefix = "kinerja" || "jasa"){
//            $string = strpos($keyword, $prefix) + strlen($prefix);
//            $str = substr($keyword, $string);
//        }

        $search_query = str_replace(' ', '+', $keyword);
        $search_query2 = str_replace(' ', '+', $keywordrival);
        $search_query3 = str_replace(' ', '+', $keywordrival2);
        $search_query4 = str_replace(' ', '+', $keywordrival3);
        $search_query5 = str_replace(' ', '+', $keywordrival4);
        $total = 1;
        

        $this->db->truncate('data_crawling');
        $crawling = array();
        $resultALL = []; //menampung semua kata dari semua blog
        $dataResult = [];
        $totalResult = 0;
        //for ($i=0;$i<10;$i++){
        for ($i=0;$i<1;$i++){
            //GET DATA FROM GOOGLE CUSTOM SEARCH ENGINE
            $start= ($total*$i) + 1;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCqjhiFcTF4jyqDb-Cre5U_Ko255fe5aZ0&cx=009697247467493233773:yzx7ibazkgk&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCcomXXfI2KsOdURy-YGEOnVA4dLw7336E&cx=013263571767881537586:w2jkjyd8pis&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCcomXXfI2KsOdURy-YGEOnVA4dLw7336E&cx=013263571767881537586:udbtjd8w4ss&q=".$search_query;

            $google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query;
            $google_url2 = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query2;
            $google_url3 = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query3;
            $google_url4 = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query4;
            $google_url5 = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query5;

            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBNM_gH2j4PvFz7_jsdVzxKS4xcr0sGJ8c&cx=007816592670394136699:zcn0ssfp0ig=".$search_query;
            $google_data = file_get_contents($google_url, false, stream_context_create($arrContextOptions));
            $google_data2 = file_get_contents($google_url2, false, stream_context_create($arrContextOptions));
            $google_data3 = file_get_contents($google_url3, false, stream_context_create($arrContextOptions));
            $google_data4 = file_get_contents($google_url4, false, stream_context_create($arrContextOptions));
            $google_data5 = file_get_contents($google_url5, false, stream_context_create($arrContextOptions));

            $dataku = json_decode($google_data);
            $dataku2 = json_decode($google_data2);
            $dataku3 = json_decode($google_data3);
            $dataku4 = json_decode($google_data4);
            $dataku5 = json_decode($google_data5);
            //GET DATA FROM GOOGLE CUSTOM SEARCH ENGINE
            $no = $start;
            $konten = array();

            foreach ($dataku->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keyword)."','".$this->db->escape_str($id_crawl1)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }

            foreach ($dataku2->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keywordrival)."','".$this->db->escape_str($id_crawl2)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }

            foreach ($dataku3->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keywordrival2)."','".$this->db->escape_str($id_crawl3)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }

            foreach ($dataku4->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keywordrival3)."','".$this->db->escape_str($id_crawl4)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }

            foreach ($dataku5->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keywordrival4)."','".$this->db->escape_str($id_crawl5)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }
        }

            $data_crawling["dataku"] = $crawling;
            //$asf["datanya"] = $row;
        $data['title'] = '';
        $data['header'] = '';
        $data['content'] = $this->load->view('home_view', $data_crawling, true);
        $data['script'] = '';
        $this->load->view('template/header');
        $this->load->view('template/footer');
         redirect('/chart');


    }

    //crawling proses rating ranking
    public function showResultRatingRanking()
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $tanggal = getdate();
        $tanggal1= $tanggal['year'];
        $id_crawl1 = 1;
        $id_crawl2 = 2;
        $id_crawl3 = 3;
        $id_crawl4 = 4;
        $id_crawl5 = 5;

    
        $selected_rating = $this->input->post('selected_rating'); 

        $keyword1 = $this->input->post('search');

        $getstring = substr($keyword1, 0);
        $textWithoutLastWord = preg_replace('/\W\w+\s*(\W*)$/', '$1', $getstring); 

        $keyword = $keyword1." ".$tanggal1;

        $keywordSearchRival1 = $this->input->post('searchRival1');
        $keywordSearchRival2 = $this->input->post('searchRival2');
        $keywordSearchRival3 = $this->input->post('searchRival3');
        $keywordSearchRival4 = $this->input->post('searchRival4');

        $keywordrival = $textWithoutLastWord." ".$keywordSearchRival1." ".$tanggal1;
        $keywordrival2 = $textWithoutLastWord." ".$keywordSearchRival2." ".$tanggal1;
        $keywordrival3 = $textWithoutLastWord." ".$keywordSearchRival3." ".$tanggal1;
        $keywordrival4 = $textWithoutLastWord." ".$keywordSearchRival4." ".$tanggal1;

//        if ($prefix = "kinerja" || "jasa"){
//            $string = strpos($keyword, $prefix) + strlen($prefix);
//            $str = substr($keyword, $string);
//        }

        $search_query = str_replace(' ', '+', $keyword);
        $search_query2 = str_replace(' ', '+', $keywordrival);
        $search_query3 = str_replace(' ', '+', $keywordrival2);
        $search_query4 = str_replace(' ', '+', $keywordrival3);
        $search_query5 = str_replace(' ', '+', $keywordrival4);
        $total = 1;
        

        $this->db->truncate('data_crawling');
        $crawling = array();
        $resultALL = []; //menampung semua kata dari semua blog
        $dataResult = [];
        $totalResult = 0;
        //for ($i=0;$i<10;$i++){
        for ($i=0;$i<1;$i++){
            //GET DATA FROM GOOGLE CUSTOM SEARCH ENGINE
            $start= ($total*$i) + 1;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCqjhiFcTF4jyqDb-Cre5U_Ko255fe5aZ0&cx=009697247467493233773:yzx7ibazkgk&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCcomXXfI2KsOdURy-YGEOnVA4dLw7336E&cx=013263571767881537586:w2jkjyd8pis&q=".$search_query;
            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyCcomXXfI2KsOdURy-YGEOnVA4dLw7336E&cx=013263571767881537586:udbtjd8w4ss&q=".$search_query;

            $google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query;
            $google_url2 = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query2;
            $google_url3 = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query3;
            $google_url4 = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query4;
            $google_url5 = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBLyJVzGmSgZ0hkepqFM-qu6UgcaRWumHw&cx=006722259216659186331:puyljl06sis&q=".$search_query5;

            //$google_url = "https://www.googleapis.com/customsearch/v1?num=".$total."&start=".$start."&key=AIzaSyBNM_gH2j4PvFz7_jsdVzxKS4xcr0sGJ8c&cx=007816592670394136699:zcn0ssfp0ig=".$search_query;
            $google_data = file_get_contents($google_url, false, stream_context_create($arrContextOptions));
            $google_data2 = file_get_contents($google_url2, false, stream_context_create($arrContextOptions));
            $google_data3 = file_get_contents($google_url3, false, stream_context_create($arrContextOptions));
            $google_data4 = file_get_contents($google_url4, false, stream_context_create($arrContextOptions));
            $google_data5 = file_get_contents($google_url5, false, stream_context_create($arrContextOptions));

            $dataku = json_decode($google_data);
            $dataku2 = json_decode($google_data2);
            $dataku3 = json_decode($google_data3);
            $dataku4 = json_decode($google_data4);
            $dataku5 = json_decode($google_data5);
            //GET DATA FROM GOOGLE CUSTOM SEARCH ENGINE
            $no = $start;
            $konten = array();

            foreach ($dataku->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keyword)."','".$this->db->escape_str($id_crawl1)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }

            foreach ($dataku2->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keywordrival)."','".$this->db->escape_str($id_crawl2)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }

            foreach ($dataku3->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keywordrival2)."','".$this->db->escape_str($id_crawl3)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }

            foreach ($dataku4->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keywordrival3)."','".$this->db->escape_str($id_crawl4)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }

            foreach ($dataku5->items as $val) {
                $itemData['title'] = $val->title;
                $itemData['link'] = $val->link;

                $dt = explode("^", "<strong>".$itemData['title'] . "^" . $itemData['link']."</strong>");
                $crawling[] = $dt;
                //-----------------AMBIL KONTEN--------------
                $url = $val->link;

                //GET DATA FROM kompasiana
                if (strpos($url, 'kompasiana') !== false) {
                    $data1= file_get_contents($url, false, stream_context_create($arrContextOptions));
                    $awal = ' <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" data-sticky_column>';
                    $awal2 = '<article class="kompasiana-article">';
                    $akhir2="</article>";
                    $akhir="</div>";

                    $isi=explode($awal, $data1);
                    $isi_2 = explode($awal2, $isi[1]);

                    $isi_3=explode($akhir2, $isi_2[0]);

                    $isi_4=explode($akhir, $isi_3[0]);

                    $newArray = array_merge($isi_4);
                    $konten = implode(" ", $newArray);

                    if($konten==''){
                        $html = str_get_html($data1);
                        $this->db->escape_like_str($konten =($html->find('.read-content', 0)->plaintext));
                    }
                }

                //GET DATA FROM wordpress or blogspot
                if (strpos($url, 'wordpress') !== false || strpos($url, 'blogspot') !== false) {
                    $file_contents= file_get_contents($url, false, stream_context_create($arrContextOptions));

                    $html = str_get_html($file_contents);
                    if (!empty($html)) {
                        $this->db->escape_like_str($konten = ($html->find('.entry-content', 0)->plaintext));
                    }

                }
                /*=============INSERT TO table==================*/
                $query = $this->db->query("INSERT INTO data_crawling (keyword, id_crawling, title, url, Konten, selected_rating) VALUES ('".$this->db->escape_str($keywordrival4)."','".$this->db->escape_str($id_crawl5)."','".$this->db->escape_str($val->title)."', '".$this->db->escape_str($val->link)."','".$this->db->escape_str($konten)."','".$this->db->escape_str($selected_rating)."')");
//                return $query;

            }
        }

            $data_crawling["dataku"] = $crawling;
            //$asf["datanya"] = $row;
        $data['title'] = '';
        $data['header'] = '';
        $data['content'] = $this->load->view('home_view', $data_crawling, true);
        $data['script'] = '';
        $this->load->view('template/header');
        $this->load->view('template/footer');
         redirect('/Text_preprocessing1');


    }

}
