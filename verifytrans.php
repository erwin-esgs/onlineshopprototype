<html>
<?php 
$cookie_name = "isikeranjang";
require 'db.php';	
session_start();	
$cookie_name = "isikeranjang";

$berhasil=0;
$transaksidetilada=0;

if(isset($_FILES['image']) && $_FILES['image']['name'] != '') { // upload bukti bayar pengguna
$idtransaksi=$_POST["idtransaksi"];	
	//ambil data file
	$imgname = $_FILES['image']['name'];	
	$imgloc = $_FILES['image']['tmp_name'];
	$imgsize = getimagesize($imgloc);
	$maxsize= 1025152;
	
	if( ($imgsize !== false) && ($_FILES['image']['size'] <= $maxsize) ) {
		
	$imgdata =addslashes (file_get_contents($imgloc));
	
	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb); 
	$sql = "INSERT INTO transaksidetil (idtransaksi, buktibayar, status) VALUES ('".$idtransaksi."' , '".$imgdata."' , 'MENGUNGGU KONFIRMASI') ";	
	$result = $con->query($sql);
		if($result){
			$berhasil=1;
		}else{
			$transaksidetilada=1;
		}
	if($transaksidetilada==1){
	$sql = "UPDATE transaksidetil SET  status='MENGUNGGU KONFIRMASI' , buktibayar = '".$imgdata."' WHERE idtransaksi = '".$idtransaksi."' ";	
	$result = $con->query($sql);
		if($result){
			$berhasil=1;
		}else{
			echo "Data gagal disimpan <br>";
		}
	}
		
	$sql = "UPDATE transaksi SET  status='MENGUNGGU KONFIRMASI' WHERE idtransaksi = '".$idtransaksi."' ";
	$result = $con->query($sql);
		if($result){
			$berhasil=1;
		}else{
			echo "Data gagal disimpan1 <br>";
		} 
	
	$con->close();
	if($berhasil==1){
		 echo 'Berhasil upload bukti transfer';
	}
	
	}
}

if(isset($_GET['idtransaksi'])){ // dari admverifytrans admin
	$idtransaksi = $_GET['idtransaksi'];
	$verify = $_POST["verify"];	
	$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	if($verify == 1){
		$sql = "UPDATE transaksidetil SET status = 'DIBAYAR' WHERE idtransaksi = '".$idtransaksi."' ";
		$result = $con->query($sql);
		$sql = "UPDATE transaksi SET status = 'DIBAYAR' WHERE idtransaksi = '".$idtransaksi."' ";
		$result = $con->query($sql);
	}else{
		$sql = "UPDATE transaksidetil SET status = 'BELUM DIBAYAR' , buktibayar = NULL WHERE idtransaksi = '".$idtransaksi."' ";
		$result = $con->query($sql);
		$sql = "UPDATE transaksi SET status = 'BELUM DIBAYAR' WHERE idtransaksi = '".$idtransaksi."' ";
		$result = $con->query($sql);
	}
	
		if($result){
			echo "Data berhasil disimpan ";
		}
	$con->close();
	
}

if( !isset($_GET['terima']) && isset($_POST['noresi']) && isset($_POST['idtransaksi']) ){ // input noresi penjual
	if($_POST['noresi']!=''){
		
	$idtransaksi = $_POST['idtransaksi'];
	$kodebarang = $_POST["kodebarang"];	
	$noresi = $_POST["noresi"];	
	$status = $_POST["status"];
	$penjual = $_SESSION['username'];
	$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	 
		$sql = "UPDATE transaksi SET status = 'DIKIRIM' , noresi = '".$noresi."'  WHERE idtransaksi = '".$idtransaksi."' AND penjual = '".$penjual."'  ";
		$result = $con->query($sql);
	
		if($result){
			header("location: transaksijual.php");
		}
	$con->close();
	}
}

if(isset($_GET['terima'])){ // Pesanan selesai pembeli
	$idtransaksi = $_POST['idtransaksi'];
	$status = $_POST["status"];	
	$penjual = $_POST["penjual"];
	$pembeli = $_SESSION['username'];
	$total=0;
	$berhasil=1;
	$con =  mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	 
	$sql = "UPDATE transaksi SET status = 'SELESAI' WHERE idtransaksi = '".$idtransaksi."' AND penjual = '".$penjual."' AND pembeli = '".$pembeli."' ";
	$result = $con->query($sql);
	if($result){
		$berhasil=1;
	}else{
		echo "Data gagal disimpan1 ";
	}
	
	$sql = "SELECT total FROM transaksi WHERE idtransaksi = '".$idtransaksi."' AND penjual = '".$penjual."' AND pembeli = '".$pembeli."' ";
	$result = $con->query($sql);
	if($result){
		while($row = mysqli_fetch_assoc($result)) {
			$total = $total+$row["total"];
		}
		$berhasil=1;
	}else{
		echo "Data gagal disimpan2 ";
	}
	
	$sql = "UPDATE user SET saldo = '".$total."' WHERE username = '".$penjual."' ";
	$result = $con->query($sql);
	if($result){
		$berhasil=1;
	}else{
		echo "Data gagal disimpan3 ";
	}
	$con->close();
	
	if($berhasil==1){
		header("location: transaksibeli.php");
	}
}

	echo '<br><a href="index.php"><button ">Back</button></a><br>';
?>
</html>