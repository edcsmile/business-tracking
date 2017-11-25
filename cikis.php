<?
	unset($_SESSION["user"]);
	session_destroy();
	header("location:giris.php");
?>
