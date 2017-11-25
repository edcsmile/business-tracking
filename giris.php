<? 
	require_once("inc/config.php");
	$showError = false;
	$errormsg ="";
	
	if($_POST["username"] && $_POST["password"]){
		$u = ninja($_POST["username"]);
		$p = ninja($_POST["password"]);
		
		$sorgu = "SELECT * FROM personel WHERE kadi='".$u."' AND sifre='".$p."' LIMIT 1";
		
		$loginControl = $db->query($sorgu, PDO::FETCH_ASSOC);
		if( $loginControl->rowCount() > 0 ) {
			$loginControl = $db->query($sorgu)->fetch(PDO::FETCH_ASSOC);
			
			$_SESSION["userlogin"] = true;
			$_SESSION["user"] = $loginControl;	
			$_SESSION["user"]["musteri"] = false;
			$_SESSION["gsaat"] = @date('h:i:s');
			
			$query = $db->prepare("INSERT INTO islemler SET
			tarih = ?,
			personel = ?,
			tur = ?,
			aciklama = ?");
			$insert = $query->execute(array(
				 @date("Y-m-d H:i:s"),
				 $loginControl["Id"],
				 "Giriş",
				 $loginControl["isim"].", sisteme giriş yaptı."
			));
			if ( $insert ){
				git("index.php");
				exit();
			} else {
				$showError = true;
			}
		} else {
			$sorgu = "SELECT * FROM musteri WHERE kadi='".$u."' AND sifre='".$p."' LIMIT 1";
			$musteriControl = $db->query($sorgu, PDO::FETCH_ASSOC);
		
			if( $musteriControl->rowCount() > 0 ) {
				$musteriControl = $db->query($sorgu)->fetch(PDO::FETCH_ASSOC);
			
				$_SESSION["userlogin"] = true;
				$_SESSION["user"] = $musteriControl;
				$_SESSION["user"]["musteri"] = true;
				$_SESSION["gsaat"] = @date('h:i:s');
				
				$query = $db->prepare("INSERT INTO islemler SET
				tarih = ?,
				personel = ?,
				tur = ?,
				aciklama = ?");
				$insert = $query->execute(array(
					 @date("Y-m-d H:i:s"),
					 $musteriControl["id"],
					 "Giriş",
					 $musteriControl["isim"]." (Müşteri) sisteme giriş yaptı."
				));
				if ( $insert ){
					git("index.php");
					exit();
				} else {
					$showError = true;
				}
			} else {
				$showError = true;
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Giriş - <?=getversiyon()?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="img/favicon.ico">
	
	<!--base css styles-->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

	<!--page specific css styles-->
	<link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">

	<!--flaty css styles-->
	<link rel="stylesheet" href="css/flaty.css">
	<link rel="stylesheet" href="css/flaty-responsive.css">
	</head>
	<body class="login-page">

		<!-- BEGIN Main Content -->
		<div class="login-wrapper">
			<div class="alert alert-danger <?=($showError)?"":"hidden"?>" style="width:340px; margin:auto;" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Geçersiz bir kullanıcı adı veya parola girdiniz !
			</div>
			<!-- BEGIN Login Form -->
			<form id="form-login" action="" method="post">
				<h3>İş Takip Sistemi</h3>
				<hr/>
				<div class="form-group">
					<div class="controls">
						<input type="text" name="username" id="username" placeholder="Kullanıcı Adı" class="form-control" data-rule-required="true" data-rule-minlength="3" />
					</div>
				</div>
				<div class="form-group">
					<div class="controls">
						<input type="password" name="password" id="password" placeholder="Şifre" class="form-control" data-rule-required="true" data-rule-minlength="4" />
					</div>
				</div>
				<div class="form-group hidden">
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" value="remember" /> Beni Hatırla
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary form-control">Giriş Yap</button>
					</div>
				</div>
				<hr/>
				<p class="clearfix">
				<a href="#" class="btn btn-warning" id="gritter-regular" style="width:100%; text-align:center;">Coder Bing</a>
				</p>
			</form>
			<!-- END Login Form -->
		</div>
		<!-- END Main Content -->


		<!--basic scripts-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="assets/jquery/jquery-2.1.1.min.js"><\/script>')</script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="assets/jquery-validation/dist/additional-methods.min.js"></script>
		<script src="assets/gritter/js/jquery.gritter.js"></script>
		<script type="text/javascript">
			$(function() {
				$('#gritter-regular').click(function () {
					$.gritter.add({
						title: 'Coder Bing',
						text: 'E-posta : info@coderbing.com <br /> İnternet Adres : <a href="http://www.coderbing.com" target="_blank">cderbing.com</a> <br />',
						image: 'img/favicon.ico',
						sticky: false,
						time: ''
					});
					return false;
				});
				if (jQuery().validate) {
					var removeSuccessClass = function(e) {
						$(e).closest('.form-group').removeClass('has-success');
					}
					var $validator = $('#form-login').validate({
						errorElement: 'span', //default input error message container
						errorClass: 'help-block', // default input error message class
						errorPlacement: function(error, element) {
							if(element.parent('.input-group').length) {
								error.insertAfter(element.parent());
							} else if (element.next('.chosen-container').length) {
								error.insertAfter(element.next('.chosen-container'));
							} else {
								error.insertAfter(element);
							}
						},
						focusInvalid: false, // do not focus the last invalid input
						ignore: "",

						invalidHandler: function (event, validator) { //display error alert on form submit              
							var el = $(validator.errorList[0].element);
							if ($(el).hasClass('chosen')) {
								$(el).trigger('chosen:activate');
							} else {
								$(el).focus();
							}
						},

						highlight: function (element) { // hightlight error inputs
							$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
						},

						unhighlight: function (element) { // revert the change dony by hightlight
							$(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
							setTimeout(function(){removeSuccessClass(element);}, 3000);
						},

						success: function (label) {
							label.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
						}
					});
					var $validator = $('#form-forgot').validate({
						errorElement: 'span', //default input error message container
						errorClass: 'help-block', // default input error message class
						errorPlacement: function(error, element) {
							if(element.parent('.input-group').length) {
								error.insertAfter(element.parent());
							} else if (element.next('.chosen-container').length) {
								error.insertAfter(element.next('.chosen-container'));
							} else {
								error.insertAfter(element);
							}
						},
						focusInvalid: false, // do not focus the last invalid input
						ignore: "",

						invalidHandler: function (event, validator) { //display error alert on form submit              
							var el = $(validator.errorList[0].element);
							if ($(el).hasClass('chosen')) {
								$(el).trigger('chosen:activate');
							} else {
								$(el).focus();
							}
						},

						highlight: function (element) { // hightlight error inputs
							$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
						},

						unhighlight: function (element) { // revert the change dony by hightlight
							$(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
							setTimeout(function(){removeSuccessClass(element);}, 3000);
						},

						success: function (label) {
							label.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
						}
					});
				}
			});
		</script>
	</body>
</html>
<?
	mysql_close($baglanti);
?>