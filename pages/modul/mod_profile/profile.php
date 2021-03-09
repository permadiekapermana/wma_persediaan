<?php

include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_thumb.php";

$user = mysql_query("SELECT * FROM `users`, level
                            WHERE username='$_SESSION[namauser]'
                            ");
$profil = mysql_fetch_array($user);

echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Profil </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Profil User</h5>
    <div class='card-body'>
    <div class='table-responsive'>
  <table class='table table-striped'>
    <tr>
      <th width='20%'>Nama Lengkap</th>
      <td width='1%'>:</td>
      <td>$profil[nama_lengkap]</td>
    </tr>
    <tr>
      <th>Email</th>
      <td>:</td>
      <td>$profil[email]</td>
    </tr>
    <tr>
      <th>Nomor Telepon</th>
      <td>:</td>
      <td>$profil[no_telp]</td>
    </tr>
    <tr>
      <th>Username</th>
      <td>:</td>
      <td>
        $profil[username]
      </td>
    </tr>
    <tr>
      <th>Hak Akses</th>
      <td>:</td>
      <td>$profil[level]</td>
    </tr>
  </table>
</div>
    </div>
  </div>
</div>
</div>"
    
?>