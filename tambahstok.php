<!DOCTYPE html>
<html>
<?php
require 'db.php';
session_start();
$kodebarang = $_GET["kodebarang"];
$stok = 0;
$stokbaru = 0;
if($_POST["stok"] > 0 ){
$stokbaru = $_POST["stok"];

	$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	$sql = "SELECT stok FROM barang WHERE kodebarang = '".$kodebarang."' ";
	$result = $con->query($sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$stok = $row["stok"];
		}	
    }

$stokbaru = $stokbaru + $stok;	

	$sql = "UPDATE barang SET stok='".$stokbaru."' WHERE kodebarang = '".$kodebarang."'  ";
	$result = $con->query($sql);
	$con->close();
	if($result){
		echo "Barang berhasil diupdate ";
	}else{
		echo "Data Gagal Diupdate!";
	}
}else{
	echo "Masukkan nominal yang benar!";
}
?>
<a href="index.php"><button>Back</button></a>
</html>