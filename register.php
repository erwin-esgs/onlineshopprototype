<!DOCTYPE html>
<html>
<?php
session_start();
require 'db.php';
$username = $_POST["username"];
$nama = $_POST["nama"];
$password =md5($_POST["password"]);

	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	$sql = "SELECT username FROM user where username = '".$username."'  ";
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
		$con->close();
		header("Location: register.html");
    }else{
		$sql = "INSERT INTO user (username, password, nama, statusid, verify) 
	       VALUES ( '".$username."' , '".$password."' , '".$nama."' , '1' , '0'  )";
		$result = $con->query($sql);

		if ($result === TRUE) {
			$con->close();
			echo "<script>
					alert('Pendaftaran berhasil!');
					window.location.replace('login.php');
				</script>";
		}else{
			$con->close();
			echo "<script>
					alert('Username sudah terdaftar');
					window.location.replace('register.html');
				</script>";
		}
    }
	
?>
</html>