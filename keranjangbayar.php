<html>
<?php 
$cookie_name = "isikeranjang";
if (isset($_COOKIE[$cookie_name])){
require 'db.php';	
session_start();	
$cookie_name = "isikeranjang";

date_default_timezone_set("Asia/Bangkok");
$idtransaksi = strval(date('ymdHis', time())); 
$kodebarang=$_POST["idbrgkeranjang"];
$penjual=$_POST["username"];
$pembeli = $_SESSION["username"];
$qty=$_POST["qtybrgkeranjang"];
$stok=$_POST["stok"];
$berat=$_POST["berat"];
$kurir=$_POST["kurir"];
$alamat=$_POST["alamat"];
$total=$_POST["total"];
$jlhpenjual = $_POST["penjual"];
$totalbayar=intval($_POST["totalbayar"]);
$beratperseller=$_POST["beratperseller"];
$berhasil=0;

	 
	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);  
	for($i=0;$i<count($kodebarang);$i++){
		
		switch($kurir[$i]){
			case 'JNE' : $total[$i]=$total[$i]+($qty[$i]*$berat[$i]*$jne); break;
			case 'J&T' : $total[$i]=$total[$i]+($qty[$i]*$berat[$i]*$jnt); break;
			case 'TIKI' : $total[$i]=$total[$i]+($qty[$i]*$berat[$i]*$tiki); break;
			case 'WAHANA' : $total[$i]=$total[$i]+($qty[$i]*$berat[$i]*$wahana); break;
		}
		
	//echo $idtransaksi; echo $kodebarang[$i]; echo $penjual[$i]; echo $pembeli; echo $qty[$i]; echo $kurir[$i]; echo $alamat; echo '<br>'; 
	$sql = "INSERT INTO transaksi (idtransaksi, kodebarang, penjual, pembeli, qty, berat, kurir, alamat, total, status) 
			VALUES ( '".$idtransaksi."' , '".$kodebarang[$i]."' , '".$penjual[$i]."' , '".$pembeli."' , '".$qty[$i]."' , '".$berat[$i]."' , '".$kurir[$i]."' , '".$alamat."'  ,  '".$total[$i]."'  , 'BELUM DIBAYAR'  )";
	$result = $con->query($sql);
		if($result){
			$berhasil=1;
		}else{
			echo "Data gagal disimpan <br>";
		}
	$newstok=$stok[$i]-$qty[$i];
	$sql = "UPDATE barang SET stok = '".$newstok."' WHERE kodebarang = '".$kodebarang[$i]."'  ";
	$result = $con->query($sql);
		if($result){
			$berhasil=1;
		}else{
			$berhasil=0;
		}
	}
	$con->close();
	if($berhasil==1){
		echo 'Silahkan menyelesaikan pembayaran dengan cara transfer ke rekening:<br> 082374296033 <br> Bank :BCA <br> A/N: ary renaldi <br> Sejumlah: Rp'.$totalbayar;
		echo '';
	}
	echo '<br><a href="index.php"><button ">Back</button></a><br>';
}	
?>
<script>
	var now = new Date();
 	var time = now.getTime();
 	time += 3600 * 1000;
 	now.setTime(time);

function getCookie(name) {
	var value = "; " + document.cookie;
	var parts = value.split("; " + name + "=");
	if (parts.length == 2) return parts.pop().split(";").shift();
}	
function delCookie() {
	document.cookie = "isikeranjang=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"; //del cookie
	if(typeof getCookie('isikeranjang') == 'undefined' ){
		var keranjang = [];
		var json_str = JSON.stringify(keranjang);
		document.cookie = 
		'isikeranjang=' + json_str + 
		'; expires=' + now.toUTCString() + 
		'; path=/';
		var json_data = JSON.parse(json_str);
	}
 
}
delCookie();
</script>
</html>