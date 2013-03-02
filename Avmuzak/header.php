<?php ob_start(); ?>
<?php include_once('classes/translate.class.php'); ?>
<?php include_once('classes/check.class.php');  ?>
<?php if (!isset($_SESSION)) session_start(); error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE); 
date_default_timezone_set('Europe/Istanbul'); ?>
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
    <link rel="stylesheet" href="assets/css/jquery-ui.css" />
    <script src="assets/js/jquery-ui.js"></script> 
     <script src="assets/js/jquery.ui.datepicker-tr.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        
   <SCRIPT language=JavaScript>
function saatigoster() {
    var d,
    saat_,
    dakika_,
    saniye_,
    x1,
    x2,
    s;
    d = new Date();
    saat_ = d.getHours();
    if (saat_.toString(10).length == 1) {
        saat_ = "0" + saat_;
    }
    dakika_ = d.getMinutes();
    if (dakika_.toString(10).length == 1) {
        dakika_ = "0" + dakika_;
    }
    saniye_ = d.getSeconds();
    if (saniye_.toString(10).length == 1) {
        saniye_ = "0" + saniye_;
    }
    s = saat_ + ":" + dakika_;
    saat.innerText = s;
}
</SCRIPT>     
    <script>
 $(function() {

    $("#datepicker").datepicker({
});

});


  </script>   
 <style>
  .ui-menu { width: 100px; }
  </style>
  <script>
  $(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
            "If this ." );
        });
      }
    });
  });
  </script>
 <script>
  $(function() {
    $( document.body ).tooltip();
  });
  </script> 

    <title>Avm Bilgi Sistemi 2013</title>
</head>
<body class="modern-ui" onload="prettyPrint()">
    
    
    <div class="page" >
        <div class="page-header " >
            <a href="home.php" >    <h4 id="anasayfa1" class="place-left hide" style="margin-left: 50px">Avm Bilgi Sistemi</h4></a>
            <div class="span3" style="margin-left: 50px" > <a href="home.php"><h1 class="fg-color-darken mennu" ><?php _e('Avm Bilgi <br>&nbsp;Sistemi'); ?></h1></a></div>
           
            <div class="clearFix"></div>
            
           
                
         
                     
	<div id="nav1_slim">
		<ul>
			
                   
		 	<li><a href="#">Avm Menü</a>
                    <ul>
					<li><a href="magaza.php">Mağaza</a></li>
					<li><a href="cari.php">Hareket</a></li>
					<li><a href="fatura.php">Liste</a></li>
                                     
			   </ul>
                    </li>
                    
                    <li><a href="#" id="active">Sistem Bilgi</a></li> 
                    <li><a  data-toggle="modal" href="#hakk1">Hakkımızda</a></li>
			
			
		</ul>
	</div>
	
<div id="hakk1" class="modal hide fade">
	<div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
        </div>
    
	<div class="modal-body">
            <div id="message"><h2>Hakkında...</h2></div>
            <label>
            <?php _e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consectetur ornare scelerisque. Aliquam purus felis, molestie quis ullamcorper vel, accumsan a magna. Etiam venenatis ullamcorper tortor eget semper. Duis purus neque, fermentum eu porttitor nec, luctus pharetra nibh. Maecenas at ligula nulla, eget pellentesque eros. Donec quis enim et massa ultrices vehicula. Praesent porta blandit nibh ut scelerisque.
Pellentesque condimentum, arcu eget posuere tristique, leo urna malesuada felis, nec posuere lacus velit eu nunc. Morbi dui libero, accumsan in consectetur mollis, porttitor vitae ligula. Mauris luctus, velit sit amet fringilla scelerisque, enim elit laoreet ante, at mattis velit massa id arcu. Proin dolor velit, commodo quis mattis a, porta lobortis nunc. Phasellus eleifend venenatis tempor. Nunc euismod lacus sagittis turpis ornare ac elementum sem molestie. Aliquam suscipit mattis sem quis mollis.'); ?>
            </label>
 	</div>
 </div>
	

<div class="clearFix"></div>
            
      <span class="place-right" style="margin-top: -10px;margin-right: 25px">            
               
  <?php if(isset($_SESSION['jigowatt']['username'])) { ?>
           
               <a href="#" class="dropdown-toggle place-right fg-color-grayDark" data-toggle="dropdown" ><?php echo $_SESSION['jigowatt']['name']; ?><img src="./assets/images/user.png"> <b class="caret"></b></a>
              <ul class="dropdown-menu place-right" >
               <li><a href="profile.php"><i class="icon-user"></i> <?php _e('Hesabım'); ?></a></li>
		<li><a href="mailto:info@onlinearge.com"><i class="icon-info-sign"></i> <?php _e('Yardım'); ?></a></li>
		<li class="divider"></li>
		<li><a href="logout.php"><?php _e('Çıkış'); ?></a></li>
              </ul>
          
    <?php       } 
else { ?>
		<ul class="nav pull-right">
		<li><a href="login.php" class="signup-link"><em class="fg-color-orangeDark"></em> <strong class="fg-color-orangeDark"></strong></a></li>
		</ul>
		<?php } ?>
            </span>
        </div></div> 
	
		<?php  
               function toUpperCase( $input ){	
return strtoupper( strtr( $input,'ğüşıiöç', 'ĞÜŞIİÖÇ') );
}

function toLowerCase( $input ){	
return strtolower(strtr( $input,'ĞÜŞIİÖÇ','ğüşıiöç'));
}


?>
<?php
//require('rapor/makefont/makefont.php');

//MakeFont('tahoma.ttf','cp1254');
?> 
