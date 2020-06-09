<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<script> 
function validasi1() { 
var stok = document.getElementById("stok").value;
var harga = document.getElementById("harga").value; 
 
	if(stok == '' && harga == ''){ 
		return false;
	}else{
		alert("Stok/Harga berhasil Diupdate");
		return true; 
	}
}

</script>
<?php
require 'db.php';
session_start();
date_default_timezone_set("Asia/Bangkok");
$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
$username = $_SESSION["username"]; 

	echo '<div class="header">';
	echo '</div>';
	echo ' <div class="toolbar">';
		echo ' <a href="index.php"><button> &nbsp Back  &nbsp </button></a><br> ';
	echo '</div>';
	
	$sql = "SELECT saldo from user  WHERE username = '".$username."'";
	$result = $con->query($sql);
	if ($result->num_rows == 1) {
		while($row = mysqli_fetch_assoc($result)) {
		$saldo = $row["saldo"];
		}
	}
	echo '<br><div class="contentkeranjang">';
	echo ' <div >Saldo: '.$saldo.'  </div> <br>';

	echo ' <div> <a href="barangbaru.html"><button>Tambah Barang</button></a> </div> ';
	echo '</div>';
	$sql = "SELECT * from barang  WHERE username = '".$username."'";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			
			$kodebarang = $row["kodebarang"];
			$namabarang = $row["namabarang"];
			$stok = $row["stok"];
			$harga = $row["harga"];
			$gambar = $row["gambar"];
		
		echo '<div class="contentkeranjang">';
		echo ' <div> '.$namabarang.'</div><br>'; 
		echo ' <a href="produk.php?kodebarang='.$kodebarang.'"> <img src="data:image/jpeg;base64,'.base64_encode( $gambar ).'" height="150" width="150" />  </a>';
		echo ' <div> Stok:'.$stok.' Harga: Rp'.$harga.' </div> ' ;
		echo ' <form name="newform" method="post" action="barangupdate.php?kode='.$kodebarang.'"  > ';
		echo ' <input class="textinput1" id="stok" name="stok" placeholder="Ubah Stok Barang" type="number"> <br> ';
		echo ' <input class="textinput1" id="harga" name="harga" placeholder="Ubah Harga Barang" type="number">  ';
		echo ' <input class="button1" type="submit" />';
		echo ' </form> ';
		echo ' <a href="barangupdate.php?kodebarang='.$kodebarang.'"><button onclick="return confirm();">Hapus Barang</button></a> </div> ';
		echo '</div>';
		}
		
    }
	$con->close();

?>

</html>