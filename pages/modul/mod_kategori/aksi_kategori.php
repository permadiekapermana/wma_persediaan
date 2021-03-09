<?php
session_start();
error_reporting(0);
include "../../../config/koneksi.php";
include "../../../config/fungsi_seo.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='kategori' AND $act=='hapus'){
  mysql_query("DELETE FROM kategori WHERE id_kategori='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input kategori
elseif ($module=='kategori' AND $act=='input'){

  $cek_kategori = mysql_num_rows(mysql_query("SELECT * FROM kategori WHERE nama_kategori = '$_POST[nama_kategori]'"));
	if ( $cek_kategori > 0 ){
		echo "<script>alert('Data kategori yang anda masukan sudah ada !');history.go(-1)</script>";
	} else{

  $kategori_seo = seo_title($_POST['nama_kategori']);
  mysql_query("INSERT INTO kategori(id_kategori, nama_kategori) VALUES('$_POST[id_kategori]', '$_POST[nama_kategori]')");
  header('location:../../media.php?module='.$module);
}
}

// Update kategori
elseif ($module=='kategori' AND $act=='update'){
  $kategori_seo = seo_title($_POST['nama_kategori']);
  mysql_query("UPDATE kategori SET nama_kategori = '$_POST[nama_kategori]' WHERE id_kategori = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
}
?>
