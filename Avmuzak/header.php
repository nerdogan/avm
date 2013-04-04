<?php ob_start(); ?>
<?php include_once('classes/translate.class.php'); ?>
<?php include_once('classes/check.class.php');  ?>
<?php if (!isset($_SESSION)) session_start(); error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE); 
date_default_timezone_set('Europe/Istanbul');  ?>
<!DOCTYPE html>
<html class="sidebar_default  no-js" lang="tr">
 
<head>
  <title>Avm Bilgi Sistemi 2013</title>

    <meta charset="utf-8">
    <meta name="description" content="Avm Mağaza Kontrol Sistemi 2013">
    <meta name="author" content="Namık ERDOĞAN">
    <meta name="keywords" content="Avm, Mağaza, Kontrol,yönetim, Sistemi, 2013">

  
     <script src="assets/js/jquery.ui.datepicker-tr.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
  <script src="assets/js/jquery.ui.datepicker-tr.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="shortcut icon" href="css/images/favicon.png">
<!-- Le styles -->
<link href="css/twitter/bootstrap.css" rel="stylesheet">
<link href="css/base.css" rel="stylesheet">
<link href="css/twitter/responsive.css" rel="stylesheet">
<link href="css/jquery-ui-1.8.23.custom.css" rel="stylesheet">
<script src="js/plugins/modernizr.custom.32549.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->

        
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

</head>

  <!-- 
            <ul class="menu" style="margin-top:10px">
                <li data-role="dropdown">
                    <a href="#">Avm Bilgi</a>
                    <ul class="dropdown-menu">
                        <li><a href="magaza.php">Mağaza</a></li>
                        <li><a href="cari.php">Cari</a></li>
                        <li><a href="fatura.php">Fatura</a></li>
                        <li><a href="banka.php">Banka</a></li>
                    </ul>
                    </li>
                    <li data-role="dropdown"> 
                     <a href="#">Hareket</a>
                    <ul class="dropdown-menu">
                        <li><a href="fatura.php">Fatura</a></li>
                        <li><a href="hareket.php?ne=odeme&do=yeni">Ödeme</a></li>
                        <li><a href="hareket.php?ne=tahsilat&do=yeni">Tahsilat</a></li>
                        <li><a href="#">Gelir-Gider Eşleme</a></li>
                        <li><a href="banka1.php">Banka</a></li>
                    </ul>
                </li>
                
                 <li data-role="dropdown"> 
                     <a href="#">Liste</a>
                    <ul class="dropdown-menu">
                        <li><a href="fatura.php?do=liste">Fatura</a></li>
                        <li><a href="cari.php">Cari Hesap</a></li>
                        <li><a href="banka.php">Banka</a></li>
                        <li><a href="#">Teminat Mektubu</a></li>
                    </ul>
                </li>
                
                 <li data-role="dropdown"> 
                     <a href="#">Tanımlar</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Döviz Kuru</a></li>
                        <li><a href="#">Tefe/Tüfe Oranı</a></li>
                        <li><a href="#">Ciro Takip</a></li>
                        <li><a href="#"></a></li>
                    </ul>
                </li>
                
                 <li data-role="dropdown"> 
                     <a href="#">Teknik</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Cihaz Kartları</a></li>
                        <li><a href="#">Bakım Çizelgesi</a></li>
                        <li><a href="#">Otomatik Uyarı ayarları</a></li>
                        <li><a href="#"></a></li>
                    </ul>
                </li>
                <li><a /></li>
                <li class="divider"></li>
                <li><a /></li>
            </ul>
            
            
           <a href="home.php" > 
               <img class="place-left" style="margin-top:5px;height: 35px;" src="./assets/images/Home2.png">  </a>
<a href="http://onlinearge.com" target="_blank" >  <img class="place-left" style="margin-top:5px;height: 35px" src="./assets/images/Globe.png"> </a>
<a href="mailto:info@onlinearge.com" > <img class="place-left" style="margin-top:5px;height: 35px" src="./assets/images/Mail.png">    </a>
                    
<!--        <div class="input-control text span3 place-right" style="margin:5px;height: 45px;">
        <input type="text" class="with-helper" />
        <button class="btn-search"></button>
        </div>
<span class="place-right" style="margin-top: 0px;margin-right: 25px">   
                    
               
  <?php if(isset($_SESSION['jigowatt']['username'])) { ?>
           
         <a href="#" class="dropdown-toggle place-right fg-color-darken" data-toggle="dropdown"  style="margin:5px 2px 0px 0px;">
        
             <?php echo $_SESSION['jigowatt']['gravatar']; ?>
          <?php echo "  ",$_SESSION['jigowatt']['name'],"  "; ?>
          <img src="./assets/images/down.png" style="margin:5px 0px 0px 2px;"> </a>
         <ul class="dropdown-menu place-right" style="margin-top: 0px;margin-right: 25px">
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
            
            
            
        </div>
    </div>
    <!--      menü   bitiş                                      
                   
                   
            
            
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
<div class="clearFix"></div>        </div></div> 
	

<?php
//require('rapor/makefont/makefont.php');

//MakeFont('tahoma.ttf','cp1254');
?> 
-->