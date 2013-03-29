<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php');
// yan menu başlangıç?>
<?php if( !protectThis("*") ) :header( 'Location: login.php' );
endif; 
if ( $_GET['ne']=="odeme"):$bolum="Ödeme";
endif;
if ( $_GET['ne']=="tahsilat"):$bolum="Tahsilat";
endif;
        
?>

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
<img src="./assets/images/hesap.png" style="height: 50px;width: 50px" class="place-left"> <h2> <?php echo $bolum ?> Bölümü</h2>     
     
           

<div class="page snapped">
   

 <div id="sidebar1" class="">
<ul class="nav">
    <li><a class="btn btn-warning" href="#"><i class="cus-application"></i> <?php echo $bolum ?> Bölümü</a></li>
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

<form class="" action="hareket.php" method="post" name="formekle" id="formekle" accept-charset="utf-8">
  <input type="hidden" name="formID" value="30133819675356" />
  <input type="hidden" name="bolum" value="<?php echo $bolum ?>" />
  <div class="form-all">
   
    <div class="form-header-group">
          <h3 id="header_1" class="form-header">
<?php echo $bolum ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a class="btn btn-success" href="#" onclick="document.getElementById('formekle').submit()"><i class="icon-ok icon-white"></i> KAYDET </a>
               </h3>
        </div>
   
            
 <hr style="margin-bottom: 10px;margin-top: 10px;border-bottom-color: #2f96b4;width: 710px">   
        
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
        
        
    </td> <td> </td>
<td style="width: 120px">     
      
    Tarih :
        <div id="cid_99" class="form-input">
              <input type="text"  id="datepicker"  name="tarih" style="width: 90px" /> 
        </div>
     
</tr><tr>
    <td>
        Ödeme Şekli:
        <div id="cid_6" class="form-input">
          <select class="form-dropdown" style="width:150px" id="input_5" name="odemesekli">
            <option>Seçiniz</option>
            <option value="1">NAKİT </option>
            <option value="2">KREDİ KARTI </option>
            
            
          </select>
        </div>
 
    </td> 
    <td>
        
    </td>
    <td>
        Belge No:<div id="cid_4" class="form-input">
        <input type="text" class="" id="input_3" name="faturano"  style="width: 90px" />
        </div>
    </td>
</tr>
<tr>
  <td>       <TEXTAREA NAME="not" ROWS="3" COLS="65" style="width: 350px" title="Açıklama" > </TEXTAREA> </td> 
  <td> </td>
  <td>
Tutar:<div id="cid_4" class="form-input">
<input type="text" class="" id="input_897" name="gtop"  style="width: 90px" />
</div> 
 </td>
</tr>

</tbody>
</table><br><br>




 
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
                        $top=$generic->secure($_POST['odemesekli']);
                        $bolum=$generic->secure($_POST['bolum']);
                        $gtop=$generic->secure($_POST['gtop']);
                        $kdv="";
                        
                        switch ($bolum) {
    case "Tahsilat":
        $alacak=$gtop;
        $borc="0";
        $turu="6";
        break;
    
    case "Ödeme":
        $alacak="0";
        $borc=$gtop;
        $turu="5";
        break;
                        }            
                        
                        
                        
                        $idd="";
                        $param=array (':firma'=>$musno,':tarih'=>$tarih,':turu'=>$turu,
                            ':faturano' => $faturano,':nott'=>$nott,':top'=>$top,
                            ':kdv'=>$kdv,':gtop'=>$gtop ,':borc'=>$borc,':alacak'=>$alacak   );
                       $okmu= $generic->query('INSERT INTO hareket (musno,tarih,turu,faturano,odemesekli,kdv,gtop,nott,borc,alacak) VALUES ( :firma , :tarih,:turu,:faturano,:top,:kdv,:gtop,:nott,:borc,:alacak)',$param);
		//	$this->token = !empty($_POST['token']) ? $_POST['token'] : '';
		//	$this->process();
              if ($okmu->rowCount()==1): echo"kaydedildi"; 
// header( 'Location: hareket.php?do=liste' ) ;
 endif;

		endif;
                ?>
        
        <?php
      
        
        ?>
        
       

        
        
    </span>  
       </div></div>    
  
   <?php include_once('footer.php'); ?>