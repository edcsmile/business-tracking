<?
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	$baslik = "Personel İşlemleri";
	$isError = false;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		yetkiKontrol("0,1,2,3,4");
		
		// İş Gelişme Bölümü
		if($_GET["islem"] == "yenigelismeekle"){
			$is_adi						=		$_POST["is_adi"];			
			$is_id						=		$_POST["is_id"];
			$calisma_turu			=		$_POST["calisma_turu"];
			$calisma_aciklamasi	=		$_POST["calisma_aciklamasi"];
			
			if(empty($_POST["is_tarih"]))
				$is_tarih = date("Y-m-d H:i:s");
			else
				$is_tarih = dateTimeConvertTR($_POST["is_tarih"]);
			
			switch($calisma_turu)
			{
				case 0: $gTuru = "Düzenleme"; break;
				case 1: $gTuru = "Değişiklik"; break;
				case 2: $gTuru = "Güncelleme"; break;
				case 3: $gTuru = "Yapılacak / Beklemede"; break;
				case 4: $gTuru = "Yapım Aşamasında"; break;
			}
			
			if( veriEkle(array("is_no", "is_durum", "is_tarih", "is_not", "is_personel"), array($is_id, $calisma_turu, $is_tarih, $calisma_aciklamasi, $_SESSION["user"]["Id"]), "tasks_performed") )
			{
				islemKaydi("{$is_adi} | Gelişme Ekle", "bir gelişme ekledi. ({$gTuru})");
			}
			
			git("isler.php?islem=sonIslemler&Id=".$is_id);
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
						case "calismalar":
						?>
			    <div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Çalışmalarım</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
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
										<th style="width: 250px">İşlemler</th>
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
									
									$veri = tabloCek("jobs", "*", "{$filtre} {$firma} ORDER BY id ASC");
									
									 $i = 1;
									 foreach( $veri as $row ) {
										 $calisanlar = explode("-", $row["is_gorevliler"]);
										 $getFirma = veriCek("firma", "firma_ad", "id", $row["is_firma"]);
										 if(in_array($_SESSION["user"]["Id"], $calisanlar))
										 {
										 ?>
											 <tr>
												<td><?=$i;?></td>
												<td><?=$getFirma["firma_ad"];?></td>
												<td><?=$row["is_adi"];?></td>
												<td><?=gorevliIsle($row["is_gorevliler"]);?></td>
												<td><?=tarih($row["is_olusturma_tarihi"]);?></td>
												<td><?=durumIsle($row["is_durum"]);?></td>
												<td>
													<a <?=($row["is_durum"] != 5)?'class="btn btn-primary btn-sm" href="?islem=gelismeEkle&Id='.$row["id"].'"':'class="btn btn-primary btn-sm disabled"'?>><i class="fa fa-edit"></i> Gelişme Ekle</a>
													<a class="btn btn-primary btn-sm" href="isler.php?islem=sonIslemler&Id=<?=$row["id"];?>"><i class="fa fa-edit"></i> Son İşlemler</a>
												</td>
											 </tr>
										 <?
											$i++;
										 }
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
						case "gelismeEkle":
						$veri = veriCek("jobs", "*", "id", $_GET["Id"]);
						
						if($veri["is_durum"] == 5)
							git("?islem=calismalar");
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> <?=$veri["is_adi"]?> | Gelişme Ekle </h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yenigelismeekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="is_id" value="<?=$veri["id"]?>" />
								<input type="hidden" name="is_adi" value="<?=$veri["is_adi"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Gelişme Türü</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="calisma_turu" class="form-control">
										<option value="0" selected>Düzenleme</option>
										<option value="1">Değişiklik</option>
										<option value="2">Güncelleme</option>
										<option value="3">Yapılacak / Beklemede</option>
										<option value="4">Yapım Aşamasında</option>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Gelişme Türü</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="calisma_aciklamasi" class="form-control" cols="5" rows="5"></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Gelişme Tarihi</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <div class="input-group date datetimepicker">
										<input name="is_tarih" placeholder="Boş bırakılırsa mevcut tarihi otomatik belirler.." type='text' class="form-control" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									 </div>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=calismalar';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "sonaktivite":
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
										$lastAcitivity = tabloCek("tasks_performed", "*", "WHERE is_personel = {$_SESSION["user"]["Id"]} ORDER BY id DESC LIMIT 25");
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
											<span class="tl-title"><a title="Ayrıntılı İncele" href="isler.php?islem=sonIslemler&Id=<?=$oldJob["id"];?>"><?=$oldJob["ad"];?></a> - <?=durumIsleV2($row["is_durum"]);?><span class="badge badge-info"><?=$oldUser["ad"];?></span></span>
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
						default:
							git("?islem=calismalar");
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
				$('.mn-mepersonel').addClass('active');
				$('.mn-mepersonel-<?=$_GET["islem"]?>').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
				
				$("select[name=is_filter]").change(function(){
					var filtre = $(this).val();
					location.href = "?islem=calismalar&firma=<?=$_GET["firma"];?>&filtre=" + filtre;
				});
				
				$("select[name=is_firma]").change(function(){
					var firma = $(this).val();
					location.href = "?islem=calismalar&firma=" + firma + "&filtre=<?=$_GET["filtre"];?>";
				});
				
				$(".datetimepicker").datetimepicker({
                    locale: 'tr'
                });
			});
		</script>
		
	</body>
</html>