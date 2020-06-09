<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<?php 
	require 'db.php';
		
	echo ' <div class="toolbar">';	
	echo ' <div class="headerkiri"> <a href="transaksibeli.php"><button>Pembelian</button></a> </div> ';
	if($_SESSION["verify"] == '1'){
		echo ' <div class="headerkiri"> <a href="transaksijual.php"><button>Penjualan</button></a> </div> ';
		echo ' <div class="headerkiri"> <a href="displaybarang.php"><button>Menu Toko</button></a> </div> ';
	}
	echo ' <div class="headerkanan"> Keranjang  <a href="keranjang.php"><button id="keranjang"></button></a></div>';
	echo ' </div>';
	
	echo ' <div class="content">';
	$page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;
	$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	$sql = "SELECT kodebarang from barang ";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
		$total = $result->num_rows;
	}
	$sql = "SELECT * from barang LIMIT $mulai, $halaman";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			
			$kodebarang = $row["kodebarang"];
			$namabarang = $row["namabarang"];
			$stok = $row["stok"];
			$berat = $row["berat"];
			$harga = $row["harga"];
			$gambar = $row["gambar"];
			
		echo ' <div class="produk"> '; 
		echo ' <div class="namaproduk"> '.$namabarang.'</div>';
		echo ' <a href="produk.php?kodebarang='.$kodebarang.'"> <img src="data:image/jpeg;base64,'.base64_encode( $gambar ).'" height="70%" width="100%" />  </a>';
		echo ' <div class="namaproduk">Harga: Rp'.$harga.' | Stok:'.$stok.'  </div> ' ;
		echo '<button class="namaproduk" onclick="tambahkeranjang('.$kodebarang.','.$stok.')">  &nbsp  + ke keranjang &nbsp  </button> ';
		echo '</div>' ;
		
		}
		
    }
	$con->close();
	echo ' </div >';
	
	echo ' <div class="halaman">';
		$pages = ceil($total/$halaman); 
		for ($i=1; $i<=$pages ; $i++){ ?>
		<a href="?halaman=<?php echo $i; ?>"><button><?php echo $i; ?></button></a><?php
		}
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