<?php
session_start();
error_reporting(0);
include "../../../config/koneksi.php";


$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='supplier' AND $act=='hapus'){
  mysql_query("DELETE FROM suplier WHERE id_suplier='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input kategori
elseif ($module=='supplier' AND $act=='input'){
if (empty($_POST[nm_suplier])){
    
    echo "<script>alert('nama suplier barang belum diisi'); onclick=self.history.back()</script>";
}
$cek_kategori = mysql_num_rows(mysql_query("SELECT * FROM suplier WHERE nm_suplier = '$_POST[nm_suplier]'"));
if ( $cek_kategori > 0 ){
  echo "<script>alert('Data Supplier yang anda masukan sudah ada !');history.go(-1)</script>";
} else{

  mysql_query("INSERT INTO suplier(  id_suplier,
									nm_suplier,
									alamat,
									no_telp)
									
									
									
																		
						VALUES	('$_POST[id_suplier]',
						'$_POST[nm_suplier]',
						'$_POST[alamat]',
						'$_POST[no_telp]')");
												
						
																		
  header('location:../../media.php?module='.$module);}
}


// Update kategori
elseif ($module=='supplier' AND $act=='update'){
  mysql_query("UPDATE suplier SET nm_suplier = '$_POST[nm_suplier]',
  alamat = '$_POST[alamat]',
  no_telp = '$_POST[no_telp]'
  
  
  
  
  									WHERE id_suplier = '$_POST[id_suplier]'");
  header('location:../../media.php?module='.$module);
}
?>
