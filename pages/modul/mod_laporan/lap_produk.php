<?php
  include "../config/koneksi.php";
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }

else{


echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Laporan Produk </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Laporan Data Produk</h5>
    <div class='card-body'>
    <form class='form-horizontal' action='modul/mod_laporan/cetaklap_produk.php' target='_blank' method='post'>
                    
      <fieldset>
        <div class='control-group'>
          <div class='controls'>
            <div class='input-prepend input-group'>
              
              <button class='btn btn-primary' type='submit'><i class='fa fa-print'></i> Cetak</button>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
    <p>
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
  
    
}

?>
