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
$(".mennu").text("");
goster('anasayfa1');
//$('.modern-ui').css('backgroundImage','url(../images/bg.jpg)');

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
      <div class="search row-fluid container">
        <h2>Arama</h2>
        <form class="form-search">
          <div class="input-append">
             <input type="text" class=" search-query" placeholder="">
            <button class="btn_search color_4">Arama</button>
          </div>
        </form>
      </div>
      <ul id="sidebar_menu" class="navbar nav nav-list container full">
        <li class="accordion-group active color_4"> <a class="dashboard " href="home.php"><img src="img/menu_icons/dashboard.png"><span>Başlangıç</span></a> </li>
        
            
        <li class="accordion-group color_3"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse1">
                <img src="img/menu_icons/grid.png"><span>Mağaza</span></a>
          <ul id="collapse1" class="accordion-body collapse in">
              <li 
                  <?php if ($_GET['do']=="ekle"):echo "class='active'" ;endif; ?>
                      ><a href="magaza.php?do=ekle">Yeni Ekle</a></li>
              <li><a href="magaza.php?do=arama">Ara</a></li>
              <li><a href="magaza.php?do=sil">Sil</a></li>
              <li><a href="magaza.php?do=liste">Tam Liste</a></li>
              
          </ul>
        </li>
        
        <li class="color_8"> <a class="widgets"data-parent="#sidebar_menu" href="cari.php"> <img src="img/menu_icons/calendar.png"><span>Cari</span></a> </li>
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
          <img src="./assets/images/marketmavi.png" style="height: 50px;width: 50px" class="pull-left"> <h2>Mağaza Bölümü</h2> 
          </div>   
      </div>
  <?php
 
 if(($_GET['do'] === "sil")): {
 
      if(!($_GET['id'])): { ?>
          
      <div class="row-fluid">
        <div class="span7">
        <div class="box paint color_7">
            <div class="title">
              <h4> <i class="icon-book"></i><span>Sil</span> </h4>
            </div>
            <div class="content">
  <form class="row-fluid  form-horizontal " action="magaza.php?do=sil" method="get"  accept-charset="utf-8">
<input type="hidden" name="do" value="sil">
   <?php           
  echo "<select style='width:500px' name='id'><option value='.'>Firma Seç</option>";
     foreach($generic->query('SELECT * FROM magaza WHERE mtur_id<>4') as $row) {
        echo "<option value='",$row['id'],"'", ($_GET['id']==$row['id'])? "selected" : "";
        echo ">", $row['kod']," -  "," ",$row['unvan'],"</option>\n";
        }
     echo "</select><button type='submit' class='btn btn-primary pull-right'>Sil</button>";    
      
      
      
  }
endif;
     
      $elma=$_GET['id'];
     $param=array (':ad'=> $elma ); 
      
  foreach($generic->query('SELECT * FROM magaza WHERE id=:ad',$param) as $row) {    }
  $okmu=$generic->query('DELETE FROM magaza WHERE id=:ad',$param);
  if ($okmu->rowCount()==1):
  $generic->displayMessage(sprintf('<div class="alert alert-success">' . _('Kayıt başarıyla silindi. (') .$row['id']." ".$row['kod']." ".$row['ad']." ".$row['unvan']." ". ')</div>'),FALSE);
endif;    
  }
  
  endif;
?>   
        <?php 

// Arama bölümü
if(($_GET['do'] === "arama")) : ?>

        <div class="row-fluid">
        <div class="span7">
        <div class="box paint color_7">
            <div class="title">
              <h4> <i class="icon-book"></i><span>Arama</span> </h4>
            </div>
            <div class="content">
                
<form class="row-fluid  form-horizontal" action="magaza.php?do=arama" method="post" name="arama" id="arama" accept-charset="utf-8">

 <br><br>
 <div id="cid_4" class="form-input">
 
<input type="text" class="span7" id="input_444" name="aramai" size="20" onkeyup="submitform()" placeholder="Lütfen Mağaza adı veya kodu birkaç harf girin."/><br>
</div>
 </div></div></div></div>
        
  <div class="row-fluid ">
        <div class="span12">
          <div class="box paint color_18">
            <div class="title">
              <h4> <i class=" icon-bar-chart"></i><span>Mağazalar </span> </h4>
            </div>
            <!-- End .title -->
            <div class="content top">
             
 
 
<table class="responsive table table-striped table-bordered" border="0" cellpadding="5" cellspacing="1" style="" >
    <thead>
<h4> <tr><td>No</td><td>Mağaza Kodu</td><td>Mağaza Adı</td><td>Mağaza Resmi Adı</td><td></td></tr></h4>
      </thead>

<?php

 ?>
 
<SCRIPT language="JavaScript">
function submitform()
{
  //$( "#sidebar" ).load("menu.php");
  if  (document.arama.aramai.value.length > 1){ 
  document.arama.submit();
}
  
}
</SCRIPT>

 
</form>
  <?php 
    
 if ($_POST['aramai']) : {
     
     $elma="%".$_POST['aramai']."%";
     
      //$elma=toUpperCase($elma);
    
     $number=0;
        $param=array (':ad'=> $elma ); 
foreach($generic->query('SELECT * FROM magaza WHERE (ad LIKE :ad or unvan LIKE :ad or kod LIKE :ad) and mtur_id<>4',$param) as $row) {
    $number++;
    echo "<tr class=",( ($number & 1) ? 'odd' : 'even' ),"><td>",$row['id'],"</td><td>",$row['kod'],"</td><td>",$row['ad'],"</td><td>",$row['unvan'],
        "</td><td><a href='", (($row['mtur_id']==="4") ? 'cari' : 'magaza') ,".php?do=duzenle&id=",$row['id'],"'></a>" ,
'<ul id="menu',$number,'">
  <li>
    <a href="#">seç</a>
    <ul>
    <li><a href="cari.php?do=goster&id=',$row['id'],'">Göster</a></li>
      <li><a href=', (($row['mtur_id']==="4") ? 'cari' : 'magaza') ,'.php?do=duzenle&id=',$row['id'],'>Düzenle</a></li>
       <li><a href="magaza.php?do=sil&id=',$row['id'],'">Sil</a></li>
      <li><a href="fatura.php?do=yeni&id=',$row['id'],'">Fatura</a></li>
    </ul>
  </li>
  </ul>    
    <script>
$( "#menu',$number,'" ).menu();
</script>';             

    
}        
 

echo "<SCRIPT >  document.arama.aramai.value='",$_POST['aramai'],"' ; document.arama.aramai.focus();
          
              </SCRIPT>";
      
        }
        
        
  endif;

  
  endif;?>
    
 </table>
 
 
  <?php // arama sonu
  
 


 // listeleme başlangıcı
   if(($_GET['do'] === "liste")|| !($_GET['do']) ): { ?>
 
                <div class="row-fluid ">
        <div class="span12">
          <div class="box paint color_18">
            <div class="title">
              <h4> <i class=" icon-bar-chart"></i><span>Mağazalar </span> </h4>
            </div>
            <!-- End .title -->
            <div class="content top">
 <br>  
  <table class="responsive table table-striped table-bordered" border="0" cellpadding="5" cellspacing="1" style="" >
      <thead>
  <h3> <tr><td>No</td><td> Kodu</td><td>Firma Adı</td><td>Firma Resmi Adı</td><td><a href='magazalist.pdf'>PDF</a></td></tr></h3>
  </thead>
  <?php
        $number=0;    
foreach($generic->query('SELECT * FROM magaza WHERE mtur_id<>4 ') as $row) {
    $number++;
  $data[]=$row ;
echo "<tr class='",( ($number & 1) ? 'odd' : 'even' ),"'><td>",$row['id'],"</td><td>",$row['kod'],"</td><td>",$row['ad'],"</td><td>",$row['unvan'],
        "</td><td><a href='", (($row['mtur_id']==="4") ? 'cari' : 'magaza') ,".php?do=duzenle&id=",$row['id'],"'></a>" ,
'<ul id="menu',$number,'">
  <li>
    <a href="#">seç</a>
    <ul>
    <li><a href="cari.php?do=goster&id=',$row['id'],'">Göster</a></li>
      <li><a href=', (($row['mtur_id']==="4") ? 'cari' : 'magaza') ,'.php?do=duzenle&id=',$row['id'],'>Düzenle</a></li>
      <li><a href="magaza.php?do=sil&id=',$row['id'],'">Sil</a></li>
      <li><a href="fatura.php?do=yeni&id=',$row['id'],'">Fatura</a></li>
    </ul>
  </li>
  </ul>    
    <script>
$( "#menu',$number,'" ).menu();
</script>';             


   }}

require('rapor/tfpdf.php');

class PDF extends tFPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
  
    $data = array();
    foreach($file as $line)
        $data[] = $line;
    return $data;
}

// Simple table


// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(10,35,90,120);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,$row[2],'LR');
        $this->Cell($w[3],6,$row[3],'LR');
        $this->Ln();
        }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    //$this->SetFont('','B');
    // Header
    $w = array(10, 25, 90, 150);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
   // $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
        // $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}


// Column headings
$header = array('No', 'kod', 'Firma Ad', 'Resmi Ad');
// Data loading
//$data = $pdf->LoadData('countries.txt');

$pdf = new PDF('L','mm','A4');
$pdf->AddFont('tahoma','','tahoma.ttf',true);
$pdf->SetFont('tahoma','',12);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Text(100,7,'MAĞAZA LİSTE');
$pdf->Text(260,200,'Crexist.com');
$pdf->Text(10,200,'Avm Bilgi Sistemi');
$pdf->Text(240,7, date("d-m-Y H:i:s"));
$pdf->Output("magazalist.pdf","F");
echo "";
// rapor sonu
endif;

 ?>
  </table>
 
 

<?php 
// Ekleme ve Düzenleme   
if(($_GET['do'] === "ekle")||($_GET['do'] === "duzenle") ): ?>
<div class="row-fluid">
        <div class="span8">
          <div class="box paint color_7">
            <div class="title">
              <h4> <i class="icon-book"></i><span>MAĞAZA KARTI <?php echo strtoupper($_GET['do']); ?></span> </h4>
            </div>
              <div class="content">
                  
             
<form class="jotform-form" action="magaza.php" method="post" name="formekle" id="formekle" accept-charset="utf-8">
	<input type="hidden" name="formID" value="<?php echo $_GET['do'] ?>" /> <input type="hidden" name="firmID" value="<?php echo $_GET['id'] ?>" />
	<div class="form-all">
		<ul class="form-section nav">
			<li id="cid_1" class="form-input-wide ">
			<div class="form-header-group">
				<h3 id="header_1" class="form-header">
				
				</h3>
			</div>
			</li>
			<table border="0" cellpadding="0" cellspacing="1" style="">
			<tbody>
			<tr>
                            <td>
                                <li class="form-line" id="id_99">
				<label class="form-label-left" id="label_99" for="input_2">
				</label>
				<div id="cid_99" class="form-input">
					<input type="text" class="" id="input_2" name="magazakod" size="20" placeholder="Mağaza Kod"/>
				</div>
				</li>
                            </td>
				<td>
					<li class="form-line" id="id_4">
					<label class="form-label-left" id="label_4" for="input_3">
					<span class="form-required"></span>
					</label>
					<div id="cid_4" class="form-input">
						<input type="text" class="form-required" id="input_3" name="q4_magazaAdi" size="20" placeholder=" Mağaza Adı"/>
					</div>
					</li>
				</td>
				<td>
					<li>
					<div id="cid_5" class="form-input">
						<label class="form-label-left" id="label_5" for="input_4"></label>
						<input type="text" class="form-textbox" id="input_4" name="q5_ticariVe" size="20" placeholder="Ticari ve Hukuki Firma Adı"/>
					</div>
					</li>
				</td>
			</tr>
			<tr>
                            
			<td>
				<li class="form-line" id="id_6">
				<label class="form-label-left" id="label_6" for="input_5"></label>
				<div id="cid_6" class="form-input">
					<select class="form-dropdown" style="width:150px" id="input_5" name="q6_turu" placeholder="">
						<option> Türü </option>
						<option value="1"> Mağaza </option>
						<option value="2"> Depo </option>
						<option value="3"> Stand </option>
					</select>
				</div>
				</li>
				<li class="form-line" id="id_7">
				<label class="form-label-left" id="label_7" for="input_6"></label>
				<div id="cid_7" class="form-input">
					<select class="form-dropdown" style="width:150px" id="input_6" name="q7_magazaTuru7">
						<option> Mağaza Sektör</option>
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
				<label class="form-label-left" id="label_11" for="input_7"></label>
				<div id="cid_11" class="form-input">
					<select class="form-dropdown" style="width:150px" id="input_7" name="q11_depoTuru">
						<option> Depo Türü </option>
						<option value="1"> Mağaza Deposu </option>
						<option value="2"> Diğer </option>
						<option value="3"> Seçenek 3 </option>
					</select>
				</div>
				</li>
				<li class="form-line" id="id_9">
				<label class="form-label-left" id="label_9" for="input_8"></label>
				<div id="cid_9" class="form-input">
					<select class="form-dropdown" style="width:150px" id="input_8" name="q9_standTuru">
						<option> Stand Türü</option>
						<option value="1">Sabit </option>
						<option value="2"> Uzun Süreli </option>
						<option value="3"> Diğer </option>
					</select>
				</div>
				</li>
			</td>
			<td>
				<li class="form-line" id="id_12">
				<label class="form-label-left" id="label_12" for="input_9"></label>
				<div id="cid_12" class="form-input">
					<select class="form-dropdown" style="width:150px" id="input_9" name="q12_firmaTuru">
						<option> Firma Türü</option>
						<option value="1"> Bayi </option>
						<option value="2"> Firma </option>
						<option value="3"> Diğer </option>
					</select>
				</div>
				</li>
				<li class="form-line" id="id_14">
				<label class="form-label-left" id="label_14" for="input_10"></label>
				<div id="cid_14" class="form-input">
					<input type="text" class="form-textbox" id="input_10" name="q14_sermaye14" size="20" placeholder=" Sermaye "/>
				</div>
				</li>
				<li class="form-line" id="id_16">
				<label class="form-label-left" id="label_16" for="input_11"></label>
				<div id="cid_16" class="form-input">
					<input type="text" class="form-textbox" id="input_11" name="q16_vergiDairesi" size="20" placeholder="Vergi Dairesi "/>
				</div>
				</li>
				<li class="form-line" id="id_15">
				<label class="form-label-left" id="label_15" for="input_12"></label>
				<div id="cid_15" class="form-input">
					<input type="text" class="form-textbox" id="input_12" name="q15_vergiNo" size="20" placeholder="Vergi No "/>
				</div>
				</li>
			</td>
		
			<td>
				<li class="form-line" id="id_17">
				<label class="form-label-left" id="label_17" for="input_14"></label>
				<div id="cid_17" class="form-input">
					<input type="text" class="form-textbox" id="input_14" name="q17_mgzSahibi17" size="20" placeholder="Mağaza Sahibi"/>
				</div>
				</li>
				<li class="form-line" id="id_18">
				<label class="form-label-left" id="label_18" for="input_111"></label>
				<div id="cid_18" class="form-input">
					<input type="text" class="form-textbox" id="input_15" name="q18_mgzSahibi" size="20" placeholder="Mağaza Sahibi Tel"/>
				</div>
				</li>
				<li class="form-line" id="id_19">
				<label class="form-label-left" id="label_19" for="input_14"></label>
				<div id="cid_19" class="form-input">
					<input type="text" class="form-textbox" id="input_16" name="q19_mgzMuduru" size="20" placeholder="Mağaza Müdürü"/>
				</div>
				</li>
				<li class="form-line" id="id_20">
				<label class="form-label-left" id="label_20" for="input_15"></label>
				<div id="cid_20" class="form-input">
					<input type="tel" class="form-textbox" id="input_17" name="q20_mgzMuduru20" size="20" placeholder="Mağaza Müdürü Tel"/>
				</div>
				</li>
				<li class="form-line" id="id_21">
				<label class="form-label-left" id="label_21" for="input_16"></label>
				<div id="cid_21" class="form-input">
					<input type="text" class="form-textbox" id="input_18" name="q21_mgzDahili21" size="20" placeholder="Mağaza Dahili Tel"/>
				</div>
				</li>
			</td> 
                       </tr>
		<tr> 
                        
			<td>
				<li class="form-line" id="id_22">
				<label class="form-label-left" id="label_22" for="input_17"></label>
				<div id="cid_22" class="form-input">
					<input type="email" class="form-textbox" id="input_34" name="eposta" size="20" placeholder="mağaza e-posta"/>
				</div>
				</li>
				<li class="form-line" id="id_22">
				<label class="form-label-left" id="label_22" for="input_17"></label>
				<div id="cid_22" class="form-input">
					<input type="text" class="form-textbox" id="input_19" name="q22_mgzTel" size="20" placeholder="Mağaza Tel"/>
				</div>
				</li>
				<li class="form-line" id="id_23">
				<label class="form-label-left" id="label_23" for="input_18"></label>
				<div id="cid_23" class="form-input">
					<input type="text" class="form-textbox" id="input_20" name="q23_mgzFax" size="20" placeholder="Mağaza Fax"/>
				</div>
				</li>
				<li class="form-line" id="id_24">
				<label class="form-label-left" id="label_24" for="input_19"></label>
				<div id="cid_24" class="form-input">
					<input type="text" class="form-textbox validate[Numeric]" id="input_21" name="q24_magazaPersonel24" size="20" placeholder="Personel Sayısı"/>
				</div>
				</li>
				<li class="form-line" id="id_25">
				<label class="form-label-left" id="label_25" for="input_20"></label>
				<div id="cid_25" class="form-input">
					<input type="text" class="form-textbox validate[Numeric]" id="input_23" name="q25_bayan" size="20" placeholder="Kadın Personel"/>
				</div>
				</li>
				<li class="form-line" id="id_26">
				<label class="form-label-left" id="label_26" for="input_21"></label>
				<div id="cid_26" class="form-input">
					<input type="text" class="form-textbox validate[Numeric]" id="input_22" name="q26_erkek" size="20" placeholder="Erkek Personel"/>
				</div>
				</li>
			</td>
		
			<td>
				<li class="form-line" id="id_22">
				<label class="form-label-left" id="label_28" for="input_28"></label>
				<div id="cid_28" class="form-input">
					<input type="text" class="form-textbox" id="input_25" name="q28_genelMerkez" size="20" placeholder="Genel Merkez Yetkilisi"/>
				</div>
				</li>
				<li class="form-line" id="id_29">
				<label class="form-label-left" id="label_29" for="input_23"></label>
				<div id="cid_29" class="form-input">
					<input type="text" class="form-textbox" id="input_26" name="q29_genelMerkez29" size="20" placeholder="Genel Merkez Tel"/>
				</div>
				</li>
				<li class="form-line" id="id_30">
				<label class="form-label-left" id="label_30" for="input_24"></label>
				<div id="cid_30" class="form-input">
					<input type="text" class="form-textbox" id="input_27" name="q30_genelMerkez30" size="20" placeholder="Genel Merkez Fax"/>
				</div>
				</li>
				<li class="form-line" id="id_31">
				<label class="form-label-left" id="label_31" for="input_25"></label>
				<div id="cid_31" class="form-input">
					<input type="text" class="form-textbox" id="input_28" name="q31_genelMerkez31" size="20" placeholder="Genel Merkez Adres"/>
				</div>
				</li>
				<li class="form-line" id="id_32">
				<label class="form-label-left" id="label_32" for="input_29"></label>
				<div id="cid_32" class="form-input">
					<input type="text" class="form-textbox" id="input_29" name="q32_digerMagaza" size="20" placeholder="Diğer Mağaza Yerleri"/>
				</div>
				</li>
			</td>
			<td>
				<li class="form-line" id="id_27">
				<label class="form-label-left" id="label_27" for="input_27"></label>
				<div id="cid_27" class="form-input">
					<input type="text" class="form-textbox" id="input_24" name="q27_magazaArac" size="20" placeholder="Mağaza Araç Sayısı"/>
				</div>
				</li>
				<li class="form-line" id="id_33">
				<label class="form-label-left" id="label_33" for="input_28"></label>
				<div id="cid_33" class="form-input">
					<input type="text" class="form-textbox" id="input_30" name="q33_magazaM2" size="20" placeholder="Mağaza m2"/>
				</div>
				</li>
				<li class="form-line" id="id_34">
				<label class="form-label-left" id="label_34" for="input_29"></label>
				<div id="cid_34" class="form-input">
					<input type="text" class="form-textbox" id="input_31" name="q34_depoM2" size="20" placeholder="Depo m2"/>
				</div>
				</li>
				<li class="form-line" id="id_35">
				<label class="form-label-left" id="label_35" for="input_30"></label>
				<div id="cid_35" class="form-input">
					<input type="text" class="form-textbox" id="input_32" name="q35_toplamM2" size="20" placeholder="Toplam m2"/>
				</div>
				</li>
				<li class="form-line" id="id_38">
				<label class="form-label-left" id="label_38" for="input_31"></label>
				<div id="cid_38" class="form-input">
					<select class="form-dropdown" style="width:150px" id="input_13" name="q38_magaza">
						<option>Aktif mi ? </option>
						<option value="0">Aktif </option>
						<option value="1">Pasif </option>
					</select>
				</div>
				</li>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td><td>
				&nbsp;
			</td>
			<td>
				<li class="form-line" id="id_37">
				<div id="cid_37" class="form-input-wide">
					<div class="controls span9">
                    <button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;Kaydet&nbsp;&nbsp;&nbsp;&nbsp;</button>
                  </div>
				</div>
				</li>
			</ul>
		</form>
	</td>
</tr>
</tbody>
</table>
        
        </div>        
        
        
<?php endif;  ?>
  
<?php if($_GET['do'] === "duzenle"): ?>
<?php 
     if ($_GET['id']) : {
     $elma=$_GET['id'];
     $param=array (':ad'=> $elma ); 
foreach($generic->query('SELECT * FROM magaza WHERE id=:ad',$param) as $row) {
      
    for ( $counter = 2; $counter <= 40; $counter += 1) {

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
                        $idd=$_POST['firmID'];
                        $eposta=$generic->secure($_POST['eposta']);
                        
                        $param=array (':kod'=>$kod,':ad'=>$ad,':unvan'=>$unvan,
                            ':mtur_id' => $mtur_id,':mmtur_id'=>$mmtur_id,':dtur_id'=>$dtur_id,
                            ':stur_id'=>$stur_id,':ftur_id'=>$ftur_id,':sermaye'=>$sermaye,
                            ':vd'=>$vd,':vno'=>$vno,':miptal'=>$miptal,':msah'=>$msah,
                            ':msahtel'=>$msahtel,':mmud'=>$mmud,':mmudtel'=>$mmudtel,
                            ':mdahtel'=>$mdahtel,':mtel'=>$mtel,':mfax'=>$mfax,
                            ':mper'=>$mper,':mpere'=>$mpere,':mperk'=>$mperk,
                            ':marac'=>$marac,':gmyet'=>$gmyet,':gmtel'=>$gmtel,
                            ':gmfax'=>$gmfax,':gmadres'=>$gmadres,':dmyer'=>$dmyer,
                            ':mmt'=>$mmt,':dmt'=>$dmt,':tmt'=>$tmt,':notlar'=>$not,':eposta'=>$eposta
                        );
                        $param1=array (':kod'=>$kod,':ad'=>$ad,':unvan'=>$unvan,
                            ':mtur_id' => $mtur_id,':mmtur_id'=>$mmtur_id,':dtur_id'=>$dtur_id,
                            ':stur_id'=>$stur_id,':ftur_id'=>$ftur_id,':sermaye'=>$sermaye,
                            ':vd'=>$vd,':vno'=>$vno,':miptal'=>$miptal,':msah'=>$msah,
                            ':msahtel'=>$msahtel,':mmud'=>$mmud,':mmudtel'=>$mmudtel,
                            ':mdahtel'=>$mdahtel,':mtel'=>$mtel,':mfax'=>$mfax,
                            ':mper'=>$mper,':mpere'=>$mpere,':mperk'=>$mperk,
                            ':marac'=>$marac,':gmyet'=>$gmyet,':gmtel'=>$gmtel,
                            ':gmfax'=>$gmfax,':gmadres'=>$gmadres,':dmyer'=>$dmyer,
                            ':mmt'=>$mmt,':dmt'=>$dmt,':tmt'=>$tmt,':notlar'=>$not,':idd'=>$idd,':eposta'=>$eposta
                        );
                        
                        if ($_POST['formID']=="duzenle"):
                        {$generic->query("UPDATE magaza SET `kod` = :kod , `ad` = :ad, `unvan` = :unvan, `mtur_id` = :mtur_id,`mmtur_id`=:mmtur_id,`dtur_id`=:dtur_id ,`stur_id`=:stur_id ,`ftur_id`=:ftur_id ,`sermaye`=:sermaye ,`vd`=:vd ,`vno`=:vno ,`miptal`=:miptal ,`msah`=:msah ,`msahtel`=:msahtel ,`mmud`=:mmud ,`mmudtel`=:mmudtel ,`mdahtel`=:mdahtel ,`mtel`=:mtel ,`mfax`=:mfax ,`mper`=:mper ,`mpere`=:mpere ,`mperk`=:mperk ,`marac`=:marac ,`gmyet`=:gmyet ,`gmtel`=:gmtel ,`gmfax`=:gmfax ,`gmadres`=:gmadres ,`dmyer`=:dmyer ,`mmt`=:mmt ,`dmt`=:dmt ,`tmt`=:tmt ,`notlar`=:notlar,`eposta`=:eposta WHERE `id` = :idd",$param1);}
                        else :{
                        $generic->query('INSERT INTO magaza (kod,ad,unvan,mtur_id,mmtur_id,dtur_id,stur_id,ftur_id,sermaye,vd,vno,miptal,msah,msahtel,mmud,mmudtel,mdahtel,mtel,mfax,mper,mpere,mperk,marac,gmyet,gmtel,gmfax,gmadres,dmyer,mmt,dmt,tmt,notlar,eposta) VALUES ( :kod , :ad,:unvan,:mtur_id,:mmtur_id,:dtur_id,:stur_id,:ftur_id,:sermaye,:vd,:vno,:miptal,:msah,:msahtel,:mmud,:mmudtel,:mdahtel,:mtel,:mfax,:mper,:mpere,:mperk,:marac,:gmyet,:gmtel,:gmfax,:gmadres,:dmyer,:mmt,:dmt,:tmt,:notlar,:eposta)',$param);
                        }
                    endif;
		//	$this->token = !empty($_POST['token']) ? $_POST['token'] : '';
		//	$this->process();
              

		endif;
                ?>

    
      
    
    </div>
    <!-- End #container --> 
  </div>
  <div id="footer">
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

