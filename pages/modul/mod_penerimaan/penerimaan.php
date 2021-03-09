<?php
  include "../config/koneksi.php";
  include "../config/library.php";
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }

else{

  $pel="PNR.";
  $y=substr($pel,0,2);
  $query=mysql_query("select * from penerimaan where substr(id_penerimaan,1,2)='$y' order by id_penerimaan desc limit 0,1");
  $row=mysql_num_rows($query);
  $data=mysql_fetch_array($query);
  
  if ($row>0){
  $no=substr($data['id_penerimaan'],-3)+1;}
  else{
  $no=1;
  }
  $nourut=1000+$no;
  $no_pel=$pel.substr($nourut,-3);

  $pel2="FAK.";
  $y2=substr($pel2,0,2);
  $query2=mysql_query("select * from penerimaan where substr(no_faktur,1,2)='$y2' order by id_penerimaan desc limit 0,1");
  $row2=mysql_num_rows($query2);
  $data2=mysql_fetch_array($query2);
  
  if ($row2>0){
  $no2=substr($data2['no_faktur'],-3)+1;}
  else{
  $no2=1;
  }
  $nourut2=1000+$no2;
  $no_pel2=$pel2.substr($nourut2,-3);

$aksi="modul/mod_penerimaan/aksi_penerimaan.php";
switch($_GET[act]){
  // Tampil User
  default:

echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Penerimaan </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Data Penerimaan</h5>
    <div class='card-body'>
    <a href='?module=penerimaan&act=tambahpenerimaan'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Tambah</button></a>
    </p>
    <div class='table-responsive'>
    <table id='example4' class='table table-striped table-bordered' style='width:100%'>
        <thead>
            <tr>
                <th width='5px'>No.</th>
                <th>Nomor Penerimaan</th>
                <th>Tanggal Penerimaan</th>
                <th>Produk</th>
                <th>Nomor Supplier</th>
                <th>Nomor Faktur</th>
                <th>Jumlah</th>
                <th width='15%'>Aksi</th>
            </tr>
        </thead>
        <tbody>";
        $tampil = mysql_query("SELECT
        *
      FROM
        `penerimaan`
        INNER JOIN `produk` ON `produk`.`id_produk` = `penerimaan`.`id_produk`
        INNER JOIN `suplier` ON `suplier`.`id_suplier` = `penerimaan`.`id_suplier`
                                  ORDER BY id_penerimaan DESC");  
        $no = 1;
        while($r=mysql_fetch_array($tampil)){
        echo"
            <tr>
                <td>$no</td>
                <td>$r[id_penerimaan]</td>
                <td>$r[tgl_penerimaan]</td>
                <td>$r[nama_produk]</td>
                <th>$r[id_suplier]</th>
                <th>$r[no_faktur]</th>
                <th>$r[jumlah]</th>
                <td><a href='?module=penerimaan&act=editpenerimaan&id=$r[id_penerimaan] 'class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit</a>
                <a href='$aksi?module=penerimaan&act=hapus&id=$r[id_penerimaan]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin hapus data ? Data yang dihapus tidak dapat dipulihkan !')\"><i class='fa fa-trash-o'></i> Hapus</a>
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
  
  case "tambahpenerimaan":

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Penerimaan </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Tambah Penerimaan</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=penerimaan&act=input'>
      <div class='col-md-6'>
          <label for='id_penerimaan' class='col-form-label'>Nomor Penerimaan</label>
          <input id='id_penerimaan' name='id_penerimaan' value='$no_pel' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='tanggal1' class='col-form-label'>Tanggal Penerimaan</label>
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
          <label for='jumlah' class='col-form-label'>Jumlah</label>
          <input id='jumlah' name='jumlah' type='text' class='form-control' required>
      </div>
      <div class='col-md-6'>
          <label for='no_suplier' class='col-form-label'>Nama Supplier</label>
          <select class='form-control' name='id_suplier'>";
            $tampil=mysql_query("SELECT * FROM suplier ORDER BY id_suplier");
            if ($r[id_suplier]==0){
            echo "<option value=0 selected>- Pilih Nama Suplpier -</option>";
            }   

            while($w=mysql_fetch_array($tampil)){
            if ($r[id_suplier]==$w[id_suplier]){
            echo "<option value=$w[id_suplier] selected>$w[nm_suplier]</option>";
            }
            else{
            echo "<option value=$w[id_suplier]>$w[nm_suplier]</option>";
            }
            }
            echo "
          </select>
      </div> 
      <div class='col-md-6'>
          <label for='no_faktur' class='col-form-label'>Nomor Faktur</label>
          <input id='no_faktur' name='no_faktur' value='$no_pel2' type='text' class='form-control' required>
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
    
  case "editpenerimaan":

  $edit=mysql_query("SELECT
  *
FROM
  `penerimaan`
  INNER JOIN `produk` ON `produk`.`id_produk` = `penerimaan`.`id_produk`
  INNER JOIN `suplier` ON `suplier`.`id_suplier` = `penerimaan`.`id_suplier`
  INNER JOIN `users` ON `users`.`username` = `penerimaan`.`username` WHERE id_penerimaan='$_GET[id]'");
  $r=mysql_fetch_array($edit);

  echo"
  <div class='row'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
      <div class='page-header'>
        <h2 class='pageheader-title'>Penerimaan </h2>
      </div>
    </div>
  </div>
  <div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='card'>
    <h5 class='card-header'>Edit Penerimaan</h5>
      <div class='card-body'>
      
      <form method='POST' action='$aksi?module=penerimaan&act=update'>
      <div class='col-md-6'>
          <label for='nama_kategori' class='col-form-label'>Nomor Penerimaan</label>
          <input id='nama_kategori' name='id_penerimaan' value='$r[id_penerimaan]' type='text' class='form-control' disabled>
          <input id='username' name='id' value='$r[id_penerimaan]' type='hidden' class='form-control' required>
      </div>      
      <div class='col-md-6'>
          <label for='tgl_penerimaan' class='col-form-label'>Tanggal Penerimaan</label>
          <input id='tgl_penerimaan' name='tgl_penerimaan' value='$r[tgl_penerimaan]' type='date' class='form-control' required>
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
          <label for='jumlah' class='col-form-label'>Jumlah</label>
          <input id='jumlah' name='jumlah' value='$r[jumlah]' type='text' class='form-control' required>
      </div> 
      <div class='col-md-6'>
          <label for='no_suplier' class='col-form-label'>Nama Supplier</label>
          <select class='form-control' name='id_suplier'>";
            $tampil=mysql_query("SELECT * FROM suplier ORDER BY id_suplier");
            if ($r[id_suplier]==0){
            echo "<option value=0 selected>- Pilih Nama Suplpier -</option>";
            }   

            while($w=mysql_fetch_array($tampil)){
            if ($r[id_suplier]==$w[id_suplier]){
            echo "<option value=$w[id_suplier] selected>$w[nm_suplier]</option>";
            }
            else{
            echo "<option value=$w[id_suplier]>$w[nm_suplier]</option>";
            }
            }
            echo "
          </select>
      </div>
      <div class='col-md-6'>
          <label for='no_faktur' class='col-form-label'>Nomor Faktur</label>
          <input id='no_faktur' name='no_faktur' value='$r[no_faktur]' type='text' class='form-control' disabled>
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
