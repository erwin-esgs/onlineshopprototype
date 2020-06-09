<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<?php 
	require 'db.php';
	session_start();
	if(isset($_SESSION["username"])){ 
	$username = $_SESSION["username"];
	$count=0;
	$uniqueidtransaksi=[];
	$trans1idtransaksi=[];
	
	echo '<div class="header">';
	echo '</div>';
	echo ' <div class="toolbar">';
	echo ' <a href="index.php"><button> &nbsp Back  &nbsp </button></a><br> ';
	echo '</div>';
	
	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	$sql = "SELECT idtransaksi, kodebarang, pembeli, qty, berat, kurir, alamat, status, total FROM transaksi WHERE penjual = '".$username."' AND (status = 'DIBAYAR' OR status = 'DIKIRIM' OR status = 'SELESAI') ";
	$result = $con->query($sql);
	
	echo ' <table class="mytable" > ';
	echo'<tr><th>ID Transaksi</th><th>Kode Barang</th><th>Jumlah Barang</th><th>Berat</th><th>Kurir</th><th>Total Harga</th><th>Status Pesanan</th><th></th></tr>';
	if (isset($result->num_rows) && $result->num_rows > 0) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$idtransaksi[$count] = $row["idtransaksi"]; 
			$kodebarang[$count] = $row["kodebarang"]; 
			$pembeli[$count] = $row["pembeli"]; 
			$qty[$count] = $row["qty"]; 
			$berat[$count] = $row["berat"];
			$kurir[$count] = $row["kurir"]; 
			$alamat[$count] = $row["alamat"]; 
			$total[$count] = $row["total"]; 
			$status[$count] = $row["status"];
		
		echo '<tr>';
		if(!isset($idtransaksi[$count-1]) || $idtransaksi[$count]!=$idtransaksi[$count-1]  ){ 	 //baris ID	
			if($status[$count] == 'DIBAYAR' || $status[$count] == 'DIKIRIM'){
				echo  ' <form action="verifytrans.php" method="post"  > ';
			}	
			echo ' <td> <input type="text" name="idtransaksi" value="'.$idtransaksi[$count].'" readonly /> </td>';
		}else{
			echo ' <td>  </td>';
		}

		echo ' <td> <a href="produk.php?kodebarang='.$kodebarang[$count].'"><input type="text" name="kodebarang" value="'.$kodebarang[$count].'" readonly /></a> </td>';	
		echo  '<td> '.$qty[$count].'Pcs</td>';
		echo  '<td> '.$berat[$count].'Kg</td>';
		echo  '<td> <input type="text" name="kurir" value="'.$kurir[$count].'" readonly /> </td>';
		echo  '<td>'.$total[$count].'</td>';
		
		if(!isset($idtransaksi[$count-1]) || $idtransaksi[$count]!=$idtransaksi[$count-1]  ){ 	 //baris ID	
			if($status[$count] == 'DIBAYAR' || $status[$count] == 'DIKIRIM'){
				echo  '<td> <input type="text" name="status" value="'.$status[$count].'" readonly /> </td>';
				echo  '<td> <input type="text" id="resi'.$count.'" name="noresi" placeholder="Masukkan Nomor Resi" /> <input type="submit" value="Submit No. Resi" name="submit"/> </td> </form> </tr>';
			}else{
				echo  '<td> <input type="text" name="status" value="'.$status[$count].'" readonly /> </td><td></td>';
			}
		}else{
			echo ' <td>  </td><td></td>';
		}
		
		echo '</tr>';
		$count=$count+1;
		}			
    }
	$con->close(); 
	echo ' </table> ';
	}
	
	/*
	for($i=0;$i<$count;$i++){ 	//pencarian ID array transaksi
		$countflag=0;
		for($ii=0;$ii<count($uniqueidtransaksi);$ii++){
			if($idtransaksi[$i] == $uniqueidtransaksi[$ii]){
				$countflag=1;
				$trans1idtransaksi[$ii] = $trans1idtransaksi[$ii]+1;
			}
		}
		if($countflag==0){
			array_push($uniqueidtransaksi,$idtransaksi[$i]);
			array_push($trans1idtransaksi,1);
		}
	}
		for($i=0;$i<count($trans1idtransaksi);$i++){ 	//pencarian ID array pembeli dlm id trans
		$countflag=0;
		for($ii=0;$ii<$trans1idtransaksi[$i];$ii++){
			if($penjual[$i] == $uniqueidtransaksi[$ii]){
				$countflag=1;
			}
		}
		if($countflag==0){
			array_push($uniqueidtransaksi,$idtransaksi[$i]);
		}
	}*/
	
?>

</html>