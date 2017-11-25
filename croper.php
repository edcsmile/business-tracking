<? 	
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	$orjimage = $_GET["image"];
	$width = $_GET["w"];
	$height = $_GET["h"];
	$path = "";
	$mod = $_GET["mod"];
	if($orjimage && $width && $height && $mod){} else {header("location:index.php");}
	switch($mod){
		case"urun":
			$path = "../images/urunler/";
		break;
		case"galeri":
			$path = "../images/galeri/";
		break;
		
		default:
		
		break;
	}
	$url = $path.$orjimage;
	if($_POST){
		$x = $_POST["x"];
		$y = $_POST["y"];
		$x2 = $_POST["x2"];
		$y2 = $_POST["y2"];
		$w = $_POST["w"];
		$h = $_POST["h"];
		$upload = new Upload($url,"tr_TR");
		if($upload->uploaded) {
			$newname = explode(".",str_replace("orj_","",$orjimage));
			$upload->file_new_name_body = $newname[0];
			$resimw = $upload->image_src_x - $x2;
			$resimh = $upload->image_src_y - $y2;
			$upload->image_crop = "{$y} {$resimw} {$resimh} {$x}";
			$upload->Process($path);
			if($upload->processed){
				@unlink($url);	
				switch($mod){
					case"urun":
						header("location:urun.php");
					break;		
					case"galeri":
						header("location:galeri.php");
					break;
					default:
					
					break;
				}	
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?=head('Resim Kırpıcı');?>
	
	<link rel="stylesheet" href="css/jquery.Jcrop.min.css">

	<?=endhead("");?>
</head>
<body>
	<?=topbar();?>
    <div class="container" id="main-container">
		<?=leftbar();?>
        <div id="main-content">
			<!-- içerik -->
			<div class="page-title">
				<div>
					<h1>
						<i class="fa fa-file-o"></i>Fotoğraf Düzenleme</h1>
					<h4>
						Lütfen resminizi düzenleyiniz.
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box box-blue">
						<div class="box-title">
							<h3><i class="fa fa-desktop"></i></h3>
							<div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							</div>
						</div>
						<div class="box-content">
							<img src="<?=$url?>" id="crop" />
							<br /><br />
							<form method="post">
								<input type="hidden" name="x" id="x"/>
								<input type="hidden" name="y" id="y"/>
								<input type="hidden" name="x2" id="x2"/>
								<input type="hidden" name="y2" id="y2"/>
								<input type="hidden" name="w" id="w"/>
								<input type="hidden" name="h" id="h"/>
								<button type="submit" class="btn btn-primary" value="Kırp"><i class="fa fa-check"></i> Kırp</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- içerik -->
        <?=footer();?>
        </div>
    </div
	
	<?=scripts();?>
	
	<!--page specific plugin scripts-->
																		
	<script src="js/jquery.Jcrop.min.js"></script>
	<script>
		$(document).ready(function () {
			$("#crop").Jcrop({
				onChange: showCoords,
				onSelect: showCoords,
				minSize: [<?=$width?>, <?=$height?>],
				maxSize: [<?=$width?>, <?=$height?>],
				aspectRatio: <?=$width?>/<?=$height?>,
				bgColor:     'black',
				bgOpacity:   .4,
				setSelect:   [ 100, 100, 50, 50 ],
			});
		});
		function showCoords(c){
			$("#x").val(c.x);
			$("#y").val(c.y);
			$("#x2").val(c.x2);
			$("#y2").val(c.y2);
			$("#w").val(c.w);
			$("#h").val(c.h);
		}
	</script>
	
	<?=endscripts();?>
																				
</body>
</html>