<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<body>
<?php 
	session_start();
	if(isset($_SESSION["username"])){
		header("location:index.php");
	}	
	?> 
<div class="formlogin">
	<form name="login" method="POST" action="login1.php" >
		<div class="contentlogin">
			<input class="text1" name="username" placeholder="ID Pengguna" type="text"><br>
			<input class="text1" name="password" placeholder="Password" type="password"><br>
		</div>
		<div class="contentlogin">
			<input class="button1" type="submit" value="Log in">
	</form>
		<a href="register.html"><button type="button">Register</button></a>
		<a href="index.php"><button type="button"> &nbsp Back &nbsp </button></a>
		</div>
		
</div>
</body>
</html>