<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(0);
ini_set('max_execution_time', 0);
// ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

 class Text_preprocessing3 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_textpreprocessing');
        $this->load->helper('url');

    }

    function index()
    {
        $text_preprocessing = $this->model_textpreprocessing->tokenizing3();

        $array_preprocessing = array();
        $lemma = array();

        //proses tokenizing dan casefolding
        foreach ($text_preprocessing as $item_txt) {
            $teks = $item_txt->konten;
            $low = strtolower($teks);
            $tokenizing = explode(' ', $low);


            foreach ($tokenizing as $tok){
                $array_preprocessing[]=$tok;
                
            }

        }

        $lemma_sinonim = array();
        $lemma_antonim = array();

        $status = $this->db->query("select distinct selected_rating from data_crawling")->result_array();
        foreach ($status as $st) {
            foreach ($st as $key => $value) {
                $select_rating=$value;
            }
        }

        if ($select_rating==1) {
            //result form tabel sinonim masih semua kategori
       $syn = $this->db->query("select lemma_sinonim from dataset_jasapengiriman ")->result_array();

       foreach ($syn as $s){
           foreach ($s as $k){
               $string=($k);

               $dok = str_replace(","," ",$string);
               $to = explode(' ', $dok);

               foreach ($to as $t){
                   $lemma_sinonim[]=$t;

               }

           }
       }

       //result form tabel antonim masih semua kategori
       $ant = $this->db->query("select lemma_antonim from dataset_jasapengiriman ")->result_array();

       foreach ($ant as $s){
           foreach ($s as $k){
               $string=($k);

               $dok = str_replace(","," ",$string);
               $to = explode(' ', $dok);

               foreach ($to as $t){
                   $lemma_antonim[]=$t;

               }

           }
       }

       
       $syn_ant=array();
       $syn_ant2=array();
        $syn_ant[]=array_merge($lemma_sinonim,$lemma_antonim);

        foreach ($syn_ant as $item_synant) {
            foreach ($item_synant as $item_synant2) {
                $syn_ant2[]=$item_synant2;
            }
        }

        //filter kata dari hasil crawling dengan db kata sifat
        $result1 = array_intersect($array_preprocessing,$syn_ant2);

        $result_uniq = array_unique($result1);

        $this->db->truncate('selective_adjpasslist');

        foreach ($result_uniq as $rs)
        {
            if ($rs!=null){
                $params['list'] = $rs;
                $this->db->insert('selective_adjpasslist', $params);
            }
            else
            {

            }
        }

        $hh = array();

        $dataset_jasapengiriman = $this->db->query("select list from selective_adjpasslist")->result_array();       

        $index = 0;
        foreach ($dataset_jasapengiriman as $jml){
        foreach ($jml as $jml_sinant ){

            $hh[]=$jml_sinant;

        
            }
        }

        $i=0;
        $dt=array(); //ARRAY SUBKATEGORI - LEMMA SINONIM
        $st=array(); //ARRAY SUBKATEGORI - LEMMA ANTONIM
        $sinonim=array(); // VALUE SINONIM
        $antonim=array(); // VALUE ANTONIM
        $save_value=array(); //simpan jumlah value sinonim-antonim
        $th=array();//threshold


        //masih ke select semua
        foreach ($hh as $s){
            $ltn["sinonim"][$s] = 1;
            $subkt = $this->db->query("select subkategori from dataset_jasapengiriman where lemma_sinonim like '%$s%' ")->result();
            $dt[$i]=$subkt[0]->subkategori;

            $i++;
        }

        ////echo " <p><h2>Jumlah Sinonim Ditemukan</h2></p>";

        $dt1=array_count_values($dt); // menampilkan jumlah antonim


        foreach ($dt1 as $value => $key){
            $sinonim[$value]=$key;


        }


        // mengisi antonim dengan nilai minus satu masih ke select semua
        foreach ($hh as $a){
            $ltn["antonim"][$a] = -1;

            $ask = $this->db->query("select subkategori from dataset_jasapengiriman where lemma_antonim like '%$a%' ")->result();
            $st[$i]=$ask[0]->subkategori;

            $i++;
        }

        ////echo " <p><h2>Jumlah Antonim Ditemukan</h2></p>";

        $st1=array_count_values($st);

        foreach ($st1 as $value => $key){
            $antonim[$value]=$key * -1;
        }


        foreach ($sinonim as $item =>$key) {
            if(in_array($item,array_keys($antonim))==1){
                $index=array_search($item,array_keys($antonim));
                array_keys($antonim)[$index].' => '.array_values($antonim)[$index];
                $bgs=$key+(array_values($antonim)[$index]);
                $save_value[array_keys($antonim)[$index]]=$bgs;
            }
            else{
                $save_value[$item]=$key;
            }
        }

        ////echo "<p><h2>Total Sinonim dan Antonim</h2></p>";


        foreach ($save_value as $key => $value){
            ////echo '<strong>';
            ////echo $key.'=>'.$value;
            $low = strtolower($key);
            ////echo $low.'=>'.$value;
            ////echo '</strong>';
            ////echo '</br>';
        }

        ////echo "<br>";

    ////echo "<p><h2>Threshold Nilai Sinonim Antonim</h2></p>";

    // fungsi treshold
    function th_1($var)
    {
        return($var >= 1 or $var <= -1 or $var == 0);
    }

    ////print_r($save_value);


    $th[] = (array_filter($save_value,"th_1"));

    $th_pos=array(); //threshold positif
    $th_neg=array(); //threshold negatif
    $th_net=array(); //threshold netral

    foreach ($th as $afk){
        foreach ($afk as $key1 => $value1){
            if ($value1>=1){
                ////echo '<strong>';
                ////print_r($key1.'=>'.$value1=1);
                ////echo '</strong>';
                ////echo '</br>';

                $th_pos[$key1]=$value1=1;
            }
            elseif ($value1<=-1){
                ////echo '<strong>';
                ////print_r($key1.'=>'.$value1=-1);
                ////echo '</strong>';
                ////echo '</br>';

                $th_neg[$key1]=$value1=-1;

            }
            else {
                ////echo '<strong>';
                ////print_r($key1.'=>'.$value1=0);
                ////echo '</strong>';
                ////echo '</br>';

                $th_net[$key1]=$value1=0;
            }

        }
    }

    ////echo "<br>";

    ////echo "<p><h2>Nilai Aspek Total</h2></p>";

    $i=0;
    $sum_pos=array();
    $sum_neg=array();
    $sum_net=array();
    $has_pos=array();
    $sub_pos=array();
    $sub_neg=array();
    $sub_net=array();

    $tot=array();
    $tot_sub=array();
    $jumlah = array();
    $jumlah_sub = array();
    $nilai_aspek = array();


    //masih ke select semua
    foreach ($th_pos as $key => $value){
        $query = $this->db->query("select kategori, subkategori from dataset_jasapengiriman where subkategori = '$key' ")->result();
        $sum_pos[]= $query[0]->kategori.' => '.$value;
        $sub_pos[] = $query[0]->kategori.' - '.$query[0]->subkategori;

        $i++;


    }

    //masih ke select semua
    foreach ($th_neg as $key => $value){
        $query2 = $this->db->query("select kategori, subkategori from dataset_jasapengiriman where subkategori = '$key' ")->result();
        $sum_neg[]= $query2[0]->kategori.' => '.$value;
        $sub_neg[] = $query2[0]->kategori.' - '.$query2[0]->subkategori;

        $i++;
    }

    //masih ke select semua
    foreach ($th_net as $key => $value){
        $query3 = $this->db->query("select kategori, subkategori from dataset_jasapengiriman where subkategori = '$key' ")->result();
        $sum_net[]= $query3[0]->kategori.' => '.$value;
        $sub_net[] = $query3[0]->kategori.' - '.$query3[0]->subkategori;

        $i++;
    }
    $tot[] = array_merge($sum_pos,$sum_neg,$sum_net);
    $tot_sub[] = array_merge($sub_pos,$sub_neg,$sub_net);


    foreach ($tot as $item) {

    }

    foreach ($tot_sub as $item2) {

    }

    $ii=array();

    //distict kategori masih ke select semua
    // $this->db->distinct();
    // $this->db->select('kategori');
    // $this->db->where('status=$select_rating');
    // $query = $this->db->get('dataset_jasapengiriman')->result_array();

    $query = $this->db->query("select kategori from dataset_jasapengiriman ")->result_array();
    


    //perulangan menampilkan distinct kategori
    for ($i=0;$i<sizeof($query);$i++){
        $tmp = 0;
        for ($s=0;$s<sizeof($item);$s++){
            $subs = str_replace(' ', '', substr($tot[0][$s], 0, strpos($tot[0][$s], '=>')));

            if ($subs == $query[$i]['kategori']){
                $nilainya = substr($tot[0][$s], strlen($subs)+3, strpos($tot[0][$s], '=>'))."<br>";
                ////print_r($nilainya);
                $tmp += $nilainya;
            }
        }

        $jumlah[$query[$i]['kategori']] = $tmp;
    }

    foreach ($jumlah as $key => $val) {
        ////echo '<strong>';
        ////echo $key.'=>'.$val;
        ////echo '</strong>';
        $nilai_aspek[$key] = $val;
        $coba = $nilai_aspek;
        ////echo "<br>";
    }

    $ii2=array();
    for ($i=0;$i<sizeof($query);$i++) {
        $tmp = 0;
        for ($s = 0; $s < sizeof($item2); $s++) {
            $subs = str_replace(' ', '', substr($tot_sub[0][$s], 0, strpos($tot_sub[0][$s], '-')));

            ////print_r($subs);
            if ($subs == $query[$i]['kategori']) {
                $nilainya = substr($tot_sub[0][$s], 0, strpos($tot_sub[0][$s], '-')) . "<br>";
                ////print_r($nilainya);

                $str = (explode("=>", $nilainya));
                ////print_r($str);

                $ii2[]=$str;
            }
        }
        }



    ////echo "<br>";
    foreach ($ii2 as $ite) {
        $kategori[$ite[0]] += 1;

    }

    $abc=array();
    foreach ($kategori as $k => $v){
        ////echo $k." : ".$v."<br>";
        $abc[]=$v;
    }

    ////echo "<br>";

    ////echo "<p><h2>Nilai Aspek </h2></p>";

    $kueri = $this->db->query("select DISTINCT kategori from dataset_jasapengiriman")->result_array();
    ////print_r($qq);
    $banyak_data = array();
    foreach ($kueri as $item) {
        foreach ($item as $item2) {
            //$aqj[] = array($item2);
            $ak = $this->db->query("select kategori from dataset_jasapengiriman where kategori like '$item2'")->num_rows();
            $banyak_data[] = $ak;
            ////print_r($ak);
        }
    }

    $i=0;
    $nilai_aspk=array();
    foreach ($coba as $key => $val) {
        ////echo '<strong>';
        ////echo $key."=>".(($val/$banyak_data[$i])*5)."<br>";
        ////echo '</strong>';

        $nilai_aspk[$key]= (($val/$banyak_data[$i])*5);
        $i++;
    }

    ////echo "<br>";

    ////echo "<p><h2>Nilai Rating </h2></p>";

    $count=count($nilai_aspk);
    $sum=array_sum($nilai_aspk);

    $total=$sum/$count;
    ////echo "Hasil Rating adalah : ".number_format($total,1);
    $nilai=number_format($total,1);

    //$this->db->truncate('nilai');
    $this->db->query('insert into nilai (nilai) values ('.$this->db->escape($nilai).')');

        
    }

        elseif ($select_rating==2) {
           $syn = $this->db->query("select lemma_sinonim from dataset_tempatwisata ")->result_array();

       foreach ($syn as $s){
           foreach ($s as $k){
               $string=($k);

               $dok = str_replace(","," ",$string);
               $to = explode(' ', $dok);

               foreach ($to as $t){
                   $lemma_sinonim[]=$t;

               }

           }
       }

       //result form tabel antonim masih semua kategori
       $ant = $this->db->query("select lemma_antonim from dataset_tempatwisata ")->result_array();

       foreach ($ant as $s){
           foreach ($s as $k){
               $string=($k);

               $dok = str_replace(","," ",$string);
               $to = explode(' ', $dok);

               foreach ($to as $t){
                   $lemma_antonim[]=$t;

               }

           }
       }

       
       $syn_ant=array();
       $syn_ant2=array();
        $syn_ant[]=array_merge($lemma_sinonim,$lemma_antonim);

        foreach ($syn_ant as $item_synant) {
            foreach ($item_synant as $item_synant2) {
                $syn_ant2[]=$item_synant2;
            }
        }

        //filter kata dari hasil crawling dengan db kata sifat
        $result1 = array_intersect($array_preprocessing,$syn_ant2);

        $result_uniq = array_unique($result1);

        $this->db->truncate('selective_adjpasslist');

        foreach ($result_uniq as $rs)
        {
            if ($rs!=null){
                $params['list'] = $rs;
                $this->db->insert('selective_adjpasslist', $params);
            }
            else
            {

            }
        }

        $hh = array();

        $dataset_tempatwisata = $this->db->query("select list from selective_adjpasslist")->result_array();       

        $index = 0;
        foreach ($dataset_tempatwisata as $jml){
        foreach ($jml as $jml_sinant ){

            $hh[]=$jml_sinant;

        
            }
        }

        $i=0;
        $dt=array(); //ARRAY SUBKATEGORI - LEMMA SINONIM
        $st=array(); //ARRAY SUBKATEGORI - LEMMA ANTONIM
        $sinonim=array(); // VALUE SINONIM
        $antonim=array(); // VALUE ANTONIM
        $save_value=array(); //simpan jumlah value sinonim-antonim
        $th=array();//threshold


        //masih ke select semua
        foreach ($hh as $s){
            $ltn["sinonim"][$s] = 1;
            $subkt = $this->db->query("select subkategori from dataset_tempatwisata where lemma_sinonim like '%$s%' ")->result();
            $dt[$i]=$subkt[0]->subkategori;

            $i++;
        }

        ////echo " <p><h2>Jumlah Sinonim Ditemukan</h2></p>";

        $dt1=array_count_values($dt); // menampilkan jumlah antonim


        foreach ($dt1 as $value => $key){
            $sinonim[$value]=$key;


        }


        // mengisi antonim dengan nilai minus satu masih ke select semua
        foreach ($hh as $a){
            $ltn["antonim"][$a] = -1;

            $ask = $this->db->query("select subkategori from dataset_tempatwisata where lemma_antonim like '%$a%' ")->result();
            $st[$i]=$ask[0]->subkategori;

            $i++;
        }

        ////echo " <p><h2>Jumlah Antonim Ditemukan</h2></p>";

        $st1=array_count_values($st);

        foreach ($st1 as $value => $key){
            $antonim[$value]=$key * -1;
        }


        foreach ($sinonim as $item =>$key) {
            if(in_array($item,array_keys($antonim))==1){
                $index=array_search($item,array_keys($antonim));
                array_keys($antonim)[$index].' => '.array_values($antonim)[$index];
                $bgs=$key+(array_values($antonim)[$index]);
                $save_value[array_keys($antonim)[$index]]=$bgs;
            }
            else{
                $save_value[$item]=$key;
            }
        }

        ////echo "<p><h2>Total Sinonim dan Antonim</h2></p>";


        foreach ($save_value as $key => $value){
            ////echo '<strong>';
            ////echo $key.'=>'.$value;
            $low = strtolower($key);
            ////echo $low.'=>'.$value;
            ////echo '</strong>';
            ////echo '</br>';
        }

        ////echo "<br>";

    ////echo "<p><h2>Threshold Nilai Sinonim Antonim</h2></p>";

    // fungsi treshold
    function th_1($var)
    {
        return($var >= 1 or $var <= -1 or $var == 0);
    }

    ////print_r($save_value);


    $th[] = (array_filter($save_value,"th_1"));

    $th_pos=array(); //threshold positif
    $th_neg=array(); //threshold negatif
    $th_net=array(); //threshold netral

    foreach ($th as $afk){
        foreach ($afk as $key1 => $value1){
            if ($value1>=1){
                ////echo '<strong>';
                ////print_r($key1.'=>'.$value1=1);
                ////echo '</strong>';
                ////echo '</br>';

                $th_pos[$key1]=$value1=1;
            }
            elseif ($value1<=-1){
                ////echo '<strong>';
                ////print_r($key1.'=>'.$value1=-1);
                ////echo '</strong>';
                ////echo '</br>';

                $th_neg[$key1]=$value1=-1;

            }
            else {
                ////echo '<strong>';
                ////print_r($key1.'=>'.$value1=0);
                ////echo '</strong>';
                ////echo '</br>';

                $th_net[$key1]=$value1=0;
            }

        }
    }

    ////echo "<br>";

    ////echo "<p><h2>Nilai Aspek Total</h2></p>";

    $i=0;
    $sum_pos=array();
    $sum_neg=array();
    $sum_net=array();
    $has_pos=array();
    $sub_pos=array();
    $sub_neg=array();
    $sub_net=array();

    $tot=array();
    $tot_sub=array();
    $jumlah = array();
    $jumlah_sub = array();
    $nilai_aspek = array();


    //masih ke select semua
    foreach ($th_pos as $key => $value){
        $query = $this->db->query("select kategori, subkategori from dataset_tempatwisata where subkategori = '$key' ")->result();
        $sum_pos[]= $query[0]->kategori.' => '.$value;
        $sub_pos[] = $query[0]->kategori.' - '.$query[0]->subkategori;

        $i++;


    }

    //masih ke select semua
    foreach ($th_neg as $key => $value){
        $query2 = $this->db->query("select kategori, subkategori from dataset_tempatwisata where subkategori = '$key' ")->result();
        $sum_neg[]= $query2[0]->kategori.' => '.$value;
        $sub_neg[] = $query2[0]->kategori.' - '.$query2[0]->subkategori;

        $i++;
    }

    //masih ke select semua
    foreach ($th_net as $key => $value){
        $query3 = $this->db->query("select kategori, subkategori from dataset_tempatwisata where subkategori = '$key' ")->result();
        $sum_net[]= $query3[0]->kategori.' => '.$value;
        $sub_net[] = $query3[0]->kategori.' - '.$query3[0]->subkategori;

        $i++;
    }
    $tot[] = array_merge($sum_pos,$sum_neg,$sum_net);
    $tot_sub[] = array_merge($sub_pos,$sub_neg,$sub_net);


    foreach ($tot as $item) {

    }

    foreach ($tot_sub as $item2) {

    }

    $ii=array();

    //distict kategori masih ke select semua
    // $this->db->distinct();
    // $this->db->select('kategori');
    // $this->db->where('status=$select_rating');
    // $query = $this->db->get('dataset_tempatwisata')->result_array();

    $query = $this->db->query("select kategori from dataset_tempatwisata ")->result_array();
    


    //perulangan menampilkan distinct kategori
    for ($i=0;$i<sizeof($query);$i++){
        $tmp = 0;
        for ($s=0;$s<sizeof($item);$s++){
            $subs = str_replace(' ', '', substr($tot[0][$s], 0, strpos($tot[0][$s], '=>')));

            if ($subs == $query[$i]['kategori']){
                $nilainya = substr($tot[0][$s], strlen($subs)+3, strpos($tot[0][$s], '=>'))."<br>";
                ////print_r($nilainya);
                $tmp += $nilainya;
            }
        }

        $jumlah[$query[$i]['kategori']] = $tmp;
    }

    foreach ($jumlah as $key => $val) {
        ////echo '<strong>';
        ////echo $key.'=>'.$val;
        ////echo '</strong>';
        $nilai_aspek[$key] = $val;
        $coba = $nilai_aspek;
        ////echo "<br>";
    }

    $ii2=array();
    for ($i=0;$i<sizeof($query);$i++) {
        $tmp = 0;
        for ($s = 0; $s < sizeof($item2); $s++) {
            $subs = str_replace(' ', '', substr($tot_sub[0][$s], 0, strpos($tot_sub[0][$s], '-')));

            ////print_r($subs);
            if ($subs == $query[$i]['kategori']) {
                $nilainya = substr($tot_sub[0][$s], 0, strpos($tot_sub[0][$s], '-')) . "<br>";
                ////print_r($nilainya);

                $str = (explode("=>", $nilainya));
                ////print_r($str);

                $ii2[]=$str;
            }
        }
        }



    ////echo "<br>";
    foreach ($ii2 as $ite) {
        $kategori[$ite[0]] += 1;

    }

    $abc=array();
    foreach ($kategori as $k => $v){
        ////echo $k." : ".$v."<br>";
        $abc[]=$v;
    }

    ////echo "<br>";

    ////echo "<p><h2>Nilai Aspek </h2></p>";

    $kueri = $this->db->query("select DISTINCT kategori from dataset_tempatwisata")->result_array();
    ////print_r($qq);
    $banyak_data = array();
    foreach ($kueri as $item) {
        foreach ($item as $item2) {
            //$aqj[] = array($item2);
            $ak = $this->db->query("select kategori from dataset_tempatwisata where kategori like '$item2'")->num_rows();
            $banyak_data[] = $ak;
            ////print_r($ak);
        }
    }

    $i=0;
    $nilai_aspk=array();
    foreach ($coba as $key => $val) {
        ////echo '<strong>';
        ////echo $key."=>".(($val/$banyak_data[$i])*5)."<br>";
        ////echo '</strong>';

        $nilai_aspk[$key]= (($val/$banyak_data[$i])*5);
        $i++;
    }

    ////echo "<br>";

    ////echo "<p><h2>Nilai Rating </h2></p>";

    $count=count($nilai_aspk);
    $sum=array_sum($nilai_aspk);

    $total=$sum/$count;
    ////echo "Hasil Rating adalah : ".number_format($total,1);
    $nilai=number_format($total,1);

    //$this->db->truncate('nilai');
    $this->db->query('insert into nilai (nilai) values ('.$this->db->escape($nilai).')');
        
    }

    elseif ($select_rating==3) {
           $syn = $this->db->query("select lemma_sinonim from dataset_organisasi ")->result_array();

       foreach ($syn as $s){
           foreach ($s as $k){
               $string=($k);

               $dok = str_replace(","," ",$string);
               $to = explode(' ', $dok);

               foreach ($to as $t){
                   $lemma_sinonim[]=$t;

               }

           }
       }

       //result form tabel antonim masih semua kategori
       $ant = $this->db->query("select lemma_antonim from dataset_organisasi ")->result_array();

       foreach ($ant as $s){
           foreach ($s as $k){
               $string=($k);

               $dok = str_replace(","," ",$string);
               $to = explode(' ', $dok);

               foreach ($to as $t){
                   $lemma_antonim[]=$t;

               }

           }
       }

       
       $syn_ant=array();
       $syn_ant2=array();
        $syn_ant[]=array_merge($lemma_sinonim,$lemma_antonim);

        foreach ($syn_ant as $item_synant) {
            foreach ($item_synant as $item_synant2) {
                $syn_ant2[]=$item_synant2;
            }
        }

        //filter kata dari hasil crawling dengan db kata sifat
        $result1 = array_intersect($array_preprocessing,$syn_ant2);

        $result_uniq = array_unique($result1);

        $this->db->truncate('selective_adjpasslist');

        foreach ($result_uniq as $rs)
        {
            if ($rs!=null){
                $params['list'] = $rs;
                $this->db->insert('selective_adjpasslist', $params);
            }
            else
            {

            }
        }

        $hh = array();

        $dataset_organisasi = $this->db->query("select list from selective_adjpasslist")->result_array();       

        $index = 0;
        foreach ($dataset_organisasi as $jml){
        foreach ($jml as $jml_sinant ){

            $hh[]=$jml_sinant;

        
            }
        }

        $i=0;
        $dt=array(); //ARRAY SUBKATEGORI - LEMMA SINONIM
        $st=array(); //ARRAY SUBKATEGORI - LEMMA ANTONIM
        $sinonim=array(); // VALUE SINONIM
        $antonim=array(); // VALUE ANTONIM
        $save_value=array(); //simpan jumlah value sinonim-antonim
        $th=array();//threshold


        //masih ke select semua
        foreach ($hh as $s){
            $ltn["sinonim"][$s] = 1;
            $subkt = $this->db->query("select subkategori from dataset_organisasi where lemma_sinonim like '%$s%' ")->result();
            $dt[$i]=$subkt[0]->subkategori;

            $i++;
        }

        ////echo " <p><h2>Jumlah Sinonim Ditemukan</h2></p>";

        $dt1=array_count_values($dt); // menampilkan jumlah antonim


        foreach ($dt1 as $value => $key){
            $sinonim[$value]=$key;


        }


        // mengisi antonim dengan nilai minus satu masih ke select semua
        foreach ($hh as $a){
            $ltn["antonim"][$a] = -1;

            $ask = $this->db->query("select subkategori from dataset_organisasi where lemma_antonim like '%$a%' ")->result();
            $st[$i]=$ask[0]->subkategori;

            $i++;
        }

        ////echo " <p><h2>Jumlah Antonim Ditemukan</h2></p>";

        $st1=array_count_values($st);

        foreach ($st1 as $value => $key){
            $antonim[$value]=$key * -1;
        }


        foreach ($sinonim as $item =>$key) {
            if(in_array($item,array_keys($antonim))==1){
                $index=array_search($item,array_keys($antonim));
                array_keys($antonim)[$index].' => '.array_values($antonim)[$index];
                $bgs=$key+(array_values($antonim)[$index]);
                $save_value[array_keys($antonim)[$index]]=$bgs;
            }
            else{
                $save_value[$item]=$key;
            }
        }

        ////echo "<p><h2>Total Sinonim dan Antonim</h2></p>";


        foreach ($save_value as $key => $value){
            ////echo '<strong>';
            ////echo $key.'=>'.$value;
            $low = strtolower($key);
            ////echo $low.'=>'.$value;
            ////echo '</strong>';
            ////echo '</br>';
        }

        ////echo "<br>";

    ////echo "<p><h2>Threshold Nilai Sinonim Antonim</h2></p>";

    // fungsi treshold
    function th_1($var)
    {
        return($var >= 1 or $var <= -1 or $var == 0);
    }

    ////print_r($save_value);


    $th[] = (array_filter($save_value,"th_1"));

    $th_pos=array(); //threshold positif
    $th_neg=array(); //threshold negatif
    $th_net=array(); //threshold netral

    foreach ($th as $afk){
        foreach ($afk as $key1 => $value1){
            if ($value1>=1){
                ////echo '<strong>';
                //print_r($key1.'=>'.$value1=1);
                //echo '</strong>';
                //echo '</br>';

                $th_pos[$key1]=$value1=1;
            }
            elseif ($value1<=-1){
                //echo '<strong>';
                //print_r($key1.'=>'.$value1=-1);
                //echo '</strong>';
                //echo '</br>';

                $th_neg[$key1]=$value1=-1;

            }
            else {
                //echo '<strong>';
                //print_r($key1.'=>'.$value1=0);
                //echo '</strong>';
                //echo '</br>';

                $th_net[$key1]=$value1=0;
            }

        }
    }

    //echo "<br>";

    //echo "<p><h2>Nilai Aspek Total</h2></p>";

    $i=0;
    $sum_pos=array();
    $sum_neg=array();
    $sum_net=array();
    $has_pos=array();
    $sub_pos=array();
    $sub_neg=array();
    $sub_net=array();

    $tot=array();
    $tot_sub=array();
    $jumlah = array();
    $jumlah_sub = array();
    $nilai_aspek = array();


    //masih ke select semua
    foreach ($th_pos as $key => $value){
        $query = $this->db->query("select kategori, subkategori from dataset_organisasi where subkategori = '$key' ")->result();
        $sum_pos[]= $query[0]->kategori.' => '.$value;
        $sub_pos[] = $query[0]->kategori.' - '.$query[0]->subkategori;

        $i++;


    }

    //masih ke select semua
    foreach ($th_neg as $key => $value){
        $query2 = $this->db->query("select kategori, subkategori from dataset_organisasi where subkategori = '$key' ")->result();
        $sum_neg[]= $query2[0]->kategori.' => '.$value;
        $sub_neg[] = $query2[0]->kategori.' - '.$query2[0]->subkategori;

        $i++;
    }

    //masih ke select semua
    foreach ($th_net as $key => $value){
        $query3 = $this->db->query("select kategori, subkategori from dataset_organisasi where subkategori = '$key' ")->result();
        $sum_net[]= $query3[0]->kategori.' => '.$value;
        $sub_net[] = $query3[0]->kategori.' - '.$query3[0]->subkategori;

        $i++;
    }
    $tot[] = array_merge($sum_pos,$sum_neg,$sum_net);
    $tot_sub[] = array_merge($sub_pos,$sub_neg,$sub_net);


    foreach ($tot as $item) {

    }

    foreach ($tot_sub as $item2) {

    }

    $ii=array();

    //distict kategori masih ke select semua
    // $this->db->distinct();
    // $this->db->select('kategori');
    // $this->db->where('status=$select_rating');
    // $query = $this->db->get('dataset_organisasi')->result_array();

    $query = $this->db->query("select kategori from dataset_organisasi ")->result_array();
    


    //perulangan menampilkan distinct kategori
    for ($i=0;$i<sizeof($query);$i++){
        $tmp = 0;
        for ($s=0;$s<sizeof($item);$s++){
            $subs = str_replace(' ', '', substr($tot[0][$s], 0, strpos($tot[0][$s], '=>')));

            if ($subs == $query[$i]['kategori']){
                $nilainya = substr($tot[0][$s], strlen($subs)+3, strpos($tot[0][$s], '=>'))."<br>";
                ////print_r($nilainya);
                $tmp += $nilainya;
            }
        }

        $jumlah[$query[$i]['kategori']] = $tmp;
    }

    foreach ($jumlah as $key => $val) {
        //echo '<strong>';
        //echo $key.'=>'.$val;
        //echo '</strong>';
        $nilai_aspek[$key] = $val;
        $coba = $nilai_aspek;
        //echo "<br>";
    }

    $ii2=array();
    for ($i=0;$i<sizeof($query);$i++) {
        $tmp = 0;
        for ($s = 0; $s < sizeof($item2); $s++) {
            $subs = str_replace(' ', '', substr($tot_sub[0][$s], 0, strpos($tot_sub[0][$s], '-')));

            ////print_r($subs);
            if ($subs == $query[$i]['kategori']) {
                $nilainya = substr($tot_sub[0][$s], 0, strpos($tot_sub[0][$s], '-')) . "<br>";
                ////print_r($nilainya);

                $str = (explode("=>", $nilainya));
                ////print_r($str);

                $ii2[]=$str;
            }
        }
        }



    //echo "<br>";
    foreach ($ii2 as $ite) {
        $kategori[$ite[0]] += 1;

    }

    $abc=array();
    foreach ($kategori as $k => $v){
        ////echo $k." : ".$v."<br>";
        $abc[]=$v;
    }

    //echo "<br>";

    //echo "<p><h2>Nilai Aspek </h2></p>";

    $kueri = $this->db->query("select DISTINCT kategori from dataset_organisasi")->result_array();
    ////print_r($qq);
    $banyak_data = array();
    foreach ($kueri as $item) {
        foreach ($item as $item2) {
            //$aqj[] = array($item2);
            $ak = $this->db->query("select kategori from dataset_organisasi where kategori like '$item2'")->num_rows();
            $banyak_data[] = $ak;
            ////print_r($ak);
        }
    }

    $i=0;
    $nilai_aspk=array();
    foreach ($coba as $key => $val) {
        //echo '<strong>';
        //echo $key."=>".(($val/$banyak_data[$i])*5)."<br>";
        //echo '</strong>';

        $nilai_aspk[$key]= (($val/$banyak_data[$i])*5);
        $i++;
    }

    //echo "<br>";

    ////echo "<p><h2>Nilai Rating </h2></p>";

    $count=count($nilai_aspk);
    $sum=array_sum($nilai_aspk);

    $total=$sum/$count;
    ////echo "Hasil Rating adalah : ".number_format($total,1);
    $nilai=number_format($total,1);

    //$this->db->truncate('nilai');
    $this->db->query('insert into nilai (nilai) values ('.$this->db->escape($nilai).')');
    
    }
    
    // $this->load->view('template/header');
    // $this->load->view('ratting_view');
    // // //echo "kadal";
    // $this->load->view('template/footer');

    redirect('/Text_preprocessing4/');
        }

    
    }
?>