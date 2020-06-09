<!DOCTYPE html>
<html>
<?php
require 'db.php';
session_start();
date_default_timezone_set("Asia/Bangkok");
$kodebarang = strval(date('ymdHis ', time()));
$username = $_SESSION["username"];

if(isset($_GET['adm'])){
	$username = $_GET['adm'];
	$verify = $_POST["verify"];	
	$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	if($verify == 1){
		$sql = "UPDATE user SET verify = '".$verify."' WHERE username = '".$username."' ";
	}else{
		$sql = "UPDATE user SET verify = '".$verify."' , ktp = '' WHERE username = '".$username."' ";
	}
	$result = $con->query($sql);
		if($result){
			echo "Data berhasil disimpan ";
		}
	$con->close();
	
}else{
	if($_FILES['image']['name'] != '') {
	//ambil data file
	$imgname = $_FILES['image']['name'];	
	$imgloc = $_FILES['image']['tmp_name'];
	$imgsize = getimagesize($imgloc);
	$maxsize= 1025152;
	
    if( ($imgsize !== false) && ($_FILES['image']['size'] <= $maxsize) ) {

		$imgdata =addslashes (file_get_contents($imgloc));
		$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
		$sql = "UPDATE user SET ktp = '".$imgdata."' WHERE username = '".$username."' ";
		$result = $con->query($sql);
		if($result){
			$con->close();
			echo "Data berhasil disimpan ";
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

}
?>
<a href="index.php"><button>Back</button></a>
</html>