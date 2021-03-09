<?php
  include "../config/koneksi.php";
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }

else{

  $pel="KAT.";
  $y=substr($pel,0,2);
  $query=mysql_query("select * from kategori where substr(id_kategori,1,2)='$y' order by id_kategori desc limit 0,1");
  $row=mysql_num_rows($query);
  $data=mysql_fetch_array($query);
  
  if ($row>0){
  $no=substr($data['id_kategori'],-3)+1;}
  else{
  $no=1;
  }
  $nourut=1000+$no;
  $nopel=$pel.substr($nourut,-3);

$aksi="modul/mod_kategori/aksi_kategori.php";
switch($_GET[act]){
  // Tampil User
  default:

echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Kategori </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Data Kategori</h5>
    <div class='card-body'>
    <a href='?module=kategori&act=tambahkategori'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Tambah</button></a>
    </p>
    <div class='table-responsive'>
    <table id='example4' class='table table-striped table-bordered' style='width:100%'>
        <thead>
            <tr>
                <th width='5px'>No.</th>
                <th>Nama Kategori</th>
                <th width='15%'>Aksi</th>
            </tr>
        </thead>
        <tbody>";
        $tampil = mysql_query("SELECT * FROM `kategori`
                                  ORDER BY id_kategori DESC");  
        $no = 1;
        while($r=mysql_fetch_array($tampil)){
        echo"
            <tr>
                <td>$no</td>
                <td>$r[nama_kategori]</td>
                <td><a href='?module=kategori&act=editkategori&id=$r[id_kategori] 'class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit</a>
                <a href='$aksi?module=kategori&act=hapus&id=$r[id_kategori]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin hapus data ? Data yang dihapus tidak dapat dipulihkan !')\"><i class='fa fa-trash-o'></i> Hapus</a>
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
  
  case "tambahkategori":

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Kategori </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Tambah Kategori</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=kategori&act=input'>      
      <div class='col-md-6'>
          <label for='nama_kategori' class='col-form-label'>Nama Kategori</label>
          <input id='nama_kategori' name='nama_kategori' type='text' class='form-control' required>
          <input id='kode_kategori' value='$nopel' name='id_kategori' type='hidden' class='form-control'>
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
    
  case "editkategori":
  
  $edit = mysql_query("SELECT * FROM kategori WHERE id_kategori='$_GET[id]'");
  $r    = mysql_fetch_array($edit);

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Kategori </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Edit Kategori</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=kategori&act=update'>
      <div class='col-md-6'>
          <label for='nama_kategori' class='col-form-label'>Nama Kategori</label>
          <input id='nama_kategori' name='nama_kategori' value='$r[nama_kategori]' type='text' class='form-control' required>
          <input id='username' name='id' value='$r[id_kategori]' type='hidden' class='form-control' required>
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
}
}
?>
