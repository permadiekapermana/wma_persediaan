<?php
  include "../config/koneksi.php";
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }

else{

  $pel="PRO.";
  $y=substr($pel,0,2);
  $query=mysql_query("select * from produk where substr(id_produk,1,2)='$y' order by id_produk desc limit 0,1");
  $row=mysql_num_rows($query);
  $data=mysql_fetch_array($query);
  
  if ($row>0){
  $no=substr($data['id_produk'],-3)+1;}
  else{
  $no=1;
  }
  $nourut=1000+$no;
  $nopel=$pel.substr($nourut,-3);

$aksi="modul/mod_produk/aksi_produk.php";
switch($_GET[act]){
  // Tampil User
  default:

echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Produk </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Data Produk</h5>
    <div class='card-body'>
    <a href='?module=produk&act=tambahproduk'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Tambah</button></a>
    </p>
    <div class='table-responsive'>
    <table id='example4' class='table table-striped table-bordered' style='width:100%'>
        <thead>
            <tr>
                <th width='5px'>No.</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>Tanggal Masuk</th>
                <th width='15%'>Aksi</th>
            </tr>
        </thead>
        <tbody>";
        $tampil = mysql_query("SELECT
        *
      FROM
        `produk`
        INNER JOIN `kategori` ON `kategori`.`id_kategori` = `produk`.`id_kategori`
                                  ORDER BY id_produk DESC");  
        $no = 1;
        while($r=mysql_fetch_array($tampil)){
        echo"
            <tr>
                <td>$no</td>
                <td>$r[nama_produk]</td>
                <td>$r[nama_kategori]</td>
                <td>$r[harga]</td>
                <th>$r[stok]</th>
                <th>$r[tgl_masuk]</th>
                <td><a href='?module=produk&act=editproduk&id=$r[id_produk] 'class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit</a>
                <a href='$aksi?module=produk&act=hapus&id=$r[id_produk]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin hapus data ? Data yang dihapus tidak dapat dipulihkan !')\"><i class='fa fa-trash-o'></i> Hapus</a>
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
  
  case "tambahproduk":

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Produk </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Tambah Produk</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=produk&act=input'>
      <div class='col-md-6'>
          <label for='id_produk' class='col-form-label'>Kode Produk</label>
          <input id='id_produk' value='$nopel' name='id_produk' type='text' class='form-control'>
      </div>
      <div class='col-md-6'>
          <label for='nama_produk' class='col-form-label'>Nama Produk</label>
          <input id='nama_produk' name='nama_produk' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
        <label for='nama_produk' class='col-form-label'>Kategori Produk</label>
        <select class='form-control' name='kategori'>
          <option>-- Pilih Kategori Produk --</option>";
          $tampil=mysql_query("SELECT * FROM kategori ORDER BY id_kategori");
          while($r=mysql_fetch_array($tampil)){
          echo "<option value=$r[id_kategori]>$r[nama_kategori]</option>";
          }
          echo "
        </select>
      </div>    
      <div class='col-md-6'>
          <label for='harga' class='col-form-label'>Harga</label>
          <input id='harga' name='harga' type='text' class='form-control' required>
      </div> 
      <div class='col-md-6'>
          <label for='stok' class='col-form-label'>Stok</label>
          <input id='stok' name='stok' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='deskripsi' class='col-form-label'>Deskripsi</label>
          <textarea class='form-control' id='stok' name='deskripsi' rows='3' required></textarea>
      </div>
      <div class='col-md-6'>
          <input type=hidden name='fupload' size=40> 
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
    
  case "editproduk":

  $edit = mysql_query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
  $r    = mysql_fetch_array($edit);

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Produk </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Edit Produk</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=produk&act=update'>
      <div class='col-md-6'>
          <label for='id_produk' class='col-form-label'>Kode Produk</label>
          <input id='id_produk' value='$nopel' name='id_produk' type='text' class='form-control' disabled>
          <input id='id_produk' value='$nopel' name='id_produk' type='hidden' class='form-control'>
      </div>
      <div class='col-md-6'>
          <label for='nama_produk' class='col-form-label'>Nama Produk</label>
          <input id='nama_produk' value='$r[nama_produk]' name='nama_produk' type='text' class='form-control' required>
          <input id='nama_produk' value='$r[id_produk]' name='id' type='hidden' class='form-control' required>
      </div>
      <div class='col-md-6'>
        <label for='nama_produk' class='col-form-label'>Kategori Produk</label>
        <select class='form-control' name='kategori'>
          <option>-- Pilih Kategori Produk --</option>";          
          $tampil=mysql_query("SELECT * FROM kategori ORDER BY id_kategori");
          if ($r[id_kategori]==0){
          echo "<option value='0' selected>-- Pilih Kategori --</option>";
          }   
          while($w=mysql_fetch_array($tampil)){
          if ($r[id_kategori]==$w[id_kategori]){
          echo "<option value=$w[id_kategori] selected>$w[nama_kategori]</option>";
          }
          else{
          echo "<option value=$w[id_kategori]>$w[nama_kategori]</option>";
          }
          }
          echo "
        </select>
      </div>    
      <div class='col-md-6'>
          <label for='harga' class='col-form-label'>Harga</label>
          <input id='harga' name='harga' value='$r[harga]' type='text' class='form-control' required>
      </div> 
      <div class='col-md-6'>
          <label for='stok' class='col-form-label'>Stok</label>
          <input id='stok' name='stok' value='$r[stok]' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='deskripsi' class='col-form-label'>Deskripsi</label>
          <input class='form-control' value='$r[deskripsi]' id='stok' name='deskripsi' rows='3' required></input>
      </div>
      <div class='col-md-6'>
          <input type=hidden name='fupload' size=40> 
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
