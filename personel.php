<?
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["musteri"])
		yetkiKontrol("müşteriler giremez");
	
	$baslik = "Personel Yönetimi";
	$isError = false;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		yetkiKontrol("0");
		
		if($_GET["islem"] == "eklepost"){
			$avatar = ninja($_POST['avatar']);
			$isim = ninja($_POST['isim']);
			$kadi = ninja($_POST['kadi']);
			$sifre = ninja($_POST['sifre']);
			$yetki = ninja($_POST['yetki']);
			if(!empty($isim) || !empty($kadi) || !empty($sifre)){
				$sutunlar = array("avatar", "isim", "kadi", "sifre", "yetki");
				$veriler = array($avatar, $isim, $kadi, $sifre, $yetki);
				veriEkle($sutunlar, $veriler, "personel");
				islemKaydi("Personel Ekleme", "sisteme bir personel ekledi. (<b>{$isim}</b>)");
				git("?islem=liste");
			} else {
				$isError = true;
			}
		}
		
		if($_GET["islem"] == "yenimusteriekle"){
			$isim = ninja($_POST['isim']);
			$kadi = ninja($_POST['kadi']);
			$sifre = ninja($_POST['sifre']);
			$yetki = ninja($_POST['yetki']);
			
			$one = 1;
			$isler = $_POST['isler'];
			
			if($isler)
			{
				$oneTotal		=		count($isler);
				foreach( $isler as $is )
				{
					if($one == 1)
						$musteriyeAitIs .= $is;
					else
						$musteriyeAitIs .= "-".$is;
					
					$one = 0;
				}
			}
			
			if(!empty($isim) || !empty($kadi) || !empty($sifre)){
				$sutunlar = array("is_id", "isim", "kadi", "sifre");
				$veriler = array($musteriyeAitIs, $isim, $kadi, $sifre);
				veriEkle($sutunlar, $veriler, "musteri");
				islemKaydi("Yeni Müşteri Ekle", "sisteme bir müşteri ekledi. (<b>{$isim}</b>)");
				git("?islem=musteri_listesi");
			} else {
				$isError = true;
			}
		}
		
		if($_GET["islem"] == "musteribilgiguncelle"){
			$id = $_POST['id'];
			$isim = ninja($_POST['isim']);
			$kadi = ninja($_POST['kadi']);
			$sifre = ninja($_POST['sifre']);
			$yetki = ninja($_POST['yetki']);
			
			$one = 1;
			$isler = $_POST['isler'];
			
			if($isler)
			{
				$oneTotal		=		count($isler);
				foreach( $isler as $is )
				{
					if($one == 1)
						$musteriyeAitIs .= $is;
					else
						$musteriyeAitIs .= "-".$is;
					
					$one = 0;
				}
			}
			
			if(!empty($isim) || !empty($kadi) || !empty($sifre)){
				$sutunlar = array("is_id", "isim", "kadi", "sifre");
				$veriler = array($musteriyeAitIs, $isim, $kadi, $sifre);
				veriGuncelle($sutunlar, $veriler, "musteri", "id", $id);
				islemKaydi("Müşteri Düzenle", "<b>{$isim}</b>, adlı müşterinin bilgilerini güncelledi.");
				git("?islem=musteri_listesi");
			} else {
				$isError = true;
			}
		}
		
		if($_GET["islem"] == "duzenlepost" && ctype_digit($_GET["Id"])){
			$Id = $_GET["Id"];
			$avatar = ninja($_POST['avatar']);
			$isim = ninja($_POST['isim']);
			$kadi = ninja($_POST['kadi']);
			$sifre = ninja($_POST['sifre']);
			$yetki = ninja($_POST['yetki']);	
			if(isset($isim) || isset($kadi) || isset($sifre)){
				$eskiveri = veriCek("personel", "*", "Id", $_GET["Id"]);
				$sutunlar = array("avatar", "isim", "kadi", "sifre", "yetki");
				$veriler = array($avatar, $isim, $kadi, $sifre, $yetki);
				veriGuncelle($sutunlar, $veriler, "personel", "Id", $_GET["Id"]);
				islemKaydi("Personel Düzenle", "sistemdeki personeli güncelledi. (Eski İsim : {$eskiveri["isim"]} - Eski Kullanıcı Adı : {$eskiveri["kadi"]})");
				git("?islem=liste");
			} else {
				$isError = true;
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
						<h4></h4>
					</div>
				</div>
				<?
					switch($_GET["islem"]){
						case "ekle":
						yetkiKontrol("0");
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Yeni Personel Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=eklepost" id="validation-form" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="avatar" class="col-sm-3 col-lg-2 control-label">Avatar</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <img id="avtimg" src="img/demo/avatar/avatar1.jpg" alt="" />
									  <br /><br />
									  <select name="avatar" id="avatar" class="form-control">
										<option value="avatar1.jpg">Avatar 1</option>
										<option value="avatar2.jpg">Avatar 2</option>
										<option value="avatar3.jpg">Avatar 3</option>
										<option value="avatar4.jpg">Avatar 4</option>
										<option value="avatar5.jpg">Avatar 5</option>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">İsim</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="isim" id="isim" placeholder="İsim giriniz" class="form-control" data-rule-required="true">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kullanıcı Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="kadi" id="kadi" placeholder="Kullanıcı Adı giriniz" class="form-control" data-rule-required="true" data-rule-minlength="3">
								   </div>
								</div>
								<div class="form-group">
								   <label for="sifre" class="col-sm-3 col-lg-2 control-label">Şifre</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="sifre" id="sifre" placeholder="Şifre giriniz" class="form-control" data-rule-required="true" data-rule-minlength="4">
								   </div>
								</div>
								<div class="form-group">
								   <label for="yetki" class="col-sm-3 col-lg-2 control-label">Yetki</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="yetki" id="yetki" class="form-control">
										<option value="0">Yönetici</option>
										<option value="4">Genel Kordinatör</option>
										<option value="1">Sekreter</option>
										<option value="2" selected>Eleman</option>
										<option value="3">Stajyer</option>
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
						case "musteri_listesi":
						?>
				<div class="row">
				   <div class="col-md-12">
					  <div class="box">
						 <div class="box-title">
							<h3><i class="fa fa-table"></i> Müşteri Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
							<?=(yetkiKontrolGizle("0"))?'<button type="button" class="btn btn-primary" onclick="javascript:location.href=\'?islem=musteri_ekle\';"><i class="fa fa-check"></i> Yeni Müşteri Ekle</button>
							<br /><br />':''?>
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th>#</th>
										<th>İsim</th>
										<th>Kullanıcı Adı</th>
										<th>Şifre</th>
										<th>İş</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $veri = tabloCek("musteri", "*", "ORDER BY id DESC");
									 $i=1;
									 foreach( $veri as $row ) {
									 ?>
									 <tr>
										<td style="width: 2%;"><?=$i;?></td>
										<td><?=$row["isim"];?></td>
										<td><?=$row["kadi"];?></td>
										<td><?=(yetkiKontrolGizle("0"))?$row["sifre"]:"***"?></td>
										<td>
										<?php
										$one = 1;
										$control = strpos($row["is_id"], "-");
										if($control)
										{
											$isler = explode("-", $row["is_id"]);
											foreach( $isler as $is_id )
											{
												$isBilgisi = veriCek("jobs ", "is_adi, id", "id", $is_id);
												if($one == 1)
												{
													echo $isBilgisi["is_adi"] . " - ";
													$one = 0;
												} else {
													echo $isBilgisi["is_adi"];
												}
											}
										} else {
											$isBilgisi = veriCek("jobs ", "is_adi, id", "id", $row["is_id"]);
											echo $isBilgisi["is_adi"];
										}
										?>
										</td>
										<td>
											<?php if(yetkiKontrolGizle("0")) { ?>
										    <a class="btn btn-primary btn-sm" href="?islem=musteri_duzenle&Id=<?=$row["Id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
										    <a class="btn btn-danger btn-sm" href="?islem=musteri_sil&Id=<?=$row["Id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
											<?php } else { ?>
											<a class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Düzenle</a>
										    <a class="btn btn-danger btn-sm disabled"><i class="fa fa-trash-o"></i> Sil</a>
											<?php } ?>
										</td>
									 </tr>
									 
									 <?
									 $i++;
									 }
									 ?>
									 <?=($i == 1)?"<tr><td colspan='7'><b>Henüz bir müşteri eklenmemiş..</b></td></tr>":""?>
								  </tbody>
							   </table>
							</div>
						 </div>
					  </div>
				   </div>
				</div>
						<?
						break;
						case "musteri_ekle":
						yetkiKontrol("0");
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Yeni Müşteri Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yenimusteriekle" id="validation-form" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">İsim</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="isim" id="isim" placeholder="İsim giriniz" class="form-control" data-rule-required="true">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kullanıcı Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="kadi" id="kadi" placeholder="Kullanıcı Adı giriniz" class="form-control" data-rule-required="true" data-rule-minlength="3">
								   </div>
								</div>
								<div class="form-group">
								   <label for="sifre" class="col-sm-3 col-lg-2 control-label">Şifre</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="sifre" id="sifre" placeholder="Şifre giriniz" class="form-control" data-rule-required="true" data-rule-minlength="4">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Müşteriye ait İş</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <ul class="personeller_btns">
										<li>Müşteriye ait iş'i seçiniz..</li>
										<div class="clear"></div>
									  </ul>
									  <br /><p><b>İş Ekle</b></p>
									  <select class="form-control set_is">
										<option value="-1" selected disabled>İş Seç</option>
										<?php
											$isler = tabloCek("jobs", "id, is_adi", "ORDER BY id DESC");
											
											foreach( $isler as $is )
											{
												echo "<option value='{$is["id"]}'>{$is["is_adi"]}</option>";
											}
										?>
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
						case "musteri_duzenle":
						yetkiKontrol("0");
						$musteri = veriCek("musteri", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Müşteri Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=musteribilgiguncelle" id="validation-form" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="id" value="<?=$_GET["Id"]?>" />
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">İsim</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="isim" id="isim" value="<?=$musteri["isim"]?>" placeholder="İsim giriniz" class="form-control" data-rule-required="true">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kullanıcı Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="kadi" id="kadi" value="<?=$musteri["kadi"]?>" placeholder="Kullanıcı Adı giriniz" class="form-control" data-rule-required="true" data-rule-minlength="3">
								   </div>
								</div>
								<div class="form-group">
								   <label for="sifre" class="col-sm-3 col-lg-2 control-label">Şifre</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="sifre" id="sifre" value="<?=$musteri["sifre"]?>" placeholder="Şifre giriniz" class="form-control" data-rule-required="true" data-rule-minlength="4">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Müşteriye ait İş</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <ul class="personeller_btns">
										<?php
											if(!empty($musteri["is_id"]))
											{
												$control = strpos($musteri["is_id"], "-");
												if($control == true)
												{
													$gorevliler = explode("-", $musteri["is_id"]);
													foreach( $gorevliler as $gorevli )
													{
														$gorevliBilgisi = veriCek("jobs ", "is_adi, id", "id", $gorevli);
														echo "<li id='is_{$gorevliBilgisi["id"]}'>{$gorevliBilgisi["is_adi"]} <input type='hidden' name='isler[]' value='{$gorevliBilgisi["id"]}' /> <i class='fa fa-times isDel' aria-hidden='true'></i></li>";
													}
												} else {
													$gorevliBilgisi = veriCek("jobs ", "is_adi, id", "id", $musteri["is_id"]);
													echo "<li id='is_{$gorevliBilgisi["id"]}'>{$gorevliBilgisi["is_adi"]} <input type='hidden' name='isler[]' value='{$gorevliBilgisi["id"]}' /> <i class='fa fa-times isDel' aria-hidden='true'></i></li>";
												}
											} else {
												echo "<li>Seçilmiş bir iş bulunamadı..</li>";
											}
										?>
										<div class="clear"></div>
									  </ul>
									  <br /><p><b>İş Ekle</b></p>
									  <select class="form-control set_is">
										<option value="-1" selected disabled>İş Seç</option>
										<?php
											$isler = tabloCek("jobs", "id, is_adi", "ORDER BY id DESC");
											
											foreach( $isler as $is )
											{
												echo "<option value='{$is["id"]}'>{$is["is_adi"]}</option>";
											}
										?>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Güncelle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=musteri_listesi';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
							<?
						break;
						case "musteri_sil":
						yetkiKontrol("0");
						if(ctype_digit($_GET["Id"]))
						{
							$eskiVeri = veriCek("musteri", "isim", "id", $_GET["Id"]);
							veriSil("musteri", "id", $_GET["Id"]);
							islemKaydi("Müşteri Listesi", "<b>{$eskiVeri["isim"]}</b>, adlı müşteriyi sildi.");
						}
						git("?islem=musteri_listesi");
						break;
						case "duzenle":
						yetkiKontrol("0");
						if(!ctype_digit($_GET["Id"]))
							$_GET["Id"] = 0;
						
						$row = veriCek("personel", "*", "Id", $_GET["Id"]);
						if( !$row ){
							git("?islem=liste");
							die();
						}
						$veri = veriCek("personel", "*", "Id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Personel Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=duzenlepost&Id=<?=$veri["Id"];?>" id="validation-form" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="avatar" class="col-sm-3 col-lg-2 control-label">Avatar</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <img id="avtimg" src="img/demo/avatar/<?=$veri["avatar"];?>" alt="" />
									  <br /><br />
									  <select name="avatar" id="avatar" class="form-control">
										<option <?=($veri["avatar"]=="avatar1.jpg")?"selected":""?> value="avatar1.jpg">Avatar 1</option>
										<option <?=($veri["avatar"]=="avatar2.jpg")?"selected":""?> value="avatar2.jpg">Avatar 2</option>
										<option <?=($veri["avatar"]=="avatar3.jpg")?"selected":""?> value="avatar3.jpg">Avatar 3</option>
										<option <?=($veri["avatar"]=="avatar4.jpg")?"selected":""?> value="avatar4.jpg">Avatar 4</option>
										<option <?=($veri["avatar"]=="avatar5.jpg")?"selected":""?> value="avatar5.jpg">Avatar 5</option>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">İsim</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="isim" id="isim" value="<?=$veri["isim"];?>" placeholder="İsim giriniz" class="form-control" data-rule-required="true">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kullanıcı Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="kadi" id="kadi" value="<?=$veri["kadi"];?>" placeholder="Bölüm giriniz" class="form-control" data-rule-required="true" data-rule-minlength="3">
								   </div>
								</div>
								<div class="form-group">
								   <label for="sifre" class="col-sm-3 col-lg-2 control-label">Şifre</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="sifre" id="sifre" value="<?=$veri["sifre"];?>" placeholder="Plaka giriniz" class="form-control" data-rule-required="true" data-rule-minlength="4">
								   </div>
								</div>
								<div class="form-group">
								   <label for="yetki" class="col-sm-3 col-lg-2 control-label">Yetki</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="yetki" id="yetki" class="form-control">
										<option value="0" <?=($veri["yetki"]=="0")?"selected":""?>>Yönetici</option>
										<option value="4" <?=($veri["yetki"]=="4")?"selected":""?>>Genel Kordinatör</option>
										<option value="1" <?=($veri["yetki"]=="1")?"selected":""?>>Sekreter</option>
										<option value="2" <?=($veri["yetki"]=="2")?"selected":""?>>Eleman</option>
										<option value="3" <?=($veri["yetki"]=="3")?"selected":""?>>Stajyer</option>
									  </select>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Düzenle</button>
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
						case "liste":
							?>
				<div class="row">
				   <div class="col-md-12">
					  <div class="box">
						 <div class="box-title">
							<h3><i class="fa fa-table"></i> Personel Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
							<?=(yetkiKontrolGizle("0"))?'<button type="button" class="btn btn-primary" onclick="javascript:location.href=\'?islem=ekle\';"><i class="fa fa-check"></i> Yeni Personel Ekle</button>
							<br /><br />':''?>
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th>#</th>
										<th>Avatar</th>
										<th>İsim</th>
										<th>Kullanıcı Adı</th>
										<th>Şifre</th>
										<th>Yetki</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $veri = tabloCek("personel", "*", "ORDER BY yetki,isim");
									 $i=1;
									 foreach( $veri as $row ) {
									 ?>
									 <tr>
										<td style="width: 2%;"><?=$i;?></td>
										<td style="width: 5%;"><img src="img/demo/avatar/<?=$row["avatar"];?>" alt="" /></td>
										<td><?=$row["isim"];?></td>
										<td><?=($row["yetki"] == 0 && !yetkiKontrolGizle("0"))?'***':$row["kadi"];?></td>
										<td><?=(yetkiKontrolGizle("0"))?$row["sifre"]:"***"?></td>
										<td>
											<?php
												switch($row["yetki"])
												{
													case 0: echo "Yönetici"; break;
													case 1: echo "Sekreter"; break;
													case 2: echo "Eleman"; break;
													case 3: echo "Stajyer"; break;
													case 4: echo "Genel Kordinatör"; break;
												}
											?>
										</td>
										<td>
											<?php if(yetkiKontrolGizle("0")) { ?>
										    <a class="btn btn-primary btn-sm" href="?islem=duzenle&Id=<?=$row["Id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
										    <a class="btn btn-danger btn-sm" href="?islem=sil&Id=<?=$row["Id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
											<?php } else { ?>
											<a class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Düzenle</a>
										    <a class="btn btn-danger btn-sm disabled"><i class="fa fa-trash-o"></i> Sil</a>
											<?php } ?>
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
						case "sil":
						if(ctype_digit($_GET["Id"]) && $GLOBALS["user"]["Id"] != $_GET["Id"]){
							$eskiveri = veriCek("personel", "*", "Id", $_GET["Id"]);
							veriSil("personel", "Id", $_GET["Id"]);
							islemKaydi("Personel Silme", "sistemde ki personeli sildi. ({$eskiveri["isim"]}, kullanıcı adı : {$eskiveri["kadi"]})");	
						}
						git("?islem=liste");
						break;
						default:
							git("?islem=liste");
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
				$('.mn-personel').addClass('active');
				$('.mn-personel-<?=$_GET["islem"]?>').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
				
				$("*").on('click', '.isDel', function() {
					var sonuc = confirm("Seçilen işi kaldırmak istediğinize emin misiniz?");
					
					if(sonuc)
					{
						var cur = $(this).parent().find("input").val();
						$("#is_"+cur).remove();
					} else {
						return false;
					}
				});
				
				$(".set_is").change(function(){
					var getId = $(this).val();
					var getName = $(".set_is option[value='"+getId+"']").text();
					
					if($("#is_" + getId).is("li"))
						alert("Seçilen iş zaten mevcut..");
					else {
						$(".personeller_btns").prepend("<li id='is_"+getId+"'>"+getName+" <input type='hidden' name='isler[]' value='"+getId+"' /> <i class='fa fa-times isDel' aria-hidden='true'></i></li>");
					}
				});
			});
		</script>
	</body>
</html>