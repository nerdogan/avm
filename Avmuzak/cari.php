<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php');
// yan menu başlangıç?>

 <script type="text/javascript">
     document.title="Avm Mağaza Kontrol Sistemi 2013 - CARİ BÖLÜMÜ"
	function goster(id) {
		document.getElementById(id).style.display = 'block';
	}
	function gizle(id) {
		document.getElementById(id).style.display = 'none';
	}


</script>                   
 <div id="sidebar" class="sidebar">
<ul class="nav">
<img src="assets/img/logo1.png">	
<li><a href="home.php"> <img src=""></a> </li>
<?php if( protectThis(1) ) : ?>
<li><a href="cari.php?do=ekle"><?php _e('Yeni Kayıt'); ?></a></li>
<li><a href="#"><?php _e('Tam Liste'); ?></a></li>
<li><a href="cari.php?do=arama"><?php _e('Arama'); ?></a></li>
<li><a href="#"><?php _e(''); ?></a></li>
<li><a href="protected.php"><?php _e(''); ?></a></li>
</ul>
</div>
<?php // Yan menü bitiş
 endif; ?>



<?php 
// Arama bölümü
if(($_GET['do'] === "arama")|| !($_GET['do']) ): ?>
<br>
<form class="" action="cari.php?do=arama" method="post" name="arama" id="arama" accept-charset="utf-8">
<label class="form-label-left" id="label_444" for="input_444">
         Lütfen firma adını girin yada aşağıdan seçiminizi yapın:<span class="form-required">*</span>
        </label>
    <div id="cid_4" class="form-input">
          <input type="text" class="form-textbox validate[required]" id="input_444" name="aramai" size="20" onkeyup="submitform()" /><br>
          <div class="done"> </div>
          <table class="table table-hover" border="0" cellpadding="5" cellspacing="1" style="width: 810px;" >
              <h4> <tr><td>id</td><td> Kodu</td><td>Firma Adı</td><td>Firma Resmi Adı</td><td></td></tr></h4>
<?php

  ?>
 
<SCRIPT language="JavaScript">
function submitform()
{
 // $( "#content" ).load("home.php");
  if  (document.arama.aramai.value.length > 1){ 
  document.arama.submit();
}
  
}
</SCRIPT>


        </div>
</form>
  <?php 
    
 if ($_POST['aramai']) : {
     $elma="%".$_POST['aramai']."%";
      $elma=toUpperCase($elma);
     print $elma;
     
     $number=0;
        $param=array (':ad'=> $elma ); 
foreach($generic->query('SELECT * FROM magaza WHERE ad LIKE :ad',$param) as $row) {
    $number++;
if ($row['mtur_id']=4) :  {
    echo "<tr class=",( ($number & 1) ? 'odd' : 'even' ),"><td>",$row['id'],"</td><td>",$row['kod'],"</td><td>",$row['ad'],"</td><td>",$row['unvan'],"</td><td><a href='cari.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
}
else : {
echo "<tr class=",( ($number & 1) ? 'odd' : 'even' ),"><td>",$row['id'],"</td><td>",$row['kod'],"</td><td>",$row['ad'],"</td><td>",$row['unvan'],"</td><td><a href='magaza.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
    
}
endif;

}

        
        
        }
  else : {
        $number=0;    
foreach($generic->query('SELECT * FROM magaza ') as $row) {
    $number++;
  if ($row['mtur_id']==="4") :  {
    echo "<tr class=",( ($number & 1) ? 'odd' : 'even' ),"><td>",$row['id'],"</td><td>",$row['kod'],"</td><td>",$row['ad'],"</td><td>",$row['unvan'],"</td><td><a href='cari.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
}
else : {
echo "<tr class=",( ($number & 1) ? 'odd' : 'even' ),"><td>",$row['id'],"</td><td>",$row['kod'],"</td><td>",$row['ad'],"</td><td>",$row['unvan'],"</td><td><a href='magaza.php?do=duzenle&id=",$row['id'],"'></a>" ,
'<ul id="menu',$number,'">
  <li>
    <a href="#">seç</a>
    <ul>
    <li><a href="#">Göster</a></li>
      <li><a href="magaza.php?do=duzenle&id=',$row['id'],'">Düzenle</a></li>
      <li><a href="#">Sil</a></li>
      <li><a href="fatura.php?do=yeni&id=',$row['id'],'">Fatura</a></li>
    </ul>
  </li>
  </ul>    
    <script>
$( "#menu',$number,'" ).menu();
</script>';             

}
endif;
}
  }
  endif;
 
  
  
  
  if (!$_POST['aramai']) : {
 }
  else : {
      echo "<SCRIPT >  document.arama.aramai.value='",$_POST['aramai'],"' ; document.arama.aramai.focus();
          
              </SCRIPT>";
      print $_POST['aramai'];
  
  
  }
endif;
  
  endif;?>
    
 </table>

<?php 
// Ekleme ve Düzenleme   
if(($_GET['do'] === "ekle")||($_GET['do'] === "duzenle") ): ?>

<form class="jotform-form" action="cari.php" method="post" name="formekle" id="formekle" accept-charset="utf-8">
  <input type="hidden" name="formID" value="30133819675356" />
  <div class="form-all">
    <ul class="nav nav-list">
        
        
      <li id="cid_1" class="form-input-wide">
        <div class="form-header-group">
          <h2 id="header_1" class="form-header">
           Cari Kartı 
          </h2>
        </div>
      </li>
        
  <table border="0" cellpadding="0" cellspacing="1" style="width: 610px;">
<tbody>
<tr>
    <td>
        <li class="form-line" id="id_99">
        <label class="form-label-left" id="label_99" for="input_2"> Cari Kod:<span class="form-required">*</span> </label>
        <div id="cid_99" class="form-input">
        <input type="text" class="form-textbox validate[required]" id="input_2" name="magazakod"  size="20" />
        </div>
        </li>
    </td>
    <td>
        <li class="form-line" id="id_38">
        <label class="form-label-left" id="label_38" for="input_31"> FİRMA </label>
        <div id="cid_38" class="form-input">
        <div class="form-single-column">
        <input type="radio" class="form-radio" id="input_38_0" name="q38_magaza" checked="checked" value="TRUE" /> aktif &nbsp;&nbsp; 
        <input type="radio" class="form-radio" id="input_38_1" name="q38_magaza" value="iptal" /> iptal 
        </div>
     </td>
</tr>					
                            
                            
<tr>
    <td>
        <li class="form-line" id="id_4">
        <label class="form-label-left" id="label_4" for="input_3"> Firma Adı:<span class="form-required">*</span> </label>
        <div id="cid_4" class="form-input">
        <input type="text" class="form-textbox validate[required]" id="input_3" name="q4_magazaAdi" onkeyup="hideStuff('cid_5')" size="20" />
        </div>
         </li>
   </td>
    <td>
        <li>
             <div id="cid_5" class="form-input">
             <label class="form-label-left" id="label_5" for="input_4">Ticari ve Hukuki Firma Adı: </label>
             <input type="text" class="form-textbox" id="input_4" name="q5_ticariVe" size="20" />
             </div>
       </li>
  </td>
</tr>
<tr>
     <td>
	 <li class="form-line" id="id_6">
        <label class="form-label-left" id="label_6" for="input_5"> Türü: </label>
        <div id="cid_6" class="form-input">
          <select class="form-dropdown" style="width:150px" id="input_5" name="q6_turu">
            <option>  </option>
            <option value="1"> Mağaza </option>
            <option value="2"> Depo </option>
            <option value="3"> Stand </option>
            <option value="4" selected> Tedarik </option>
          </select>
        </div>
         </li>
     </td>
     <td>
      <li class="form-line" id="id_7">
        <label class="form-label-left" id="label_7" for="input_6"> Mağaza Türü: </label>
        <div id="cid_7" class="form-input">
          <select class="form-dropdown" style="width:150px" id="input_6" name="q7_magazaTuru7">
            <option>  </option>
            <option value="1"> Gıda </option>
            <option value="2"> Hazır Giyim </option>
            <option value="3"> Hizmet </option>
            <option value="4"> Deri Ayakkabı </option>
            <option value="5"> Aksesuar </option>
            <option value="6"> Market </option>
          </select>
        </div>
      </li>
        </td>
 </tr>
 <tr>  <td>      
      <li class="form-line" id="id_14">
        <label class="form-label-left" id="label_14" for="input_10"> SERMAYE </label>
        <div id="cid_14" class="form-input">
          <input type="text" class="form-textbox" id="input_10" name="q14_sermaye14" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_16">
        <label class="form-label-left" id="label_16" for="input_11"> VERGİ DAİRESİ </label>
        <div id="cid_16" class="form-input">
          <input type="text" class="form-textbox" id="input_11" name="q16_vergiDairesi" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_15">
        <label class="form-label-left" id="label_15" for="input_12"> VERGİ NO </label>
        <div id="cid_15" class="form-input">
          <input type="text" class="form-textbox" id="input_12" name="q15_vergiNo" size="20" />
        </div>
      </li></td>
			<td>	
						  <li class="form-line" id="id_22">
        <label class="form-label-left" id="label_28" for="input_28"> GENEL MERKEZ YETKİLİSİ </label>
        <div id="cid_28" class="form-input">
          <input type="text" class="form-textbox" id="input_22" name="q28_genelMerkez" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_29">
        <label class="form-label-left" id="label_29" for="input_23"> GENEL MERKEZ TEL </label>
        <div id="cid_29" class="form-input">
          <input type="text" class="form-textbox" id="input_23" name="q29_genelMerkez29" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_30">
        <label class="form-label-left" id="label_30" for="input_24"> GENEL MERKEZ FAX </label>
        <div id="cid_30" class="form-input">
          <input type="text" class="form-textbox" id="input_24" name="q30_genelMerkez30" size="20" />
        </div>
      </li>
                        </td>
        </tr>
        <tr>
           <td>
						&nbsp;</td> <td>
     
     </td>
	</tr>
				<tr>
					
					<td>
      
    </ul>
  </div>
 
 </td>
				</tr>
				
				<tr>
					<td>
						&nbsp;</td>
					<td>
						&nbsp;</td>
				</tr>
			</tbody>
		</table>
      <li class="form-line" id="id_31">
        <label class="form-label-left" id="label_31" for="input_25"> GENEL MERKEZ ADRES </label>
        <div id="cid_31" class="form-input">
          <input type="text" class="form-textbox" id="input_25" name="q31_genelMerkez31" style="width: 500px" />
        </div>
      </li>  
  
						<li class="form-line" id="id_37">
        <div id="cid_37" class="form-input-wide">
          <div style="margin-left:156px" class="form-buttons-wrapper">
            <button id="input_37" type="submit" class="form-submit-button">
              Kaydet
            </button>
          </div>
        </div>
      </li>
</form> 

      
    
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




if(isset($_POST['q4_magazaAdi'])) :
			
			$kod = $generic->secure($_POST['magazakod']);
                        $ad = $generic->secure($_POST['q4_magazaAdi']);
                        $unvan = $generic->secure($_POST['q5_ticariVe']);
                        $mtur_id = $generic->secure($_POST['q6_turu']);
                        $mmtur_id = $generic->secure($_POST['q7_magazaTuru7']);
                        $dtur_id = $generic->secure($_POST['q11_depoTuru']);
                        $stur_id = $generic->secure($_POST['q9_standTuru']);
                        $ftur_id = $generic->secure($_POST['q12_firmaTuru']);
                        $miptal = $generic->secure($_POST['q38_magaza']);
                        $sermaye = $generic->secure($_POST['q14_sermaye14']);
                        $vd = $generic->secure($_POST['q16_vergiDairesi']);
                        $vno = $generic->secure($_POST['q15_vergiNo']);
                        $msah = $generic->secure($_POST['q17_mgzSahibi17']);
                        $msahtel = $generic->secure($_POST['q18_mgzSahibi']);
                        $mmud = $generic->secure($_POST['q19_mgzMuduru']);
                        $mmudtel = $generic->secure($_POST['q20_mgzMuduru20']);
                        $mdahtel = $generic->secure($_POST['q21_mgzDahili21']);
                        $mtel = $generic->secure($_POST['q22_mgzTel']);
                        $mfax = $generic->secure($_POST['q23_mgzFax']);
                        $mper = $generic->secure($_POST['q24_magazaPersonel24']);
                        $mpere = $generic->secure($_POST['q26_erkek']);
                        $mperk = $generic->secure($_POST['q25_bayan']);
                        $marac = $generic->secure($_POST['q27_magazaArac']);
                        $gmyet = $generic->secure($_POST['q28_genelMerkez']);
                        $gmtel = $generic->secure($_POST['q29_genelMerkez29']);
                        $gmfax = $generic->secure($_POST['q30_genelMerkez30']);
                        $gmadres = $generic->secure($_POST['q31_genelMerkez31']);
                        $dmyer = $generic->secure($_POST['q32_digerMagaza']);
                        $mmt = $generic->secure($_POST['q33_magazaM2']);
                        $dmt = $generic->secure($_POST['q34_depoM2']);
                        $tmt = $generic->secure($_POST['q35_toplamM2']);                        
                        $not = $generic->secure($_POST['q4_magazaAdi']);
                        $idd="";
                        $param=array (':kod'=>$kod,':ad'=>$ad,':unvan'=>$unvan,
                            ':mtur_id' => $mtur_id,':mmtur_id'=>$mmtur_id,':dtur_id'=>$dtur_id,
                            ':stur_id'=>$stur_id,':ftur_id'=>$ftur_id,':sermaye'=>$sermaye,
                            ':vd'=>$vd,':vno'=>$vno
                        );
                        $generic->query('INSERT INTO magaza (kod,ad,unvan,mtur_id,mmtur_id,dtur_id,stur_id,ftur_id,sermaye,vd,vno) VALUES ( :kod , :ad,:unvan,:mtur_id,:mmtur_id,:dtur_id,:stur_id,:ftur_id,:sermaye,:vd,:vno)',$param);
		//	$this->token = !empty($_POST['token']) ? $_POST['token'] : '';
		//	$this->process();
              

		endif;
                ?>
        
        <?php
      
        
        ?>
        
        
          
               
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <br><br><br><br><br><br><br><br><br>
    <?php include_once('footer.php'); ?>