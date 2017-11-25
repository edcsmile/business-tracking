<?
	require_once("inc/config.php");
	@mysql_query("INSERT INTO islemler (tarih,personel,tur,aciklama) VALUES ('".@date("Y-m-d H:i:s")."',".$_SESSION["user"]["Id"].",'Çıkış','".$_SESSION["user"]["isim"]." sistemden çıkış yaptı.')");
	$_SESSION["userlogin"] = false;
	unset($_SESSION["user"]);
	session_destroy();
	header("location:giris.php");
?>