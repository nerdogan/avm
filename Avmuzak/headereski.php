<?php ob_start(); ?>
<?php include_once('classes/translate.class.php'); ?>
<?php include_once('classes/check.class.php'); ?>
<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
	<head>
		<meta charset="utf-8">
		<title>Avm Mağaza Kontrol Sistemi 2013 </title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Avm Mağaza Kontrol Sistemi">
		<meta name="author" content="Namık ERDOĞAN">

		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le styles -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!--<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
		<link href="assets/css/jigowatt.css" rel="stylesheet"> 
<link href="assets/css/cus-icons.css" rel="stylesheet"> 
		<link rel="shortcut icon" href="favicon.ico">
                    
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="HandheldFriendly" content="true" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
  <script src="assets/js/jquery.ui.datepicker-tr.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
 
  <script>
  $(function() {
    
    $( "#datepicker" ).datepicker({
        
    });
    
    
  });
  </script>
  <style>
  .ui-menu { width: 100px; }
  </style>
                    
	</head>

	<body>

<!-- Navigation
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container" style="width: auto;">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="brand" href="#">AVM Manager</a>
        <div class="nav-collapse">
          <ul class="nav">
            <li class="active"><a href="home.php"> Anasayfa</a></li>
              <?php if( protectThis(1) ) : ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cari <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="cari.php?do=ekle">Yeni Kayıt</a></li>
                <li><a href="cari.php">Liste</a></li>
                <li class="divider"></li>
                <li><a href="cari.php">Arama</a></li>
              </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fatura <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="fatura.php?do=yeni">Yeni Kayıt</a></li>
                <li><a href="fatura.php">Liste</a></li>
                <li><a href="fatura.php">Sil İptal</a></li>
                <li class="divider"></li>
                <li><a href="fatura.php">Arama</a></li>
              </ul>
            </li>  
              
             <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mağaza <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="magaza.php?do=ekle">Yeni Kayıt</a></li>
                <li><a href="magaza.php?do=arama">Liste</a></li>
                <li class="divider"></li>
                <li><a href="magaza.php?do=arama">Arama</a></li>
              </ul>
            </li>
            
            <li><a href="#"><?php _e('Listeler'); ?></a></li>
	    <li><a href="#"><?php _e('Teknik'); ?></a></li>
	    <li><a href="#"><?php _e('Tanımlar'); ?></a></li>
          
            <?php endif; ?>
            
            
          </ul>
         
          <ul class="nav pull-right">
            <li><a href="#">Yardım</a></li>
            <li class="divider-vertical"></li>
            <?php if(isset($_SESSION['jigowatt']['username'])) { ?>
           
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['jigowatt']['username']; ?><img src="./assets/images/user.png"> <b class="caret"></b></a>
              <ul class="dropdown-menu">
               <li><a href="profile.php"><i class="icon-user"></i> <?php _e('Hesabım'); ?></a></li>
		<li><a href="mailto:info@onlinearge.com"><i class="icon-info-sign"></i> <?php _e('Yardım'); ?></a></li>
		<li class="divider"></li>
		<li><a href="logout.php"><?php _e('Çıkış'); ?></a></li>
              </ul>
            </li>
    <?php        }
else { ?>
		<ul class="nav pull-right">
			<li><a href="login.php" class="signup-link"><em><?php _e('Hoşgeldiniz'); ?></em> <strong><?php _e('Giriş Yapın!'); ?></strong></a></li>
		</ul>
		<?php } ?>
          </ul>
        </div><!-- /.nav-collapse -->
      </div>
    </div><!-- /navbar-inner -->
  </div><!-- /navbar -->
  
  				
	
		
	

<!-- Main content
================================================== 
<div id="content">-->
<div class="container" style="width: auto;" >
			<div class="row">

				<div class="span2">

 <br><br><br>     