<?
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 0){
		git("index.php");
		die();
	}	
	
	$baslik = "Genel Tanımlar";
	$isError = false;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Ülke Bölümü
		if($_GET["islem"] == "yeniulkeekle"){
			$ulke_kodu			=		$_POST["ulke_kodu"];
			$ulke_turkce		=		$_POST["ulke_turkce"];
			$ulke_ingilizce		=		$_POST["ulke_ingilizce"];
			$ulke_durum		=		$_POST["ulke_durum"];
			
			$newImg = resimUpload($_FILES["ulke_resim"], "", false, "images/upload", "icerik.php?islem=ulke");
			
			if( veriEkle(array("ulke_kodu", "tr_ad", "en_ad", "bayrak", "durum"), array($ulke_kodu, $ulke_turkce, $ulke_ingilizce, $newImg, $ulke_durum), "ulkeler") )
			{
				islemKaydi("Genel Tanımlar", "{$ulke_turkce}, adlı ülke ekledi..");
				git("icerik.php?islem=ulke");
			} else {
				die("eklerken bir hata oluştu..");
			}
		}
		
		if($_GET["islem"] == "ulkeguncelle"){
			$ulkeId				=		$_POST["ulke_id"];
			$ulke_kodu			=		$_POST["ulke_kodu"];
			$ulke_turkce		=		$_POST["ulke_turkce"];
			$ulke_ingilizce		=		$_POST["ulke_ingilizce"];
			$ulke_durum		=		$_POST["ulke_durum"];
			
			if(!empty($_FILES["ulke_resim"]["name"]))
			{
				$getOldImg = veriCek("ulkeler", "bayrak", "ulke_id", $ulkeId);
				$newImg = resimUpload($_FILES["ulke_resim"], $getOldImg["bayrak"], false, "images/upload", "icerik.php?islem=ulke");
				veriGuncelle(array("bayrak"), array($newImg), "ulkeler", "ulke_id", $ulkeId);
			}
			
			if( veriGuncelle(array("ulke_kodu", "tr_ad", "en_ad", "durum"), array($ulke_kodu, $ulke_turkce, $ulke_ingilizce, $ulke_durum), "ulkeler", "ulke_id", $ulkeId) )
			{
				islemKaydi("Genel Tanımlar", "{$ulke_turkce}, adlı ülkeyi düzenledi..");
				git("?islem=ulkeDuzenle&Id=".$ulkeId);
			} else {
				git("icerik.php?islem=ulke");
			}
		}
		
		// Şehir Bölümü
		if($_GET["islem"] == "yenisehirekle"){
			$sehir_turkce		=		$_POST["sehir_turkce"];
			$sehir_ingilizce	=		$_POST["sehir_ingilizce"];
			$sehir_ulke			=		$_POST["sehir_ulke"];
			$sehir_durum		=		$_POST["sehir_durum"];
			
			if( veriEkle(array("ulke_kodu", "tr_sehir", "en_sehir", "durum"), array($sehir_ulke, $sehir_turkce, $sehir_ingilizce, $sehir_durum), "sehirler") )
			{
				islemKaydi("Genel Tanımlar", "{$sehir_turkce}, adlı şehir ekledi..");
				git("icerik.php?islem=sehirler");
			} else {
				git("icerik.php?islem=sehirler");
			}
		}
		
		if($_GET["islem"] == "sehirguncelle"){
			$sehirId				=		$_POST["sehir_id"];
			$sehir_turkce		=		$_POST["sehir_turkce"];
			$sehir_ingilizce	=		$_POST["sehir_ingilizce"];
			$sehir_ulke			=		$_POST["sehir_ulke"];
			$sehir_durum		=		$_POST["sehir_durum"];
			
			if( veriGuncelle(array("ulke_kodu", "tr_sehir", "en_sehir", "durum"), array($sehir_ulke, $sehir_turkce, $sehir_ingilizce, $sehir_durum), "sehirler", "sehir_id", $sehirId) )
			{
				islemKaydi("Genel Tanımlar", "{$sehir_turkce}, adlı şehiri düzenledi..");
				git("?islem=sehirDuzenle&Id=".$sehirId);
			} else {
				git("icerik.php?islem=sehirler");
			}
		}
		
		// İlçe Bölümü
		if($_GET["islem"] == "yeniilceekle"){
			$ilce_turkce		=		$_POST["ilce_turkce"];
			$ilce_ingilizce		=		$_POST["ilce_ingilizce"];
			$ilce_sehir			=		$_POST["ilce_sehir"];
			$ilce_durum		=		$_POST["ilce_durum"];
			
			if( veriEkle(array("sehir_kodu", "tr_ilce", "en_ilce", "durum"), array($ilce_sehir, $ilce_turkce, $ilce_ingilizce, $ilce_durum), "ilceler") )
			{
				islemKaydi("Genel Tanımlar", "{$ilce_turkce}, adlı ilçe ekledi..");
				git("icerik.php?islem=ilceler");
			} else {
				git("icerik.php?islem=ilceler");
			}
		}
		
		if($_GET["islem"] == "ilceguncelle"){
			$ilce_id		=		$_POST["ilce_id"];
			$ilce_turkce		=		$_POST["ilce_turkce"];
			$ilce_ingilizce		=		$_POST["ilce_ingilizce"];
			$ilce_sehir			=		$_POST["ilce_sehir"];
			$ilce_durum		=		$_POST["ilce_durum"];
			
			if( veriGuncelle(array("sehir_kodu", "tr_ilce", "en_ilce", "durum"), array($ilce_sehir, $ilce_turkce, $ilce_ingilizce, $ilce_durum), "ilceler", "ilce_id", $ilce_id) )
			{
				islemKaydi("Genel Tanımlar", "{$ilce_turkce}, adlı ilçeyi düzenledi..");
				git("?islem=ilceDuzenle&Id=".$ilce_id);
			} else {
				git("icerik.php?islem=ilceler");
			}
		}
		
		// Sektör Bölümü
		if($_GET["islem"] == "yenisektorekle"){
			$turkce		=		$_POST["turkce"];
			$ingilizce	=		$_POST["ingilizce"];
			$durum		=		$_POST["durum"];
			
			if( veriEkle(array("tr_sektor", "en_sektor", "durum"), array($turkce, $ingilizce, $durum), "sektorler") )
			{
				islemKaydi("Genel Tanımlar", "{$turkce}, adlı sektör ekledi..");
				git("icerik.php?islem=sektorler");
			} else {
				git("icerik.php?islem=sektorler");
			}
		}
		
		if($_GET["islem"] == "sektorguncelle") {
			$id			=		$_POST["id"];
			$turkce		=		$_POST["turkce"];
			$ingilizce	=		$_POST["ingilizce"];
			$durum		=		$_POST["durum"];
			
			if( veriGuncelle(array("tr_sektor", "en_sektor", "durum"), array($turkce, $ingilizce, $durum), "sektorler", "sektor_id", $id) )
			{
				islemKaydi("Genel Tanımlar", "{$turkce}, adlı sektörü düzenledi..");
				git("?islem=sektorDuzenle&Id=".$id);
			} else {
				git("icerik.php?islem=sektorler");
			}
		}
		
		// Görevler Bölümü
		if($_GET["islem"] == "yenigorevekle"){
			$turkce		=		$_POST["turkce"];
			$ingilizce	=		$_POST["ingilizce"];
			$durum		=		$_POST["durum"];
			$sektor		=		$_POST["sektor"];
			
			if( veriEkle(array("sektor_kodu", "tr_gorev", "en_gorev", "durum"), array($sektor, $turkce, $ingilizce, $durum), "gorevler") )
			{
				islemKaydi("Genel Tanımlar", "{$turkce}, adlı görev ekledi..");
				git("icerik.php?islem=gorevler");
			} else {
				git("icerik.php?islem=gorevler");
			}
		}
		
		if($_GET["islem"] == "gorevguncelle") {
			$id			=		$_POST["id"];
			$turkce		=		$_POST["turkce"];
			$ingilizce	=		$_POST["ingilizce"];
			$durum		=		$_POST["durum"];
			$sektor		=		$_POST["sektor"];
			
			if( veriGuncelle(array("sektor_kodu", "tr_gorev", "en_gorev", "durum"), array($sektor, $turkce, $ingilizce, $durum), "gorevler", "gorev_id", $id) )
			{
				islemKaydi("Genel Tanımlar", "{$turkce}, adlı görevi düzenledi..");
				git("?islem=gorevDuzenle&Id=".$id);
			} else {
				git("icerik.php?islem=gorevler");
			}
		}
		
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<?=head($baslik);?>
		
		<!--page specific css styles-->	
				
		<?=endhead("");?>
	</head>
	<body>
	
		<?=topbar();?>

		<div class="container" id="main-container">

			<?=leftbar();?>

			<div id="main-content">
				<div class="page-title">
					<div>
						<h1><i class="fa fa-file-o"></i> <?=$baslik;?></h1>
						<h4>
							
						</h4>
					</div>
				</div>
				
				<?
					switch($_GET["islem"]){
						case "ulke":
						?>
			    <div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Ülkeler</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ulkeekle';"><i class="fa fa-check"></i> Yeni Kayıt Ekle</button>
							<br /><br />
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th style="width: 5%;">Bayrak</th>
										<th>Ülke Kodu</th>
										<th>Ülke Türkçe</th>
										<th>Ülke İngilizce</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $veri = tabloCek("ulkeler", "*", "ORDER BY ulke_id DESC");
									 $i=1;
									 foreach( $veri as $row ) {
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><a target="_blank" href="../images/upload/<?=$row["bayrak"];?>"><img src="../images/upload/<?=$row["bayrak"];?>" style="max-width: 100%;" /></a></td>
											<td><?=$row["ulke_kodu"];?></td>
											<td><?=$row["tr_ad"];?></td>
											<td><?=$row["en_ad"];?></td>
											<td>
											   <a class="btn btn-primary btn-sm" href="?islem=ulkeDuzenle&Id=<?=$row["ulke_id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
											   <a class="btn btn-danger btn-sm" href="?islem=ulkeSil&Id=<?=$row["ulke_id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
											</td>
										 </tr>
									 <?
										$i++;
									 }
									 ?>
								  </tbody>
							   </table>
							</div>
						 </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "ulkeekle":
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Ülke Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yeniulkeekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Ülke Kodu</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ulke_kodu" value="" class="form-control" data-rule-required="true">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Ülke Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ulke_turkce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Ülke İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ulke_ingilizce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="sifre" class="col-sm-3 col-lg-2 control-label">Resim</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="file" name="ulke_resim" class="form-control" data-rule-minlength="4">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="ulke_durum" class="form-control">
										<option value="1">Göster</option>
										<option value="0">Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=liste';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "ulkeDuzenle":
						$veri = veriCek("ulkeler", "*", "ulke_id", $_GET["Id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Ülke Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=ulkeguncelle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="ulke_id" value="<?=$_GET["Id"];?>" />
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Ülke Kodu</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ulke_kodu" value="<?=$veri["ulke_kodu"];?>" class="form-control" data-rule-required="true">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Ülke Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ulke_turkce" value="<?=$veri["tr_ad"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Ülke İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ulke_ingilizce" value="<?=$veri["en_ad"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="sifre" class="col-sm-3 col-lg-2 control-label">Mevcut Resim / Değiştir</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <a target="_blank" href="../images/upload/<?=$veri["bayrak"];?>"><img src="../images/upload/<?=$veri["bayrak"];?>" style="max-width: 5%;" /></a>
									  <input type="file" name="ulke_resim" class="form-control" data-rule-minlength="4">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="ulke_durum" class="form-control">
										<option value="1" <?=($veri["durum"] == 1)?"selected":""?>>Göster</option>
										<option value="0" <?=($veri["durum"] == 0)?"selected":""?>>Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Güncelle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=liste';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "ulkeSil":
						if( ctype_digit($_GET["Id"]) ) {
							$eskiveri = veriCek("ulkeler", "tr_ad, bayrak", "ulke_id", $_GET["Id"]);
							@unlink("../images/upload/" . $eskiveri["bayrak"]);
							
							veriSil("ulkeler", "ulke_id", $_GET["Id"]);
							islemKaydi("Genel Tanımlar | Ülkeler", "bir ülke sildi. ({$eskiveri["tr_ad"]})");
						}
						git("?islem=ulke");
						break;
						case "sehirler":
						if(empty($_GET["ulke"]))
							$_GET["ulke"] = "207";
						?>
			    <div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Şehirler</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=sehirekle';"><i class="fa fa-check"></i> Yeni Kayıt Ekle</button> <br /><br />
							<p><b>Ülke Seç</b></p>
							<select name="ulke_filter" class="form-control">
								<?php
									$getUlkeler = tabloCek("ulkeler", "ulke_id, tr_ad", "ORDER BY ulke_id DESC");
									
									foreach( $getUlkeler as $ulke )
									{
										if($_GET["ulke"] == $ulke["ulke_id"])
											echo "<option value='{$ulke["ulke_id"]}' selected>{$ulke["tr_ad"]}</option>";
										else
											echo "<option value='{$ulke["ulke_id"]}'>{$ulke["tr_ad"]}</option>";
									}
								?>
							</select>
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th style="width: 5%;">Bayrak</th>
										<th style="width: 10%;">Ülke Kodu</th>
										<th>Şehir Türkçe</th>
										<th>Şehir İngilizce</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $veri = tabloCek("sehirler", "*", "WHERE ulke_kodu = '{$_GET["ulke"]}' ORDER BY sehir_id DESC");
									 $i = 1;
									 $oldBayrakNo = 0;
									 $oldBayrak = "";
									 foreach( $veri as $row ) {
										 $getUlke = veriCek("ulkeler", "ulke_id, ulke_kodu, bayrak", "ulke_id", $row["ulke_kodu"]);
										 if( $oldBayrakNo != $getUlke["ulke_id"] )
										 {
											 $oldBayrak = "../images/upload/".$getUlke["bayrak"];
											 $oldBayrakNo = $getUlke["ulke_id"];
										 }
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><a target="_blank" href="<?=$oldBayrak?>"><img src="<?=$oldBayrak?>" style="max-width: 100%;" /></a></td>
											<td><?=$getUlke["ulke_kodu"];?></td>
											<td><?=$row["tr_sehir"];?></td>
											<td><?=$row["en_sehir"];?></td>
											<td>
											   <a class="btn btn-primary btn-sm" href="?islem=sehirDuzenle&Id=<?=$row["sehir_id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
											   <a class="btn btn-danger btn-sm" href="?islem=sehirSil&Id=<?=$row["sehir_id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
											</td>
										 </tr>
									 <?
										$i++;
									 }
									 ?>
								  </tbody>
							   </table>
							</div>
						 </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "sehirekle":
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Şehir Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yenisehirekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Şehir Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="sehir_turkce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Şehir İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="sehir_ingilizce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Ülke Seç</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="sehir_ulke" class="form-control">
											<?php
												$getUlkeler = tabloCek("ulkeler", "ulke_id, tr_ad", "ORDER BY ulke_id DESC");
												
												foreach( $getUlkeler as $ulke )
													echo "<option value='{$ulke["ulke_id"]}'>{$ulke["tr_ad"]}</option>";
											?>
										</select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="sehir_durum" class="form-control">
										<option value="1">Göster</option>
										<option value="0">Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=sehirler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "sehirDuzenle":
						$veri = veriCek("sehirler", "*", "sehir_id", $_GET["Id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Şehir Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=sehirguncelle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="sehir_id" value="<?=$veri["sehir_id"];?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Şehir Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="sehir_turkce" value="<?=$veri["tr_sehir"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Şehir İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="sehir_ingilizce" value="<?=$veri["en_sehir"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Ülke Seç</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="sehir_ulke" class="form-control">
											<?php
												$getUlkeler = tabloCek("ulkeler", "ulke_id, tr_ad", "ORDER BY ulke_id DESC");
												
												foreach( $getUlkeler as $ulke )
												{
													if($ulke["ulke_id"] == $veri["ulke_kodu"])
														echo "<option value='{$ulke["ulke_id"]}' selected>{$ulke["tr_ad"]}</option>";
													else
														echo "<option value='{$ulke["ulke_id"]}'>{$ulke["tr_ad"]}</option>";
												}
											?>
										</select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="sehir_durum" class="form-control">
										<option value="1" <?=($veri["durum"] == 1)?"selected":""?>>Göster</option>
										<option value="0" <?=($veri["durum"] == 0)?"selected":""?>>Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Düzenle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=sehirler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "sehirSil":
						if( ctype_digit($_GET["Id"]) ) {
							$eskiveri = veriCek("sehirler", "tr_sehir", "sehir_id", $_GET["Id"]);
							
							veriSil("sehirler", "sehir_id", $_GET["Id"]);
							islemKaydi("Genel Tanımlar | Şehirler", "bir şehir sildi. ({$eskiveri["tr_sehir"]})");
						}
						git("?islem=sehirler");
						break;
						case "ilceler":
						if(empty($_GET["ulke"]))
							$_GET["ulke"] = "207";
						if(empty($_GET["sehir"]))
							$_GET["sehir"] = "55";
						?>
			    <div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Şehirler</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ilceekle';"><i class="fa fa-check"></i> Yeni Kayıt Ekle</button> <br /><br />
							<p><b>Ülke Seç</b></p>
							<select name="ilce_sehir_ulke" class="form-control">
								<?php
									$getUlkeler = tabloCek("ulkeler", "ulke_id, tr_ad", "ORDER BY ulke_id DESC");
									
									foreach( $getUlkeler as $ulke )
									{
										if($_GET["ulke"] == $ulke["ulke_id"])
											echo "<option value='{$ulke["ulke_id"]}' selected>{$ulke["tr_ad"]}</option>";
										else
											echo "<option value='{$ulke["ulke_id"]}'>{$ulke["tr_ad"]}</option>";
									}
								?>
							</select>
							<p><b>Şehir Seç</b></p>
							<select name="ilce_filter" class="form-control">
								<?php
									if(!empty($_GET["ulke"]))
										$getSehirler = tabloCek("sehirler", "sehir_id, tr_sehir", "WHERE ulke_kodu = '{$_GET["ulke"]}' ORDER BY sehir_id DESC");
									
									foreach( $getSehirler as $sehir )
									{
										if($_GET["sehir"] == $sehir["sehir_id"])
											echo "<option value='{$sehir["sehir_id"]}' selected>{$sehir["tr_sehir"]}</option>";
										else
											echo "<option value='{$sehir["sehir_id"]}'>{$sehir["tr_sehir"]}</option>";
									}
								?>
							</select>
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th style="width: 10%;">Şehir</th>
										<th>İlçe Türkçe</th>
										<th>İlçe İngilizce</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $veri = tabloCek("ilceler", "*", "WHERE sehir_kodu = '{$_GET["sehir"]}' ORDER BY ilce_id DESC");
									 $sehir = veriCek("sehirler", "tr_sehir", "sehir_id", $_GET["sehir"]);
									 $i = 1;
									 $oldBayrakNo = 0;
									 $oldBayrak = "";
									 foreach( $veri as $row ) {
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><?=$sehir["tr_sehir"];?></td>
											<td><?=$row["tr_ilce"];?></td>
											<td><?=$row["en_ilce"];?></td>
											<td>
											   <a class="btn btn-primary btn-sm" href="?islem=ilceDuzenle&Id=<?=$row["ilce_id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
											   <a class="btn btn-danger btn-sm" href="?islem=ilceSil&Id=<?=$row["ilce_id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
											</td>
										 </tr>
									 <?
										$i++;
									 }
									 ?>
								  </tbody>
							   </table>
							</div>
						 </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "ilceekle":
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> İlçe Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yeniilceekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İlçe Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ilce_turkce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İlçe İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ilce_ingilizce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Şehir Seç</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="ilce_sehir" class="form-control">
											<?php
												$getSehirler = tabloCek("sehirler", "sehir_id, tr_sehir", "ORDER BY sehir_id DESC");
												
												foreach( $getSehirler as $sehir )
													echo "<option value='{$sehir["sehir_id"]}'>{$sehir["tr_sehir"]}</option>";
											?>
										</select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="ilce_durum" class="form-control">
										<option value="1">Göster</option>
										<option value="0">Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=sehirler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "ilceDuzenle":
						$veri = veriCek("ilceler", "*", "ilce_id", $_GET["Id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> İlçe Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=ilceguncelle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="ilce_id" value="<?=$veri["ilce_id"];?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İlçe Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ilce_turkce" value="<?=$veri["tr_ilce"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İlçe İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ilce_ingilizce" value="<?=$veri["en_ilce"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Şehir Seç</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="ilce_sehir" class="form-control">
											<?php
												$getSehirler = tabloCek("sehirler", "sehir_id, tr_sehir", "ORDER BY sehir_id DESC");
												
												foreach( $getSehirler as $sehir )
												{
													if($veri["sehir_kodu"] == $sehir["sehir_id"])
														echo "<option value='{$sehir["sehir_id"]}' selected>{$sehir["tr_sehir"]}</option>";
													else
														echo "<option value='{$sehir["sehir_id"]}'>{$sehir["tr_sehir"]}</option>";
												}
											?>
										</select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="ilce_durum" class="form-control">
										<option value="1" <?=($veri["durum"] == 1)?"selected":""?>>Göster</option>
										<option value="0" <?=($veri["durum"] == 0)?"selected":""?>>Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Düzenle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=sehirler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "ilceSil":
						if( ctype_digit($_GET["Id"]) ) {
							$eskiveri = veriCek("ilceler", "tr_ilce", "ilce_id", $_GET["Id"]);
							
							veriSil("ilceler", "ilce_id", $_GET["Id"]);
							islemKaydi("Genel Tanımlar | Şehirler", "bir ilçe sildi. ({$eskiveri["tr_ilce"]})");
						}
						git("?islem=ilceler");
						break;
						case "sektorler":
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Sektörler</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=sektorEkle';"><i class="fa fa-check"></i> Yeni Kayıt Ekle</button> <br /><br />
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th>Sektör Türkçe</th>
										<th>Sektör İngilizce</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $veri = tabloCek("sektorler", "*", "ORDER BY sektor_id DESC");
									 $i = 1;
									 $oldBayrakNo = 0;
									 $oldBayrak = "";
									 foreach( $veri as $row ) {
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><?=$row["tr_sektor"];?></td>
											<td><?=$row["en_sektor"];?></td>
											<td>
											   <a class="btn btn-primary btn-sm" href="?islem=sektorDuzenle&Id=<?=$row["sektor_id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
											   <a class="btn btn-danger btn-sm" href="?islem=sektorSil&Id=<?=$row["sektor_id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
											</td>
										 </tr>
									 <?
										$i++;
									 }
									 ?>
								  </tbody>
							   </table>
							</div>
						 </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "sektorEkle":
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Sektör Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yenisektorekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Sektor Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="turkce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Sektor İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ingilizce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="durum" class="form-control">
										<option value="1">Göster</option>
										<option value="0">Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=sehirler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "sektorDuzenle":
						$veri = veriCek("sektorler", "*", "sektor_id", $_GET["Id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Sektör Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=sektorguncelle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="id" value="<?=$veri["sektor_id"];?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Sektor Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="turkce" value="<?=$veri["tr_sektor"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Sektor İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ingilizce" value="<?=$veri["en_sektor"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="durum" class="form-control">
										<option value="1" <?=($veri["durum"] == 1)?"selected":""?>>Göster</option>
										<option value="0" <?=($veri["durum"] == 0)?"selected":""?>>Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Düzenle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=sehirler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "sektorSil":
						if( ctype_digit($_GET["Id"]) ) {
							$eskiveri = veriCek("sektorler", "tr_sektor", "sektor_id", $_GET["Id"]);
							
							veriSil("sektorler", "sektor_id", $_GET["Id"]);
							islemKaydi("Genel Tanımlar | Sektörler", "bir sektör sildi. ({$eskiveri["tr_sektor"]})");
						}
						git("?islem=sektorler");
						break;
						case "gorevler":
						if(empty($_GET["sektor"]))
							$_GET["sektor"] = "1";
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Görevler</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=gorevEkle';"><i class="fa fa-check"></i> Yeni Kayıt Ekle</button> <br /><br />
							<p><b>Sektör Seç</b></p>
							<select name="sektor_sec" class="form-control">
								<?php
									$getSektorler = tabloCek("sektorler", "sektor_id, tr_sektor", "ORDER BY sektor_id DESC");
									
									foreach( $getSektorler as $sektor )
									{
										if($_GET["sektor"] == $sektor["sektor_id"])
											echo "<option value='{$sektor["sektor_id"]}' selected>{$sektor["tr_sektor"]}</option>";
										else
											echo "<option value='{$sektor["sektor_id"]}'>{$sektor["tr_sektor"]}</option>";
									}
								?>
							</select>
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th>Sektör</th>
										<th>Görev Türkçe</th>
										<th>Görev İngilizce</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $veri = tabloCek("gorevler", "*", "WHERE sektor_kodu = '{$_GET["sektor"]}' ORDER BY gorev_id DESC");
									 $i = 1;
									 foreach( $veri as $row ) {
										 $sektor = veriCek("sektorler", "tr_sektor", "sektor_id", $_GET["sektor"]);
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><?=$sektor["tr_sektor"];?></td>
											<td><?=$row["tr_gorev"];?></td>
											<td><?=$row["en_gorev"];?></td>
											<td>
											   <a class="btn btn-primary btn-sm" href="?islem=gorevDuzenle&Id=<?=$row["gorev_id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
											   <a class="btn btn-danger btn-sm" href="?islem=gorevSil&Id=<?=$row["gorev_id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
											</td>
										 </tr>
									 <?
										$i++;
									 }
									 ?>
								  </tbody>
							   </table>
							</div>
						 </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "gorevEkle":
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Görev Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yenigorevekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Görev Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="turkce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Görev İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ingilizce" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Sektör Seç</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="sektor" class="form-control">
											<?php
												$getSektorler = tabloCek("sektorler", "sektor_id, tr_sektor", "ORDER BY sektor_id DESC");
												
												foreach( $getSektorler as $sektor )
													echo "<option value='{$sektor["sektor_id"]}'>{$sektor["tr_sektor"]}</option>";
											?>
										</select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="durum" class="form-control">
										<option value="1">Göster</option>
										<option value="0">Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=gorevler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "gorevDuzenle":
						$veri = veriCek("gorevler", "*", "gorev_id", $_GET["Id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Görev Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=gorevguncelle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="id" value="<?=$veri["gorev_id"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Görev Türkçe</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="turkce" value="<?=$veri["tr_gorev"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Görev İngilizce</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="ingilizce" value="<?=$veri["en_gorev"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Sektör Seç</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="sektor" class="form-control">
											<?php
												$getSektorler = tabloCek("sektorler", "sektor_id, tr_sektor", "ORDER BY sektor_id DESC");
												
												foreach( $getSektorler as $sektor )
												{
													if($veri["sektor_kodu"] == $sektor["sektor_id"])
														echo "<option value='{$sektor["sektor_id"]}' selected>{$sektor["tr_sektor"]}</option>";
													else
														echo "<option value='{$sektor["sektor_id"]}'>{$sektor["tr_sektor"]}</option>";
												}
											?>
										</select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="durum" class="form-control">
										<option value="1" <?=($veri["durum"] == 1)?"selected":""?>>Göster</option>
										<option value="0" <?=($veri["durum"] == 0)?"selected":""?>>Gizle</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=gorevler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "gorevSil":
						if( ctype_digit($_GET["Id"]) ) {
							$eskiveri = veriCek("gorevler", "tr_gorev", "gorev_id", $_GET["Id"]);
							
							veriSil("gorevler", "gorev_id", $_GET["Id"]);
							islemKaydi("Genel Tanımlar | Şehirler", "bir görev sildi. ({$eskiveri["tr_gorev"]})");
						}
						git("?islem=gorevler");
						break;
						default:
							git("?islem=ulke");
						break;
					}
				?>				
				
				<?=footer();?>
				
			</div>
		</div>
		<?=scripts();?>
		
		<!--page specific plugin scripts-->
		<script src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="assets/jquery-validation/dist/additional-methods.min.js"></script>
		
		<?=endscripts();?>
		
		<script>
			$(document).ready(function () {
				$('.mn-icerik').addClass('active');
				$('.mn-icerik-<?=$_GET["islem"]?>').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
				
				$("select[name=ulke_filter]").change(function(){
					var target = $(this).val();
					location.href = "?islem=sehirler&ulke=" + target;
				});
				
				$("select[name=ilce_sehir_ulke]").change(function(){
					var target = $(this).val();
					location.href = "?islem=ilceler&ulke=" + target;
				});
				$("select[name=ilce_filter]").change(function(){
					var target1 = $("select[name=ilce_sehir_ulke]").val();
					var target2 = $(this).val();
					location.href = "?islem=ilceler&ulke=" + target1 + "&sehir=" + target2;
				});
				
				$("select[name=sektor_sec]").change(function(){
					var target = $(this).val();
					location.href = "?islem=gorevler&sektor=" + target;
				});
				
			});
		</script>
		
	</body>
</html>