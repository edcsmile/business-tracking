<?
	require_once("inc/config.php");
	require_once("inc/class.upload.php");
	$user = $_SESSION["user"];
   
	function head($title){
	?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?=$title . " - " . getversiyon();?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="img/favicon.ico">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		
		<link href="assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<?
	}
   
	function endhead($title){
	?>
		<link rel="stylesheet" href="css/flaty.css">
		<link rel="stylesheet" href="css/flaty-responsive.css">
	<?
	}
   
	function topbar(){
	?>
		<div id="theme-setting">
		   <a href="#"><i class="fa fa-gears fa fa-2x"></i></a>
		   <ul>
			  <li>
				 <span>Tema</span>
				 <ul class="colors" data-target="body" data-prefix="skin-">
					<li class="active"><a class="blue" href="#"></a></li>
					<li><a class="red" href="#"></a></li>
					<li><a class="green" href="#"></a></li>
					<li><a class="orange" href="#"></a></li>
					<li><a class="yellow" href="#"></a></li>
					<li><a class="pink" href="#"></a></li>
					<li><a class="magenta" href="#"></a></li>
					<li><a class="gray" href="#"></a></li>
					<li><a class="black" href="#"></a></li>
				 </ul>
			  </li>
			  <li>
				 <span>Üst Bar</span>
				 <ul class="colors" data-target="#navbar" data-prefix="navbar-">
					<li class="active"><a class="blue" href="#"></a></li>
					<li><a class="red" href="#"></a></li>
					<li><a class="green" href="#"></a></li>
					<li><a class="orange" href="#"></a></li>
					<li><a class="yellow" href="#"></a></li>
					<li><a class="pink" href="#"></a></li>
					<li><a class="magenta" href="#"></a></li>
					<li><a class="gray" href="#"></a></li>
					<li><a class="black" href="#"></a></li>
				 </ul>
			  </li>
			  <li>
				 <span>Sol Bar</span>
				 <ul class="colors" data-target="#main-container" data-prefix="sidebar-">
					<li class="active"><a class="blue" href="#"></a></li>
					<li><a class="red" href="#"></a></li>
					<li><a class="green" href="#"></a></li>
					<li><a class="orange" href="#"></a></li>
					<li><a class="yellow" href="#"></a></li>
					<li><a class="pink" href="#"></a></li>
					<li><a class="magenta" href="#"></a></li>
					<li><a class="gray" href="#"></a></li>
					<li><a class="black" href="#"></a></li>
				 </ul>
			  </li>
			  <li>
				 <span></span>
				 <a data-target="navbar" href="#"><i class="fa fa-square-o"></i> Üst Barı Sabitle</a>
				 <a class="hidden-inline-xs" data-target="sidebar" href="#"><i class="fa fa-square-o"></i> Sol Barı Sabitle</a>
			  </li>
		   </ul>
		</div>
		<div id="navbar" class="navbar">
		   <button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
		   <span class="fa fa-bars"></span>
		   </button>
		   <a class="navbar-brand" href="#">
		   <small>
		   <i class="fa fa-desktop"></i>
		   <?=getversiyon();?>
		   </small>
		   </a>
		   <ul class="nav flaty-nav pull-right">
			  <li class="user-profile">
				 <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
				 <img class="nav-user-photo" src="img/demo/avatar/<?=$GLOBALS["user"]["avatar"]?>" alt="<?=$GLOBALS["user"]["isim"]?>" />
				 <span class="hhh" id="user_info">
				 <?=$GLOBALS["user"]["isim"]?>
				 </span>
				 <i class="fa fa-caret-down"></i>
				 </a>
				 <ul class="dropdown-menu dropdown-navbar" id="user_menu">
					<li class="nav-header"><i class="fa fa-clock-o"></i>Giriş Saati <?=$_SESSION["gsaat"]?></li>
					<li class="divider"></li>
					<li><a href="cikis.php"><i class="fa fa-off"></i>Çıkış</a></li>
				 </ul>
			  </li>
		   </ul>
		</div>
	<?
	}
   
	function leftbar(){
	?>
		<div id="sidebar" class="navbar-collapse collapse">
		   <ul class="nav nav-list">
			  <li class="mn-gpanel"><a href="index.php"><i class="fa fa-dashboard"></i><span>Gösterge Paneli</span></a></li>
			  <?php if(yetkiKontrolGizle("0,1,2,3,4")) {
				  $readlyToAll = tabloCek("musteri_talep", "readly", "WHERE musteri_id = {$_SESSION["user"]["Id"]} AND readly = '1'");
					if( $readlyToAll->rowCount() > 0 )
						$count = '<span class="badge badge-warning right">'.$readlyToAll->rowCount().'</span>';
					else
						$count = '';
			  ?>
			  <li class="mn-musteri"><a href="musteri.php?islem=talepler"><i class="fa fa-user-circle"></i><span>Müşteri Talepleri <?=$count;?></span></a></li>
			  <li class="mn-firma"><a href="firma.php" class="dropdown-toggle"><i class="fa fa-building"></i><span>Firma</span></a></li>
			  <li class="mn-mepersonel">
				 <a href="#" class="dropdown-toggle"><i class="fa fa-user-circle"></i><span>Personel İşlemleri</span><b class="arrow fa fa-angle-right"></b></a>
				 <ul class="submenu">
					<li class="mn-mepersonel-calismalar"><a href="mepersonel.php?islem=calismalar">Çalışmalarım</a></li>
					<li class="mn-mepersonel-sonaktivite"><a href="mepersonel.php?islem=sonaktivite">Son Aktivitelerim</a></li>
				 </ul>
			  </li>
			  <?php } ?>
			  <li class="mn-isler">
				 <a href="#" class="dropdown-toggle"><i class="fa fa-paper-plane"></i><span>İş Yönetimi</span><b class="arrow fa fa-angle-right"></b></a>
				 <ul class="submenu">
					<li class="mn-isler-liste"><a href="isler.php?islem=liste">İş Listesi</a></li>
					<?php
						if($_SESSION["user"]["musteri"]) {
							$readlyToAll = tabloCek("musteri_talep", "readly_to", "WHERE musteri_id = {$_SESSION["user"]["Id"]} AND readly_to = '1'");
							if( $readlyToAll->rowCount() > 0 )
								$count = '<span class="badge badge-warning right">'.$readlyToAll->rowCount().'</span>';
							else
								$count = '';
							
							echo '<li class="mn-isler-talepler"><a href="isler.php?islem=talepler">Talepleriniz '.$count.'</a></li>';
						}
					?>
					<?php if(yetkiKontrolGizle("0,1,2,3,4")) { ?>
					<li class="mn-isler-aktivite"><a href="isler.php?islem=sonAktiviteler">Son Aktiviteler</a></li>
					<?php } ?>
				 </ul>
			  </li>
			  <?php if(yetkiKontrolGizle("0,1,2,3,4")) { ?>
			  <li class="mn-personel">
				 <a href="#" class="dropdown-toggle"><i class="fa fa-user"></i><span>Personel Yönetimi</span><b class="arrow fa fa-angle-right"></b></a>
				 <ul class="submenu">
					<?=(yetkiKontrolGizle("0"))?'
					<li class="mn-personel-ekle"><a href="personel.php?islem=ekle">Personel Ekle</a></li>
					':''?>
					<li class="mn-personel-liste"><a href="personel.php?islem=liste">Personel Listesi</a></li>
					<li class="mn-personel-musteri_ekle"><a href="personel.php?islem=musteri_listesi">Müşteri Listesi</a></li>
				 </ul>
			  </li>
			  <li class="mn-islemler"><a href="islemler.php"><i class="fa fa-tasks"></i><span>İşlem Listesi</span></a></li>
			  <?php } ?>
		   </ul>
		   <div id="sidebar-collapse" class="visible-lg">
			  <i class="fa fa-angle-double-left"></i>
		   </div>
		</div>
	<?
	}
   
	function footer(){
	?>
		<footer>
		   <p><?=getversiyon();?> &copy; <?=@date("Y");?> by <a href="http://www.coderbing.com" target="_blank">Coder Bing<a></p>
		</footer>
		<a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
	<?
	}
   
	function scripts(){
	?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="assets/jquery/jquery-2.1.1.min.js"><\/script>')</script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="assets/jquery-cookie/jquery.cookie.js"></script>
		
		<script src="assets/bootstrap-datetimepicker/js/Moment.js" type="text/javascript"></script>
		<script src="assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<?
	}
	
	function endscripts(){
	?>
		<script src="assets/ckeditor/ckeditor.js"></script>
		<script type="text/javascript">
		   CKEDITOR.replace( 'kurumsal_icerik' );
		</script>		
		<script src="js/flaty.js"></script>
		<script src="js/flaty-demo-codes.js"></script>
	<?
	}