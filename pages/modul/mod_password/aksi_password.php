<?php
session_start();
error_reporting(0);
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

$user = mysql_query("SELECT * FROM users where username='$_SESSION[namauser]'");
$r    = mysql_fetch_array($user);

$pass_lama=md5($_POST[pass_lama]);
$pass_baru=md5($_POST[pass_baru]);

if (empty($_POST[pass_baru]) OR empty($_POST[pass_lama]) OR empty($_POST[pass_ulangi])){
  echo "<p align=center>Anda harus mengisikan semua data pada form Ganti Password.<br />"; 
  echo "<a href=javascript:history.go(-1)><b>Ulangi Lagi</b></a></p>";
}
else{ 
// Apabila password lama cocok dengan password admin di database
if ($pass_lama==$r[password]){
  // Pastikan bahwa password baru yang dimasukkan sebanyak dua kali sudah cocok
  if ($_POST[pass_baru]==$_POST[pass_ulangi]){
    mysql_query("UPDATE users SET password = '$pass_baru' where username='$_SESSION[namauser]'");
    echo "<script>alert('Password Berhasil Diganti!');history.go(-1);</script>"; 
  }
  else{
    // echo "<p align=center>Password baru yang Anda masukkan sebanyak dua kali belum cocok.<br />"; 
    echo "<script>alert('Konfirmasi Password yang anda masukkan tidak cocok!');history.go(-1);</script>";  
  }
}
else{
  // echo "<p align=center>Anda salah memasukkan Password Lama Anda.<br />"; 
  echo "<script>alert('Password lama anda Salah!');history.go(-1);</script>";
}
}
}
?>
