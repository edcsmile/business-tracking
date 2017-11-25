<?
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	$baslik = "Firma Yönetimi";
	$isError = false;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		yetkiKontrol("0,4");
		
		// Firma Bölümü
		if($_GET["islem"] == "yenifirmaekle"){
			$firma_ad		=		$_POST["firma_ad"];
			$firma_tarih	=		dateTimeConvertTR($_POST["firma_tarih"]);
			$durum		=		$_POST["durum"];
			
			if( veriEkle(array("firma_ad", "tarih", "durum"), array($firma_ad, $firma_tarih, $durum), "firma") )
			{
				islemKaydi("Firma Yönetimi | Ekle", "{$firma_ad}, adlı firma ekledi..");
				git("?islem=liste");
			} else {
				git("?islem=liste");
			}
		}
		
		if($_GET["islem"] == "firmaguncelle"){
			$firma_id		=		$_POST["firma_id"];
			$firma_ad		=		$_POST["firma_ad"];
			$durum		=		$_POST["durum"];
			
			$eskiVeri = veriCek("firma", "*", "id", $firma_id);
			if($eskiveri["durum"] == 1)
				$eskiDurum = "Aktif";
			else
				$eskiDurum = "Pasif";
			
			if($durum == 1)
				$yeniDurum = "Aktif";
			else
				$yeniDurum = "Pasif";
			
			$sutun	=	array("firma_ad", "durum");
			$cevap	=	array($firma_ad, $durum);
			
			if(!empty($_POST["firma_tarih"]))
			{
				$firma_tarih	=		dateTimeConvertTR($_POST["firma_tarih"]);
				
				array_push($sutun, "tarih");
				array_push($cevap, $firma_tarih);
			}
			
			if( veriGuncelle($sutun, $cevap, "firma", "id", $firma_id) )
			{
				islemKaydi("Genel Tanımlar", "{$firma_ad}, adlı şehiri düzenledi.. => Eski Adı : {$eskiVeri["firma_ad"]}, Eski Durum : {$eskiDurum}, Yeni Durum : {$yeniDurum}");
				git("?islem=duzenle&Id=".$firma_id);
			} else {
				git("?islem=liste");
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
						case "liste":
						?>
			    <div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Firma</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<?=(yetkiKontrolGizle("0,4"))?'<button type="button" class="btn btn-primary" onclick="javascript:location.href=\'?islem=ekle\';"><i class="fa fa-check"></i> Yeni Firma Ekle</button> <br /><br />':''?>
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th style="width: 10%;">Firma Adı</th>
										<th style="width: 15%;">Firma Durumu</th>
										<th>Toplam İş Sayısı</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									 $veri = tabloCek("firma", "*", "ORDER BY id ASC");
									 $i = 1;
									 foreach( $veri as $row ) {
										 $isSayisi = tabloCek("jobs", "id", "WHERE is_firma = {$row["id"]}");
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><?=$row["firma_ad"];?></td>
											<td><?=($row["durum"] == 1)?"Aktif":"Pasif"?></td>
											<td><a href="isler.php?islem=liste&firma=<?=$row["id"];?>&filtre=1"><?=$isSayisi->rowCount();?></a></td>
											<td>
												<?php if(yetkiKontrolGizle("0,4")) { ?>
												<a class="btn btn-primary btn-sm" href="?islem=duzenle&Id=<?=$row["id"];?>"><i class="fa fa-edit"></i> Düzenle</a>
												<a class="btn btn-danger btn-sm" href="?islem=sil&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
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
						case "ekle":
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Firma Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=yenifirmaekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Firma Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="firma_ad" value="" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Oluşturulma Tarihi</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <div class="input-group date datetimepicker">
										<input name="firma_tarih" type='text' class="form-control" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									 </div>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="durum" class="form-control">
										<option value="1">Aktif</option>
										<option value="0">Pasif</option>
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
						case "duzenle":
						$veri = veriCek("firma", "*", "id", $_GET["Id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Firma Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=firmaguncelle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="firma_id" value="<?=$veri["id"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Firma Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="firma_ad" value="<?=$veri["firma_ad"];?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Oluşturulma Tarihi</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <div class="input-group date datetimepicker">
										<input name="firma_tarih" type='text' placeholder="<?=tarih($veri["tarih"]);?>" class="form-control" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									 </div>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Durum</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="durum" class="form-control">
										<option value="1" <?=($veri["durum"] == 1)?"selected":""?>>Aktif</option>
										<option value="0" <?=($veri["durum"] == 0)?"selected":""?>>Pasif</option>
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
						case "sil":
						yetkiKontrol("0");
						if( ctype_digit($_GET["Id"]) ) {
							$eskiveri = veriCek("firma", "firma_ad", "id", $_GET["Id"]);
							
							veriSil("firma", "id", $_GET["Id"]);
							islemKaydi("Firma Yönetimi", "bir firma sildi. ({$eskiveri["firma_ad"]})");
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
				$('.mn-firma').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
				
				$(".datetimepicker").datetimepicker({
                    locale: 'tr'
                });
			});
		</script>
		
	</body>
</html>