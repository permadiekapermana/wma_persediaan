<?php
session_start();
error_reporting(0);
include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_thumb.php";
include "../../../config/fungsi_seo.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus produk
if ($module=='produk' AND $act=='hapus'){
  mysql_query("DELETE FROM produk WHERE id_produk='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input produk
elseif ($module=='produk' AND $act=='input'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file; 

  $produk_seo      = seo_title($_POST[nama_produk]);

  // Apabila ada gambar yang diupload
  // if (!empty($lokasi_file)){
  //   UploadImage($nama_file_unik);
  $cek_produk = mysql_num_rows(mysql_query("SELECT * FROM produk WHERE nama_produk = '$_POST[nama_produk]'"));
	if ( $cek_produk > 0 ){
		echo "<script>alert('Data produk yang anda masukan sudah ada !');history.go(-1)</script>";
	} else{
    mysql_query("INSERT INTO produk(id_produk, nama_produk,
                                    produk_seo,
                                    id_kategori,
                                    harga,
                                    stok,
                                    deskripsi,
                                    tgl_masuk) 
                            VALUES('$_POST[id_produk]', '$_POST[nama_produk]',
                                   '$produk_seo',
                                   '$_POST[kategori]',
                                   '$_POST[harga]',
                                   '$_POST[stok]',
                                   '$_POST[deskripsi]',
                                   '$tgl_sekarang')");
  // }
  // else{
  //   mysql_query("INSERT INTO produk(nama_produk,
  //                                   produk_seo,
  //                                   id_kategori,
  //                                   harga,
  //                                   stok,
  //                                   deskripsi,
  //                                   tgl_posting) 
  //                           VALUES('$_POST[nama_produk]',
  //                                  '$produk_seo',
  //                                  '$_POST[kategori]',                                
  //                                  '$_POST[harga]',
  //                                  '$_POST[stok]',
  //                                  '$_POST[deskripsi]',
  //                                  '$tgl_sekarang')");
  // }
  header('location:../../media.php?module='.$module);
  }
}

// Update produk
elseif ($module=='produk' AND $act=='update'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file; 

  $produk_seo      = seo_title($_POST[nama_produk]);

  // Apabila gambar tidak diganti
  if (empty($lokasi_file)){
    mysql_query("UPDATE produk SET nama_produk = '$_POST[nama_produk]',
                                   produk_seo  = '$produk_seo',
                                  --  produk_seo  = '$judul_seo', 
                                   id_kategori = '$_POST[kategori]',
                                   harga       = '$_POST[harga]',
                                   stok        = '$_POST[stok]',
                                   deskripsi   = '$_POST[deskripsi]'
                             WHERE id_produk   = '$_POST[id]'");
  }
  // else{
  //   UploadImage($nama_file_unik);
  //   mysql_query("UPDATE produk SET nama_produk = '$_POST[judul]',
  //                                  produk_seo  = '$produk_seo', 
  //                                  id_kategori = '$_POST[kategori]',
  //                                  harga       = '$_POST[harga]',
  //                                  stok        = '$_POST[stok]',
  //                                  deskripsi   = '$_POST[deskripsi]',
  //                                  gambar      = '$nama_file_unik'   
  //                            WHERE id_produk   = '$_POST[id]'");
  // }
  header('location:../../media.php?module='.$module);
}
?>
