<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php');
// yan menu başlangıç?>
<?php include_once('menu.php'); ?>

 <script type="text/javascript">
	function goster(id) {
		document.getElementById(id).style.display = 'block';
	}
	function gizle(id) {
		document.getElementById(id).style.display = 'none';
	}


</script>                   
 <div id="sidebar" class="sidebar">
<ul class="nav">

<?php if( protectThis(1) ) : ?>
<li><a href="fatura.php?do=ekle"><?php _e('Yeni Kayıt'); ?></a></li>
<li><a href="fatura.php?do=duzenle"><?php _e('Düzenle'); ?></a></li>
<li><a href="#"><?php _e('Sil'); ?></a></li>
<li><a href="#"><?php _e('Tam Liste'); ?></a></li>
<li><a href="fatura.php?do=arama"><?php _e('Arama'); ?></a></li>
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
<form class="" action="fatura.php?do=arama" method="post" name="arama" id="arama" accept-charset="utf-8">
<label class="form-label-left" id="label_444" for="input_444">
         Lütfen Mağaza adını girin yada aşağıdan seçiminizi yapın:<span class="form-required">*</span>
        </label>
    <div id="cid_4" class="form-input">
          <input type="text" class="form-textbox validate[required]" id="input_444" name="aramai" size="20" onkeyup="submitform()" /><br>
          <div class="done"> </div>
          <table border="0" cellpadding="5" cellspacing="1" style="width: 810px;" >
              <h4> <tr><td>id</td><td>Mağaza Kodu</td><td>Mağaza Adı</td><td>Mağaza Resmi Adı</td><td></td></tr></h4>
<?php

  ?>
 
<SCRIPT language="JavaScript">
function submitform()
{
  
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
     print $elma;
     $number=0;
        $param=array (':ad'=> $elma ); 
foreach($generic->query('SELECT * FROM magaza WHERE ad LIKE :ad',$param) as $row) {
    $number++;
    echo "<tr background=",( ($number & 1) ? 'black' : 'white' ),"><td>",$row['id'],"</td><td>",$row['kod'],"</td><td>",$row['ad'],"</td><td>",$row['unvan'],"</td><td><a href='fatura.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
}        
        
        }
  else : {
        $number=0;    
foreach($generic->query('SELECT * FROM magaza ') as $row) {
    $number++;
    echo "<tr class='",( ($number & 1) ? 'odd' : 'even' ),"'><td>",$row['id'],"</td><td>",$row['kod'],"</td><td>",$row['ad'],"</td><td>",$row['unvan'],"</td><td><a href='fatura.php?do=duzenle&id=",$row['id'],"'>Düzenle</a></td></tr>" ;
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

<form class="jotform-form" action="fatura.php" method="post" name="formekle" id="formekle" accept-charset="utf-8">
  <input type="hidden" name="formID" value="30133819675356" />
  <div class="form-all">
    <ul class="form-section">
        
        
      <li id="cid_1" class="form-input-wide">
        <div class="form-header-group">
          <h2 id="header_1" class="form-header">
           Fatura
          </h2>
        </div>
      </li>
        
        <table border="0" cellpadding="0" cellspacing="1" style="width: 610px;">
			<tbody>
				<tr>
					<td>
						<li class="form-line" id="id_4">
        <label class="form-label-left" id="label_4" for="input_3">
          Mağaza Adı:<span class="form-required">*</span>
        </label>
        <div id="cid_4" class="form-input">
          <input type="text" class="form-textbox validate[required]" id="input_3" name="q4_magazaAdi" onkeyup="hideStuff('cid_5')" size="20" />
        </div>
      </li></td>
					<td>

                            
						 <li>
                                                      <div id="cid_5" class="form-input">
          <label class="form-label-left" id="label_5" for="input_4">Ticari ve Hukuki Firma Adı: </label>
       
          <input type="text" class="form-textbox" id="input_4" name="q5_ticariVe" size="20" />
        </div>
      </li></td>
				</tr>
				<tr>
                                    
                                    <li class="form-line" id="id_99">
        <label class="form-label-left" id="label_99" for="input_2">
          Mağaza Kod:<span class="form-required">*</span>
        </label>
        <div id="cid_99" class="form-input">
          <input type="text" class="form-textbox validate[required]" id="input_2" name="magazakod"  size="20" />
        </div>
      </li></td>
					<td>
						 <li class="form-line" id="id_6">
        <label class="form-label-left" id="label_6" for="input_5"> Türü: </label>
        <div id="cid_6" class="form-input">
          <select class="form-dropdown" style="width:150px" id="input_5" name="q6_turu">
            <option>  </option>
            <option value="1"> Mağaza </option>
            <option value="2"> Depo </option>
            <option value="3"> Stand </option>
          </select>
        </div>
      </li>
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
      <li class="form-line" id="id_11">
        <label class="form-label-left" id="label_11" for="input_7"> Depo Türü </label>
        <div id="cid_11" class="form-input">
          <select class="form-dropdown" style="width:150px" id="input_7" name="q11_depoTuru">
            <option>  </option>
            <option value="1"> Mağaza Deposu </option>
            <option value="2"> Diğer </option>
            <option value="3"> Seçenek 3 </option>
          </select>
        </div>
      </li>
      <li class="form-line" id="id_9">
        <label class="form-label-left" id="label_9" for="input_8"> Stand Türü: </label>
        <div id="cid_9" class="form-input">
          <select class="form-dropdown" style="width:150px" id="input_8" name="q9_standTuru">
            <option>  </option>
            <option value="1">Sabit </option>
            <option value="2"> Uzun Süreli </option>
            <option value="3"> Diğer </option>
          </select>
        </div>
      </li></td>
					<td>
						<li class="form-line" id="id_12">
        <label class="form-label-left" id="label_12" for="input_9"> FiRMA TÜRÜ </label>
        <div id="cid_12" class="form-input">
          <select class="form-dropdown" style="width:150px" id="input_9" name="q12_firmaTuru">
            <option>  </option>
            <option value="1"> Bayi </option>
            <option value="2"> Firma </option>
            <option value="3"> Diğer </option>
          </select>
        </div>
      </li>
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
				</tr>
				<tr>
					<td>
						<li class="form-line" id="id_17">
        <label class="form-label-left" id="label_17" for="input_13"> MĞZ SAHİBİ </label>
        <div id="cid_17" class="form-input">
          <input type="text" class="form-textbox" id="input_13" name="q17_mgzSahibi17" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_18">
        <label class="form-label-left" id="label_18" for="input_111"> MĞZ SAHİBİ TEL </label>
        <div id="cid_18" class="form-input">
          <input type="text" class="form-textbox" id="input_111" name="q18_mgzSahibi" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_19">
        <label class="form-label-left" id="label_19" for="input_14"> MĞZ MÜDÜRÜ </label>
        <div id="cid_19" class="form-input">
          <input type="text" class="form-textbox" id="input_14" name="q19_mgzMuduru" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_20">
        <label class="form-label-left" id="label_20" for="input_15"> MĞZ MÜDÜRÜ TEL </label>
        <div id="cid_20" class="form-input">
          <input type="text" class="form-textbox" id="input_15" name="q20_mgzMuduru20" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_21">
        <label class="form-label-left" id="label_21" for="input_16"> MĞZ DAHİLİ TEL </label>
        <div id="cid_21" class="form-input">
          <input type="text" class="form-textbox" id="input_16" name="q21_mgzDahili21" size="20" />
        </div>
      </li></td>
					<td>
						<li class="form-line" id="id_22">
        <label class="form-label-left" id="label_22" for="input_17"> MĞZ TEL </label>
        <div id="cid_22" class="form-input">
          <input type="text" class="form-textbox" id="input_17" name="q22_mgzTel" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_23">
        <label class="form-label-left" id="label_23" for="input_18"> MĞZ FAX </label>
        <div id="cid_23" class="form-input">
          <input type="text" class="form-textbox" id="input_18" name="q23_mgzFax" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_24">
        <label class="form-label-left" id="label_24" for="input_19"> MAĞAZA PERSONEL SAYISI </label>
        <div id="cid_24" class="form-input">
          <input type="text" class="form-textbox validate[Numeric]" id="input_19" name="q24_magazaPersonel24" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_25">
        <label class="form-label-left" id="label_25" for="input_20"> BAYAN </label>
        <div id="cid_25" class="form-input">
          <input type="text" class="form-textbox validate[Numeric]" id="input_20" name="q25_bayan" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_26">
        <label class="form-label-left" id="label_26" for="input_21"> ERKEK </label>
        <div id="cid_26" class="form-input">
          <input type="text" class="form-textbox validate[Numeric]" id="input_21" name="q26_erkek" size="20" />
        </div>
      </li></td>
				</tr>
				<tr>
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
      <li class="form-line" id="id_31">
        <label class="form-label-left" id="label_31" for="input_25"> GENEL MERKEZ ADRES </label>
        <div id="cid_31" class="form-input">
          <input type="text" class="form-textbox" id="input_25" name="q31_genelMerkez31" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_32">
        <label class="form-label-left" id="label_32" for="input_26"> DİĞER MAĞAZA YERLERİ </label>
        <div id="cid_32" class="form-input">
          <input type="text" class="form-textbox" id="input_26" name="q32_digerMagaza" size="20" />
        </div>
      </li></td>
					<td>
						<li class="form-line" id="id_27">
        <label class="form-label-left" id="label_27" for="input_27"> MAĞAZA ARAÇ SAYISI </label>
        <div id="cid_27" class="form-input">
          <input type="text" class="form-textbox" id="input_27" name="q27_magazaArac" size="20" />
        </div>
      </li>
    
      <li class="form-line" id="id_33">
        <label class="form-label-left" id="label_33" for="input_28"> MAĞAZA M2 </label>
        <div id="cid_33" class="form-input">
          <input type="text" class="form-textbox" id="input_28" name="q33_magazaM2" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_34">
        <label class="form-label-left" id="label_34" for="input_29"> DEPO M2 </label>
        <div id="cid_34" class="form-input">
          <input type="text" class="form-textbox" id="input_29" name="q34_depoM2" size="20" />
        </div>
      </li>
      <li class="form-line" id="id_35">
        <label class="form-label-left" id="label_35" for="input_30"> TOPLAM M2 </label>
        <div id="cid_35" class="form-input">
          <input type="text" class="form-textbox" id="input_30" name="q35_toplamM2" size="20" />
        </div>
      </li>
           <li class="form-line" id="id_38">
        <label class="form-label-left" id="label_38" for="input_31"> MAĞAZA </label>
        <div id="cid_38" class="form-input">
          <div class="form-single-column">
              <input type="radio" class="form-radio" id="input_38_0" name="q38_magaza" checked="checked" value="TRUE" />
              aktif &nbsp;&nbsp; 
              <input type="radio" class="form-radio" id="input_38_1" name="q38_magaza" value="iptal" />
               iptal 
          </div>
        </div>
      </li></td>
				</tr>
				<tr>
					<td>
						&nbsp;</td>
					<td>
						<li class="form-line" id="id_37">
        <div id="cid_37" class="form-input-wide">
          <div style="margin-left:156px" class="form-buttons-wrapper">
            <button id="input_37" type="submit" class="form-submit-button">
              Kaydet
            </button>
          </div>
        </div>
      </li>
      
    </ul>
  </div>
 
</form> </td>
				</tr>
				
				<tr>
					<td>
						&nbsp;</td>
					<td>
						&nbsp;</td>
				</tr>
			</tbody>
		</table>
       
        
              
      
    
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
        
       
<form id='fatura' class='sfm_form' method='post' action='fatura.php' accept-charset='UTF-8'>
         <div id='fatura_errorloc' class='error_strings' style='width:300px;text-align:left'></div>
         <div id='fatura_outer_div' class='form_outer_div' style='width:300px;height:400px'>
            <div style='position:relative' id='fatura_inner_div'>
               <input type='hidden' name='sfm_form_submitted' value='yes'/>
              
               <div id='label_container' class='sfm_form_label'>
                  <label id='label'>Label</label>
               </div>
                <div id='Textbox_container'>
                  <input type='text' name='Textbox' id='Textbox' size='20' class='sfm_textbox'/>
               </div>
                <div id='label1_container' class='sfm_form_label'>
                  <label id='label1'>Lal</label>
               </div>
               <div id='Textbox1_container'>
                  <input type='text' name='Textbox1' id='Textbox1' size='20' class='sfm_textbox'/>
               </div>
                <div id='label2_container' class='sfm_form_label'>
                  <label id='label2'>Label</label>
               </div>
               <div id='Textbox2_container'>
                  <input type='text' name='Textbox2' id='Textbox2' size='20' class='sfm_textbox'/>
               </div>
               <input type="submit">
            </div>
         </div>
 </form>

        
        
        
        
        
        <br><br><br><br><br><br><br><br><br>
    <?php include_once('footer.php'); ?>