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
<li><a class="btn btn-large btn-success" href="banka1.php?do=yeni"><?php _e('Yeni Kayıt'); ?></a></li><br>
<li><a class="btn btn-large btn-danger" href="#"><?php _e('Sil İptal'); ?></a></li><br>
<li><a class="btn btn-large btn-info" href="banka1.php?do=liste"><?php _e('Tam Liste'); ?></a></li><br>
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
$banka_id = $_POST['banka_id'];
$parts = explode('.', $_POST['tarih']);
$tarih  = "$parts[2]-$parts[1]-$parts[0]";
$dekontno = $_POST['dekontno'];
$tutar = $_POST['tutar'];
$aciklama = $_POST['aciklama'];
$harekettipi = $_POST['harekettipi'];
$op = $_POST['op'];
$kullanici_no_ekleyen = $_POST['kullanici_no_ekleyen'];
$kullanici_no_duzenleyen = $_POST['kullanici_no_duzenleyen'];
$param = array (':id'=>$id,':banka_id'=>$banka_id,':tarih'=>$tarih,':dekontno'=>$dekontno,':tutar'=>$tutar,':aciklama'=>$aciklama,':harekettipi'=>$harekettipi,':op'=>$op,':kullanici_no_ekleyen'=>$kullanici_no_ekleyen,':kullanici_no_duzenleyen'=>$kullanici_no_duzenleyen);
if (!empty($banka_id)){
$query11 = "INSERT INTO banka_hareket (id,banka_id,tarih,dekontno,tutar,aciklama,harekettipi,op,kullanici_no_ekleyen,kullanici_no_duzenleyen) VALUES ( :id,:banka_id,:tarih,:dekontno,:tutar,:aciklama,:harekettipi,:op,:kullanici_no_ekleyen,:kullanici_no_duzenleyen )";
$result = $generic->query($query11, $param);
 if ($result->rowCount()==1): echo"kaydedildi";  header( "Location: banka1.php?do=liste&msg=1" ) ; endif;
}
 
 

// tüm liste

if(($_GET['do'] === "liste")  ): 
echo "<table>";
    echo "<tr><td>Tarih </td><td>Hareket Tipi</td><td>Tutar</td><td >Dekont No</td><td style='width:300px'>Açıklama&nbsp;</td><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
     $number=0;  
     $kackayit=$generic->query('SELECT *  FROM banka_hareket ORDER BY tarih asc');
     $toplam=0.0;
foreach($kackayit as $row) {
    $number++;
    echo "<tr class='",( ($number & 1) ? 'success' : 'info' ),"'><td> ",$row[2],"</td><td> ",$row[6],"</td><td> ",$row[4],"</td><td> ",$row[3],"</td><td> ",$row[5],"</td><td> ",$row[7],"</td><td><a href='banka.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
    if ($row[6]=="1"):{
        $toplam+=$row[4];
    }
        else: {
    $toplam-=$row[4];
}
endif;
    }
 echo "<tr class='",( ($number & 1) ? 'success' : 'info' ),"'><td></td><td>Bakiye : </td><td>",$toplam,"<td> </td><td> </td></td><td></td><td></td></tr>" ;    
echo '</table';  

    
endif; 
 // listeleme sonu

// Ekleme ve Düzenleme   
if(($_GET['do'] === "yeni")  ): ?>

<form class="" action="banka1.php" method="post" name="formbanka" id="formekle" accept-charset="utf-8">
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
<B>&nbsp;banka_id</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
  <?php
 echo "<select style='width:300px' name='banka_id'><option value='.'>Banka Seç</option>";
     foreach($generic->query('SELECT * FROM bankakart') as $row) {
        echo "<option value='",$row['id'],"'", ($_GET['id']==$row['id'])? "selected" : "";
        echo ">", $row[1]," - "," ",$row[3]," ",$row[5]," ",$row[4]," ","</option>\n";
        }
     echo "</select><p>";
         ?>
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;tarih</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type= 'text' name = 'tarih' id='datepicker'  value = "<? echo $tarih; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;dekontno</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'dekontno' size = '30' maxlength = '25' value = "<? echo $dekontno; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;tutar</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type = 'text' name = 'tutar'  value = "<? echo $tutar; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;aciklama</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type ='text' name = 'aciklama' size = '60' maxlength = '250' value = "<? echo $aciklama; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;harekettipi</B>
</span></div></TD>
<TD class='row4' > <div align='left'><span class='postdetails'>
         <select class="form-dropdown" style="width:200px" name = 'harekettipi' >
            <option>  </option>
           <option value="1" selected> Yatırılan Gelen (+) </option>
            <option value="2" selected> Çekilen Giden (-) </option>
          </select>

</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;op</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type= 'checkbox' name = 'op' value = 'true'> Set 
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;kullanici_no_ekleyen</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type = 'text' name = 'kullanici_no_ekleyen' size = '16+5' maxlength = '11' value = "<? echo $kullanici_no_ekleyen; ?>">
</span></div></TD>
</TR>
<TR>
<TD class='row4'> <div align='left'><span class='postdetails'>
<B>&nbsp;kullanici_no_duzenleyen</B>
</span></div></TD>
<TD class='row4'> <div align='left'><span class='postdetails'>
<input type = 'text' name = 'kullanici_no_duzenleyen' size = '16+5' maxlength = '11' value = "<? echo $kullanici_no_duzenleyen; ?>">
</span></div></TD>
</TR>
<TR>
<TD class=''> <div align='left'><span class='postdetails'>
<B>&nbsp;</B>
</span></div></TD>
<TD class='darkrow3'> <div align='left'><span class='postdetails'><input type = 'submit' value = 'submit data'></span></div></TD>


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