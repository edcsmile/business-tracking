<?
	/*********************************/
					// İlker Şahin //
	/*********************************/
	
	//error_reporting(0);
	
	header('Content-Type: text/html; charset=utf-8');
	
	$k_id = "username"; // veritabanı kullanıcı adı - database username
	$k_pass = "password"; // veritabanı kullanıcı şifresi - database password
	$k_host = "localhost"; // sunucu - host
	$k_db = "database"; // veritabanı adı - database name
	
	try {
		$db = new PDO("mysql:host={$k_host};dbname={$k_db};charset=utf8", $k_id, $k_pass);
	} catch ( PDOException $e ){
		 // die($e->getMessage());
		 die("DATABASE NOT FOUND!");
	}

	session_start();
	setlocale(LC_TIME, "turkish"); 
	date_default_timezone_set('Europe/Istanbul'); 

	$malware = $db->query("SELECT Id FROM security WHERE ip = '".$_SERVER['REMOTE_ADDR']."'", PDO::FETCH_ASSOC);
	if( $malware->rowCount() > 0 )
	{
		die("IP BLOCKED.");
	}

	function QueryFilter($str)
	{
		$str = str_replace("*", "[INJ]",$str);
		$str = str_replace("UNION", "[INJ]",$str);
		$str = str_replace("SELECT", "[INJ]",$str);
		$str = str_replace("WHERE", "[INJ]",$str);
		$str = str_replace("UPDATE", "[INJ]",$str);
		$str = str_replace("INSERT", "[INJ]",$str);
		$str = str_replace("ORDER", "[INJ]",$str);
		$str = str_replace("MODIFY", "[INJ]",$str);
		$str = str_replace("RENAME", "[INJ]",$str);
		$str = str_replace("DECLARE", "[INJ]",$str);
		$str = str_replace("TABLE_NAME", "[INJ]",$str);
		$str = str_replace("COLUMN_NAME", "[INJ]",$str);
		$str = str_replace("COLUMNS", "[INJ]",$str);
		$str = str_replace("DATA_TYPE", "[INJ]",$str);
		$str = str_replace("CHARACTER", "[INJ]",$str);
		$str = str_replace("LENGTH", "[INJ]",$str);
		$str = str_replace("FETCH", "[INJ]",$str);
		$str = str_replace("STATUS", "[INJ]",$str);
		$str = str_replace("union", "[INJ]",$str);
		$str = str_replace("select", "[INJ]",$str);
		$str = str_replace("update", "[INJ]",$str);
		$str = str_replace("inster", "[INJ]",$str);
		$str = str_replace("order", "[INJ]",$str);
		$str = str_replace("modify", "[INJ]",$str);
		$str = str_replace("rename", "[INJ]",$str);
		$str = str_replace("declare", "[INJ]",$str);
		$str = str_replace("table_name", "[INJ]",$str);
		$str = str_replace("column_table", "[INJ]",$str);
		$str = str_replace("columns", "[INJ]",$str);
		$str = str_replace("data_type", "[INJ]",$str);
		$str = str_replace("character", "[INJ]",$str);
		$str = str_replace("length", "[INJ]",$str);
		$str = str_replace("fetch", "[INJ]",$str);
		$str = str_replace("status", "[INJ]",$str);
		$str = str_replace("adf.ly", "[INJ]",$str);
		return $str;
	}
	
	$gelenurladresi = QueryFilter($_SERVER["REQUEST_URI"]);

	if (strpos($gelenurladresi, '[INJ]') !== false) {
		veriEkle(array("ip", "browser", "http_url", "sdate"), array($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['REQUEST_URI'], @date("Y-m-d H:i:s")), "security_count");
		$getvt = tabloCek("security_count", "*", "WHERE ip = '{$_SERVER['REMOTE_ADDR']}'");
		$vtsayac = $getvt->rowCount();
		$sayacsayisi = 5 - intval($vtsayac);
		if($sayacsayisi <= 0) {
		  veriEkle(array("ip","host","browser","sdate"), array($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_HOST'], $_SERVER['HTTP_USER_AGENT'], @date("Y-m-d H:i:s")), "security");
		}
		die("Geçersiz İstek !");
	}

	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
		// SSL connection
		$weburl = 'https://'.$_SERVER["SERVER_NAME"].'/';
	} else {
		$weburl = 'http://'.$_SERVER["SERVER_NAME"].'/';
	}
	
	function getversiyon(){
		return 'Yönetim Paneli v7.1.2';	
	}
	
	function permalink($s){   
		$tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',','?',';','*','+','^','"','#','$','%','&','{','[',']','}','*','|','>','<',"'",'~','@','!',':',';','â','’','Ä');
		$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','ı');
		$s = str_replace($tr,$eng,$s);
		$s = strtolower($s);
		$s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
		$s = preg_replace('/\s+/', '-', $s);
		$s = preg_replace('|-+|', '-', $s);
		$s = preg_replace('/#/', '', $s);
		$s = str_replace('.', '', $s);
		$s = trim($s, '-');
		return $s;
	}
	
	function QueryFilterClear($str)
	{
		$str = str_replace("*", "",$str);
		$str = str_replace("<", "",$str);
		$str = str_replace(">", "",$str);
		$str = str_replace(";", "",$str);
		$str = str_replace("(", "",$str);
		$str = str_replace(")", "",$str);
		$str = str_replace("UNION", "",$str);
		$str = str_replace("SELECT", "",$str);
		$str = str_replace("WHERE", "",$str);
		$str = str_replace("UPDATE", "",$str);
		$str = str_replace("INSERT", "",$str);
		$str = str_replace("ORDER", "",$str);
		$str = str_replace("MODIFY", "",$str);
		$str = str_replace("RENAME", "",$str);
		$str = str_replace("DECLARE", "",$str);
		$str = str_replace("TABLE_NAME", "",$str);
		$str = str_replace("COLUMN_NAME", "",$str);
		$str = str_replace("COLUMNS", "",$str);
		$str = str_replace("DATA_TYPE", "",$str);
		$str = str_replace("CHARACTER", "",$str);
		$str = str_replace("LENGTH", "",$str);
		$str = str_replace("FETCH", "",$str);
		$str = str_replace("STATUS", "",$str);
		$str = str_replace("union", "",$str);
		$str = str_replace("select", "",$str);
		$str = str_replace("update", "",$str);
		$str = str_replace("inster", "",$str);
		$str = str_replace("order", "",$str);
		$str = str_replace("modify", "",$str);
		$str = str_replace("rename", "",$str);
		$str = str_replace("declare", "",$str);
		$str = str_replace("table_name", "",$str);
		$str = str_replace("column_table", "",$str);
		$str = str_replace("columns", "",$str);
		$str = str_replace("data_type", "",$str);
		$str = str_replace("character", "",$str);
		$str = str_replace("length", "",$str);
		$str = str_replace("fetch", "",$str);
		$str = str_replace("status", "",$str);
		$str = str_replace("adf.ly", "",$str);
		return $str;
	}
	
	function ninja($str){
		$str = QueryFilterClear($str);
		return $str;
	}
	
	function yetkiKontrol($no)
	{
		$yetkiler = array();
		
		if(strpos($no, ","))
			$yetkiler = explode(",", $no);
		else
			array_push($yetkiler, $no);
		
		if(!in_array($_SESSION["user"]["yetki"], $yetkiler)) {
			git("index.php");
			die();
		}
	}
	
	function yetkiKontrolGizle($no)
	{
		$yetkiler = array();
		
		if(strpos($no, ","))
			$yetkiler = explode(",", $no);
		else
			array_push($yetkiler, $no);
		
		if(!in_array($_SESSION["user"]["yetki"], $yetkiler))
			return false;
		else
			return true;
	}
	
	function git($adres){
		echo "<script>document.location.href='".$adres."';</script>";
		die();
	}
	
	function islemKaydi($tur, $aciklama)
	{
		global $db;
		
		$query = $db->prepare("INSERT INTO islemler SET
		tarih = ?,
		personel = ?,
		tur = ?,
		aciklama = ?");
		$insert = $query->execute(array(
			@date("Y-m-d H:i:s"), "{$GLOBALS["user"]["Id"]}", "{$tur}", "{$GLOBALS["user"]["isim"]}, {$aciklama}" 
		));
		return;
	}
	
	function tabloCek($tablo, $alanlar, $manuel)
	{
		global $db;
		
		$veri = $db->query("SELECT {$alanlar} FROM {$tablo} {$manuel}", PDO::FETCH_ASSOC);
		return $veri;
	}
	
	function veriCek($tablo, $alanlar, $sutun, $id)
	{
		global $db;
		
		$veri = $db->query("SELECT {$alanlar} FROM {$tablo} WHERE {$sutun} = '{$id}'")->fetch(PDO::FETCH_ASSOC);
		return $veri;
	}
	
	function veriSil($tablo, $sutun, $id)
	{
		global $db;
		
		$query = $db->prepare("DELETE FROM {$tablo} WHERE {$sutun} = :edc");
		$delete = $query->execute(array(
		   'edc' => $id
		));
	}
	
	function veriEkle($sutunlar, $veriler, $tablo)
	{
		global $db;
		
		$other = array();
		$sorgu = "";
		$count = count($veriler);
		$a = 0;
		for($i = 0; $i < $count; $i++)
		{
			$a++;
			if($a == $count)
				$sorgu .= $sutunlar[$i]." = ?";
			else
				$sorgu .= $sutunlar[$i]." = ?,";
		}
		
		$query = $db->prepare("INSERT INTO {$tablo} SET {$sorgu}");
		$insert = $query->execute($veriler);
		
		if ( $insert )
			return true;
		else
			return false;
	}
	
	function veriGuncelle($sutunlar, $veriler, $tablo, $hedef, $no)
	{
		global $db;
		
		$other = array();
		$sorgu = "";
		$a = 0;
		$count = count($veriler);
		for($i = 0; $i < $count; $i++)
		{
			$a++;
			if($a == $count)
				$sorgu .= $sutunlar[$i]." = :a_".$sutunlar[$i];
			else
				$sorgu .= $sutunlar[$i]." = :a_".$sutunlar[$i].",";
		}
		
		$b = 0;
		foreach( $sutunlar as $sutun )
		{
			$other["a_".$sutun] = $veriler[$b];
			$b++;
		}
		
		$other["no"] = $no;
		
		$query = $db->prepare("UPDATE {$tablo} SET {$sorgu} WHERE {$hedef} = :no");
		$update = $query->execute($other);
		
		if ( $update )
			return true;
		else
			return false;
	}
	
	function resimUpload($filePic, $oldImg,  $thumb, $path, $url)
	{
		$newPath = explode("/", $path);
		$processPath	=		"../".$newPath[0]."/".$newPath[1]."/";
		$path				=		$newPath[0]."/".$newPath[1]."/";
		
		if(!empty($oldImg))
		{
			@unlink($processPath . $oldImg);
			@unlink($processPath . "thumb/" . $oldImg);
		}
		
		$upload = new Upload($filePic);
		if ($upload->uploaded) {
			$filename = md5(microtime());
			
			$uzanti = pathinfo($filePic["name"]);
			$uzanti = $uzanti["extension"];
			
			$upload->image_resize = false;
			$upload->file_new_name_body = $filename;
			$upload->Process($processPath);
			
			switch( $uzanti ) {
				case "png": $ctype="image/png"; break;
				case "jpeg": $ctype="image/jpeg"; break;
				case "jpg": $ctype="image/jpeg"; break;
				default: { $upload->image_convert = jpg; $ctype="image/jpeg"; } break;
			}
			
			if($thumb == true)
			{
				if($upload->image_src_x < 265) $stat = 1;
				else $stat = 0;
			
				git("ImageSizer.php?ctype={$ctype}&resim={$path}{$filename}.{$uzanti}&target={$path}thumb/{$filename}.{$uzanti}&stat=".$stat."&url={$url}");
			}
			
			return $filename.".".$uzanti;
		} else {
			return false;
		}
	}
	
	function tarih($par)
	{
		$explode = explode(" ", $par);
		$explode2 = explode("-", $explode[0]);
		$zaman = substr($explode[1], 0, 5);

		if ($explode2[1] == "1") $ay = "Ocak";
		elseif ($explode2[1] == "2") $ay = "Şubat";
		elseif ($explode2[1] == "3") $ay = "Mart";
		elseif ($explode2[1] == "4") $ay = "Nisan";
		elseif ($explode2[1] == "5") $ay = "Mayıs";
		elseif ($explode2[1] == "6") $ay = "Haziran";
		elseif ($explode2[1] == "7") $ay = "Temmuz";
		elseif ($explode2[1] == "8") $ay = "Ağustos";
		elseif ($explode2[1] == "9") $ay = "Eylül";
		elseif ($explode2[1] == "10") $ay = "Ekim";
		elseif ($explode2[1] == "11") $ay = "Kasım";
		elseif ($explode2[1] == "12") $ay = "Aralık";

		return $explode2[2]." ".$ay." ".$explode2[0].", ".$zaman;
	}
	
	function dateTimeConvertTR($datetime)
	{
		$tarihVeSaat	=	explode(" ", $datetime);
		$tarih			=	$tarihVeSaat[0];
		$saat				=	$tarihVeSaat[1];
		
		$parcala			=	explode(".", $tarih);
		$tarih			=	$parcala[2]."-".$parcala[1]."-".$parcala[0];
		$saat				.=	":00";
		
		$yenitarih		=	$tarih." ".$saat;
		
		return $yenitarih;
	}
	
	function openUrlWithWindow($url)
	{
		echo "
		<script type='text/javascript'>
			window.open('{$url}', '_blank', 'width=400, height=300,left=200,top=100', false);
		</script>
		";
	}
	
	function gorevliIsle($veri)
	{
		$one = 1;
		$control = strpos($veri, "-");
		if($control == true)
		{
			$gorevliler = explode("-", $veri);
			foreach( $gorevliler as $gorevli )
			{
				$gorevliBilgisi = veriCek("personel ", "isim", "Id", $gorevli);
				if($one == 1)
					$belirle .= $gorevliBilgisi["isim"];
				else
					$belirle .= ", ".$gorevliBilgisi["isim"];
				
				$one = 0;
			}
			
			return $belirle;
		} else {
			$gorevliBilgisi = veriCek("personel ", "isim", "Id", $veri);
			return $gorevliBilgisi["isim"];
		}
	}

	function durumIsle($veri)
	{
		if($veri == 0)
			return "Havuz";
		if($veri == 1)
			return "Yapılacak / Beklemede";
		if($veri == 2)
			return "Yapım Aşamasında";
		if($veri == 3)
			return "Tasarım Onayı Bekliyor";
		if($veri == 4)
			return "Yayın Onayı Bekliyor";
		if($veri == 5)
			return "Tamamlandı";
	}
	
	/* Müşteri Durumu */
	function musteriDurumIsle($veri)
	{
		if($veri == 0)
			return "Beklemede";
		if($veri == 1)
			return "İnceleniyor";
		if($veri == 2)
			return "Yapım Aşamasında";
		if($veri == 3)
			return "Reddedildi";
		if($veri == 4)
			return "Tamamlandı";
	}

	function durumIsleV2($veri)
	{
		if($veri == 0)
			return "Düzenleme";
		if($veri == 1)
			return "Değişiklik";
		if($veri == 2)
			return "Güncelleme";
		if($veri == 3)
			return "Yapılacak / Beklemede";
		if($veri == 4)
			return "Yapım Aşamasında";
	}
?>