<!DOCTYPE html>
<?php
setcookie("isikeranjang", "", time() - 3600, '/');
?>
<html>
<?php
session_start();
require 'db.php';
$username = $_POST["username"];
$password = md5($_POST["password"]);

if(isset($_GET["logout"])){
		$logout = $_GET["logout"];
		if($logout == 1){
		session_destroy();
		//header("location:index.php");
		echo "<script language='javascript'>alert('Berhasil Logout');window.location.href = 'index.php';</script>";
	}	
}else{
	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	$sql = "SELECT username , password , statusid ,verify FROM user WHERE username = '".$username."' and password = '".$password."' ";
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$_SESSION["statusid"] = $row["statusid"];
			$_SESSION["verify"] = $row["verify"];
		}
		$_SESSION["username"] = $username;
		$_COOKIE["keranjang"] = 0;
		$con->close();
		//header("location:index.php");
		echo "<script language='javascript'>alert('Berhasil Login');window.location.href = 'index.php';</script>";
    }else{
		$con->close();
		//header("Location: login.php");
		echo "<script language='javascript'>alert('Gagal Login');window.location.href = 'login.php';</script>";
    }
}
?>
</html>