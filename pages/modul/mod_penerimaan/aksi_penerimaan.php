<?php
session_start();
error_reporting(0);
include "../../../config/koneksi.php";


$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='penerimaan' AND $act=='hapus'){
  mysql_query("DELETE FROM penerimaan WHERE id_penerimaan='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input kategori
elseif ($module=='penerimaan' AND $act=='input'){
if (empty($_POST[jumlah])){
    
    echo "<script>alert('jumlah produk belum diisi'); onclick=self.history.back()</script>";
}
else
{
	$cek_faktur = mysql_num_rows(mysql_query("SELECT * FROM penerimaan WHERE no_faktur = '$_POST[no_faktur]'"));
	if ( $cek_faktur > 0 ){
		echo "<script>alert('Nomor Faktur yang anda masukan sudah ada !');history.go(-1)</script>";
	} else{

	$jml_terima=$_POST['jumlah'];
	$tampil = mysql_query("SELECT * FROM produk WHERE 
	id_produk='$_POST[id_produk]'");
	$r=mysql_fetch_array($tampil);
	$jumlah = $r['stok'] + $jml_terima;
  	mysql_query("INSERT INTO penerimaan(  id_penerimaan,
									tgl_penerimaan,
									id_produk,
									jumlah,
									id_suplier,
									no_faktur,
									username)																		
						VALUES	('$_POST[id_penerimaan]',
						'$_POST[tanggal1]',
						'$_POST[id_produk]',
						'$_POST[jumlah]',
						'$_POST[id_suplier]',
						'$_POST[no_faktur]',
						'$_POST[username]')");
	mysql_query("UPDATE produk SET stok = '$jumlah' WHERE id_produk='$_POST[id_produk]'");	
						
																		
  header('location:../../media.php?module='.$module);}
	}
}

// Update kategori
elseif ($module=='penerimaan' AND $act=='update'){
  mysql_query("UPDATE penerimaan SET tgl_penerimaan = '$_POST[tgl_penerimaan]',
  id_produk = '$_POST[id_produk]',
  jumlah = '$_POST[jumlah]',
  id_suplier = '$_POST[id_suplier]'
  
  
  
  
  									WHERE id_penerimaan = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
}
?>
