<?php
  include "grafik_penjualan.php";

switch($_GET[act]){
	// Tampil User
	default:
echo"	
	<div class='row'>
	<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
	  <div class='card'>
	  <h5 class='card-header'>Grafik Penjualan Produk</h5>
		<div class='card-body'>
		<form method='POST' action='?module=grafik&act=lihatgrafik' enctype='multipart/form-data'>
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
		Tanggal Awal<input type='date' style='width: 200px' name='dari'  class='form-control' title='Dari tanggal' required/>
		</div> <br>
		<div class='col-md-6'>
		Tanggal Akhir <input type='date' style='width: 200px' name='sampai'  class='form-control' title='Sampai tanggal' required/>
		</div> <br>
		<div class='col-md-6'>
		<button type='submit' class='btn btn-round btn-primary'>Submit</button>
		</div>
		</form>

		</div>
	  </div>
	</div>
  </div>";

break;
  
case "lihatgrafik":

	$edit = mysql_query("SELECT * FROM produk WHERE id_produk='$_POST[id_produk]'");
  	$r2    = mysql_fetch_array($edit);

	echo"	
	<div class='row'>
	<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
	  <div class='card'>
	  <h5 class='card-header'>Grafik Penjualan Produk</h5>
		<div class='card-body'>
		<form method='POST' action='?module=grafik&act=lihatgrafik' enctype='multipart/form-data'>
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
		Tanggal Awal<input type='date' style='width: 200px' name='dari'  class='form-control' title='Dari tanggal' required/>
		</div> <br>
		<div class='col-md-6'>
		Tanggal Akhir <input type='date' style='width: 200px' name='sampai'  class='form-control' title='Sampai tanggal' required/>
		</div> <br>
		<div class='col-md-6'>
		<button type='submit' class='btn btn-round btn-primary'>Submit</button>
		</div>
		</form>
		<br>
		<h3 align='center'>Grafik Penjualan $r2[nama_produk]</h3>		
		<div id='container1'></div>
		</div>
	  </div>
	</div>
  </div>";
}

?>