<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<?php 
	require 'db.php';
	session_start();
	$login="login.php";	
	
	echo '<div class="header">';
			
	echo '</div>';
	
	if(isset($_GET["kodebarang"])){
		echo ' <div class="toolbar">';
		echo ' <div class="headerkiri"><a href="index.php"><button> &nbsp Back  &nbsp </button></a></div>';
		if(!isset($_SESSION["username"])){
			echo '<div class="headerkanan">Keranjang  <a href='.$login.'><button id="keranjang"></button></a></div>';
		}else{
			echo ' <div class="headerkanan"> Keranjang  <a href="keranjang.php"><button id="keranjang"></button></a></div>';
		}
		echo '</div>';
		
		$kodebarang = $_GET['kodebarang'];				
	
		$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
		$sql = "SELECT * FROM barang WHERE kodebarang = '".$kodebarang."' ";
		$result = $con->query($sql);
	
	if ($result->num_rows == 1) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			
			$namabarang = $row["namabarang"];
			$deskripsi = $row["deskripsi"];
			$stok = $row["stok"];
			$harga = $row["harga"];
			$gambar = $row["gambar"];
			$username = $row["username"];
			
		echo ' <div class="contentdisplay"> '; 
		echo ' <div class="namaproduk"> '.$namabarang.'</div>';
		echo ' <img src="data:image/jpeg;base64,'.base64_encode( $gambar ).'" height="80%" width="60%" /> ';
		echo ' <div class="keteranganproduk"> ';
		echo ' <div class="headerkiri"> ';
		echo ' <div class="contentbrg"> Stok:'.$stok.'</div>' ; 
		echo ' <div class="contentbrg"> Harga: Rp'.$harga.'   </div>' ; 
		echo ' <div class="contentbrg"> Penjual: '.$username.'</div>' ;
		echo ' <div class="contentbrg"> Deskripsi: '.$deskripsi.'</div>' ; 
		echo '</div>' ;
		echo '</div>' ;
		if(!isset($_SESSION["username"])){
			echo '<div> <a href='.$login.'><button class="namaproduk">Tambah ke keranjang</button> </div></a>' ;
		}else{
			echo '<div ><button class="namaproduk" onclick="tambahkeranjang('.$kodebarang.','.$stok.')">Tambah ke keranjang</button> </div>' ;
		}
		 echo '</div>' ;
		}
		
    }
	$con->close();
	}
	echo ' <div class="halaman">';
	echo ' </div>';
	
?>

<script>
	var sum = 0;
	var kodebarangjs = '0';
	var now = new Date();
 	var time = now.getTime();
 	time += 3600 * 1000;
 	now.setTime(time);
	
function getCookie(name) {
	var value = "; " + document.cookie;
	var parts = value.split("; " + name + "=");
	if (parts.length == 2) return parts.pop().split(";").shift();
}
	
if(typeof getCookie('isikeranjang') == 'undefined' ){
	var keranjang = [];
	var json_str = JSON.stringify(keranjang);
	document.cookie = 
	'isikeranjang=' + json_str + 
	'; expires=' + now.toUTCString() + 
	'; path=/';
	var json_data = JSON.parse(json_str);
}else{
	var json_str = getCookie('isikeranjang');
	var json_data = JSON.parse(json_str);
}
document.getElementById("keranjang").innerHTML=json_data.length;
	
function tambahkeranjang(kodebarang,stok){
	sum = 0;
	kodebarangjs = kodebarang;
	var keranjang = [];
	var isikeranjang = getCookie('isikeranjang');
	
	if(isikeranjang != ''){
		var json_str = getCookie('isikeranjang');
		var json_data = JSON.parse(json_str);
		
		for(i=0;i<json_data.length;i++){
			if(kodebarang == json_data[i]){
				sum = sum+1;
			}
		}
		
		if(sum >= stok){
			alert("Stok barang tidak cukup");
		}else{
			json_data.push(kodebarang);
		}		
		json_str = JSON.stringify(json_data);
	
		document.cookie = 
		'isikeranjang=' + json_str + 
		'; expires=' + now.toUTCString() + 
		'; path=/';
		document.getElementById("keranjang").innerHTML=json_data.length;
	}
}
</script>
</html>