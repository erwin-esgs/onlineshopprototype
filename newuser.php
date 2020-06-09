<!DOCTYPE html>
<html>
<?php
require 'db.php';
session_start();
$username = $_POST["username"];

$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);

if(isset($_POST["password"])){ //add

$statusid = $_POST["statusid"];	
$password = md5($_POST["password"]);	

	$sql = "SELECT username FROM user where username = '".$username."'  ";
	$result = $con->query($sql);

	if ($result->num_rows == 0) {
		$sql = "INSERT INTO user (username, password, statusid) 
				VALUES ( '".$username."' , '".$password."' , '".$statusid."'  )";
		$result = $con->query($sql);
		
		if($result){
			echo "Username berhasil disimpan ";
		}	
	}else{
		
		echo "Gagal disimpan, Username sudah ada";
	}
	$con->close();
}else{ // delete

	$sql = "DELETE FROM user where username = '".$username."'  ";
	$result = $con->query($sql);
	
	if($result){
		echo "Username berhasil dihapus ";
	}
	$con->close();
}
?>
<a href="index.php"><button>Back</button></a>
</html>