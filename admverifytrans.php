<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<?php
require 'db.php';
session_start();
date_default_timezone_set("Asia/Bangkok");

 
	echo ' <div class="toolbar">';
	echo ' <div class="headerkiri"><a href="index.php"><button> &nbsp Back  &nbsp </button></a></div><br>';

	echo '</div>';

if(isset($_GET['idtransaksi'])){
	$idtransaksi = $_GET['idtransaksi'];
	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	$sql = "SELECT * FROM transaksidetil WHERE idtransaksi = '".$idtransaksi."' AND status = 'MENGUNGGU KONFIRMASI' ";
	$result = $con->query($sql);
	
	echo ' <div class="contentdisplay"> '; 
	if ($result->num_rows == 1) {
		while($row = mysqli_fetch_assoc($result)) {
			$buktibayar = $row["buktibayar"];
		}
		if($buktibayar == ''){
			echo ' <img src="data:image/png;base64,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" height="400" width="400" /> ';
		}else{
			echo ' <img src="data:image/jpeg;base64,'.base64_encode( $buktibayar ).'" height="400" width="600" /> ';
		
		echo '<form action="verifytrans.php?idtransaksi='.$idtransaksi.'" method="post" >';
		?>
			<select name="verify">
			<option value=1> Terima </option>
			<option value=0> Tolak </option>
			</select>
			<input type="submit" value="Verifikasi Pembayaran" name="submit"/>
			</form>
		<?php
		}
	}
	echo '</div>';
}
?>
</html>