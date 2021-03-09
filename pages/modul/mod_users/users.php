<?php
  include "../config/koneksi.php";
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }

else{

$aksi="modul/mod_users/aksi_users.php";
switch($_GET[act]){
  // Tampil User
  default:

echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Users </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Data User</h5>
    <div class='card-body'>
    <a href='?module=users&act=tambahuser'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Tambah</button></a>
    </p>
    <div class='table-responsive'>
    <table id='example4' class='table table-striped table-bordered' style='width:100%'>
        <thead>
            <tr>
                <th width='5px'>No.</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Level</th>
                <th>Blokir</th>
                <th width='10%'>Aksi</th>
            </tr>
        </thead>
        <tbody>";
        $tampil = mysql_query("SELECT
        *
      FROM
        `users`
        INNER JOIN `level` ON `level`.`id_level` = `users`.`id_level`
                                  ORDER BY username DESC");  
        $no = 1;
        while($r=mysql_fetch_array($tampil)){
        echo"
            <tr>
                <td>$no</td>
                <td>$r[nama_lengkap]</td>
                <td>$r[username]</td>
                <td>$r[level]</td>
                <td>$r[blokir]</td>
                <td><a href='?module=users&act=edituser&id=$r[username] 'class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit</a>
                </td>
            </tr>";
						$no++;						
	        }
        echo"               
        </tbody>
    </table>
</div>
    </div>
  </div>
</div>
</div>";
  
    break;
  
  case "tambahuser":

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Users </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Tambah User</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=users&act=input'>
      <div class='col-md-6'>
          <label for='username' class='col-form-label'>Username</label>
          <input id='username' name='username' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='password' class='col-form-label'>Password</label>
          <input id='password' name='password' type='password' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='nama_lengkap' class='col-form-label'>Nama Lengkap</label>
          <input id='nama_lengkap' name='nama_lengkap' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='email' class='col-form-label'>Email</label>
          <input id='email' name='email' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='no_telp' class='col-form-label'>Nomor Telepon</label>
          <input id='no_telp' name='no_telp' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
        <label for='no_telp' class='col-form-label'>Hak Akses</label> <br>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' checked='' value='LVL.001' class='custom-control-input'><span class='custom-control-label'>Admin</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.002' class='custom-control-input'><span class='custom-control-label'>Partman</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.003' class='custom-control-input'><span class='custom-control-label'>Kepala Bengkel</span>
        </label>
      </div>
      <br>
      <div class='col-md-6'>
      <button class='btn btn-primary' type='button' onclick=self.history.back()>Cancel</button>
      <button class='btn btn-primary' type='reset'>Reset</button>
      <button type='submit' class='btn btn-round btn-primary'>Submit</button>
      </div>
      </form>

      </div>
    </div>
  </div>
  </div>";

     break;
    
  case "edituser":

  $edit = mysql_query("SELECT
  *
FROM
  `users`
  INNER JOIN `level` ON `level`.`id_level` = `users`.`id_level` WHERE username='$_GET[id]'");
  $r    = mysql_fetch_array($edit);
  $pass=($r[password]);

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Users </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Edit User</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=users&act=update'>
      <div class='col-md-6'>
          <label for='username' class='col-form-label'>Username</label>
          <input id='username' name='username' value='$r[username]' type='text' class='form-control' required>
          <input id='username' name='id' value='$r[username]' type='hidden' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='password' class='col-form-label'>Password</label>
          <input id='password' name='password' type='password' class='form-control'>
      </div>
      <div class='col-md-6'>
          <label for='nama_lengkap' class='col-form-label'>Nama Lengkap</label>
          <input id='nama_lengkap' name='nama_lengkap' value='$r[nama_lengkap]' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='email' class='col-form-label'>Email</label>
          <input id='email' name='email' value='$r[email]' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='no_telp' class='col-form-label'>Nomor Telepon</label>
          <input id='no_telp' name='no_telp' value='$r[no_telp]' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
        <label for='no_telp' class='col-form-label'>Hak Akses</label> <br>";
        if ($r[level]=='Admin')   {                         
        echo"
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' checked='' value='LVL.001' class='custom-control-input'><span class='custom-control-label'>Admin</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.002' class='custom-control-input'><span class='custom-control-label'>Partman</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.003' class='custom-control-input'><span class='custom-control-label'>Kepala Bengkel</span>
        </label>";
        }
        elseif ($r[level]=='Partman')    {
        echo"
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.001' class='custom-control-input'><span class='custom-control-label'>Admin</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.002' checked='' class='custom-control-input'><span class='custom-control-label'>Partman</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.003' class='custom-control-input'><span class='custom-control-label'>Kepala Bengkel</span>
        </label>";
        }
        elseif ($r[level]=='Kepala Bengkel')    {
        echo"
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.001' class='custom-control-input'><span class='custom-control-label'>Admin</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.002'  class='custom-control-input'><span class='custom-control-label'>Partman</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='level' value='LVL.003' checked='' class='custom-control-input'><span class='custom-control-label'>Kepala Bengkel</span>
        </label>";
        }
        echo"
      </div>";
      if ($_SESSION[namauser]==$_GET[id])   {                         
      echo"      
          <input type='hidden' name='blokir' checked='' value='N' class='custom-control-input'>
        ";
      }
      else{
      echo"
        <div class='col-md-6'>
        <label for='no_telp' class='col-form-label'>Blokir User</label> <br>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='blokir' checked='' value='N' class='custom-control-input'><span class='custom-control-label'>Tidak</span>
        </label>
        <label class='custom-control custom-radio custom-control-inline'>
          <input type='radio' name='blokir' value='Y' class='custom-control-input'><span class='custom-control-label'>Ya</span>
        </label>
      </div>";
      }
      echo"
      <br>
      <div class='col-md-6'>
      <button class='btn btn-primary' type='button' onclick=self.history.back()>Cancel</button>
      <button class='btn btn-primary' type='reset'>Reset</button>
      <button type='submit' class='btn btn-round btn-primary'>Submit</button>
      </div>
      </form>

      </div>
    </div>
  </div>
  </div>";

    break;  
}
}
?>
