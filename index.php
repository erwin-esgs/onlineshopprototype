<html>
<head>
  <link rel="stylesheet" href="css.css">
</head>
<body>
<?php 
	session_start();
	if(!isset($_SESSION["username"])){
		echo '<div class="header">';
		echo '<div class="headerkiri"> &nbsp TOKO &nbsp </div>';
		echo ' <div class="headerkanan"><a href="register.html"><button> &nbspRegister</button></a></div> ';
		echo ' <div class="headerkanan"><a href="login.php"><button> &nbsp Login &nbsp &nbsp</button></a></div> ';
		echo ' <div class="headerkanan">Silahkan login/register dulu &nbsp </div>';
		echo "</div>";
		
		include 'home.php';
		//header("location:login.php");
	}else{
		$username = $_SESSION["username"];
		$statusid = $_SESSION["statusid"];
		echo '<div class="header">';
		echo '<div class="headerkiri"> &nbsp TOKO &nbsp </div>';
		echo '<div class="headerkanan"><a href="login1.php?logout=1"><button>Logout</button></a></div>';
		echo '<div class="headerkanan">Selamat datang: <a href="profile.php"><button>'.$username.'</button></a> </div> ';
		echo "</div>";
		
?>    
<?php
		if($statusid == 0){
			include 'admin.php';
		}elseif($statusid == 1){
			include 'pengguna.php';
		}else{
			include 'home.php';
		}	
		
	}
?>

</body>
</html>