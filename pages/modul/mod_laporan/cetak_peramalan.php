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
include "rupiah.php";
define('FPDF_FONTPATH','font/');
require('fpdf_protection.php');
$dari=$_POST[dari];	
$sampai=$_POST[sampai];


	$query= "SELECT
	*
  FROM
	`produk`
	INNER JOIN `kategori` ON `kategori`.`id_kategori` = `produk`.`id_kategori`
							  ORDER BY id_produk DESC";
	
if (!empty($query))
	  {
	  
	  $baca= mysql_query($query);
	

	$pdf=new FPDF('L','cm','Legal');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(1,3,1);
	$pdf->SetAutoPageBreak(true,3);
	$pdf->SetFont('Arial','B',14);
	$pdf->Image("images/auto_2000.jpg",2,1.15,6,'L');
	$pdf->SetFont('Arial','B',16);
	$pdf->Ln();
	$pdf->Cell(0,.6,'PT Astra International Tbk. - Toyota',0,0,'C');
	$pdf->Ln();
	$pdf->Cell(0,.6,'Toyota - Cirebon Branch',0,0,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',14);	
	$pdf->Cell(0,.6,'Jln. Brigjen Darsono 14 .',0,0,'C');	
	$pdf->Ln();
	$pdf->Cell(0,.6,'Cirebon 45135 .',0,0,'C');	
	$pdf->Ln();
	$pdf->Cell(0,.6,' Telp. 0231-232000 Fax 0231-202009.',0,0,'C');	
	$pdf->Ln();
	$pdf->Cell(0,.2,'____________________________________________________________________________________________________________________',0,0,'C');
	$pdf->Ln();
		$pdf->Cell(0,.2,'____________________________________________________________________________________________________________________',0,0,'C');
	$x=$pdf->GetY();
	$pdf->SetY($x+1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,1,'Laporan Penjualan Part Gross',0,0,'C');
	$pdf->SetFont('Arial','',14);
	$pdf->Ln();


		if (mysql_num_rows ($baca)>0){
	$x=$pdf->GetY();
	$pdf->SetY($x+1);

	$pdf->SetFont('Arial','B',12);
	//$pdf->Cell(2.2,1,'Kode buku',1,0,'C');
	$pdf->Cell(2,1,'No.',1,0,'C');
	$pdf->Cell(12,1,'Nama Produk',1,0,'C');
	$pdf->Cell(5,1,'Kategori',1,0,'C');
	$pdf->Cell(4,1,'Harga',1,0,'C');
	$pdf->Cell(4,1,'Stok',1,0,'C');
	$pdf->Cell(4,1,'Tanggal Masuk',1,0,'C');



	$pdf->Ln();
	
	
	
while ($hasil=mysql_fetch_array($baca))
{
	$no++;

	
	
	 $pdf->SetFont('Arial','',12);
	//$pdf->Cell(2.2,1,$hasil[kode_buku],1,0,'C');
	$pdf->Cell(2,1,$no.'.',1,0,'C');
	$pdf->Cell(12,1,$hasil['nama_produk'],1,0,'L');
	$pdf->Cell(5,1,$hasil['nama_kategori'],1,0,'L');
	$pdf->Cell(4,1,$hasil['harga'],1,0,'L');
	$pdf->Cell(4,1,$hasil['stok'],1,0,'C');
	$pdf->Cell(4,1,$hasil['tgl_masuk'],1,0,'C');

	$pdf->Ln();
	
	}
	
	$x=$pdf->GetY();
	$pdf->SetY($x+2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,'Mengetahui,',0,0,'C');
	$pdf->Ln();
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,'Karyawan ',0,0,'C');
	$pdf->Ln();
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,'Auto2000 Cirebon ',0,0,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(15,0.5,'');
	$pdf->Cell(0,0.5,$_SESSION[namalengkap],0,0,'C');
	$pdf->Ln();
	
	}
	$pdf->Output();
	}}
?>
