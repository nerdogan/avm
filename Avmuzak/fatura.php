<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php');
// yan menu başlangıç?>
<?php if( !protectThis("*") ) :header( 'Location: login.php' );
endif; ?>

 <script type="text/javascript">
function goster(id) {
    document.getElementById(id).style.display = 'block';
}
function gizle(id) {
    document.getElementById(id).style.display = 'none';
}
function hesapla(id1, id2, id3) {
    document.getElementById(id3).value = ((document.getElementById(id1).value) * (document.getElementById(id2).value));
    var urun = (eval(document.getElementById('input_12').value) + eval(document.getElementById('input_1103').value) + eval(document.getElementById('input_1107').value) + eval(document.getElementById('input_1111').value) + eval(document.getElementById('input_1115').value));
    document.getElementById('top').innerHTML = urun;
    document.getElementById('kdv').innerHTML = urun * 18 / 100;
    document.getElementById('gtop').innerHTML = urun + (urun * 18 / 100);
    document.getElementById('toptop').value = urun;
    document.getElementById('kdvkdv').value = urun * 18 / 100;
    document.getElementById('gtopgtop').value = urun + (urun * 18 / 100);
}
$(".mennu").text("");
goster('anasayfa1');

</script>  


<body>
<div id="loading"><img src="img/ajax-loader.gif"></div>
<div id="responsive_part">
  <div class="logo"> <a href="home.php"><span>Start</span><span class="icon"></span></a> </div>
  <ul class="nav responsive">
    <li>
      <button class="btn responsive_menu icon_item" data-toggle="collapse" data-target=".overview"> <i class="icon-reorder"></i> </button>
    </li>
  </ul>
</div>
<!-- Responsive part -->

<div id="sidebar" class="">
  <div class="scrollbar">
    <div class="track">
      <div class="thumb">
        <div class="end"></div>
      </div>
    </div>
  </div>
  <div class="viewport ">
    <div class="overview collapse">
<!--      <div class="search row-fluid container"> 
        <h2>Arama</h2>
        <form class="form-search">
          <div class="input-append">
             <input type="text" class=" search-query" placeholder="">
            <button class="btn_search color_4">Arama</button>
          </div>
        </form>
      </div>    -->
      <ul id="sidebar_menu" class="navbar nav nav-list container full">
        <li class="accordion-group  color_4"> <a class="dashboard " href="home.php"><img src="img/menu_icons/dashboard.png"><span>Başlangıç</span></a> </li>
        
            
        <li class="accordion-group color_3 "> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse1">
                <img src="img/menu_icons/grid.png"><span>Mağaza</span></a>
          <ul id="collapse1" class="accordion-body collapse ">
              <li 
                  <?php if ($_GET['do']=="ekle"):echo "class='active'" ;endif; ?>
                      ><a href="magaza.php?do=ekle">Yeni Ekle</a></li>
              <li  <?php if ($_GET['do']=="arama"):echo "class='active'" ;endif; ?>><a href="magaza.php?do=arama">Ara</a></li>
              <li  <?php if ($_GET['do']=="sil"):echo "class='active'" ;endif; ?>><a href="magaza.php?do=sil">Sil</a></li>
              <li  <?php if ($_GET['do']=="liste"):echo "class='active'" ;endif; ?>><a href="magaza.php?do=liste">Tam Liste</a></li>
              
          </ul>
        </li>
        
        <li class="accordion-group color_8 active"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse2">
                <img src="img/menu_icons/calendar.png"><span>Cari</span></a>
          <ul id="collapse2" class="accordion-body collapse in ">
              <li 
                  <?php if ($_GET['do']=="ekle"):echo "class='active'" ;endif; ?>
                      ><a href="cari.php?do=ekle">Yeni Ekle</a></li>
              <li  <?php if ($_GET['do']=="arama"):echo "class='active'" ;endif; ?>><a href="cari.php?do=arama">Ara</a></li>
              <li  <?php if ($_GET['do']=="sil"):echo "class='active'" ;endif; ?>><a href="cari.php?do=sil">Sil</a></li>
              <li  <?php if ($_GET['do']=="liste"):echo "class='active'" ;endif; ?>><a href="cari.php?do=liste">Tam Liste</a></li>
              
          </ul>
        </li>
        <li class="color_24"> <a class="widgets"data-parent="#sidebar_menu" href="fatura.php"> <img src="img/menu_icons/statistics.png"><span>Fatura</span></a> </li>
        <li class="color_8"> <a class="widgets"data-parent="#sidebar_menu" href="banka.php"> <img src="img/menu_icons/gallery.png"><span>Banka</span></a> </li>
        
      
        <li class="accordion-group color_3"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse2"> <img src="img/menu_icons/widgets.png"><span>Hareketler</span></a>
          <ul id="collapse2" class="accordion-body collapse">
<li><a href="fatura.php">Fatura</a></li>
                        <li><a href="hareket.php?ne=odeme&do=yeni">Ödeme</a></li>
                        <li><a href="hareket.php?ne=tahsilat&do=yeni">Tahsilat</a></li>
                        <li><a href="#">Gelir-Gider Eşleme</a></li>
                        <li><a href="banka1.php">Banka</a></li>
              
          </ul>
        </li>
        
       
        <li class="accordion-group color_25"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse5">
                <img src="img/menu_icons/others.png"><span>Listeler</span></a>
          <ul id="collapse5" class="accordion-body collapse">
           <li><a href="fatura.php?do=liste">Fatura</a></li>
                        <li><a href="cari.php">Cari Hesap</a></li>
                        <li><a href="banka.php">Banka</a></li>
                        <li><a href="#">Teminat Mektubu</a></li>
            </ul>
        </li>
        
         <li class="accordion-group color_12"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse3">
                 <img src="img/menu_icons/tables.png"><span>Tanımlar</span></a>
          <ul id="collapse3" class="accordion-body collapse">
             <li><a href="#">Döviz Kuru</a></li>
                        <li><a href="#">Tefe/Tüfe Oranı</a></li>
                        <li><a href="#">Ciro Takip</a></li>
                        <li><a href="#"></a></li>
          </ul>
        </li>
        
         <li class="color_4"> <a class="widgets"data-parent="#sidebar_menu" href="#"> <img src="img/menu_icons/explorer.png"><span>Teknik</span> <!--  --></a> </li>
        
      </ul>
      <div class="menu_states row-fluid container ">
        <h2 class="pull-left">Menu Ayarları</h2>
        <div class="options pull-right">
          <button id="menu_state_1" class="color_4" rel="tooltip" data-state ="sidebar_icons" data-placement="top" data-original-title="Icon Menu">1</button>
          <button id="menu_state_2" class="color_4 active" rel="tooltip" data-state ="sidebar_default" data-placement="top" data-original-title="Fixed Menu">2</button>
          <button id="menu_state_3" class="color_4" rel="tooltip" data-placement="top" data-state ="sidebar_hover" data-original-title="Floating on Hover Menu">3</button>
        </div>
      </div>
      <!-- End sidebar_box --> 
      
    </div>
  </div>
</div>

<div id="main">
  <div class="container">
    <div class="header row-fluid">
      <div class="logo"> <a href="home.php"><span>Başlangıç</span><span class="icon"></span></a> </div>
      <div class="top_right">
        <ul class="nav nav_menu">
          <li class="dropdown"> <a class="dropdown-toggle administrator" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
            <div class="title"><span class="name">          <?php echo "  ",$_SESSION['jigowatt']['name'],"  "; ?></span>
                <span class="subtitle">          <?php echo "  ",$_SESSION['jigowatt']['username'],"  "; ?> </span></div>
            <span class="icon"><?php echo $_SESSION['jigowatt']['gravatar']; ?></span></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
              <li><a href="profile.php"><i class=" icon-user"></i> Hesabım</a></li>
               <li><a href="mailto:namikerdogan@crexist.com"><i class=" icon-flag"></i>Yardım</a></li>
              <li><a href="logout.php"><i class=" icon-unlock"></i>Çıkış</a></li>
             
            </ul>
          </li>
        </ul>
      </div>
      <!-- End top-right --> 
    </div>
    <div id="main_container">
        
       
      <div class="row-fluid">
          
          <div class="span12"> 
              <div class="box paint color_7"><div class="content">
          <img src="./assets/images/hesap.png" style="height: 50px;width: 50px" class="pull-left"> <h2>Fatura Bölümü</h2>     
          </div>   
      </div></div></div>


 
    
   
  
<?php // Yan menü bitiş  <span class="btn btn-large btn-warning fg-color-darken" style="background-color: transparent  ;filter:alpha(opacity=100);opacity:1;">
  ?>
      
<?php 

// tüm liste

if(($_GET['do'] === "liste")  ): 
echo "<table class='responsive table>";
    echo "<tr><td>Tarih</td><td>No</td><td style='width:300px'>Firma Adı</td><td style='width:120px'>Tutar</td><td>Not</td><td>Kod&nbsp;&nbsp;&nbsp; </td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
     $number=0;  
     $kackayit=$generic->query('SELECT magaza.kod,tarih,magaza.unvan,faturano,gtop,nott  FROM hareket INNER JOIN magaza ON  hareket.musno =  magaza.id');
     $toplam=0.0;
foreach($kackayit as $row) {
    $number++;
    echo "<tr class='",( ($number & 1) ? 'odd' : 'even' ),"'><td> ",$row[1],"</td><td> ",$row[3],"</td><td> ",$row[2],"</td><td> ",$row[4]," TL </td><td> ",$row[5],"</td><td>",$row[0],"</td><td><a class='fg-color-darken' href='magaza.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
    $toplam+=$row[4];
    }
 echo "<tr class='",( ($number & 1) ? 'even' : 'odd' ),"'><td> </td><td> </td><td>Toplam : </td><td> ",$toplam," TL </td><td> </td><td></td><td></td><td></td></tr>" ;    
echo '</table';  

    
endif; 
 // listeleme sonu

// Ekleme ve Düzenleme   
if(($_GET['do'] === "yeni")  ): ?>

<form class="" action="fatura.php" method="post" name="formekle" id="formekle" accept-charset="utf-8">
  <input type="hidden" name="formID" value="30133819675356" />
  <div class="form-all">
   
    <div class="form-header-group">
          <h3 id="header_1" class="form-header">
              Fatura &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a class="btn btn-success" href="#" onclick="document.getElementById('formekle').submit()"><i class="icon-ok icon-white"></i> KAYDET </a>
               </h3>
        </div>
   
            
    
        
<table border="0" cellpadding="0" cellspacing="1" style="width: 710px">
<tbody>
<tr>
    <td style="width: 500px">
<?php 
         
 //     if ($_GET['id']) : {
//     $elma=$_GET['id'];
//     $param=array (':ad'=> $elma ); 
// foreach($generic->query('SELECT * FROM magaza WHERE id=:ad',$param) as $row) {
 //   echo $row['kod']," -  ",$row['ad'],"<br>  ",$row['unvan'];
// }
  //    } 
//else :{
     echo "<select style='width:500px' name='firma'><option value='.'>Firma Seç</option>";
     foreach($generic->query('SELECT * FROM magaza') as $row) {
        echo "<option value='",$row['id'],"'", ($_GET['id']==$row['id'])? "selected" : "";
        echo ">", $row['kod']," -  "," ",$row['unvan'],"</option>\n";
        }
     echo "</select><p>";
//}
//endif;
     
 ?>
        
        
    </td> <td> &nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="width: 120px">     
      
    Tarih :
        <div id="cid_99" class="form-input">
              <input type="text"  id="datepicker"  name="tarih" style="width: 90px" /> 
        </div>
     
</tr><tr>
    <td> </td> <td> </td>
        <td>Fatura Tipi:
        <div id="cid_6" class="form-input">
          <select class="form-dropdown" style="width:100px" id="input_5" name="turu">
            <option>Seçiniz</option>
            <option value="1">ALIŞ </option>
            <option value="2">SATIŞ </option>
            <option value="3">ALIŞ İADE</option>
            <option value="4">SATIŞ İADE</option>
            
          </select>
        </div>
     
   </td>
</tr>
<tr>
  <td> </td> <td> </td> 
   <td> 
Fatura No:
<div id="cid_4" class="form-input">
<input type="text" class="" id="input_3" name="faturano"  style="width: 90px" />
</div>

</td>
</tr>

</tbody>
</table><br><br>

 <table border="0" cellpadding="0" cellspacing="1" style="width: 660px">
<tbody>

 <tr>
 <td>   
  <label class="form-label-left" id="label_5" for="input_4" style="width: 150px">Tanımlama</label>
</td>
 <td style="width: 60px"><label class="form-label-left" id="label_14" for="input_10">Miktar</label>
 </td>
 <td style="width: 60px"><label class="form-label-left" id="label_16" for="input_11">Fiyat</label>
 </td>
 <td style="width: 100px"><label class="form-label-left" id="label_15" for="input_12">Tutar</label>
 </td>
 <td style="width: 70px">&nbsp; </td>
       </tr>     
          
          
       
   
            
      
   </tbody>
</table> 

<table border="0" cellpadding="0" cellspacing="1" style="width: 660px">
<tbody>
<tr>
<td><input type="text" class="form-textbox" id="input_4" name="tanim1" style="width: 350px" /></td>
<td style="width: 60px"><input type="text" class="form-textbox" id="input_10" name="miktar1" style="width: 50px" value="1" onkeyup="hesapla('input_10','input_11','input_12')"/>
</td>
<td style="width: 60px"><input type="text" class="form-textbox" id="input_11" name="fiyat1" style="width: 50px" onkeyup="hesapla('input_10','input_11','input_12')"/>
</td>
<td style="width: 100px"><input type="text" class="form-textbox" id="input_12" name="tutar1" style="width: 100px" value="0" />
</td><td>&nbsp;</td><td style="width:70px"><span id="ekle1" class="badge badge-info"  onclick="goster('cid_116');gizle('ekle1')">EKLE</span>
</td>
</tr>
</tbody>
</table> 

  <table id="cid_116" border="0" cellpadding="0" cellspacing="1" style="width: 660px;display: none">
<tbody>

 <tr>
 <td>   
 <input type="text" class="form-textbox" id="input_1100" name="tanim2" style="width: 350px"  />
</td>
 <td style="width: 60px">
 <input type="text" class="form-textbox" id="input_1101" name="miktar2" style="width: 50px" value="1" onkeyup="hesapla('input_1101','input_1102','input_1103')"/>
 </td>
 <td style="width: 60px">
 <input type="text" class="form-textbox" id="input_1102" name="fiyat2" style="width: 50px" onkeyup="hesapla('input_1101','input_1102','input_1103')"/>
 </td>
 <td style="width: 100px">
<input type="text" class="form-textbox" id="input_1103" name="tutar2" style="width: 100px" value="0" />
</td>
<td style="width: 70px">&nbsp;<span id="ekle2" class="badge badge-info" onclick="goster('cid_117');gizle('ekle2')">EKLE</span></td>
       </tr>     
          
          
       
   
            
      
   </tbody>
</table> 
 <table id="cid_117" border="0" cellpadding="0" cellspacing="1" style="width: 660px;display: none">
<tbody>

 <tr>
 <td>   
 <input type="text" class="form-textbox" id="input_1104"  name="tanim3" style="width: 350px" />
</td>
 <td>
 <input type="text" class="form-textbox" id="input_1105" name="miktar3" style="width: 50px" value="1" onkeyup="hesapla('input_1105','input_1106','input_1107')"/>
 </td>
 <td>
 <input type="text" class="form-textbox" id="input_1106" name="fiyat3" style="width: 50px" onkeyup="hesapla('input_1105','input_1106','input_1107')"/>
 </td>
 <td>
 <input type="text" class="form-textbox" id="input_1107" name="tutar3" style="width: 100px" value="0" />
 </td>
<td>&nbsp;<span id="ekle3" class="badge badge-info" onclick="goster('cid_118');gizle('ekle3')">EKLE</span></td>
</tr>     
</tbody>
</table> 
 <table id="cid_118" border="0" cellpadding="0" cellspacing="1" style="width: 660px;display: none">
<tbody>

 <tr>
 <td>   
 <input type="text" class="form-textbox" id="input_1108" name="tanim4" style="width: 350px" />
</td>
 <td>
 <input type="text" class="form-textbox" id="input_1109" name="miktar4" style="width: 50px" value="1" onkeyup="hesapla('input_1109','input_1110','input_1111')"/>
 </td>
 <td>
 <input type="text" class="form-textbox" id="input_1110" name="fiyat4" style="width: 50px" onkeyup="hesapla('input_1109','input_1110','input_1111')" />
 </td>
 <td>
 <input type="text" class="form-textbox" id="input_1111" name="tutar4" style="width: 100px" value="0" />
 </td>
<td>&nbsp;<span id="ekle4" class="badge badge-info" onclick="goster('cid_119');gizle('ekle4')">EKLE</span></td>
</tr>     
</tbody>
</table> 
 <table id="cid_119" border="0" cellpadding="0" cellspacing="1" style="width: 660px;display: none">
<tbody>

 <tr>
 <td>   
 <input type="text" class="form-textbox" id="input_1112" name="tanim5" style="width: 350px" />
</td>
 <td>
 <input type="text" class="form-textbox" id="input_1113" name="miktar5" style="width: 50px" value="1" onkeyup="hesapla('input_1113','input_1114','input_1115')" />
 </td>
 <td>
 <input type="text" class="form-textbox" id="input_1114" name="fiyat5" style="width: 50px" onkeyup="hesapla('input_1113','input_1114','input_1115')" />
 </td>
 <td>
 <input type="text" class="form-textbox" id="input_1115" name="tutar5" style="width: 100px" value="0" />
 </td>
<td>&nbsp;<span id="ekle5" class="badge badge-info" onclick="goster('cid_120');gizle('ekle5')"></span></td>
</tr>     
</tbody>
</table> 

<hr style="margin-bottom: 10px;margin-top: 10px;border-bottom-color: #2f96b4;width: 710px">

 <table id="cid_119" border="0" cellpadding="0" cellspacing="1" style="width: 710px">
<tbody>

 <tr>
 <td>   
<TEXTAREA NAME="not" ROWS="3" COLS="65" style="width: 350px"></TEXTAREA>
</td>
<td>
 <!-- fatura alt toplamını kdv işlemi -->
    <table>
 <tr>
     <td> Toplam :</td><td><span id="top"> 0 </span>&nbsp; TL</td>
      
</tr>
<tr>
     <td> KDV :</td><td><span id="kdv"> 0 </span>&nbsp; TL</td>
</tr><tr>
    <td > Genel Toplam :</td><td><span id="gtop"> 0 </span>&nbsp; TL</td>
</tr>
</table>
</tr>
  
    
</tbody>
</table> 
<input type="hidden" name="toplam" id="toptop" >
<input type="hidden" name="kdv" id="kdvkdv">
<input type="hidden" name="gtop" id="gtopgtop">

 
</form> 
</div>


        <?php endif;  ?>
   
     
     <?php if($_GET['do'] === "duzenle"): ?>
      <?php 
     if ($_GET['id']) : {
     $elma=$_GET['id'];
     $param=array (':ad'=> $elma ); 
foreach($generic->query('SELECT * FROM magaza WHERE id=:ad',$param) as $row) {
      
    for ( $counter = 2; $counter <= 15; $counter += 1) {
        
	
$idd=$row[$counter-1];
         $elma="<script>   document.getElementById('input_";
          echo $elma,$counter,"').value='",$idd,"'</script>"; 
     
    }    
    
}        
     }

endif;
      
      
     ?>
        
        
     
     
     
      
     <?php endif ; ?>
        <?php 
     
//$dsn = 'mysql:host=localhost;dbname=arge_avm';
//$user = 'arge_av';
//$password = 'nmk171717';
 
//try {
 //   $magaza = new PDO($dsn, $user, $password);
//} catch (PDOException $e) {
  //  echo 'Connection failed: ' . $e->getMessage();
//}




 if(isset($_POST['faturano'])) :
     
    		
			$musno = $generic->secure($_POST['firma']);
                        $tarih = $generic->secure($_POST['tarih']);
                        $turu = $generic->secure($_POST['turu']);
                        $faturano = $generic->secure($_POST['faturano']);
                        $nott = $generic->secure($_POST['not']);
                        $top=$generic->secure($_POST['toplam']);
                        $kdv=$generic->secure($_POST['kdv']);
                        $gtop=$generic->secure($_POST['gtop']);
                        switch ($turu) {
    case "1":
        $alacak=$gtop;
        $borc="0";
        break;
    
    case "2":
        $alacak="0";
        $borc=$gtop;
        break;
    case "3":
        $alacak="0";
        $borc=$gtop;
        break;
    case "4":
        $alacak=$gtop;
        $borc="0";
        break;
                        }            
                        
                        $tanim1 = $generic->secure($_POST['tanim1']);
                        $tanim2 = $generic->secure($_POST['tanim2']);
                        $tanim3 = $generic->secure($_POST['tanim3']);
                        $tanim4 = $generic->secure($_POST['tanim4']);
                        $tanim5 = $generic->secure($_POST['tanim5']);
                        $miktar1 = $generic->secure($_POST['miktar1']);
                        $miktar2 = $generic->secure($_POST['miktar2']);
                        $miktar3 = $generic->secure($_POST['miktar3']);
                        $miktar4 = $generic->secure($_POST['miktar4']);
                        $miktar5 = $generic->secure($_POST['miktar5']);
                        $fiyat1 = $generic->secure($_POST['fiyat1']);
                        $fiyat2 = $generic->secure($_POST['fiyat2']);
                        $fiyat3 = $generic->secure($_POST['fiyat3']);
                        $fiyat4 = $generic->secure($_POST['fiyat4']);
                        $fiyat5 = $generic->secure($_POST['fiyat5']);
                        
                        $idd="";
                        $param=array (':firma'=>$musno,':tarih'=>$tarih,':turu'=>$turu,
                            ':faturano' => $faturano,':nott'=>$nott,':top'=>$top,
                            ':kdv'=>$kdv,':gtop'=>$gtop ,':borc'=>$borc,':alacak'=>$alacak   );
                       $okmu= $generic->query('INSERT INTO hareket (musno,tarih,turu,faturano,top,kdv,gtop,nott,borc,alacak) VALUES ( :firma , :tarih,:turu,:faturano,:top,:kdv,:gtop,:nott,:borc,:alacak)',$param);
		//	$this->token = !empty($_POST['token']) ? $_POST['token'] : '';
		//	$this->process();
              if ($okmu->rowCount()==1): echo"kaydedildi";  header( 'Location: fatura.php?do=liste' ) ; endif;

		endif;
                ?>
        
        <?php
      
        
        ?>
        
       

        
        
    </span>  
       </div></div>    
  
    <div id="footer" style="position: fixed;bottom: 0px">
    <p> &copy; 2013 Crexist Inc.   info@crexist.com  2013 | v.1.2.0 </p>
    <span class="company_logo"><a href="http://www.crexist.com"></a></span> </div>
</div>
<div class="background_changer dropdown">
  <div class="dropdown" id="colors_pallete"> <a data-toggle="dropdown" data-target="drop4" class="change_color"></a>
    <ul  class="dropdown-menu pull-left" role="menu" aria-labelledby="drop4">
      <li><a data-color="color_0" class="color_0" tabindex="-1">1</a></li>
      <li><a data-color="color_1" class="color_1" tabindex="-1">1</a></li>
      <li><a data-color="color_2" class="color_2" tabindex="-1">2</a></li>
      <li><a data-color="color_3" class="color_3" tabindex="-1">3</a></li>
      <li><a data-color="color_4" class="color_4" tabindex="-1">4</a></li>
      <li><a data-color="color_5" class="color_5" tabindex="-1">5</a></li>
      <li><a data-color="color_6" class="color_6" tabindex="-1">6</a></li>
      <li><a data-color="color_7" class="color_7" tabindex="-1">7</a></li>
      <li><a data-color="color_8" class="color_8" tabindex="-1">8</a></li>
      <li><a data-color="color_9" class="color_9" tabindex="-1">9</a></li>
      <li><a data-color="color_10" class="color_10" tabindex="-1">10</a></li>
      <li><a data-color="color_11" class="color_11" tabindex="-1">10</a></li>
      <li><a data-color="color_12" class="color_12" tabindex="-1">12</a></li>
      <li><a data-color="color_13" class="color_13" tabindex="-1">13</a></li>
      <li><a data-color="color_14" class="color_14" tabindex="-1">14</a></li>
      <li><a data-color="color_15" class="color_15" tabindex="-1">15</a></li>
      <li><a data-color="color_16" class="color_16" tabindex="-1">16</a></li>
      <li><a data-color="color_17" class="color_17" tabindex="-1">17</a></li>
      <li><a data-color="color_18" class="color_18" tabindex="-1">18</a></li>
      <li><a data-color="color_19" class="color_19" tabindex="-1">19</a></li>
      <li><a data-color="color_20" class="color_20" tabindex="-1">20</a></li>
      <li><a data-color="color_21" class="color_21" tabindex="-1">21</a></li>
      <li><a data-color="color_22" class="color_22" tabindex="-1">22</a></li>
      <li><a data-color="color_23" class="color_23" tabindex="-1">23</a></li>
      <li><a data-color="color_24" class="color_24" tabindex="-1">24</a></li>
      <li><a data-color="color_25" class="color_25" tabindex="-1">25</a></li>
    </ul>
  </div>
</div>
<!-- End .background_changer -->
</div>
<!-- /container --> 

<!-- Le javascript
    ================================================== --> 
<!-- General scripts --> 
<script src="js/jquery.js" type="text/javascript"> </script> 
<!--[if !IE]> -->
<!--[if !IE]> -->
<script src="js/plugins/enquire.min.js" type="text/javascript"></script> 
<!-- <![endif]-->
<!-- <![endif]-->
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript" src="js/plugins/jquery.sparkline.min.js"></script> 
<script src="js/plugins/excanvas.compiled.js"></script>
<script src="js/bootstrap-transition.js" type="text/javascript"></script> 
<script src="js/bootstrap-alert.js" type="text/javascript"></script> 
<script src="js/bootstrap-modal.js" type="text/javascript"></script> 
<script src="js/bootstrap-dropdown.js" type="text/javascript"></script> 
<script src="js/bootstrap-scrollspy.js" type="text/javascript"></script> 
<script src="js/bootstrap-tab.js" type="text/javascript"></script> 
<script src="js/bootstrap-tooltip.js" type="text/javascript"></script> 
<script src="js/bootstrap-popover.js" type="text/javascript"></script> 
<script src="js/bootstrap-button.js" type="text/javascript"></script> 
<script src="js/bootstrap-collapse.js" type="text/javascript"></script> 
<script src="js/bootstrap-carousel.js" type="text/javascript"></script> 
<script src="js/bootstrap-typeahead.js" type="text/javascript"></script> 
<script src="js/bootstrap-affix.js" type="text/javascript"></script> 
<script src="js/fileinput.jquery.js" type="text/javascript"></script> 
<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script> 
<script src="js/jquery.touchdown.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.uniform.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.tinyscrollbar.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/jnavigate.jquery.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/jquery.touchSwipe.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.peity.min.js"></script> 

<!-- Flot charts --> 
<script language="javascript" type="text/javascript" src="js/plugins/flot/jquery.flot.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/flot/jquery.flot.resize.js"></script> 

<!-- Data tables --> 
<script type="text/javascript" language="javascript" src="js/plugins/datatables/js/jquery.dataTables.js"></script> 

<!-- Task plugin --> 
<script language="javascript" type="text/javascript" src="js/plugins/knockout-2.0.0.js"></script> 

<!-- Custom made scripts for this template --> 
<script src="js/scripts.js" type="text/javascript"></script> 

</body>
</html>
    
    
    
    
 <?php ob_flush(); ?>   
   