	<script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/highcharts.js" type="text/javascript"></script>
    <script type="text/javascript">
	
	var chart1;
	$(document).ready(function() {
		chart1 = new Highcharts.Chart({
			chart: {
            	renderTo: 'container',
	            type: 'column'
    	    },   
        	title: {
            	text: 'Grafik Penjualan Barang '
	        },
    	    xAxis: {
        	    categories: ['Tanggal Penjualan']
	        },
    	    yAxis: {
        	    title: {
            	text: 'Jumlah Penjualan'
            }
        },
		series:             
            
			[
				<?php 
				include "../../../config/koneksi.php";
				$sql = mysql_query("SELECT * FROM penjualan where id_produk='PRO.001' order by tgl_penjualan");
				while ($data = mysql_fetch_array($sql)) {
					$namakelas = $data['tgl_penjualan'];
					$n_produk = $data['id_produk'];
					$sqljumlahkelas = mysql_query("SELECT jml_penjualan FROM penjualan WHERE tgl_penjualan='$namakelas'");
					while ($datajumlah = mysql_fetch_array($sqljumlahkelas)) {
						$jumlah = $datajumlah['jml_penjualan'];
					}
				?>
					{
						name: '<?php echo $namakelas; ?>',
						data: [<?php echo $jumlah; ?>]
					},
				<?php 
				} 
				?>
            ]
		});
	});	
</script>
