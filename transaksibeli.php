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
	$sql = "SELECT idtransaksi, kodebarang, penjual, qty, kurir, noresi, total, status FROM transaksi WHERE pembeli = '".$username."' ";
	$result = $con->query($sql);
	
	echo ' <table class="mytable"> ';
	echo'<tr><th>ID Transaksi</th><th>Penjual</th><th>Kode Barang</th><th>Jumlah Barang</th><th>Kurir</th><th>No. Resi</th><th>Total Harga</th><th>Status Pesanan</th><th></th></tr>';
	if (isset($result->num_rows) && $result->num_rows > 0) {
	    // output data of each row
	while($row = mysqli_fetch_assoc($result)) {
			$idtransaksi[$count] = $row["idtransaksi"]; 
			$kodebarang[$count] = $row["kodebarang"]; 
			$penjual[$count] = $row["penjual"]; 
			$qty[$count] = $row["qty"]; 
			$kurir[$count] = $row["kurir"]; 
			$noresi[$count] = $row["noresi"];
			$total[$count] = $row["total"]; 
			$status[$count] = $row["status"]; 
		
		//Baris ID
		echo  '<tr> ';
		if(!isset($idtransaksi[$count-1]) || $idtransaksi[$count]!=$idtransaksi[$count-1]  ){ 
			echo ' <td> ';
			
			if($status[$count] == 'BELUM DIBAYAR'){
				echo  ' <form action="verifytrans.php" method="post" enctype="multipart/form-data" > ';//form verify bukti
			}
			echo ' <input type="text" name="idtransaksi" value="'.$idtransaksi[$count].'" readonly />';
			
			echo'</td>';
		}else{
			echo'<td>'; 
			echo'</td>';
		}
		
		//Baris penjual
		if( (!isset($penjual[$count-1]) || $penjual[$count]!=$penjual[$count-1])  ||  (!isset($idtransaksi[$count-1]) || $idtransaksi[$count]!=$idtransaksi[$count-1]  ) ){
			echo '<td>';
			if($status[$count] == 'DIKIRIM'){
				echo  ' <form action="verifytrans.php?terima=1" method="post"> ';//form terima
				echo  ' <input type="hidden" name="idtransaksi" value="'.$idtransaksi[$count].'" readonly />	';
			}
			echo '<input type="text" name="penjual" value="'.$penjual[$count].'" readonly />';
			
			echo '</td>';
		}else{
			echo'<td>'; 
			echo'</td>';
		} 
		
		echo  '<td><a href="produk.php?kodebarang='.$kodebarang[$count].'"> '.$kodebarang[$count].'</a></td>';
		echo  '<td>'.$qty[$count].'</td>';
		echo  '<td>'.$kurir[$count].'</td>';
		echo  '<td><input type="text" name="noresi" value="'.$noresi[$count].'" readonly /></td>';
		echo  '<td>'.$total[$count].'</td>';
		
		//Baris penjual
		if(  (!isset($penjual[$count-1]) || $penjual[$count]!=$penjual[$count-1])  ||  (!isset($idtransaksi[$count-1]) || $idtransaksi[$count]!=$idtransaksi[$count-1]  ) ){
			echo'<td>'; 
			echo  ' <input type="text" name="status" value="'.$status[$count].'" readonly />';
			echo'</td>';
		}else{
			echo'<td>'; 
			echo'</td>';
		}
		
		//Baris ID
		if( (!isset($idtransaksi[$count-1]) || $idtransaksi[$count]!=$idtransaksi[$count-1] ) ){
			
			if($status[$count] == 'BELUM DIBAYAR'){
				echo  '<td>';
				echo  ' <input type="file" name="image"/> <input type="submit" value="Verifikasi Bukti" name="submit"/> </form>';
				echo  ' </td> ';
			}else{
				echo'<td>';
			echo'</td>';
			}
			
		}else{
			echo'<td>';
			echo'</td>';
		}
		
		//Baris penjual
				if(  (!isset($penjual[$count-1]) || $penjual[$count]!=$penjual[$count-1])  ||  (!isset($idtransaksi[$count-1]) || $idtransaksi[$count]!=$idtransaksi[$count-1]  ) ){
			 
					if($status[$count] == 'DIKIRIM'){
						echo'<td>';
						echo  '<input type="submit" value="Pesanan Diterima" name="submit"/> </form>';//form terima
						echo'</td>';
					}else{
						echo'<td>';
						echo'</td>';
					}
			
				}else{
					echo'<td>';
					echo'</td>';
				}
		 
		$count=$count+1;
		echo '</tr>';

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