<!DOCTYPE html>
<html>
<?php
require 'db.php';
session_start();
$username = $_SESSION["username"];

if(isset($_GET["kodebarang"])){ //DELETE
	$kodebarang = $_GET["kodebarang"];
	$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	$sql = "DELETE FROM barang WHERE kodebarang = '".$kodebarang."' AND username = '".$username."' ";
	$result = $con->query($sql);
	if($result){
		$con->close();
		echo "Barang berhasil Dihapus ";
	}else{
		$con->close();
		echo "Data Gagal Dihapus!";
	}

}else{ 							// UPDATE
	$kodebarang = $_GET["kode"];
	$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	
	if ($_POST["stok"] != '' && $_POST["stok"] >= 0){
		$stok = $_POST["stok"];
		$sql = "UPDATE barang SET stok = '".$stok."'  WHERE kodebarang = '".$kodebarang."' AND username = '".$username."'  ";
		$result = $con->query($sql);
		if($result){
			header("location:displaybarang.php");
		}else{ 
			echo "Data Gagal Diupdate!";
		}
		 
	}elseif ($_POST["harga"] != '' && $_POST["harga"] > 0){
		$harga = $_POST["harga"];
		$sql = "UPDATE barang SET harga = '".$harga."'  WHERE kodebarang = '".$kodebarang."' AND username = '".$username."'  ";
		$result = $con->query($sql);
		if($result){ 
			header("location:displaybarang.php");
		}else{ 
			echo "Data Gagal Diupdate!";
		}
		 
	}else{
		header("location:displaybarang.php");
	}
	$con->close();
}
?>
<a href="index.php"><button>Back</button></a>
</html>