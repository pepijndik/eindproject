<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Camping systeem | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <!--=================Login Css=================================-->

<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon.ico');?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/bootstrap/css/bootstrap.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/animate/animate.css');?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/css-hamburgers/hamburgers.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/animsition/css/animsition.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/select2/select2.min.css');?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/daterangepicker/daterangepicker.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login/util.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login/main.css');?>">
<!--===============================================================================================-->


</head>

<body style=" ">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178"  method="POST" action="<?php echo base_url('admin/login') ?>">
				<?php echo validation_errors(); ?>
				<?php if (!empty($errors)) {
					echo $errors;
					} ?>
					    <?php if (!empty($login_error['password']) || !empty($login_error['login'])) { ?>

          <br /><br />

          <div class="alert alert-warning alert-dismissible fade show" role="alert"> <strong>Holy guacamole!</strong> Uw wachtwoord of gebruikers naam is incorrect

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

              <span aria-hidden="true">&times;</span>

            </button>

          </div>

		  <?php } ?>
					<span class="login100-form-title">
						Inloggen Camping La Rustique 
					</span>


					<div class="wrap-input100 validate-input m-b-16" data-validate="Vul een gebruikersnaam in">
						<input class="input100" type="text" name="username" placeholder="Gebruikers naam">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Vul een wachtwoord in">
						<input class="input100" type="password" name="password" placeholder="Wachtwoord">
						<span class="focus-input100"></span>
					</div>

					<div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							Gebruikersnaam of wachtwoord
						</span>

						<a href="#" class="txt2">
							Vergeten?
						</a>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="enter" value="Login">
							Login
						</button>
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							Powerd by 
						</span>

						<a href="https://pdik.nl" class="txt3">
            Pdik systems
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	
<!--===============================================================================================-->
	<script src="<?php echo base_url('vendor/jquery/jquery-3.2.1.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('vendor/animsition/js/animsition.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('vendor/bootstrap/js/popper.js');?>"></script>
	<script src="<?php echo base_url('vendor/bootstrap/js/bootstrap.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('vendor/select2/select2.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('vendor/daterangepicker/moment.min.js');?>"></script>
	<script src="<?php echo base_url('vendor/daterangepicker/daterangepicker.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('vendor/countdowntime/countdowntime.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('assets/js/main.js');?>"></script>

</body>
</html>