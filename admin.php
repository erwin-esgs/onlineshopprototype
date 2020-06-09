<html>
<?php 
	require 'db.php';
	$count=0;
	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	echo ' <div class="toolbar">';
	echo ' <div class="headerkiri"> <a href="newuser.html"><button>New User</button></a> </div> ';
	echo ' <div class="headerkiri"> <a href="deluser.php"><button>Delete User</button></a> </div> ';
	echo ' </div>';
	
	
	echo ' <div class="content">';
	echo ' <div class="contentadm">';
	echo ' <table > ';
	echo ' <tr>   <td>Username</td>   </tr> ';	
	$sql = "SELECT username FROM user WHERE verify = '0' AND statusid = '1' ";
	$result = $con->query($sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$username = $row["username"]; 
		echo ' <tr> ';	
		echo ' <td> <a href="profileuser.php?username='.$username.' "> '.$username.' </a></td> ';
		echo ' </tr> ';	
		}			
    }
	
	echo ' </table> ';
	echo ' </div>';
	
	
	echo ' <div class="contentadm">';
	echo ' <table > ';
	echo ' <tr>   <td>Transaksi</td>   </tr> ';	
	$sql = "SELECT idtransaksi FROM transaksidetil WHERE status = 'MENGUNGGU KONFIRMASI' ";
	$result = $con->query($sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$idtransaksi[$count] = $row["idtransaksi"]; 
		
		if(!isset($idtransaksi[$count-1]) || $idtransaksi[$count]!=$idtransaksi[$count-1]  ){
			 echo ' <tr> ';	
			echo ' <td> <a href="admverifytrans.php?idtransaksi='.$idtransaksi[$count].' "> '.$idtransaksi[$count].' </a></td> ';
			echo ' </tr> ';
		}else{
		} 
		$count=$count+1;
		}			
    }
	
	echo ' </table> ';
	echo ' </div>';
	echo ' </div>';
	$con->close();
	
	echo ' <div class="halaman">';
	echo ' </div>';
?>

</html>