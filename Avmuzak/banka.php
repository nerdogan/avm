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
    echo "<tr><td>Adı </td><td>Şube</td><td>Hesap No</td><td style='width:150px'>Bakiye</td><td>&nbsp;&nbsp;&nbsp;</td><td>Açıklama</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
     $number=0;  
     $kackayit=$generic->query('SELECT *  FROM bankakart ');
     $toplam=0.0;
foreach($kackayit as $row) {
    $number++;
    echo "<tr class='",( ($number & 1) ? 'success' : 'info' ),"'><td> ",$row[1],"</td><td> ",$row[3],"</td><td> ",$row[4],"</td><td> ",$row[10],"</td><td> ",$row[5],"</td><td> ",$row[9],"</td><td><a href='banka.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
    $toplam+=$row[10];
    }
 echo "<tr class='",( ($number & 1) ? 'success' : 'info' ),"'><td> </td><td> </td><td></td><td> </td><td></td><td></td><td></td></tr>" ;    
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
    
        
        
    </span>  
       </div></div>    
  
  


  <div class="charms">
       nen
    </div>
        
      
    <?php include_once('footer.php'); ?>