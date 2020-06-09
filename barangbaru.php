<!DOCTYPE html>
<html>
<?php
require 'db.php';
session_start();
$username = $_SESSION["username"];
$namabarang = $_POST["namabarang"];
$deskripsi = $_POST["deskripsi"];
$stok = $_POST["stok"];
$berat = $_POST["berat"];
$harga = $_POST["harga"];
date_default_timezone_set("Asia/Bangkok");
$kodebarang = strval(date('ymdHis', time()));

if($_FILES['image']['name'] != '') {
	//ambil data file
	$imgname = $_FILES['image']['name'];	
	$imgloc = $_FILES['image']['tmp_name'];
	$imgsize = getimagesize($imgloc);
	$maxsize= 1025152;
	
    if( ($imgsize !== false) && ($_FILES['image']['size'] <= $maxsize) ) {
	
	// tentukan lokasi file akan dipindahkan

	// pindahkan file
	//$terupload = move_uploaded_file($imgloc, $folder.$imgname);

		$imgdata =addslashes (file_get_contents($imgloc));
		$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
		$sql = "INSERT INTO barang (kodebarang, namabarang, username, deskripsi, stok, berat, harga, gambar) 
			VALUES ( '".$kodebarang."' , '".$namabarang."' , '".$username."' , '".$deskripsi."' , '".$stok."' , '".$berat."' , '".$harga."'  , '".$imgdata."'  )";
		$result = $con->query($sql);
		if($result){
			$con->close();
			echo "Barang berhasil disimpan ";
		}else{
			$con->close();
			echo "Data Gagal Disimpan!";
		}

	} else {
    echo "File bukan gambar atau lebih dari 1mb.";
	}
}else{
	echo "Gambar harus ada.";
}

?>
<a href="index.php"><button>Back</button></a>
</html>