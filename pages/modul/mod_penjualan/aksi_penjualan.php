<?php
session_start();
error_reporting(0);
include "../../../config/koneksi.php";
include "../../../config/library.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='penjualan' AND $act=='hapus'){
  mysql_query("DELETE FROM penjualan WHERE id_penjualan='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input kategori
elseif ($module=='penjualan' AND $act=='input'){
    $edit=mysql_query("SELECT * FROM produk WHERE id_produk='$_POST[id_produk]'");
    $r=mysql_fetch_array($edit);
	$nm_produk=$r[nama_produk];
	$stock=$r[stok];
	$total=$r[harga] * $_POST[jml_penjualan];
if (empty($_POST[tanggal1])){
    
    echo "<script>alert('Tanggal penjualan produk belum diisi'); onclick=self.history.back()</script>";
}
elseif ($stock < $_POST[jml_penjualan]){
    
    echo "<script>alert('jumlah stok tidak mencukupi'); onclick=self.history.back()</script>";
}
else
{
  mysql_query("INSERT INTO penjualan(  id_penjualan,
									tgl_penjualan,
									id_produk,
									jml_penjualan,
									tot_jual,
									username)									
																		
						VALUES	('$_POST[id_penjualan]',
						'$_POST[tanggal1]',
						'$_POST[id_produk]',
						'$_POST[jml_penjualan]',
						'$total',
						'$_POST[username]')");
												
						
																		
  header('location:../../media.php?module='.$module);}
}

// Update kategori
elseif ($module=='penjualan' AND $act=='update'){
    $edit=mysql_query("SELECT * FROM produk WHERE id_produk='$_POST[id_produk]'");
    $r=mysql_fetch_array($edit);
  $nm_produk=$r[nm_produk];
	$stock=$r[stok];
	$total=$r[harga] * $_POST[jml_penjualan];
  mysql_query("UPDATE penjualan SET tgl_penjualan = '$_POST[tanggal1]',
  id_produk = '$_POST[id_produk]',
  jml_penjualan = '$_POST[jml_penjualan]',
  tot_jual='$total'
WHERE id_penjualan = '$_POST[id_penjualan]'");
  header('location:../../media.php?module='.$module);
}

?>

