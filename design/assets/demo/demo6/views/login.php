
<!DOCTYPE html>
<html lang="en">
<head>
<base  href="<?=$url?>design/">
	<title>CRM </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendors/bootstrap/dist/css/bootstrap.css">
<!--===============================================================================================-->
<link href="assets/demo/demo6/base/util.css" rel="stylesheet" type="text/css" />
<link href="assets/demo/demo6/base/main.css" rel="stylesheet" type="text/css" />
<!--===============================================================================================-->
</head>
<body>
<?php $CompanyData = get_row("settingcrm",["settingcrmId"=>1],null) ?>
	<div class="limiter" style="  background-image: url('assets/images/<?= $CompanyData->loginbg ?>');
	background-position: center;
	background-size:cover;  ">
		<div class="container-login100">
			<div class="wrap-login100 p-t-10 p-b-20">
				<form class="login100-form validate-form" method="post" action="<?=$url?>CRM_Users">
					<span class="login100-form-avatar">
						<img src="assets/images/<?= $CompanyData->settingcrmLogo ?>" alt="AVATAR">
					</span>

					<div class="wrap-input100 validate-input m-t-20 m-b-35" data-validate = "Enter username">
						<input class="input100" type="text" name="username" id="username">
						<span class="focus-input100" ></span>
					</div>

					<div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
						<input class="input100" type="password" name="password" id="password">
						<span class="focus-input100"></span>
					</div>

					<?php 
                     if(isset($error)){?>
						<div class="form-group error" style="color:red">
						 <?php echo $error?>
					    </div>
					<?php }
				?>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							تسجيل دخول 
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	<script src="vendors/jquery/dist/jquery.min.js"></script>
	<script src="vendors/popper.js/dist/popper.js"></script>
		<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<script type="text/javascript"> 
      $(document).ready( function() {
        $('.error').delay(2000).fadeOut(1000);
      });
    </script>

</body>
</html>










