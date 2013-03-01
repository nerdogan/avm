<?php ob_start(); ?>
<?php if (!isset($_SESSION)) session_start(); ?>
<?php include_once(dirname(dirname(__FILE__)) . '/classes/translate.class.php'); ?>
<?php include_once(dirname(__FILE__) . '/classes/functions.php'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title> Avm Mağaza Kontrol Sistemi | Admin Panel</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Avm Mağaza Kontrol Sistemi">
		<meta name="author" content="Namık ERDOĞAN">

		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le styles -->
                 <link href="assets/css/modern.css" rel="stylesheet">
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="../assets/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="../assets/css/jigowatt.css" rel="stylesheet">
		<link href="assets/css/datepicker.css" rel="stylesheet">
		<link href="assets/js/chosen/chosen.css" rel="stylesheet">
		<link href="assets/css/prettify.css" rel="stylesheet">

		<link rel="shortcut icon" href="//jigowatt.co.uk/favicon.ico">

		<!-- Added library to header in order to load reports -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	</head>

	<body>

<!-- Navigation
================================================== -->

	<div class="navbar navbar-fixed-top">
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">

				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<h3><a class="brand" href="home.php">Avm MAnager</a></h3>
				<div class="nav-collapse">
					<ul class="nav" id="findme">
						<li><a href="../home.php"><?php _e('Anasayfa'); ?></a></li>
						<li><a href="../protected.php"><?php _e('Güvenlik'); ?></a></li>
						<li><a href="index.php"><?php _e('Admin Panel'); ?></a></li>
					</ul>
		<?php if(isset($_SESSION['jigowatt']['username'])) { ?>
		<ul class="nav pull-right">
			<li class="dropdown">
				<p class="navbar-text dropdown-toggle" data-toggle="dropdown" id="userDrop"><?php echo $_SESSION['jigowatt']['gravatar']; ?> <a href="#"><?php echo $_SESSION['jigowatt']['username']; ?></a><b class="caret"></b></p>
				<ul class="dropdown-menu">
		<?php if(in_array(1, $_SESSION['jigowatt']['user_level'])) { ?>
					<li><a href="index.php"><i class="icon-home"></i> <?php _e('Kontrol Panel'); ?></a></li>
					<li><a href="settings.php"><i class="icon-cog"></i> <?php _e('Ayarlar'); ?></a></li> <?php } ?>
					<li><a href="../profile.php"><i class="icon-user"></i> <?php _e('Hesabım'); ?></a></li>
					<li><a href="mailto:info@onlinearge.com"><i class="icon-info-sign"></i> <?php _e('Yardım'); ?></a></li>
					<li class="divider"></li>
					<li><a href="../logout.php"><?php _e('Çıkış'); ?></a></li>
				</ul>
			</li>
		</ul>
		<?php } else { ?>
		<ul class="nav pull-right">
			<li><a href="../login.php" class="signup-link"><em><?php _e('Hoşgeldiniz'); ?></em> <strong><?php _e('Giriş Yapın!'); ?></strong></a></li>
		</ul>
		<?php } ?>
				</div>
				</div>
			</div><!-- /navbar-inner -->
		</div><!-- /navbar -->
	</div><!-- /navbar-wrapper -->
                
<!-- Main content
================================================== -->
	<div class="page secondary">
     
        sdhsdhsdh<br><br><br><br><br>
 
        <div class="page-region">
            
            <div class="page-region-content">	
			sdfhsdh
				<div class="span12">