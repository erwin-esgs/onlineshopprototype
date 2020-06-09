<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<body >

	<div class="contentlogin">
	Delete User
	<form name="newform" method="post" action="newuser.php" >

			<select name="username">
			
<?php
require 'db.php';
session_start();

	$con = mysqli_connect($hostdb,$iddb,$passdb,$namadb);
	$sql = "SELECT username FROM user ";
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$username = $row["username"];
			
		echo ' <option value='.$username.'> '.$username.' </option> ';
		}	
    }
	$con->close();
?>
			</select><br> 
				<input class="button1" type="submit" />
				<a href="index.php"><button type="button"> &nbsp Back &nbsp </button></a>
	</form> 
	
	</div>
	
<body>
</html>