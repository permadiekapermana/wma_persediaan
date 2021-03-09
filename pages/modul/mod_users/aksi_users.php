<?php

session_start();
error_reporting(0);
include "../../../config/koneksi.php";
include "../../../config/fungsi_seo.php";

$module=$_GET[module];
$act=$_GET[act];

// Input user
if ($module=='users' AND $act=='input'){
  $pass=md5($_POST[password]);
  $cek_username = mysql_num_rows(mysql_query("SELECT * FROM users WHERE username = '$_POST[username]'"));
	if ( $cek_username > 0 ){
		echo "<script>alert('Username yang anda masukan sudah ada !');history.go(-1)</script>";
	} else{
  mysql_query("INSERT INTO users(username,
                                 password,
                                 nama_lengkap,
                                 email, 
                                 no_telp,
                                 id_level,
                                 blokir,
                                 id_session) 
	                       VALUES('$_POST[username]',
                                '$pass',
                                '$_POST[nama_lengkap]',
                                '$_POST[email]',
                                '$_POST[no_telp]',
                                '$_POST[level]',
                                'N',
                                '$pass')");
  header('location:../../media.php?module='.$module);
  }
}

// Update user
elseif ($module=='users' AND $act=='update'){
  if (empty($_POST[password])) {
    mysql_query("UPDATE users SET nama_lengkap   = '$_POST[nama_lengkap]',
                                  email          = '$_POST[email]',
                                  blokir         = '$_POST[blokir]',  
                                  no_telp        = '$_POST[no_telp]',  
                                  id_level        = '$_POST[level]'
                           WHERE  username     = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
    mysql_query("UPDATE users SET password        = '$pass',
                                 nama_lengkap    = '$_POST[nama_lengkap]',
                                 email           = '$_POST[email]',  
                                 blokir          = '$_POST[blokir]',  
                                 no_telp         = '$_POST[no_telp]',
                                 id_level        = '$_POST[level]'
                           WHERE username      = '$_POST[id]'");
  }
  header('location:../../media.php?module='.$module);
}

?>
