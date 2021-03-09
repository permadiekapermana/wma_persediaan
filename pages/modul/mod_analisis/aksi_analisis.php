<?php
session_start();
error_reporting(0);
include "../../../config/koneksi.php";
include "../../../config/fungsi_seo.php";

$pel="RML.";
$y=substr($pel,0,2);
$query=mysql_query("select * from ramal_history where substr(id_ramal,1,2)='$y' order by id_ramal desc limit 0,1");
$row=mysql_num_rows($query);
$data=mysql_fetch_array($query);

if ($row>0){
$no=substr($data['id_ramal'],-3)+1;}
else{
$no=1;
}
$nourut=1000+$no;
$nopel=$pel.substr($nourut,-3);

$module=$_GET[module];
$act=$_GET[act];

// Hapus penilaian
if ($module=='penilaian' AND $act=='hapus'){
  mysql_query("DELETE FROM penilaian WHERE id_penilaian='$_GET[id]'");
  header('location:../../media.php?module=penilaian&act=lihatpenilaian');
}
elseif ($module=='analisis' AND $act=='hapus'){
  mysql_query("DELETE FROM temp WHERE id_penjualan='$_GET[id]'");
  header('location:../../media.php?module=analisis&act=analisiswma');
}
elseif ($module=='analisis' AND $act=='reset'){
  mysql_query("TRUNCATE TABLE temp");
  header('location:../../media.php?module=analisis&act=analisiswma');
}
elseif ($module=='analisis' AND $act=='save'){
  $edit = mysql_query("SELECT * FROM temp");
  $r    = mysql_fetch_array($edit);
  $edit2 = mysql_query("SELECT id_produk FROM temp_produk WHERE id='1'");
  $r2    = mysql_fetch_array($edit2);
  $r3   = mysql_query("SELECT COUNT(id_penjualan) as count FROM temp");
  $row = mysql_fetch_object($r3);
  $count = $row->count;
  $tgl_skrg = date("Ymd");
  $bln=date("n");
  $thn=date("Y");
  

  mysql_query("INSERT INTO ramal_history(id_ramal,tgl_ramal,id_produk,periode,bulan,tahun,hasil) 
  VALUES('$nopel','$tgl_skrg','$r2[id_produk]','$count','$_POST[bulan]','$thn','$_POST[id2]')");
  echo "<script>alert('Berhasil Menyimpan Hasil Peramalan !');history.go(-1)</script>";
}
// Input penilaian
elseif ($module=='analisis' AND $act=='input'){
  $cek_analisis = mysql_num_rows(mysql_query("SELECT * FROM temp WHERE id_penjualan = '$_POST[id_penjualan]'"));
  if ( $cek_analisis > 0 ){
    echo "<script>alert('Nomor Penjualan yang anda masukan sudah ada !');history.go(-1)</script>";
  } else{
  mysql_query("INSERT INTO temp(id_penjualan,jml_penjualan,skor,bobot) 
  VALUES('$_POST[id_penjualan]','$_POST[jml_penjualan]','$_POST[skor]','$_POST[bobot]')");
 
header('location:../../media.php?module=analisis&act=analisiswma');
  }
}

// Update penilaian
elseif ($module=='penilaian' AND $act=='update'){
$total=$_POST[skor1]+$_POST[skor2]+$_POST[skor3]+$_POST[skor4];
  mysql_query("UPDATE penilaian SET id_siswa = '$_POST[id_siswa]', 
  skor1 = '$_POST[skor1]',
  skor2 = '$_POST[skor2]',
  skor3 = '$_POST[skor3]',
  skor4 = '$_POST[skor4]',
  total = '$total', 
  petugas = '$_POST[petugas]'
  WHERE id_penilaian = '$_POST[id]'");
   mysql_query("UPDATE siswa SET n_penilaian = '$total'
  WHERE id_siswa = '$_POST[id_siswa]'"); 
  header('location:../../media.php?module=penilaian&act=lihatpenilaian');
}
?>
