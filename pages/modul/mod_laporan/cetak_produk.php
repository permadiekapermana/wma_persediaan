<?php
error_reporting(0);
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

include "class.ezpdf.php";
include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_indotgl.php";
include "rupiah.php";
define('FPDF_FONTPATH','font/');
require('fpdf_protection.php');
	

$query= "SELECT *  FROM produk, kategori where produk.id_kategori=kategori.id_kategori ORDER BY produk.id_produk DESC";
		
if (!empty($query))
	  {
	  
	  $baca= mysql_query($query);
	

	$pdf=new FPDF('L','cm','Legal');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(1,3,1);
	$pdf->SetAutoPageBreak(true,3);
	$pdf->SetFont('Arial','B',14);
	$pdf->Image("images/logo_sh.jpg",2,1.15,'L');
	$pdf->SetFont('Arial','B',14);
	$pdf->Ln();
	$pdf->Cell(0,.6,'LAPORAN DATA PENJUALAN PRODUK HERBAL CV. XX SENTOSA',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,.6,'Jl. Angkasa Kedung Menjangan No. 13 E Kota Cirebon',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,.6,'Hp : 085220078895 - 087729256009',0,0,'C');
	$pdf->Ln();
	$pdf->Cell(0,.6,'No SIPA. xxxx/SIPAxx.xx/2015/2015',0,0,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(0,.2,'_______________________________________________________________________________________________________________________________________',0,0,'C');
	$pdf->Ln();
		$pdf->Cell(0,.2,'_______________________________________________________________________________________________________________________________________',0,0,'C');
	$x=$pdf->GetY();
	$pdf->SetY($x+1);
	$pdf->Cell(0,1,'DAFTAR PEMESANAN OBAT HERBAL CV. XX HERBAL SENTOSA',0,0,'C');


		if (mysql_num_rows ($baca)>0){
	$x=$pdf->GetY();
	$pdf->SetY($x+1);

	$pdf->SetFont('Arial','B',14);
	//$pdf->Cell(2.2,1,'Kode buku',1,0,'C');
	$pdf->Cell(2,1,'NO',1,0,'C');
	$pdf->Cell(5,1,'NAMA PRODUK',1,0,'C');
	$pdf->Cell(5,1,'KATEGORI',1,0,'C');
	$pdf->Cell(5,1,'TANGGAL',1,0,'C');
	$pdf->Cell(5,1,'STOK',1,0,'C');
	$pdf->Cell(5,1,'HARGA',1,0,'C');



	$pdf->Ln();
	
	
while ($hasil=mysql_fetch_array($baca))
{
	$no++;
	
	 $pdf->SetFont('Arial','',12);
	//$pdf->Cell(2.2,1,$hasil[kode_buku],1,0,'C');
	$pdf->Cell(2,1,$no,1,0,'C');
	$pdf->Cell(5,1,$hasil['nama_produk'],1,0,'C');
	$pdf->Cell(5,1,$hasil['nama_kategori'],1,0,'C');
	$pdf->Cell(5,1,$hasil['tgl_masuk'],1,0,'C');
	$pdf->Cell(5,1,$hasil['stok'],1,0,'C');
	$pdf->Cell(5,1,$hasil['harga'],1,0,'C');

	
	$pdf->Ln();
	}
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,'Print cetak  '.$tgl_sekarang,0,0,'C');
	$x=$pdf->GetY();
	$pdf->SetY($x+2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Ln();
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,'Mengetahui',0,0,'C');
	$pdf->Ln();
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,'CV. Surya Herbal Sentosa',0,0,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,'Bpk. Suryaman, (owner)',0,0,'C');
	$pdf->Ln();
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,'Nip.............',0,0,'C');
	$pdf->Ln();
	

	}
	$pdf->Output();
	}}
?>
