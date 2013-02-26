<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php');
// yan menu başlangıç?>
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

</script>  
<div class="page secondary">
     
     
           

<div class="page snapped">
   

 <div id="sidebar1" class="">
<ul class="nav">
    <li><a class="btn btn-warning" href="#"><i class="cus-application"></i> Banka Bölümü</a></li>
    <br><br>
<?php if( protectThis(1) ) : ?>
<li><a class="btn btn-large btn-success" href="banka.php?do=yeni"><?php _e('Yeni Kayıt'); ?></a></li><br>
<li><a class="btn btn-large btn-danger" href="#"><?php _e('Sil İptal'); ?></a></li><br>
<li><a class="btn btn-large btn-info" href="banka.php?do=liste"><?php _e('Tam Liste'); ?></a></li><br>
<li><a href="#"><?php _e('');   ?></a></li>
</ul>
</div>
</div>
     

<div class="page fill">
  
<div class="span12">
  
   
    
    <span class="btn btn-large btn-warning">
  
<?php // Yan menü bitiş
 endif;
 if(($_GET['msg'] === "1")): $generic->displayMessage(sprintf('<div class="alert alert-success">' . _('Başarıyla kaydedildi. ('). ')</div>'),FALSE);
 endif;
 ?>
      
<?php 

$id = $_POST['id'];
$bankaadi = $_POST['bankaadi'];
$hesapsahibi = $_POST['hesapsahibi'];
$subeadi = $_POST['subeadi'];
$hesapno = $_POST['hesapno'];
$parabirimi = $_POST['parabirimi'];
$telefon1 = $_POST['telefon1'];
$telefon2 = $_POST['telefon2'];
$faks = $_POST['faks'];
$notlar = $_POST['notlar'];
$hesapbakiye = $_POST['hesapbakiye'];
$iban = $_POST['iban'];
$email = $_POST['email'];
$param = array (':id'=>$id,':bankaadi'=>$bankaadi,':hesapsahibi'=>$hesapsahibi,':subeadi'=>$subeadi,':hesapno'=>$hesapno,':parabirimi'=>$parabirimi,':telefon1'=>$telefon1,':telefon2'=>$telefon2,':faks'=>$faks,':notlar'=>$notlar,':hesapbakiye'=>$hesapbakiye,':iban'=>$iban,':email'=>$email);
if (!empty($bankaadi)){
$query11 = "INSERT INTO bankakart (id,bankaadi,hesapsahibi,subeadi,hesapno,parabirimi,telefon1,telefon2,faks,notlar,hesapbakiye,iban,email) VALUES ( :id,:bankaadi,:hesapsahibi,:subeadi,:hesapno,:parabirimi,:telefon1,:telefon2,:faks,:notlar,:hesapbakiye,:iban,:email )";
$result = $generic->query($query11, $param);
 if ($result->rowCount()==1): echo"kaydedildi";  header( 'Location: banka.php?do=liste&msg=1' ) ; endif;
}

 
 
 

// tüm liste

if(($_GET['do'] === "liste")  ): 
echo "<table>";
    echo "<tr><td>Tarih</td><td>No</td><td>Firma Adı</td><td style='width:150px'>Tutar</td><td>Not</td><td>Kod&nbsp;&nbsp;&nbsp; </td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
     $number=0;  
     $kackayit=$generic->query('SELECT *  FROM bankakart ');
     $toplam=0.0;
foreach($kackayit as $row) {
    $number++;
    echo "<tr class='",( ($number & 1) ? 'success' : 'info' ),"'><td> ",$row[1],"</td><td> ",$row[3],"</td><td> ",$row[2],"</td><td> ",$row[4]," TL </td><td> ",$row[5],"</td><td>",$row[0],"</td><td>",$row[6],"</td><td><a href='magaza.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
    $toplam+=$row[4];
    }
 echo "<tr class='",( ($number & 1) ? 'success' : 'info' ),"'><td> </td><td> </td><td>Toplam : </td><td> ",$toplam," TL </td><td> </td><td></td><td></td><td></td></tr>" ;    
echo '</table';  

    
endif; 
 // listeleme sonu

// Ekleme ve Düzenleme   
if(($_GET['do'] === "yeni")  ): ?>

<form class="" action="banka.php" method="post" name="formbanka" id="formekle" accept-charset="utf-8">
  <input type="hidden" name="formID" value="30133819675356" />
  <div class="form-all">
   
    <div class="form-header-group">
          <h3 id="header_1" class="form-header">
              Banka &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a class="btn btn-success" href="#" onclick="document.getElementById('formekle').submit()"><i class="icon-ok icon-white"></i> KAYDET </a>
               </h3>
        </div>
   
    
        
    
        
<table border="0" cellpadding="0" cellspacing="1" style="width: 710px">
<tbody>


<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;bankaadi</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'bankaadi' size = '60' maxlength = '75' value = "<? echo $bankaadi; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;hesapsahibi</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'hesapsahibi' size = '60' maxlength = '255' value = "<? echo $hesapsahibi; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;subeadi</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'subeadi' size = '60' maxlength = '75' value = "<? echo $subeadi; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;hesapno</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'hesapno' size = '55' maxlength = '50' value = "<? echo $hesapno; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;parabirimi</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'parabirimi' size = '15' maxlength = '10' value = "<? echo $parabirimi; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;telefon1</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'telefon1' size = '55' maxlength = '50' value = "<? echo $telefon1; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;telefon2</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'telefon2' size = '55' maxlength = '50' value = "<? echo $telefon2; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;faks</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'faks' size = '55' maxlength = '50' value = "<? echo $faks; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;notlar</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'notlar' size = '60' maxlength = '254' value = "<? echo $notlar; ?>">
</span></div></TD>
</TR>

<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;iban</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'iban' size = '55' maxlength = '50' value = "<? echo $iban; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;email</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'email' size = '55' maxlength = '50' value = "<? echo $email; ?>">
</span></div></TD>
</TR>
<TR>
<TD class=''> <div align='left'><span class='postdetails'>
<B>&nbsp;</B>
</span></div></TD>
<TD class='darkrow3'> <div align='left'><span class='postdetails'><input type = 'submit' value = ' Kaydet '></span></div></TD>

</TR>   

</tbody>
</table> 

 
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
                            ':kdv'=>$kdv,':gtop'=>$gtop    );
                       $okmu= $generic->query('INSERT INTO hareket (musno,tarih,turu,faturano,top,kdv,gtop,nott) VALUES ( :firma , :tarih,:turu,:faturano,:top,:kdv,:gtop,:nott)',$param);
		//	$this->token = !empty($_POST['token']) ? $_POST['token'] : '';
		//	$this->process();
              if ($okmu->rowCount()==1): echo"kaydedildi";  header( 'Location: fatura.php?do=liste' ) ; endif;

		endif;
                ?>
        
        <?php
      
        
        ?>
        
       

        
        
    </span>  
       </div></div>    
  
  


  <div class="charms">
       nen
    </div>
        
      
    <?php include_once('footer.php'); ?>