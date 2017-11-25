<?
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	$baslik = "İş Yönetimi";
	$isError = false;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(!$_SESSION["user"]["musteri"]) {
			yetkiKontrol("0,4");
			
			// İş Bölümü
			if($_GET["islem"] == "yeniisekle"){
				$one = 1;
				$gorevliler		=		$_POST["gorevliler"];
				
				if($gorevliler)
				{
					$oneTotal		=		count($gorevliler);
					foreach( $gorevliler as $gorevli )
					{
						if($one == 1)
							$iseAitGorevliler .= $gorevli;
						else
							$iseAitGorevliler .= "-".$gorevli;
						
						$one = 0;
					}
				}
				
				$is_firma			=		$_POST["is_firma"];
				$is_ad				=		$_POST["is_ad"];
				$is_tarih			=		dateTimeConvertTR($_POST["is_tarih"]);
				$durum			=		$_POST["durum"];
				$is_not				=		$_POST["is_not"];
				$is_sahibi			=		$_POST["is_sahibi"];
				$is_sahibiNot	=		$_POST["is_sahibi_not"];
				
				if( veriEkle(array("is_adi", "is_olusturma_tarihi", "is_gorevliler", "is_firma", "is_durum", "is_not", "is_sahibiBilgi", "is_sahibiNot"), array($is_ad, $is_tarih, $iseAitGorevliler, $is_firma, $durum, $is_not, $is_sahibi, $is_sahibiNot), "jobs") )
				{
					islemKaydi("İş Yönetimi > İş/Proje Ekle", "{$is_ad}, adlı proje ekledi..");
					git("?islem=liste");
				} else {
					git("?islem=liste");
				}
			}
			
			if($_GET["islem"] == "isguncelle") {
				$one = 1;
				$gorevliler		=		$_POST["gorevliler"];
				
				if($gorevliler)
				{
					$oneTotal		=		count($gorevliler);
					foreach( $gorevliler as $gorevli )
					{
						if($one == 1)
							$iseAitGorevliler .= $gorevli;
						else
							$iseAitGorevliler .= "-".$gorevli;
						
						$one = 0;
					}
				}
				
				$is_id				=		$_POST["is_id"];
				$is_firma			=		$_POST["is_firma"];
				$is_ad				=		$_POST["is_ad"];
				$is_tarih			=		$_POST["is_tarih"];
				$durum			=		$_POST["durum"];
				$is_not				=		$_POST["is_not"];
				$is_sahibi			=		$_POST["is_sahibi"];
				$is_sahibiNot	=		$_POST["is_sahibi_not"];
				
				$sutun				=		array("is_adi", "is_gorevliler", "is_firma", "is_durum", "is_not", "is_sahibiBilgi", "is_sahibiNot");
				$veri					=		array($is_ad, $iseAitGorevliler, $is_firma, $durum, $is_not, $is_sahibi, $is_sahibiNot);
				
				if( !empty($is_tarih) )
				{
					array_push($sutun, "is_olusturma_tarihi");
					array_push($veri, dateTimeConvertTR($is_tarih));
				}
				
				if( veriGuncelle($sutun, $veri, "jobs", "id", $is_id) )
				{
					islemKaydi("İş Yönetimi > İş/Proje Düzenle", "{$is_ad}, adlı işi/projeyi düzenledi..");
					git("?islem=duzenle&Id=".$is_id);
				} else {
					git("?islem=liste");
				}
			}
		} else {
			/* Müşteri */
			if($_GET["islem"] == "yenitalepgonder") {
				$is_id						=		$_POST["is_id"];
				$is_adi						=		$_POST["is_adi"];
				$talep_turu				=		$_POST["talep_turu"];
				$talep_aciklamasi		=		$_POST["talep_aciklamasi"];
				
				switch($talep_turu)
				{
					case 0: $eTuru = "İstek / Değişiklik"; break;
					case 1: $eTuru = "Hata / Düzenleme"; break;
					default: $eTuru = "Error Code : 104"; break;
				}
				
				if(!empty($talep_aciklamasi))
				{
					if(veriEkle(array("musteri_id", "is_id", "talep_turu", "talep", "tarih"), array($_SESSION["user"]["Id"], $is_id, $talep_turu, $talep_aciklamasi, date("Y-m-d H:i:s")), "musteri_talep"))
					{
						islemKaydi("{$is_adi} | Talepte Bulun", "(Müşteri) bir talepte bulundu. Talep Türü : {$eTuru}");
						git("?islem=taleptebulun&Id={$is_id}&debug=1&type=success&msg=Talebiniz iletilmiştir..");
					} else
						git("?islem=taleptebulun&Id={$is_id}&debug=1&type=danger&msg=Bir problem oluştu.. Lütfen daha sonra tekrar deneyiniz.");
				} else {
					git("?islem=taleptebulun&Id={$is_id}&debug=1&type=danger&msg=Lütfen açıklama bölümünü doldurunuz..");
				}
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
						case "liste":
				?>
			    <div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> İş Listesi</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<?=(yetkiKontrolGizle("0"))?'<button type="button" class="btn btn-primary" onclick="javascript:location.href=\'?islem=ekle\';"><i class="fa fa-check"></i> Yeni İş Ekle</button> <br /><br />':''?>
							<?php
								if(!$_SESSION["user"]["musteri"]) {
							?>
							<p><b>Firma</b></p>
							<select name="is_firma" class="form-control">
								<option value="0" selected>Tümünü Listele</option>
								<?php
									$firmalar = tabloCek("firma", "*", "ORDER BY id ASC");
									
									foreach( $firmalar as $firma )
									{
										if($firma["durum"] == 1)
										{
											if($_GET["firma"] == $firma["id"])
												echo "<option value='{$firma["id"]}' selected>{$firma["firma_ad"]}</option>";
											else
												echo "<option value='{$firma["id"]}'>{$firma["firma_ad"]}</option>";
										}
										else
											echo "<option value='{$firma["id"]}' disabled>{$firma["firma_ad"]}</option>";
									}
								?>
							</select>
							<p><b>Filtrele</b></p>
							<select name="is_filter" class="form-control">
								<option value="1" selected>Sıralama Türü Seç</option>
								<option value="0" <?=($_GET["filtre"] == "0")?"selected":""?>>Devam Eden</option>
								<option value="5" <?=($_GET["filtre"] == "5")?"selected":""?>>Tamamlanan</option>
							</select>
							<?php } ?>
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th>Firma</th>
										<th>İş/Proje Adı</th>
										<th>Görevli Kişi/ler</th>
										<th>Oluşturulma Tarihi</th>
										<th>İş/Proje Durumu</th>
										<th <?=($_SESSION["user"]["musteri"])?'style="width: 250px"':'style="width: 300px"'?>>İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $type = "AND";
									 $filtre = "";
									 
									 if($_GET["filtre"] == "5")
										$filtre = "WHERE is_durum = '5'";
									else if($_GET["filtre"] == "0")
										$filtre = "WHERE is_durum <>5";
									else if($_GET["filtre"] == "1")
										$type = "WHERE";
									else
										$type = "WHERE";
									
									if(isset($_GET["firma"]))
									{
										if($_GET["firma"] != 0)
											$firma = "{$type} is_firma = '{$_GET["firma"]}'";
										else
											$firma = "";
									}
									
									if($_SESSION["user"]["musteri"])
									{
										$one = 1;
										$control = strpos($_SESSION["user"]["is_id"], "-");
										if($control == true)
										{
											$gorevliler = explode("-", $_SESSION["user"]["is_id"]);
											foreach( $gorevliler as $gorevli )
											{
												if($one == 1)
													$belirle .= "WHERE id = {$gorevli}";
												else
													$belirle .= " OR id = '{$gorevli}'";
												
												$one = 0;
											}
										} else {
											$belirle .= "WHERE id = {$_SESSION["user"]["is_id"]}";
										}
										
										$veri = tabloCek("jobs", "*", "{$belirle} ORDER BY id ASC");
									}
									else
										$veri = tabloCek("jobs", "*", "{$filtre} {$firma} ORDER BY id ASC");
									
									 $i = 1;
									 foreach( $veri as $row ) {
										 $firma = veriCek("firma", "firma_ad", "id", $row["is_firma"]);
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><?=$firma["firma_ad"];?></td>
											<td><?=$row["is_adi"];?></td>
											<td><?=gorevliIsle($row["is_gorevliler"]);?></td>
											<td><?=tarih($row["is_olusturma_tarihi"]);?></td>
											<td><?=durumIsle($row["is_durum"]);?></td>
											<td>
												<?=($_SESSION["user"]["musteri"])?'<a class="btn btn-primary btn-sm" href="?islem=taleptebulun&Id='.$row["id"].'"><i class="fa fa-edit"></i> Talepte Bulun</a>':''?>
												<a class="btn btn-primary btn-sm" href="?islem=sonIslemler&Id=<?=$row["id"];?>"><i class="fa fa-edit"></i> Son İşlemler</a>
												<?php if(yetkiKontrolGizle("0")) { ?>
												<a class="btn btn-primary btn-sm" href="?islem=duzenle&Id=<?=$row["id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
												<a class="btn btn-danger btn-sm" href="?islem=sil&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
												<?php } else if(yetkiKontrolGizle("4")) { ?>
												<a class="btn btn-primary btn-sm" href="?islem=duzenle&Id=<?=$row["id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
												<a class="btn btn-danger btn-sm disabled"><i class="fa fa-trash-o"></i> Sil</a>
												<?php } else if(!$_SESSION["user"]["musteri"]) { ?>
												<a class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Düzenle</a>
												<a class="btn btn-danger btn-sm disabled"><i class="fa fa-trash-o"></i> Sil</a>
												<?php } ?>
											</td>
										 </tr>
									 <?
										$i++;
									 }
									 ?>
									 <?=($i == 1)?"<tr><td colspan='7'><b>Aranan kriterlere göre bir sonuç bulunamadı...</b></td></tr>":""?>
								  </tbody>
							   </table>
							</div>
						 </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "sonIslemler":
							$isKontrol = veriCek("jobs", "id", "id", $_GET["Id"]);
							
							if(!$isKontrol)
								git("?islem=liste");
						?>
				<div class="row">
					<div class="col-md-12">
						<div class="tabbable clearfix">
							<ul id="myTab1" class="nav nav-tabs">
								<li class="active"><a href="#proje-timeline" data-toggle="tab"><i class="fa fa-calendar"></i><span class="tablabel big"> Zaman Çizelgesi</span></a></li>
								<li class=""><a href="#proje-bilgileri" data-toggle="tab"><i class="fa fa-eye"></i><span class="tablabel big"> Proje Bilgileri</span></a></li>
							</ul>
							<div id="projeDetaylariTab" class="tab-content" style="background-color: #fff;">
								<div class="tab-pane fade active in" id="proje-timeline">
									<ul class="timeline">
										<?php
										$lastAcitivity = tabloCek("tasks_performed", "*", "WHERE is_no = '{$_GET["Id"]}' ORDER BY id DESC");
										$oldUser = array("id" => "", "ad" => "");
										
										foreach( $lastAcitivity as $row )
										{
											if($oldUser["id"] != $row["is_personel"])
											{
												$getUser = veriCek("personel", "Id, isim", "Id", $row["is_personel"]);
												$oldUser["id"] = $getUser["Id"];
												$oldUser["ad"] = $getUser["isim"];
											}
										?>
										<li>
											<span class="tl-icon"><i class="fa fa-quote-right" aria-hidden="true"></i></span>
											<span class="tl-time"><?=tarih($row["is_tarih"]);?></span>
											<span class="tl-title"><?=durumIsleV2($row["is_durum"]);?><span class="badge badge-info"><?=$oldUser["ad"];?></span></span>
											<div class="tl-content">
												<p><?=$row["is_not"];?></p>
											</div>
										</li>
										<?php
										}
										?>
										<li class="clearfix"></li>
									</ul>
								</div>
								<?php $job = veriCek("jobs", "*", "id", $_GET["Id"]); $firma = veriCek("firma", "firma_ad", "id", $job["is_firma"]); ?>
								<div class="tab-pane fade" id="proje-bilgileri">
									<table class="table table-condensed">
										<tbody>
											<tr>
												<th class="e-d-c-proje-bilgi padding-10px" style="border-top:none;">Firma</th><td class="padding-10px" style="border-top:none;"> : <?=$firma["firma_ad"];?></td>
											</tr>
											<tr>
												<th class="e-d-c-proje-bilgi padding-10px">İş/Proje Adı</th><td class="padding-10px"> : <?=$job["is_adi"];?></td>
											</tr>
											<tr>
												<th class="e-d-c-proje-bilgi padding-10px">İş Sahibi</th><td class="padding-10px"> : <textarea class="form-control pb-fixed" cols="5" rows="5"><?=$job["is_sahibiBilgi"];?></textarea></td>
											</tr>
											<tr>
												<th class="e-d-c-proje-bilgi padding-10px">İş Sahibi Notu</th><td class="padding-10px"> : <textarea class="form-control pb-fixed" cols="5" rows="5"><?=$job["is_sahibiNot"];?></textarea></td>
											</tr>
											<tr>
												<th class="e-d-c-proje-bilgi padding-10px">Oluşturulma Tarihi</th><td class="padding-10px"> : <?=tarih($job["is_olusturma_tarihi"]);?></td>
											</tr>
											<tr>
												<th class="e-d-c-proje-bilgi padding-10px">Görevli Kişiler</th><td class="padding-10px"> : <?=gorevliIsle($job["is_gorevliler"]);?></td>
											</tr>
											<tr>
												<th class="e-d-c-proje-bilgi padding-10px">İş/Proje Durumu</th><td class="padding-10px"> : <?=durumIsle($job["is_durum"]);?></td>
											</tr>
											<tr>
												<th class="e-d-c-proje-bilgi padding-10px">Not</th><td class="padding-10px"> : <textarea class="form-control pb-fixed" cols="5" rows="5"><?=$job["is_not"];?></textarea></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
						<?
						break;
						case "sonAktiviteler":
						yetkiKontrol("0,1,2,3,4");
						?>
				<div class="row">
					<div class="col-md-12">
						<div class="tabbable clearfix">
							<ul id="myTab1" class="nav nav-tabs">
								<li class="active"><a href="#proje-timeline" data-toggle="tab"><i class="fa fa-calendar"></i><span class="tablabel big"> Zaman Çizelgesi</span></a></li>
							</ul>
							<div id="projeDetaylariTab" class="tab-content" style="background-color: #fff;">
								<div class="tab-pane fade active in" id="proje-timeline">
									<ul class="timeline">
										<?php
										$lastAcitivity = tabloCek("tasks_performed", "*", "ORDER BY id DESC LIMIT 25");
										$oldUser = array("id" => "", "ad" => "");
										$oldJob = array("id" => "", "ad" => "");
										
										foreach( $lastAcitivity as $row )
										{
											if($oldUser["id"] != $row["is_personel"])
											{
												$getUser = veriCek("personel", "Id, isim", "Id", $row["is_personel"]);
												$oldUser["id"] = $getUser["Id"];
												$oldUser["ad"] = $getUser["isim"];
											}
											
											if($oldJob["id"] != $row["is_no"])
											{
												$getJob = veriCek("jobs", "id, is_adi", "id", $row["is_no"]);
												$oldJob["id"] = $getJob["id"];
												$oldJob["ad"] = $getJob["is_adi"];
											}
										?>
										<li>
											<span class="tl-icon"><i class="fa fa-quote-right" aria-hidden="true"></i></span>
											<span class="tl-time"><?=tarih($row["is_tarih"]);?></span>
											<span class="tl-title"><a title="Ayrıntılı İncele" href="?islem=sonIslemler&Id=<?=$oldJob["id"];?>"><?=$oldJob["ad"];?></a> - <?=durumIsleV2($row["is_durum"]);?><span class="badge badge-info"><?=$oldUser["ad"];?></span></span>
											<div class="tl-content">
												<p><?=$row["is_not"];?></p>
											</div>
										</li>
										<?php
										}
										?>
										<li class="clearfix"></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
						<?
						break;
						case "ekle":
						yetkiKontrol("0,2");
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> İş/Proje Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yeniisekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Firma</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="is_firma" class="form-control">
										<?php
											$firmalar = tabloCek("firma", "*", "ORDER BY id ASC");
											
											foreach( $firmalar as $firma )
											{
												if($firma["durum"] == 1)
													echo "<option value='{$firma["id"]}'>{$firma["firma_ad"]}</option>";
												else
													echo "<option value='{$firma["id"]}' disabled>{$firma["firma_ad"]}</option>";
											}
										?>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İş/Proje Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="is_ad" placeholder="İşin/Projenin Adı" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İş Sahibinin Bilgileri</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="is_sahibi" class="form-control" placeholder="İş sahibinin ad soyadı ve iletişim numarası.." cols="5" rows="5"></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İş Sahibinin Notu</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="is_sahibi_not" class="form-control" cols="5" rows="5"></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Oluşturulma Tarihi</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <div class="input-group date datetimepicker">
										<input name="is_tarih" type='text' class="form-control" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									 </div>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Görevli Kişiler</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <ul class="personeller_btns">
										<li>Bu proje üzerinde çalışacak görevli personelleri seçiniz..</li>
										<div class="clear"></div>
									  </ul>
									  <br /><p><b>Personel Ekle</b></p>
									  <select class="form-control set_personeller">
										<option value="-1" selected disabled>Personel Seç</option>
										<?php
											$personeller = tabloCek("personel", "Id, isim", "ORDER BY Id ASC");
											
											foreach( $personeller as $personel )
											{
												echo "<option value='{$personel["Id"]}'>{$personel["isim"]}</option>";
											}
										?>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="durum" class="form-control">
										<option value="0" <?=($veri["is_durum"] == 0)?"selected":""?>>Havuz</option>
										<option value="1" <?=($veri["is_durum"] == 1)?"selected":""?>>Yapılacak / Beklemede</option>
										<option value="2" <?=($veri["is_durum"] == 2)?"selected":""?>>Yapım Aşamasında</option>
										<option value="3" <?=($veri["is_durum"] == 3)?"selected":""?>>Tasarım Onay Bekliyor</option>
										<option value="4" <?=($veri["is_durum"] == 4)?"selected":""?>>Yayın Onayı Bekliyor</option>
										<option value="5" <?=($veri["is_durum"] == 5)?"selected":""?>>Tamamlandı</option>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Not</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="is_not" class="form-control" cols="5" rows="5"></textarea>
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
						case "duzenle":
						yetkiKontrol("0,4");
						$veri = veriCek("jobs", "*", "id", $_GET["Id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> İş/Proje Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=isguncelle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="is_id" value="<?=$veri["id"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Firma</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="is_firma" class="form-control">
										<?php
											$firmalar = tabloCek("firma", "*", "ORDER BY id ASC");
											
											foreach( $firmalar as $firma )
											{
												if($veri["is_firma"] == $firma["id"])
													echo "<option value='{$firma["id"]}' selected>{$firma["firma_ad"]}</option>";
												else
													echo "<option value='{$firma["id"]}'>{$firma["firma_ad"]}</option>";
											}
										?>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İş/Proje Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="is_ad" placeholder="İşin/Projenin Adı" value="<?=$veri["is_adi"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İş Sahibinin Bilgileri</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="is_sahibi" class="form-control" placeholder="İş sahibinin ad soyadı ve iletişim numarası.." cols="5" rows="5"><?=$veri["is_sahibiBilgi"];?></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İş Sahibinin Notu</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="is_sahibi_not" class="form-control" cols="5" rows="5"><?=$veri["is_sahibiNot"];?></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Oluşturulma Tarihi</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <div class="input-group date datetimepicker">
										<input name="is_tarih" type='text' placeholder="<?=tarih($veri["is_olusturma_tarihi"]);?>" class="form-control" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									 </div>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Görevli Kişiler</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <ul class="personeller_btns">
										<?php
											if(!empty($veri["is_gorevliler"]))
											{
												$control = strpos($veri["is_gorevliler"], "-");
												if($control == true)
												{
													$gorevliler = explode("-", $veri["is_gorevliler"]);
													foreach( $gorevliler as $gorevli )
													{
														$gorevliBilgisi = veriCek("personel ", "isim, Id", "Id", $gorevli);
														echo "<li id='personel_{$gorevliBilgisi["Id"]}'>{$gorevliBilgisi["isim"]} <input type='hidden' name='gorevliler[]' value='{$gorevliBilgisi["Id"]}' /> <i class='fa fa-times userDel' aria-hidden='true'></i></li>";
													}
												} else {
													$gorevliBilgisi = veriCek("personel ", "isim, Id", "Id", $veri["is_gorevliler"]);
													echo "<li id='personel_{$gorevliBilgisi["Id"]}'>{$gorevliBilgisi["isim"]} <input type='hidden' name='gorevliler[]' value='{$gorevliBilgisi["Id"]}' /> <i class='fa fa-times userDel' aria-hidden='true'></i></li>";
												}
											} else {
												echo "<li>Görevli bir personel bulunamadı..</li>";
											}
										?>
										<div class="clear"></div>
									  </ul>
									  <br /><p><b>Personel Ekle</b></p>
									  <select class="form-control set_personeller">
										<option value="-1" selected disabled>Personel Seç</option>
										<?php
											$personeller = tabloCek("personel", "Id, isim", "ORDER BY Id ASC");
											
											foreach( $personeller as $personel )
											{
												echo "<option value='{$personel["Id"]}'>{$personel["isim"]}</option>";
											}
										?>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="durum" class="form-control">
										<option value="0" <?=($veri["is_durum"] == 0)?"selected":""?>>Havuz</option>
										<option value="1" <?=($veri["is_durum"] == 1)?"selected":""?>>Yapılacak / Beklemede</option>
										<option value="2" <?=($veri["is_durum"] == 2)?"selected":""?>>Yapım Aşamasında</option>
										<option value="3" <?=($veri["is_durum"] == 3)?"selected":""?>>Tasarım Onay Bekliyor</option>
										<option value="4" <?=($veri["is_durum"] == 4)?"selected":""?>>Yayın Onayı Bekliyor</option>
										<option value="5" <?=($veri["is_durum"] == 5)?"selected":""?>>Tamamlandı</option>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Not</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="is_not" class="form-control" cols="5" rows="5"><?=$veri["is_not"];?></textarea>
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
						case "sil":
						yetkiKontrol("0");
						if( ctype_digit($_GET["Id"]) ) {
							$eskiveri = veriCek("jobs", "is_adi", "id", $_GET["Id"]);
							
							veriSil("tasks_performed", "is_no", $_GET["Id"]);
							veriSil("jobs", "id", $_GET["Id"]);
							islemKaydi("İş Yönetimi > İş/Proje Listesi", "bir iş sildi. ({$eskiveri["is_adi"]})");
						}
						git("?islem=liste");
						break;
						case "taleptebulun":
						if(!$_SESSION["user"]["musteri"])
							yetkiKontrol("müşteriharicigiremez");
						$veri = veriCek("jobs", "*", "id", $_GET["Id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> <?=$veri["is_adi"]?> | Talepte Bulun </h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <?=($_GET["debug"]==1)?'<div class="alert alert-'.$_GET["type"].'" role="alert"> <strong>'.$_GET["msg"].'</strong></div>':''?>
							 <form action="?islem=yenitalepgonder" id="validation-form" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="is_id" value="<?=$veri["id"]?>" />
								<input type="hidden" name="is_adi" value="<?=$veri["is_adi"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Talep Türü</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="talep_turu" class="form-control">
										<option value="0" selected>İstek / Değişiklik</option>
										<option value="1">Hata / Düzenleme</option>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Talep Açıklaması</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="talep_aciklamasi" class="form-control" cols="5" rows="5"></textarea>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Gönder</button>
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
						case "talepler":
						
						if(!$_SESSION["user"]["musteri"])
							yetkiKontrol("müşteri harici giremez");
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Düzenleme için Talepleriniz</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th>İş Adı</th>
										<th>Talep Tarihi</th>
										<th>Talep Durumu</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									$veri = tabloCek("musteri_talep", "*", "WHERE musteri_id = '{$_SESSION["user"]["Id"]}' ORDER BY id DESC");
									
									 $i = 1;
									 foreach( $veri as $row ) {
										 $getIs = veriCek("jobs", "is_adi", "id", $row["is_id"]);
										 
										 if($row["readly_to"] == 1)
										 {
											 veriGuncelle(array("readly_to"), array("0"), "musteri_talep", "id", $row["id"]);
										 }
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><?=$getIs["is_adi"];?></td>
											<td><?=tarih($row["tarih"]);?></td>
											<td><?=musteriDurumIsle($row["talep_durumu"]);?></td>
											<td>
												<a class="btn btn-primary btn-sm" href="?islem=mSonuc&Id=<?=$row["id"];?>"><i class="fa fa-edit"></i> Sonucu Görüntüle</a>
											</td>
										 </tr>
									 <?
										$i++;
									 }
									 ?>
									 <?=($i == 1)?"<tr><td colspan='7'><b>Aranan kriterlere göre bir sonuç bulunamadı...</b></td></tr>":""?>
								  </tbody>
							   </table>
							</div>
						 </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "mSonuc":
						if(!$_SESSION["user"]["musteri"])
							yetkiKontrol("müşteri harici giremez");
						
						$getTalep = veriCek("musteri_talep", "*", "id", $_GET["Id"]);
						$getIs = veriCek("jobs", "is_adi", "id", $getTalep["is_id"]);
						
						if(empty($getTalep["talep_cevaplayan"]))
							$cevaplayan = "Henüz bir dönüş yapılmadı.";
						else
						{
							$getPersonel = veriCek("personel", "isim", "Id", $getTalep["talep_cevaplayan"]);
							$cevaplayan = $getPersonel["isim"];
						}
				?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Talep Durumu</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<table class="table table-striped table-hover fill-head">
								<tr> <td><b>İş Adı</b></td> <td>:</td> <td><?=$getIs["is_adi"];?></td> </tr>
								<tr> <td><b>İstek / Talep</b></td> <td>:</td> <td><?=$getTalep["talep"];?></td> </tr>
								<tr> <td><b>Talep Tarihi</b></td> <td>:</td> <td><?=tarih($getTalep["tarih"]);?></td> </tr>
								<tr> <td style="width: 150px;"><b>Talep Durumu</b></td> <td style="width: 15px;">:</td> <td><?=musteriDurumIsle($getTalep["talep_durumu"]);?></td>
								<tr> <td><b>Cevaplayan</b></td> <td>:</td> <td><?=$cevaplayan;?></td> </tr>
								<tr> <td><b>Cevap</b></td> <td>:</td> <td><?=$getTalep["talep_cevap"];?></td> </tr>
								</tr>
							</table>
						 </div>
					   </div>
					</div>
				</div>
				<?
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
				$('.mn-isler').addClass('active');
				$('.mn-isler-<?=$_GET["islem"]?>').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
				
				$("*").on('click', '.userDel', function() {
					var sonuc = confirm("Bu personeli görevden kaldırmak istediğinize emin misiniz?");
					
					if(sonuc)
					{
						var cur = $(this).parent().find("input").val();
						$("#personel_"+cur).remove();
					} else {
						return false;
					}
				});
				
				$(".set_personeller").change(function(){
					var getId = $(this).val();
					var getName = $(".set_personeller option[value='"+getId+"']").text();
					
					if($("#personel_" + getId).is("li"))
						alert("Bu personel zaten bu görevde mevcut..");
					else {
						$(".personeller_btns").prepend("<li id='personel_"+getId+"'>"+getName+" <input type='hidden' name='gorevliler[]' value='"+getId+"' /> <i class='fa fa-times userDel' aria-hidden='true'></i></li>");
					}
				});
				
				$("select[name=is_filter]").change(function(){
					var filtre = $(this).val();
					location.href = "?islem=liste&firma=<?=$_GET["firma"];?>&filtre=" + filtre;
				});
				
				$("select[name=is_firma]").change(function(){
					var firma = $(this).val();
					location.href = "?islem=liste&firma=" + firma + "&filtre=<?=$_GET["filtre"];?>";
				});
				
				$(".datetimepicker").datetimepicker({
                    locale: 'tr'
                });
			});
		</script>
		
	</body>
</html>