<?php
	//Gunakan Koneksi
include "../../../config/koneksi.php";
	//Buat array bobot { C1 = 35%; C2 = 25%; C3 = 25%; dan C4 = 15%.}

	$pel="RML.";
	$y=substr($pel,0,2);
	$query=mysql_query("select * from ramal_history where substr(id_ramal,1,2)='$y' order by id_ramal desc limit 0,1");
	$row=mysql_num_rows($query);
	$data=mysql_fetch_array($query);
	
	if ($row>0){
	$no=substr($data['id_ramal'],-3)+1;}
	else{
	$no=1;
	}
	$nourut=1000+$no;
	$nopel=$pel.substr($nourut,-3);

$aksi="modul/mod_analisis/aksi_analisis.php";	
switch($_GET[act]){
default:

    mysql_query("DELETE FROM temp ");
	mysql_query("DELETE FROM temp_produk ");

	echo"	
	<div class='row'>
	<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
	  <div class='card'>
	  <h5 class='card-header'>Peramalan Pendistribusian Produk</h5>
		<div class='card-body'>
		<form method='POST' action='?module=analisis&act=analisiswma'>
		<div class='col-md-6'>
			<label for='nama_kategori' class='col-form-label'>Pilih Produk</label>
			<br>
			<select class='form-control' name='id_produk'>
            <option value=0 selected>- Pilih Produk -</option>";
            $tampil=mysql_query("SELECT * FROM produk ORDER BY nama_produk");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[id_produk]>$r[nama_produk]</option>";
            }
    		echo "</select>
		</div>     
		<br>
		<div class='col-md-6'>
		<button type='submit' class='btn btn-round btn-primary'>Submit</button>
		</div>
		</form>
		</div>
	  </div>
	</div>
	</div>";
		  
break;
case "analisiswma":

mysql_query("INSERT INTO temp_produk(id_produk) 
VALUES('$_POST[id_produk]')");
	$edit = mysql_query("SELECT * FROM temp_produk ");
  $r    = mysql_fetch_array($edit);
  $id_produk=$r[id_produk];
  //Buat fungsi tampilkan nama
  function getNama($id){
	  $q =mysql_query("SELECT * FROM penjualan where  id_produk = '$id_produk' ");
	  $d = mysql_fetch_array($q);
	  return $d['id_produk'];
  }
  
  //Setelah bobot terbuat select semua di tabel Matrik
  $sql = mysql_query("SELECT
  *
FROM
  `penjualan`
  INNER JOIN `produk` ON `produk`.`id_produk` = `penjualan`.`id_produk` where  penjualan.id_produk = '$id_produk' ");
  //Buat tabel untuk menampilkan hasil

echo"	
<div class='row'>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
  <div class='card'>
  <h5 class='card-header'>Peramalan Pendistribusian Produk</h5>
	<div class='card-body'>
	<a href=?module=analisis class='btn btn-round btn-primary'>Kembali</a>
	<h5 class='card-header'>Matrik Awal</h5>
	<div class='card-body'>
		<table class='table'>
			<thead>
				<tr>
					<th scope='col>No.</th>
					<th scope='col>No.</th>
					<th scope='col'>Nomor Penjualan</th>
					<th scope='col'>Nama Produk</th>
					<th scope='col'>Tanggal Penjualan</th>
					<th scope='col'>Jumlah Nilai</th>
				</tr>
			</thead>
			<tbody>";
			$no = 1;
			while ($dt = mysql_fetch_array($sql)) {
				echo "
				<tr>
					<th scope='row'>$no</th>
					<td>$dt[id_penjualan]</td>
					<td>$dt[nama_produk]</td>
					<td>$dt[tgl_penjualan]</td>
					<td>$dt[tot_jual]</td>";
					$no++;
					}
					echo "
				</tr>				
			</tbody>
		</table>";
	

		$jmldata = mysql_num_rows(mysql_query("SELECT * FROM penjualan where  id_produk = '$id_produk' "));
		
		$sql = mysql_query("SELECT
		*
	  FROM
		`penjualan`
		INNER JOIN `produk` ON `produk`.`id_produk` = `penjualan`.`id_produk` where  penjualan.id_produk = '$id_produk' order by id_penjualan ASC ");
		
		
		echo "
	</div>
	<h5 class='card-header'>Bobot Peramalan</h5>
	<div class='card-body'>
		<table class='table'>
			<thead>
				<tr>
					<th scope='col>No.</th>
					<th scope='col>No.</th>
					<th scope='col'>Nomor Penjualan</th>
					<th scope='col'>Nama Produk</th>
					<th scope='col'>Tanggal Penjualan</th>
					<th scope='col'>Jumlah</th>
					<th scope='col'>Bobot</th>
					<th scope='col'>Skor (Jml * Bobot)</th>
					<th scope='col'>Nilai</th>
					<th scope='col'>Aksi</th>
				</tr>
			</thead>
			<tbody>";
			$no = 1;
			$b=0;
			
			while ($dt = mysql_fetch_array($sql)) {
			$tot_jumlah= $tot_jumlah + $dt[jml_penjualan];
			$tot_skor=$tot_skor + $b;
			$bobot=$dt[jml_penjualan] * $b;
		
			$bobot=$bobot;
			$w=$dt[jml_penjualan];
				echo "
				<form method=POST enctype='multipart/form-data' action=$aksi?module=analisis&act=input>
				<tr>
					<th scope='row'>$no</th>
					<td>$dt[id_penjualan] <input type=hidden name='id_penjualan' value='$dt[id_penjualan]' size=5></td>
					<td>$dt[nama_produk]</td>
					<td>$dt[tgl_penjualan]</td>
					<td>$dt[jml_penjualan] <input type=hidden name='jml_penjualan' value='$dt[jml_penjualan] ' size=5></td>
					<td>$b <input type=hidden name='skor' value='$b' size=5></td>
					<td>$bobot <input type=hidden name='bobot' value='$bobot' size=5></td>
					<td>$dt[tot_jual]</td>
					<td><input type=submit class='btn btn-round btn-primary' value=Pilih></form></td>
				</tr>";
				$no++;
				$b++;
			
				
				}
			
				echo "
				<tr>
					<td class='center' colspan=4>Skor Nilai Items</td>
					<td class='center'>$tot_jumlah</td>
					<td class='center'>$tot_skor</td>					
				</tr>				
			</tbody>
		</table>";
	

		$sql = mysql_query("SELECT * FROM TEMP ");
	//Buat tabel untuk menampilkan hasil
	echo "
	</div>
	<form method='POST' action='$aksi?module=analisis&act=save'>
	
	<br><br>
	<div class='col-md-3'>Ramal Untuk Bulan : <select class='form-control' name='bulan' required>
	<option value=''>-- Pilih Bulan --</option>
	<option value='1'>Januari</option>
	<option value='2'>Februari</option>
	<option value='3'>Maret</option>
	<option value='4'>April</option>
	<option value='5'>Mei</option>
	<option value='6'>Juni</option>
	<option value='7'>Juli</option>
	<option value='8'>Agustus</option>
	<option value='9'>September</option>
	<option value='10'>Oktober</option>
	<option value='11'>November</option>
	<option value='12'>Desember</option>
  </select></div><br>
  <button type='submit' class='btn btn-primary'>Simpan Peramalan</button>&nbsp<a href='modul/mod_laporan/cetaklap_analisis.php' class='btn btn-primary' target='_blank'>Cetak Peramalan</a>
	<h5 class='card-header'>Tabel Perhitungan Bobot dan Skor Peramalan <a href='$aksi?module=analisis&act=reset' class='btn btn-primary'>Reset</a></h5>
	<div class='card-body'>
		<table class='table'>
			<thead>
				<tr>
					<th scope='col>No.</th>
					<th scope='col>No.</th>
					<th scope='col'>Nomor Penjualan</th>
					<th scope='col'>Jumlah</th>
					<th scope='col'>Bobot</th>
					<th scope='col'>Skor</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>";
			$no = 1;
			while ($dt = mysql_fetch_array($sql)) {
			$n_penjualan=$n_penjualan + $dt[jml_penjualan];
			$n_skor=$n_skor + $dt[skor];
			$n_bobot=$n_bobot + $dt[bobot];
				echo "
				<tr>
					<th scope='row'>$no</th>
					<td>$dt[id_penjualan]</td>
					<td>$dt[jml_penjualan]</td>
					<td>$dt[skor]</td>
					<td>$dt[bobot]</td>
					<td><a href='$aksi?module=analisis&act=hapus&id=$dt[id_penjualan]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin hapus data ? Data yang dihapus tidak dapat dipulihkan !')\"><i class='fa fa-trash-o'></i> Hapus</a></td>
				</tr>";
				$no++;
				}
				$nilai=$n_bobot/$n_skor;
				$nilai2=round($nilai,2);
				echo "
				<tr>
					<td class='center' colspan=2>Skor Nilai Items</td>
					<td class='center'>$n_penjualan</td>
					<td class='center'>$n_skor</td>					
					<td class='center'>$n_bobot</td>	
				</tr>	
				<tr>
					<td class='center' colspan=2>Jumlah peramalan pendistribusian yaitu : </td>
					<td class='center'>$nilai2</td>			
					<input value='$nilai2' name='id2' type='hidden' class='form-control'>			
				</tr>			
			</tbody>
		</table>";
	

		$jmldata = mysql_num_rows(mysql_query("SELECT * FROM penjualan where  id_produk = '$id_produk' "));
		
		$sql = mysql_query("SELECT * FROM penjualan where  penjualan.id_produk = '$id_produk' order by id_penjualan ASC ");
		
		
		echo "
	</div>		
	</form>
	</div>
  </div>
</div>
</div>";
	
break;
}
?>