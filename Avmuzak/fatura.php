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


<div class="page secondary">
<img src="./assets/images/hesap.png" style="height: 50px;width: 50px" class="place-left"> <h2>Fatura Bölümü</h2>     
     
           

<div class="page snapped">
   

 <div id="sidebar1" class="">
<ul class="nav">
    <li><a class="btn btn-warning" href="#"><i class="cus-application"></i> Fatura Bölümü</a></li>
    <br><br>
<?php if( protectThis(1) ) : ?>
<li><a class="btn btn-large btn-success" href="fatura.php?do=yeni"><?php _e('Yeni Kayıt'); ?></a></li><br>
<li><a class="btn btn-large btn-danger" href="#"><?php _e('Sil İptal'); ?></a></li><br>
<li><a class="btn btn-large btn-info" href="fatura.php?do=liste"><?php _e('Tam Liste'); ?></a></li><br>
<li><a class="btn btn-large btn-inverse" href="fatura.php?do=arama"><?php _e('Arama'); ?></a></li><br>
<li><a href="#"><?php _e('');   ?></a></li>
</ul>
</div>
</div>
     

<div class="page fill">
  
<div class="span12">
  
    <br><br>
    
   
  
<?php // Yan menü bitiş  <span class="btn btn-large btn-warning fg-color-darken" style="background-color: transparent  ;filter:alpha(opacity=100);opacity:1;">
 endif; ?>
      
<?php 

// tüm liste

if(($_GET['do'] === "liste")  ): 
echo "<table>";
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
  
   <?php include_once('footer.php'); ?>