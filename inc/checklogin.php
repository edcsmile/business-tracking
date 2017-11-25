<?
	##################################################
						# İlker Şahin // 26 Şubat 2017 // Kayrasoft Yazılım #
	##################################################
	if(!$_SESSION["userlogin"]){
		header("Location:giris.php");
		die();
	}
?>