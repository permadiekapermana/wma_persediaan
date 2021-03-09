<?php
  include "../config/koneksi.php";  
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }

else{
  include "../../../config/fungsi_indotgl.php";

echo"
<div class='row'>
  <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
    <div class='page-header'>
      <h2 class='pageheader-title'>Laporan Peramalan </h2>
    </div>
  </div>
</div>
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Laporan Peramalan Produk</h5>
    <div class='card-body'>
    <form class='form-horizontal' action='modul/mod_laporan/cetaklap_peramalan.php' target='_blank' method='post'>
                    
      <fieldset>
        <div class='control-group'>
          <div class='controls'>
            <div class='input-prepend input-group'>
              <input type='date' style='width: 200px' name='dari'  class='form-control' title='Dari tanggal' required />
              <input type='date' style='width: 200px' name='sampai'  class='form-control' title='Sampai tanggal' required />
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
                <th>Kode Peramalan</th>
                <th>Tanggal Peramalan</th>
                <th>Produk</th>
                <th>Periode (Bulan)</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Perkiraan Produk</th>
            </tr>
        </thead>
        <tbody>";
        $tampil = mysql_query("SELECT
        *
      FROM
        `ramal_history`
        INNER JOIN `produk` ON `produk`.`id_produk` = `ramal_history`.`id_produk` ORDER BY id_ramal DESC");  
        $no = 1;
        while($r=mysql_fetch_array($tampil)){
        echo"
            <tr>
                <td>$no</td>
                <td>$r[id_ramal]</td>";
                $tglramal=tgl_indo($r['tgl_ramal']);
                echo"
                <td>$tglramal</td>
                <td>$r[nama_produk]</td>
                <th>$r[periode]</th>";
                $bulanramal=getBulan($r['bulan']);
                echo"          
                <th>$bulanramal</th>
                <th>$r[tahun]</th>
                <th>$r[hasil]</th>
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
