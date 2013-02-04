<?php ob_start(); ?>
<?php include_once('classes/translate.class.php'); ?>
<?php include_once('classes/check.class.php'); ?>
<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="tr">    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="description" content="Avm Mağaza Kontrol Sistemi 2013">
    <meta name="author" content="Namık ERDOĞAN">
    <meta name="keywords" content="Avm, Mağaza, Kontrol,yönetim, Sistemi, 2013">

    <link href="assets/css/modern.css" rel="stylesheet">
    <link href="assets/css/modern-responsive.css" rel="stylesheet">
    <link href="assets/css/site.css" rel="stylesheet" type="text/css">
    <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="assets/js/assets/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="assets/js/assets/jquery.mousewheel.min.js"></script>

    <script type="text/javascript" src="assets/js/modern/dropdown.js"></script>
    <script type="text/javascript" src="assets/js/modern/accordion.js"></script>
    <script type="text/javascript" src="assets/js/modern/buttonset.js"></script>
    <script type="text/javascript" src="assets/js/modern/carousel.js"></script>
    <script type="text/javascript" src="assets/js/modern/input-control.js"></script>
    <script type="text/javascript" src="assets/js/modern/pagecontrol.js"></script>
    <script type="text/javascript" src="assets/js/modern/rating.js"></script>
    <script type="text/javascript" src="assets/js/modern/slider.js"></script>
    <script type="text/javascript" src="assets/js/modern/tile-slider.js"></script>
    <script type="text/javascript" src="assets/js/modern/tile-drag.js"></script>
    <link rel="stylesheet" href="assets/css/jquery-ui-1.10.0.custom.min.css" />
    <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
     <script src="assets/js/jquery.ui.datepicker-tr.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        
        
    <script>
  $(function() {
    
    $( "#datepicker" ).datepicker({
        
    });
    
    
  });
  </script>    

    <title>Avm Mağaza Kontrol Sistemi 2013</title>
</head>
<body class="modern-ui" onload="prettyPrint()">
    
    
    <div class="page" >
        <div class="page-header " >
            
      <div class="span5" > <h1 class="fg-color-white"><?php _e('AVM Manager'); ?></h1></div>
      <div class="span3 place-right" >            
               
  <?php if(isset($_SESSION['jigowatt']['username'])) { ?>
           
               <a href="#" class="dropdown-toggle place-right" data-toggle="dropdown" ><?php echo $_SESSION['jigowatt']['name']; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu place-right" >
               <li><a href="profile.php"><i class="icon-user"></i> <?php _e('Hesabım'); ?></a></li>
		<li><a href="mailto:info@onlinearge.com"><i class="icon-info-sign"></i> <?php _e('Yardım'); ?></a></li>
		<li class="divider"></li>
		<li><a href="logout.php"><?php _e('Çıkış'); ?></a></li>
              </ul>
          
    <?php        }
else { ?>
		<ul class="nav pull-right">
		<li><a href="login.php" class="signup-link"><em><?php _e('Hoşgeldiniz'); ?></em> <strong><?php _e('Giriş Yapın!'); ?></strong></a></li>
		</ul>
		<?php } ?>
            </div>
        </div></div> 
