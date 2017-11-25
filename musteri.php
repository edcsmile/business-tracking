<?
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["musteri"])
		yetkiKontrol("müşteriler giremez");
	
	$baslik = "İş Yönetimi";
	$isError = false;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		yetkiKontrol("0,2,4");
			
		if($_GET["islem"] == "talepcevap") {
			$talep_id				=		$_POST["talep_id"];
			$is_adi					=		$_POST["is_adi"];
			$talep_turu			=		$_POST["talep_turu"];
			$talep_cevap			=		$_POST["talep_cevap"];
			
			$talepBilgisi			=	veriCek("musteri_talep", "*", "id", $talep_id);
			$musteri				=	veriCek("musteri", "isim", "Id", $talepBilgisi["musteri_id"]);
			
			switch($talepBilgisi["talep_turu"])
			{
				case 0: $tTuru = "İstek / Değişiklik"; break;
				case 1: $tTuru = "Hata / Düzenleme"; break;
				default: $tTuru = "Error Code : 24"; break;
			}
			
			switch($talep_turu)
			{
				case 0: $ytTuru = "Beklemede"; break;
				case 1: $ytTuru = "İnceleniyor"; break;
				case 2: $ytTuru = "Yapım Aşamasında"; break;
				case 3: $ytTuru = "Reddedildi"; break;
				case 4: $ytTuru = "Tamamlandı"; break;
			}
			
			if( veriGuncelle(array("readly_to", "talep_cevap", "talep_durumu", "talep_cevaplayan", "talep_cevap_tarih"), array(1, $talep_cevap, $talep_turu, $_SESSION["user"]["Id"], date("Y-m-d H:i:s")), "musteri_talep", "id", $talep_id) )
			{
				islemKaydi("{$is_adi} | Talebi Yapılandır", "bir talebi yapılandırdı.. Talep Eden Müşteri : {$musteri["isim"]}, Talep Türü : {$tTuru}. Durumu '{$ytTuru}' olarak güncelledi..");
				git("?islem=talepler");
			} else {
				git("?islem=talepler");
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
						case "talepler":
						yetkiKontrol("0,1,2,3,4");
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Müşteri Talepleri</h3>
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
										<th>Talep Türü</th>
										<th>Talep Durumu</th>
										<th style="width: 200px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?
									$veri = tabloCek("musteri_talep", "*", "ORDER BY id DESC");
									
									 $i = 1;
									 foreach( $veri as $row ) {
										 $getIs = veriCek("jobs", "is_adi", "id", $row["is_id"]);
										 
										 if($row["readly"] == 1)
										 {
											 veriGuncelle(array("readly"), array("0"), "musteri_talep", "id", $row["id"]);
										 }
									 ?>
										 <tr>
											<td><?=$i;?></td>
											<td><?=$getIs["is_adi"];?></td>
											<td><?=tarih($row["tarih"]);?></td>
											<td><?=($row["talep_turu"]==0)?'İstek / Değişiklik':'Hata / Düzenleme'?></td>
											<td><?=musteriDurumIsle($row["talep_durumu"]);?></td>
											<td>
												<a class="btn btn-primary btn-sm" href="?islem=talepSonucla&Id=<?=$row["id"];?>"><i class="fa fa-edit"></i> Yapılandır</a>
												<?=(yetkiKontrolGizle("0,4"))?'<a class="btn btn-danger btn-sm" href="?islem=talepSil&Id='.$row["id"].'"><i class="fa fa-edit"></i> Sil</a>':'<a class="btn btn-danger btn-sm disabled"><i class="fa fa-edit"></i> Sil</a>'?>
											</td>
										 </tr>
									 <?
										$i++;
									 }
									 ?>
									 <?=($i == 1)?"<tr><td colspan='7'><b>Henüz bir talep bulunamadı..</b></td></tr>":""?>
								  </tbody>
							   </table>
							</div>
						 </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "talepSonucla":
						yetkiKontrol("0,1,2,3,4");
						$talepBilgisi = veriCek("musteri_talep", "*", "id", $_GET["Id"]);
						$getIs = veriCek("jobs", "is_adi", "id", $talepBilgisi["is_id"]);
						$getMusteri = veriCek("musteri", "isim", "Id", $talepBilgisi["musteri_id"]);
						?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> <?=$getIs["is_adi"]?> | Talebi Yapılandır </h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							<table class="table table-striped table-hover fill-head">
								<tr>
									<td style="width: 150px;"><b>Müşteri Adı</b></td>
									<td style="width: 15px;">;</td>
									<td><?=$getMusteri["isim"];?></td>
								</tr>
								<tr>
									<td style="width: 150px;"><b>Talep Tarihi</b></td>
									<td style="width: 15px;">;</td>
									<td><?=tarih($talepBilgisi["tarih"]);?></td>
								</tr>
								<tr>
									<td style="width: 150px;"><b>Müşteri Mesajı</b></td>
									<td style="width: 15px;">;</td>
									<td><?=$talepBilgisi["talep"];?></td>
								</tr>
							</table>
							 <form action="?islem=talepcevap" id="validation-form" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="talep_id" value="<?=$_GET["Id"]?>" />
								<input type="hidden" name="is_adi" value="<?=$getIs["is_adi"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Talep Durumu</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <select name="talep_turu" class="form-control">
										<option value="0" <?=($talepBilgisi["talep_durumu"]==0)?'selected':''?>> Beklemede </option>
										<option value="1" <?=($talepBilgisi["talep_durumu"]==1)?'selected':''?>> İnceleniyor </option>
										<option value="2" <?=($talepBilgisi["talep_durumu"]==2)?'selected':''?>> Yapım Aşamasında </option>
										<option value="3" <?=($talepBilgisi["talep_durumu"]==3)?'selected':''?>> Reddedildi </option>
										<option value="4" <?=($talepBilgisi["talep_durumu"]==4)?'selected':''?>> Tamamlandı </option>
									  </select>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Talebi Cevaplandır</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="talep_cevap" class="form-control" cols="5" rows="5"><?=$talepBilgisi["talep_cevap"];?></textarea>
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Gönder</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=talepler';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>
						<?
						break;
						case "talepSil":
						yetkiKontrol("0,4");
						if( ctype_digit($_GET["Id"]) ) {
							$talep = veriCek("musteri_talep", "musteri_id, is_id", "id", $_GET["Id"]);
							
							$musteri = veriCek("musteri", "isim", "Id", $talep["musteri_id"]);
							$isBilgisi = veriCek("jobs", "is_adi", "id", $talep["is_id"]);
							
							veriSil("musteri_talep", "id", $_GET["Id"]);
							islemKaydi("Müşteri Talepleri", "bir talebi sildi. (Müşteri Adı : {$musteri["isim"]}, Düzenleme Talep Ettiği İş Adı : {$isBilgisi["is_adi"]})");
						}
						git("?islem=talepler");
						break;
						default:
							git("?islem=talepler");
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
				$('.mn-musteri').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
		
	</body>
</html>