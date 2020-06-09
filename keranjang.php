<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<?php 
	$cookie_name = "isikeranjang";
	if (isset($_COOKIE[$cookie_name])){
	require 'db.php';		
		$isikeranjang=[];
		$idbrgkeranjang=[];
		$idusername=[];
		$qtybrgkeranjang=[];
		$count=0;
		$totalharga=0;
		
		$keranjangcookie = json_decode($_COOKIE[$cookie_name]);
		
		foreach($keranjangcookie as $barangdikeranjang) { //pindah dari cookie ke array temp
			 $isikeranjang[$count] = strval($barangdikeranjang)  ;
			 $count=$count+1;
		}
		
		for($i=0;$i<count($isikeranjang);$i++){ 	//pencarian ID array
			$countflag=0;
			for($ii=0;$ii<count($idbrgkeranjang);$ii++){
				if($isikeranjang[$i] == $idbrgkeranjang[$ii]){
					$countflag=1;
					$qtybrgkeranjang[$ii] = $qtybrgkeranjang[$ii]+1;
				}
			}
			if($countflag==0){
				array_push($idbrgkeranjang,$isikeranjang[$i]);
				array_push($qtybrgkeranjang,1);
			}
		}
		
		$keranjang=array_count_values($isikeranjang);//isi keranjang per item
			$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb); 
			$sql = "SELECT namabarang, stok, harga FROM barang WHERE "; 
			
			for($j=0;$j<count($idbrgkeranjang);$j++){ // show barang per ID
				$idbrgkeranjang[$j]=strval($idbrgkeranjang[$j]);
				//echo "Barang: ".$idbrgkeranjang[$j]." Berjumlah: ".$keranjang[$idbrgkeranjang[$j]];
				$sql = "SELECT namabarang, username, stok, berat, harga, gambar FROM barang WHERE kodebarang='".$idbrgkeranjang[$j]."'";				
				$result = $con->query($sql);
				if ($result->num_rows == 1) {
				// output data of each row 
					while($row = mysqli_fetch_assoc($result)) {
						$namabarang[$j] = $row["namabarang"];
						$stok[$j] = $row["stok"];	
						$berat[$j] = $row["berat"];						
						$harga[$j] = $row["harga"];
						$gambar[$j] = $row["gambar"];
						$username[$j] = $row["username"];
					 
					$total[$j] = $qtybrgkeranjang[$j] * $harga[$j];
					$totalharga=$totalharga+$total[$j]; 	
					
					}		
				}
			}
			$con->close();
			
			if($count != 0){
			for($i=0;$i<count($username);$i++){ 	//pencarian ID array username
			$countflag=0;
				for($ii=0;$ii<count($idusername);$ii++){
					if($username[$i] == $idusername[$ii]){
						$countflag=1; 
					}
				}
				if($countflag==0){
					array_push($idusername,$username[$i]); 
				}
			}
			//DISPLAY
			echo '<div class="header">';
			echo '</div>';
			echo ' <div class="toolbar">';
			echo ' <a href="index.php"><button onclick="tambahkeranjang('.$j.')"> &nbsp Back &nbsp </button></a><br>';
			echo '</div>';
			echo '<div class="contentkeranjang">';
			echo '<form action="keranjangbayar.php" method="post" onsubmit="return validasi1()">';
			echo 'Alamat penerima: <input type="textarea" id="alamat" class="textinput1" 		name="alamat" ><br>';
			echo '<input type="hidden" id="penjual" class="textinput1" 							name="penjual" value="'.count($idusername).'" readonly>';
			echo '</div>';
			
			for($i=0;$i<count($idusername);$i++){
				echo '<div class="contentkeranjang">';
				$beratperseller[$i]=0;
				echo '<br>Penjual: '.$idusername[$i].'<br>';
				for($ii=0;$ii<$j;$ii++){
					if($idusername[$i] == $username[$ii]){
						echo ' <br> <img src="data:image/jpeg;base64,'.base64_encode( $gambar[$ii] ).'" height="60" width="60" />   
							<input type="hidden" id="idbrgkeranjang'.$ii.'" class="textinput1" 	name="idbrgkeranjang[]" value="'.$idbrgkeranjang[$ii].'" readonly> 
							<input type="hidden" id="username'.$ii.'" class="textinput1" 		name="username[]" value="'.$idusername[$i].'" readonly>
							<input type="hidden" id="kurir'.$ii.'" class="kurir'.$i.'" 			name="kurir[]" value="0" readonly>
							Nama: <input class="textinput1" name="namabarang[]" value="'.$namabarang[$ii].'" readonly> <br> &nbsp &nbsp  &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp
							Dibeli:<button type="button" onclick="minus('.$ii.','.$stok[$ii].')">-</button> 
										<input class="textinput2" id="qtybrg'.$ii.'"  			name="qtybrgkeranjang[]" value="'.$qtybrgkeranjang[$ii].'" readonly> 
									<button type="button" onclick="plus('.$ii.','.$stok[$ii].')">+</button>  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp 
							Stok: <input class="textinput2" id="stok'.$ii.'" 					name="stok[]" value="'.$stok[$ii].'" readonly>  
							Berat: <input class="textinput2" id="berat'.$ii.'" 					name="berat[]" value="'.$berat[$ii].'" readonly>Kg<br> 
							Harga satuan: &nbsp <input class="textinput1" id="harga'.$ii.'" 	name="harga[]" value="'.$harga[$ii].'" readonly> &nbsp 
							Total: <input class="textinput1" id="total'.$ii.'" 					name="total[]" value="'.$total[$ii].'" readonly> <br>';
						
					$beratperseller[$i]=$beratperseller[$i]+($berat[$ii]*$qtybrgkeranjang[$ii]);
					}
					
				}
				echo'<input type="hidden" id="beratperseller'.$i.'" class="textinput1" 		name="beratperseller[]" value="'.$beratperseller[$i].'" readonly>';
				if($totalharga != 0){
				echo'<br>
				<select id="selectkurir'.$i.'" name="selectkurir" onchange="pilihkurir('.$i.')">
					<option value="0">Pilih Kurir</option>
					<option value="JNE">JNE</option>
					<option value="J&T">J&T</option>
					<option value="TIKI">TIKI</option>
					<option value="WAHANA">WAHANA</option>
				</select><br><br>
				';
				echo 'Ongkos kirim: <input class="hargakurir" id="hargakurir'.$i.'" name="hargakurir[]" value="0" readonly><br>';
				
				echo '<input type="hidden" class="textinput1" id="hargajne"  value="'.$jne.'" readonly>';
				echo '<input type="hidden" class="textinput1" id="hargajnt"  value="'.$jnt.'" readonly>';
				echo '<input type="hidden" class="textinput1" id="hargatiki"  value="'.$tiki.'" readonly>';
				echo '<input type="hidden" class="textinput1" id="hargawahana"  value="'.$wahana.'" readonly>';
				}
			echo '</div>';
			}
			
			echo '<div class="contentkeranjang">';
			echo  '<br>Sum: <input class="textinput1" id="jumlahbrg" name="jumlahbrg" value="'.$j.'" readonly> jenis item <br>';
			echo ' Jumlah harga barang: <input class="textinput1" id="jumlahharga" name="jumlahharga" value="'.$totalharga.'" readonly>'; 
			echo ' <br>Total ditambah ongkir: <input class="textinput1" id="totalbayar" name="totalbayar" readonly><br>';
			echo '<input class="button1" type="submit" value=" Bayar " />';
			echo '</form>';
			echo '</div>';
			
			}else{
				echo '<div class="header">';
					echo ' <a href="index.php"><button > &nbsp Back &nbsp </button></a><br>';
				echo '</div>';
			} 
			
	}
?>

<script>
	var ongkir=9000;
	
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

function refreshhargatotal() {
	var brg= parseInt(document.getElementById("jumlahbrg").value); 
	var penjual= parseInt(document.getElementById("penjual").value);
	var totalbayar=0;
	for(var i=0;i<brg;i++){
		var tmp = parseInt(document.getElementById('total'+i).value);
		totalbayar = totalbayar+tmp;
	}
	document.getElementById("jumlahharga").value=totalbayar;
	for(var i=0;i<penjual;i++){
		totalbayar = totalbayar + parseInt(document.getElementById("hargakurir"+i).value);
	}
	document.getElementById("totalbayar").value = totalbayar;
}
refreshhargatotal() ;
function refreshharga(index1,qtytemp1) {
var harga = document.getElementById('harga'+index1).value;  
var total = document.getElementById('total'+index1).value;  
  total = parseInt(harga) * qtytemp1;
  document.getElementById('harga'+index1).value = harga;
  document.getElementById('total'+index1).value = total;
  refreshhargatotal();
}


function pilihkurir(index) {
  var x = document.getElementById("selectkurir"+index).value;
  var penjual= parseInt(document.getElementById("penjual").value);
  var beratperseller=parseInt(document.getElementById("beratperseller"+index).value);
  
  switch(x){
	  case "JNE":  ongkir=parseInt(document.getElementById("hargajne").value)*beratperseller ; document.getElementById("hargakurir"+index).value = ongkir; break;
	  case "J&T": ongkir=parseInt(document.getElementById("hargajnt").value)*beratperseller; document.getElementById("hargakurir"+index).value = ongkir; break;
	  case "TIKI": ongkir=parseInt(document.getElementById("hargatiki").value)*beratperseller; document.getElementById("hargakurir"+index).value = ongkir; break;
	  case "WAHANA": ongkir=parseInt(document.getElementById("hargawahana").value)*beratperseller; document.getElementById("hargakurir"+index).value = ongkir; break;
	  default : ongkir=0; document.getElementById("hargakurir"+index).value = ongkir; break;
  }
  
  
  var y = document.getElementsByClassName('kurir'+index).length;
  for(var i=0;i<y;i++){
	  document.getElementsByClassName('kurir'+index)[i].value=x;
  }
  refreshhargatotal();
}


function plus(index,stok) {
	var qtytemp = document.getElementById('qtybrg'+index).value;
	if(qtytemp >= stok){
		alert("Stok tidak cukup");
	}else{
		qtytemp = parseInt(qtytemp)+1;
		document.getElementById('qtybrg'+index).value=qtytemp;
	}
	refreshharga(index,qtytemp);
	refreshhargatotal();
}
function minus(index,stok) {
	var qtytemp = parseInt(document.getElementById('qtybrg'+index).value);
	if(qtytemp <= 0){
		alert("Stok tidak boleh kurang dari 0");
	}else{
		qtytemp = qtytemp-1;
		document.getElementById('qtybrg'+index).value=qtytemp;
	}
	refreshharga(index,qtytemp);
	refreshhargatotal();
}

function tambahkeranjang(totalbrg){
	var keranjang = [];
	
	for(i=0;i<totalbrg;i++){
		var idtemp = document.getElementById('idbrgkeranjang'+i).value;
		var qtytemp = parseInt(document.getElementById("qtybrg"+i).value);
		
		for(j=0;j<qtytemp;j++){
			keranjang.push(idtemp);
		}
	}
	json_str = JSON.stringify(keranjang);
	
		document.cookie = 
		'isikeranjang=' + json_str + 
		'; expires=' + now.toUTCString() + 
		'; path=/';
	
}


function validasi1() { 
var alamat = document.getElementById("alamat").value;
var hargakurir = document.getElementsByClassName("hargakurir");
var pilihkurir=1;
	if(alamat == ''){
		alert("Alamat masih kosong!"); 
		return false;
	}else{
		for(i=0;i<hargakurir.length;i++){
			if(hargakurir[i].value == 0){
				pilihkurir=0;
			}
		}
		if(pilihkurir == 1){
			return true;
		}else{
			alert("Pilih kurir!");
			return false;
		}
		
	}
}
</script>
</html>