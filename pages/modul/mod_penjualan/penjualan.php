<?php
  include "../config/koneksi.php";
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }

else{

  $pel="PNJ.";
  $y=substr($pel,0,2);
  $query=mysql_query("select * from penjualan where substr(id_penjualan,1,2)='$y' order by id_penjualan desc limit 0,1");
  $row=mysql_num_rows($query);
  $data=mysql_fetch_array($query);
  
  if ($row>0){
  $no=substr($data['id_penjualan'],-3)+1;}
  else{
  $no=1;
  }
  $nourut=1000+$no;
  $no_pel=$pel.substr($nourut,-3);

$aksi="modul/mod_penjualan/aksi_penjualan.php";
switch($_GET[act]){
  // Tampil User
  default:

echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Penjualan </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Data Penjualan</h5>
    <div class='card-body'>
    <a href='?module=penjualan&act=tambahpenjualan'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Tambah</button></a>
    </p>
    <div class='table-responsive'>
    <table id='example4' class='table table-striped table-bordered' style='width:100%'>
        <thead>
            <tr>
                <th width='5px'>No.</th>
                <th>Nomor Penjualan</th>
                <th>Tanggal Penjualan</th>
                <th>Produk</th>
                <th>Jumlah Penjualan</th>
                <th>Total Penjualan</th>
                <th width='15%'>Aksi</th>
            </tr>
        </thead>
        <tbody>";
        $tampil = mysql_query("SELECT
        *
      FROM
        `penjualan`
        INNER JOIN `produk` ON `produk`.`id_produk` = `penjualan`.`id_produk`
                                  ORDER BY id_penjualan DESC");  
        $no = 1;
        while($r=mysql_fetch_array($tampil)){
        echo"
            <tr>
                <td>$no</td>
                <td>$r[id_penjualan]</td>
                <td>$r[tgl_penjualan]</td>
                <td>$r[nama_produk]</td>
                <th>$r[jml_penjualan]</th>
                <th>$r[tot_jual]</th>
                <td><a href='?module=penjualan&act=editpenjualan&id=$r[id_penjualan] 'class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit</a>
                <a href='$aksi?module=penjualan&act=hapus&id=$r[id_penjualan]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin hapus data ? Data yang dihapus tidak dapat dipulihkan !')\"><i class='fa fa-trash-o'></i> Hapus</a>
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
  
  case "tambahpenjualan":

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Penjualan </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Tambah Penjualan</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=penjualan&act=input'>
      <div class='col-md-6'>
          <label for='no_penjualan' class='col-form-label'>Nomor Penjualan</label>
          <input id='no_penjualan' name='id_penjualan' value='$no_pel' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='tanggal1' class='col-form-label'>Tanggal Penjualan</label>
          <input id='tanggal1' name='tanggal1' type='date' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='id_produk' class='col-form-label'>Nama Produk</label>
          <select class='form-control' name='id_produk'>
            <option>-- Pilih Produk --</option>";
            $tampil=mysql_query("SELECT * FROM produk ORDER BY id_produk");
            if ($r[id_produk]==0){
            echo "<option value=0 selected>- Pilih Produk -</option>";
            }   

            while($w=mysql_fetch_array($tampil)){
            if ($r[id_produk]==$w[id_produk]){
            echo "<option value=$w[id_produk] selected>$w[nama_produk]</option>";
            }
            else{
            echo "<option value=$w[id_produk]>$w[nama_produk]</option>";
            }
            }
            echo "
          </select>
      </div>
      <div class='col-md-6'>
          <label for='jml_penjualan' class='col-form-label'>Jumlah</label>
          <input id='jml_penjualan' name='jml_penjualan' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='petugas' class='col-form-label'>Diinput Oleh :</label>
          <input id='username' name='username' value='$_SESSION[namauser]' type='hidden' class='form-control' required>
          <input id='petugas' name='petugas' value='$_SESSION[namalengkap]' type='text' class='form-control' required>
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
    
  case "editpenjualan":

  $edit=mysql_query("SELECT * FROM penjualan, users WHERE id_penjualan='$_GET[id]'");
  $r=mysql_fetch_array($edit);

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Penjualan </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Edit Penjualan</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=penjualan&act=update'>
      <div class='col-md-6'>
          <label for='id_penjualan' class='col-form-label'>Nomor Penjualan</label>
          <input id='id_penjualan' name='id_penjualan' value='$r[id_penjualan]' type='text' class='form-control' disabled>
          <input id='id_penjualan' name='id_penjualan' value='$r[id_penjualan]' type='hidden' class='form-control' required>
      </div>      
      <div class='col-md-6'>
          <label for='tanggal1' class='col-form-label'>Tanggal Penjualan</label>
          <input id='tanggal1' name='tanggal1' value='$r[tgl_penjualan]' type='date' class='form-control' required>
      </div> 
      <div class='col-md-6'>
          <label for='id_produk' class='col-form-label'>Nama Produk</label>
          <select class='form-control' name='id_produk'>
            <option>-- Pilih Produk --</option>";
            $tampil=mysql_query("SELECT * FROM produk ORDER BY id_produk");
            if ($r[id_produk]==0){
            echo "<option value=0 selected>- Pilih Produk -</option>";
            }   

            while($w=mysql_fetch_array($tampil)){
            if ($r[id_produk]==$w[id_produk]){
            echo "<option value=$w[id_produk] selected>$w[nama_produk]</option>";
            }
            else{
            echo "<option value=$w[id_produk]>$w[nama_produk]</option>";
            }
            }
            echo "
          </select>
      </div>
      <div class='col-md-6'>
          <label for='jml_penjualan' class='col-form-label'>Jumlah Penjualan</label>
          <input id='jml_penjualan' name='jml_penjualan' value='$r[jml_penjualan]' type='text' class='form-control' required>
      </div>
      <br>
      <div class='col-md-6'>
          <label for='no_faktur' class='col-form-label'>Diinput Oleh : $r[nama_lengkap]</label>
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
