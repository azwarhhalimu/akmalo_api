<?php
function format_tanggal($date)
{
    return str_replace(array('/'), '-', $date);
}
function uang($cur)
{
    return str_replace(array('.'), '', $cur);
}
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}


function clean_url_youtube($url)
{
    return str_replace(array('https://www.youtube.com/watch?v='), array(''), $url);
}
function convert_jam($date)
{
   $bulan=array(
       '01'=>'Januari',
       '02'=>'Februari',
       '03'=>'Maret',
       '04'=>'April',
       '05'=>'Mei',
       '06'=>'Juni',
       '07'=>'Juli',
       '08'=>'Agustus',
       '09'=>'September',
       '10'=>'Oktober',
       '11'=>'November',
       '12'=>'Desember',
   );
   list($tanggal, $jam)=  explode(" ", $date);
   
   list($tahun, $bulanx, $hari)= explode("-", $tanggal);
   return $hari .' '.$bulan[$bulanx].' '.$tahun;
}

function convert_tanggal($date)
{
   $bulan=array(
       '01'=>'Januari',
       '02'=>'Februari',
       '03'=>'Maret',
       '04'=>'April',
       '05'=>'Mei',
       '06'=>'Juni',
       '07'=>'Juli',
       '08'=>'Agustus',
       '09'=>'September',
       '10'=>'Oktober',
       '11'=>'November',
       '12'=>'Desember',
   );
   list($year, $mounth, $day)=  explode("-", $date);
   return $day.' '.$bulan[$mounth].' '.$year;
}
function tooltip($text)
{
    return ' data-toggle="tooltip" title="'.$text.'"';
}
function popover($title, $popover)
{
    return ' data-toggle="popover" title="'.$title.'" content="'.$popover.'"';
}
function getProvinsi($id_prov)
{
    $query=query("SELECT * FROM provinsi WHERE id_prov=".$id_prov)->queryRow();
    $k= $query['nama'];
    return $k;
}
function getKota($id_kabupaten)
{
    $query=query("SELECT * FROM kabupaten WHERE id_kab=".$id_kabupaten)->queryRow();
    $k= $query['nama'];
    return $k;
}
function getKecamatan($id_kec)
{
    $kecamatan=query("SELECT * FROM kec WHERE id_kec='".$id_kec."'")->queryRow();
    $k= $kecamatan['nama_kec'];
    return $k;
}
function getKelurahan($id_kelurahan)
{
    $kelurahan=query("SELECT * FROM keldesa WHERE id_keldesa='".$id_kelurahan."'")->queryRow();
    $k=$kelurahan['nama_keldesa'];
    return $k;
}
function sisa_kas_sekolah()
{
    $kas_masuk=query('SELECT SUM(jumlah) FROM saldo_keluar WHERE id_user="'.  sessionRead('sekolah_username').'"')->queryScalar();
    $penggunaan_dana=query('SELECT sum(total_rincian) FROM penggunaan_dana WHERE id_user="'.  sessionRead('sekolah_username').'"')->queryScalar();
    $giro_pajak=query('SELECT sum(bunga+adm+pajak+pfk) from giro_pajak WHERE id_user="'.  sessionRead('sekolah_username').'"')->queryScalar();
    return ($kas_masuk-$penggunaan_dana)-$giro_pajak;
}
function sisa_saldo_bank()
{
    $saldo_masuk=query('SELECT SUM(jumlah) FROM saldo WHERE id_user="'.  sessionRead('sekolah_username').'"')->queryScalar();
    $saldo_keluar=query('SELECT SUM(jumlah) FROM saldo_keluar WHERE id_user="'.  sessionRead('sekolah_username').'"')->queryScalar();
    return $saldo_masuk-$saldo_keluar;
}
function tanggal($tanggal, $parameter)
{
    list($tahun, $bulan, $hari)=  explode("-", $tanggal);
    if($parameter=='d')
    {
        $date=$hari;
    }
    else if($parameter=='m')
    {
        $date=$bulan;
    }
    else
    {
        $date=$tahun;
    }
    return $date;
}

function url()
{
  return "http://192.168.1.9";
//return "http://192.168.43.56";
}
function alert($type,$session_name,$pesan)
{
    $sr=  sessionRead($session_name);
    if(isset($sr))
    {
        if($type=='sukses')
        {
              $al=alert_sukses($pesan);
             sessionRemove($session_name);
        }
        else
        {
              $al=alert_gagal($pesan);
             sessionRemove($session_name);
        }
        return $al;
    }
    else
    {
        
    }
}
function baseImage()
{
    return "https://"."suarwakatobi.com".'/';
}
function alert_sukses($pesan)
{
    return $x= '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>'.
            $pesan
            . '</div>';
}
function alert_gagal($pesan)
{
    return $x= '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>'.
            $pesan
            . '</div>';
}
function urlClean($uri)
{
    return str_replace(array("'",'"','<','>'), array('','','',''), $uri);
}

function xss($input)
{
    $c=new CHtmlPurifier();
    return $c->purify($input);
}
function encryptRc($data)
{ 
     $key="348290jjjifud83409";
     return base64_encode(RC4::encrypt($key, $data));
}
function dencryptRc($data)
{
     $key="348290jjjifud83409";
     $decode=  base64_decode($data);
     return RC4::decrypt($key, $decode);
}

function kode_session()
{
    return "adfdf";
}
function sessionCreate($name, $value)
{
    $kode_session=  kode_session();
    return Yii::app()->session->add($kode_session.$name,$value);
}
function sessionRead($name)
{
    $kode_session=  kode_session();
    return Yii::app()->session->itemAt($kode_session.$name);
}
function sessionRemove($name)
{
    $kode_session=  kode_session();
    return Yii::app()->session->remove($kode_session.$name);
}
function homeUrl()
{
    return Yii::app()->homeUrl;
}
function createUrl($uri)
{
    return Yii::app()->createUrl($uri);
}
function baseUrl()
{
    return Yii::app()->request->baseUrl;
}
function query($sql)
{
    return Yii::app()->db->createCommand($sql);
}
function query2($sql)
{
    return Yii::app()->db2->createCommand($sql);
}