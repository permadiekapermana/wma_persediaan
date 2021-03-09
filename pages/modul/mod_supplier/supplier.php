<?php
  include "../config/koneksi.php";
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }

else{

  $pel="SPY.";
  $y=substr($pel,0,2);
  $query=mysql_query("select * from suplier where substr(id_suplier,1,2)='$y' order by id_suplier desc limit 0,1");
  $row=mysql_num_rows($query);
  $data=mysql_fetch_array($query);
  
  if ($row>0){
  $no=substr($data['id_suplier'],-3)+1;}
  else{
  $no=1;
  }
  $nourut=1000+$no;
  $nopel=$pel.substr($nourut,-3);

$aksi="modul/mod_supplier/aksi_supplier.php";
switch($_GET[act]){
  // Tampil User
  default:

echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Supplier </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Data Supplier</h5>
    <div class='card-body'>
    <a href='?module=supplier&act=tambahsupplier'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Tambah</button></a>
    </p>
    <div class='table-responsive'>
    <table id='example4' class='table table-striped table-bordered' style='width:100%'>
        <thead>
            <tr>
                <th width='5px'>No.</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th width='15%'>Aksi</th>
            </tr>
        </thead>
        <tbody>";
        $tampil = mysql_query("SELECT * FROM `suplier`
                                  ORDER BY id_suplier DESC");  
        $no = 1;
        while($r=mysql_fetch_array($tampil)){
        echo"
            <tr>
                <td>$no</td>
                <td>$r[nm_suplier]</td>
                <td>$r[alamat]</td>
                <td>$r[no_telp]</td>
                <td><a href='?module=supplier&act=editsupplier&id=$r[id_suplier] 'class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit</a>
                <a href='$aksi?module=supplier&act=hapus&id=$r[id_suplier]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin hapus data ? Data yang dihapus tidak dapat dipulihkan !')\"><i class='fa fa-trash-o'></i> Hapus</a>
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
  
  case "tambahsupplier":

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Supplier </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Tambah Supplier</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=supplier&act=input'>
      <div class='col-md-6'>
          <label for='kode_supplier' class='col-form-label'>Kode Supplier</label>
          <input id='kode_supplier' value='$nopel' name='id_suplier' type='text' class='form-control'>
      </div>
      <div class='col-md-6'>
          <label for='nm_suplier' class='col-form-label'>Nama Supplier</label>
          <input id='nm_suplier' name='nm_suplier' type='text' class='form-control' required>
      </div> 
      <div class='col-md-6'>
          <label for='alamat' class='col-form-label'>Alamat</label>
          <input id='alamat' name='alamat' type='text' class='form-control' required>
      </div>      
      <div class='col-md-6'>
          <label for='no_telp' class='col-form-label'>Nomor Telepon</label>
          <input id='no_telp' name='no_telp' type='text' class='form-control' required>
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
    
  case "editsupplier":

  $edit = mysql_query("SELECT * FROM suplier WHERE id_suplier='$_GET[id]'");
  $r    = mysql_fetch_array($edit);

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Supplier </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Edit Supplier</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=supplier&act=update'>
      <div class='col-md-6'>
          <label for='id_suplier' class='col-form-label'>Kode Supplier</label>
          <input id='id_suplier' name='id_suplier' value='$r[id_suplier]' type='hidden' class='form-control' required>
          <input id='id_suplier' name='id_suplier' value='$r[id_suplier]' type='text' class='form-control' disabled>
      </div>      
      <div class='col-md-6'>
          <label for='nm_suplier' class='col-form-label'>Nama Supplier</label>
          <input id='nm_suplier' name='nm_suplier' value='$r[nm_suplier]' type='text' class='form-control' required>
      </div>  
      <div class='col-md-6'>
          <label for='alamat' class='col-form-label'>Alamat</label>
          <input id='alamat' name='alamat' value='$r[alamat]' type='text' class='form-control' required>
      </div>     
      <div class='col-md-6'>
          <label for='no_telp' class='col-form-label'>Nomor Telepon</label>
          <input id='no_telp' name='no_telp' value='$r[no_telp]' type='text' class='form-control' required>
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
