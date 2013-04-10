<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php'); ?>
<?php if( !protectThis("*") ) :header( 'Location: login.php' );
endif; 
 
?>
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
          <ul id="collapse1" class="accordion-body collapse">
              <li><a href="magaza.php?do=ekle">Yeni Ekle</a></li>
              <li><a href="magaza.php?do=arama">Ara</a></li>
              <li><a href="magaza.php?do=sil">Sil</a></li>
              <li><a href="magaza.php?do=liste">Tam Liste</a></li>
              
          </ul>
        </li>
         <li class="accordion-group color_8 "> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse2">
                <img src="img/menu_icons/calendar.png"><span>Cari</span></a>
          <ul id="collapse2" class="accordion-body collapse ">
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
        <div class="span6 ">
        <div class="box color_3 title_big height_big paint_hover">
          <div class="title">
            <div class="row-fluid">
              <div class="span12">
                <h4> </i><span>Mağazalar</span> </h4>
              </div>
              <!-- End .span12 --> 
            </div>
            <!-- End .row-fluid --> 
            
          </div>
          <!-- End .title -->
          <div class="content" >
              <br><br><br><br><br><br>
              Mağaza ile ilgili tüm işlemleri buradan yapabilirsiniz.
              <div class="description " style="margin-top: 10px">
           <img src="../assets/images/market.png" style="width:100px;height: 100px;">
              </div>    
          </div>
          </div>
        </div>
        <!-- End .box .span6-->
        <div class="span6">
          <div class="row-fluid fluid">
            <div class="span6">
              <div class=" box color_2 height_medium paint_hover">
                <div class="content numbers">
                  <h3 class="value">İSTANBUL</h3>
                  <div class="description mb5">Hava Durumu</div>
                  <h1 class="value"> <?php
$site="http://weather.yahooapis.com/forecastrss?w=29391294&u=c";
$ssite=  file_get_contents($site);
$site1=  explode('</pubDate>', $ssite);
$site1= explode('temp="', $site1[1]);
$site1= explode('"', $site1[1]);

echo " ",$site1[0],"&deg;";
?>
                  <div class="description pull-right"><img src="<?php echo $site1[4]; ?>" class='pull-left'  ></div>
                </div>
              </div>
            </div>
            <!-- End .span6 -->
            <div class="span6">
              <div class="box color_25 height_medium paint_hover">
                <div class="content numbers">
                  <h4 class="value"> <?php  echo tarihcevir (date("d.m.Y")); ?></h4>
                  <div class="description mb5">Takvim</div>
                  <h1 class="value">
                        <span id=saat  class="fg-color-darken place-right" ></span>
<SCRIPT language=JScript>
saatigoster();
window.setInterval("saatigoster();",60000);
</SCRIPT>
</h1>
                  <div class="description"></div>
                </div>
              </div>
            </div>
            <!-- End .span6 --> 
          </div>
          <!-- End .row-fluid -->
          <div class="row-fluid fluid">
            <div class="span6">
              <div class=" box  height_medium title_big paint_hover">
                <div class="title">
                  <div class="row-fluid">
                    <div class="span12">
                      <h5> </i><span>Faturalar</span> </h5>
                    </div>
                    <!-- End .span12 --> 
                  </div>
                  <!-- End .row-fluid --> 
                </div>
                <!-- End .title -->
                <div class="content" style="padding-top:28px;">
                  <div id="placeholder2" style="width:100%;height:85px;"></div>
                  <div class="row-fluid description">
                    <div class="pull-left">SON 30 GÜN</div>
                    <div class="pull-right">BUGÜN</div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End .span6 -->
            <div class="span6">
              <div class=" box color_26 height_medium title_big paint_hover">
                  <div class="title">
                  <div class="row-fluid">
                    <div class="span12">
                      <h5> </i><span>Cari Hesaplar</span> </h5>
                    </div>
                  </div></div>
                <div class="content icon big_icon"> <a href="#" ><img align="right" src="img/general/contacts_icon.png" /></a>
                  <div class="description"></div>
                </div>
              </div>
            </div>
            <!-- End .span6 --> 
          </div>
          <!-- End .row-fluid --> 
          
        </div>
        <!-- End.span6--> 
      </div>
      <!-- End .row-fluid -->
      

      <?php 

// http://www.tcmb.gov.tr/kurlar/201303/27032013.xml
$content = file_get_contents("http://www.tcmb.gov.tr/kurlar/today.xml"); 

$dolar_bul = explode('<Currency Kod="USD" CurrencyCode="USD">' ,$content); 

$dolar_bul = explode('</ForexBuying>',$dolar_bul[1]); 

$dolar_alis = explode('<ForexBuying>',$dolar_bul[0]); 

$dolar_bul = explode('</ForexSelling>',$dolar_bul[1]); 

$dolar_satis = explode('<ForexSelling>',$dolar_bul[0]); 

$dolar_alis = $dolar_alis[1]; 

$dolar_satis = $dolar_satis[1]; 



$euro_bul = explode('<Currency Kod="EUR" CurrencyCode="EUR">' ,$content); 

$euro_bul = explode('</ForexBuying>',$euro_bul[1]); 

$euro_alis = explode('<ForexBuying>',$euro_bul[0]); 

$euro_bul = explode('</ForexSelling>',$euro_bul[1]); 

$euro_satis = explode('<ForexSelling>',$euro_bul[0]); 

$euro_alis = $euro_alis[1]; 

$euro_satis = $euro_satis[1]; 
?>
      <div class="row-fluid">
        <div class="row-fluid box color_2 title_medium height_medium2 bar_stats paint_hover ">
          <div class="title hidden-phone">
            <h5><span>USD</span></h5>
          </div>
          <!-- End .title -->
          <div class="content row-fluid fluid numbers">
            <div class="span3 stats hidden-phone">
              <div id="placeholder3" style="width:100%;height:65px;margin-top:7px"></div>
            </div>
            <div class="span2 average_ctr">
              <h5 class="value"><span class="percent"></span></h5>
              <div class="description mt15" ><?php  echo tarihcevir (date("d.m.Y")); ?></div>
            </div>
            <div class="span3 shown_left">
              <div class="row-fluid fluid">
                <div class="span6">
                  <div class="description">Alış</div>
                  <h2 class="value"><?php echo $dolar_alis; ?></h2>
                  <div class="progress small">
                    <div class="bar white" style="width: 100%;"></div>
                  </div>
                  <div class="description" ></div>
                </div>
                <div class="span6 full">
                  <div class="description text_color_dark">Satış</div>
                  <h2 class="value text_color_dark"><?php echo $dolar_satis; ?></h2>
                  <div class="progress small">
                    <div class="bar " style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="span3 total_days">
              <div class="row-fluid">
                <div class="span6 total_clicks">
                  <h1 class="value"></h1>
                  <div class="description mt15" ></div>
                </div>
                <div class="span6 days_left">
                  <h1 class="value text_color_dark"></h1>
                  <div class="description mt15" ></div>
                </div>
              </div>
            </div>
            <div class="span1 stick top right result height_medium2"> <img src="img/arrows_up.png">
              <div class="description mt15" ></div>
            </div>
          </div>
          <!-- End .row-fluid --> 
          <!-- End .content --> 
        </div>
        <!-- End .box --> 
        
      </div>
      <!-- End .row-fluid -->
      
      <div class="row-fluid">
        <div class="row-fluid box color_27 title_medium height_medium2 bar_stats paint_hover">
          <div class="title hidden-phone">
            <h5><span>Euro</span></h5>
          </div>
          <!-- End .title -->
          <div class="content row-fluid fluid numbers">
            <div class="span3 stats hidden-phone">
              <div id="placeholder4" style="width:100%;height:65px;margin-top:7px"></div>
            </div>
            <div class="span2 average_ctr">
              <h6 class="value"><span class="percent"></span></h6>
              <div class="description mt15" ><?php  echo tarihcevir (date("d.m.Y")); ?></div>
            </div>
            <div class="span3 shown_left">
              <div class="row-fluid fluid">
                <div class="span6">
                  <div class="description">Alış</div>
                  <h2 class="value"><?php echo $euro_alis; ?></h2>
                  <div class="progress small"  >
                    <div class="bar white " style="width: 100%;"></div>
                  </div>
                  <div class="description" ></div>
                </div>
                <div class="span6 full">
                  <div class="description text_color_dark">Satış</div>
                  <h2 class="value text_color_dark"><?php echo $euro_satis; ?></h2>
                  <div class="progress small">
                    <div class="bar" style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="span3 total_days">
              <div class="row-fluid">
                <div class="span6 total_clicks">
                  <h1 class="value"></h1>
                  <div class="description mt15" ></div>
                </div>
                <div class="span6 days_left">
                  <h1 class="value text_color_dark"></h1>
                  <div class="description mt15" ></div>
                </div>
              </div>
            </div>
            <div class="span1 stick top right result height_medium2"> <img src="img/arrows_down.png">
              <div class="description mt15" > </div>
            </div>
          </div>
          <!-- End .row-fluid --> 
          <!-- End .content --> 
        </div>
        <!-- End .box --> 
        
      </div>
      <!-- End .row-fluid -->
      
      
    
    </div>
    <!-- End #container --> 
 
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
<script type="text/javascript">
  /**** Specific JS for this page ****/
/* Todo Plugin */
var todo_data = [
{id: 1, title: "<i class='gicon-gift icon-white'><\/i>Have tea with the Queen", isDone: false},
{id: 2, title: "<i class='gicon-briefcase icon-white'><\/i>Steal  James Bond car", isDone: true},
{id: 3, title: "<i class='gicon-heart icon-white'><\/i>Confirm that this template is awesome", isDone: false},
{id: 4, title: "<i class='gicon-thumbs-up icon-white'><\/i>Nothing", isDone: false},  
{id: 5, title: "<i class='gicon-fire icon-white'><\/i>Play solitaire", isDone: false}         
];


function Task(data) {
  this.title = ko.observable(data.title);
  this.isDone = ko.observable(data.isDone);
  this.isEditing = ko.observable(data.isEditing);

  this.startEdit = function (event) {
      console.log("editing");
      this.isEditing(true);
  }

  this.updateTask = function (task) {
      this.isEditing(false);
  }
}

function TaskListViewModel() {
          // Data
          var self = this;
          self.tasks = ko.observableArray([]);
          self.newTaskText = ko.observable();
          self.incompleteTasks = ko.computed(function() {
              return ko.utils.arrayFilter(self.tasks(), 
                function(task) { 
                  return !task.isDone() && !task._destroy;
              });
          });

          self.completeTasks = ko.computed(function(){
              return ko.utils.arrayFilter(self.tasks(), 
                function(task) { 
                  return task.isDone() && !task._destroy;
              });
          });

          // Operations
          self.addTask = function() {
              self.tasks.push(new Task({ title: this.newTaskText(), isEditing: false }));

              self.newTaskText("");

          };
          self.removeTask = function(task) { self.tasks.destroy(task) };

          self.removeCompleted = function(){
              self.tasks.destroyAll(self.completeTasks());
          };

          /* Load the data */
          var mappedTasks = $.map(todo_data, function(item){
              return new Task(item);
          });

          self.tasks(mappedTasks);      
      }

      ko.applyBindings(new TaskListViewModel());  
      //End Todo Plugin

      </script><script type="text/javascript">

      //Chart - Campaigns
      $(function () {
        var data_campaigns = [[1,10], [2,9], [3,8], [4,6], [5,5], [6,3], [7,9], [8,10],[9,12],[10,14],[11,15],[12,13],[13,11],[14,10],[15,9],[16,8],[17,12],[18,14],[19,16],[20,19],[21,20],[22,20],[23,19],[24,17],[25,15],[25,14],[26,12],[27,10],[28,8],[29,10],[30,12],[31,10], [32,9], [33,8], [34,6], [35,5], [36,3], [37,9], [38,10],[39,12],[40,14],[41,15],[42,13],[43,11],[44,10],[45,9],[46,8],[47,12],[48,14],[49,16],[50,12],[51,10], [52,9], [53,8], [54,6], [55,5], [56,3], [57,9], [58,10],[59,12],[60,14],[61,15],[62,13],[63,11],[64,10],[65,9],[66,8],[67,12],[68,14],[69,16]];
        var data_campaigns2 = [[1,12], [2,10], [3,9], [4,8], [5,8], [6,8], [7,8], [8,8],[9,9],[10,9],[11,10],[12,11],[13,12],[14,11],[15,10],[16,10],[17,9],[18,10],[19,11],[20,11],[21,12],[22,13],[23,14],[24,13],[25,12],[25,12],[26,11],[27,10],[28,9],[29,8],[30,7],[31,7], [32,8], [33,8], [34,7], [35,6], [36,6], [37,7], [38,8],[39,8],[40,9],[41,10],[42,11],[43,11],[44,12],[45,12],[46,11],[47,10],[48,9],[49,8],[50,8],[51,9], [52,10], [53,11], [54,12], [55,12], [56,12], [57,13], [58,13],[59,12],[60,11],[61,10],[62,9],[63,8],[64,7],[65,7],[66,6],[67,5],[68,4],[69,3]];

        var plot = $.plot($("#placeholder"),
            [ { data: data_campaigns, color:"rgba(0,0,0,0.2)", shadowSize:0, 
            bars: {
              show: true,
              lineWidth: 0,
              fill: true,

              fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
          }
      } , 
      { data: data_campaigns2, 

          color:"rgba(255,255,255, 0.4)", 
          shadowSize:0,
          lines: {show:true, fill:false}, points: {show:false},
          bars: {show:false}
      }  
      ],     
      {
        series: {
         bars: {show:true, barWidth: 0.6}
     },
     grid: { show:false, hoverable: true, clickable: false, autoHighlight: true, borderWidth:0   },
     yaxis: { min: 0, max: 20 }

 });
       
        function showTooltip(x, y, contents) {
            $('<div id="tooltip"><div class="date">12 Nov 2012<\/div><div class="title text_color_3">'+x/10+'%<\/div> <div class="description text_color_3">CTR<\/div><div class="title ">'+x*12+'<\/div><div class="description">Impressions<\/div><\/div>').css( {
                position: 'absolute',
                display: 'none',
                top: y - 125,
                left: x - 40,
                border: '0px solid #ccc',
                padding: '2px 6px',
                'background-color': '#fff',
                opacity: 10
            }).appendTo("body").fadeIn(200);
        }

        var previousPoint = null;
        $("#placeholder").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                  previousPoint = item.dataIndex;
                  $("#tooltip").remove();
                  var x = item.datapoint[0].toFixed(2),
                  y = item.datapoint[1].toFixed(2);
                  showTooltip(item.pageX, item.pageY,
                    x);
              }
          }
      });

         //Fundraisers chart
         var data_fund = [[1,10], [2,9], [3,8], [4,6], [5,5], [6,3], [7,9], [8,10],[9,12],[10,14],[11,15],[12,13],[13,11],[14,10],[15,9],[16,8],[17,12],[18,14],[19,16],[20,19],[21,20],[22,20],[23,19],[24,17],[25,15],[25,14],[26,12],[27,10],[28,8],[29,10],[30,12],[31,10], [32,9], [33,8], [34,6], [35,5], [36,3], ];
         $.plot($("#placeholder2"),
           [ { data: data_fund, color:"#fff", shadowSize:0, 
           bars: {
              show: true,
              lineWidth: 0,
              fill: true,
              highlight: {
                opacity: 0.3
            },
            fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
        }
    } 
    ],     
    {
       series: {
         bars: {show:true, barWidth: 0.6}
     },
     grid: { show:false, hoverable: true, clickable: false, autoHighlight: true, borderWidth:0   },
     yaxis: { min: 0, max: 23 }

 });

         function showTooltip2(x, y, contents) {
          $('<div id="tooltip"><div class="title ">'+x*2+'</div><div class="description">Impressions</div></div>').css( {
            position: 'absolute',
            display: 'none',
            top: y - 58,
            left: x - 40,
            border: '0px solid #ccc',
            padding: '2px 6px',
            'background-color': '#fff',
            opacity: 10
        }).appendTo("body").fadeIn(200);
      }

      var previousPoint = null;
      $("#placeholder2").bind("plothover", function (event, pos, item) {
          $("#x").text(pos.x.toFixed(2));
          $("#y").text(pos.y.toFixed(2));
          if (item) {
            if (previousPoint != item.dataIndex) {
              previousPoint = item.dataIndex;
              $("#tooltip").remove();
              var x = item.datapoint[0].toFixed(2),
              y = item.datapoint[1].toFixed(2);
              showTooltip2(item.pageX, item.pageY,
                x);
          }
      }
  });
    //Envato chart
    $.plot($("#placeholder3"),
       [ { data: data_fund, color:"rgba(0,0,0,0.2)", shadowSize:0, 
       bars: {
          lineWidth: 0,
          fill: true,
          fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
      },
      lines: {show:false, fill:true}, points: {show:false} } 
  ],     
  {
   series: {
     bars: {show:true, barWidth: 0.6}
 },
 grid: { show:false, hoverable: true, clickable: false, autoHighlight: true, borderWidth:0   },
 yaxis: { min: 0, max: 23 }

});
    //Facebook chart
    $.plot($("#placeholder4"),
       [ { data: data_fund, color:"rgba(0,0,0,0.2)", shadowSize:0, 
       bars: {

          lineWidth: 0,
          fill: true,

          fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
      },
      lines: {show:false, fill:true}, points: {show:false}
  } 
  ],     
  {
   series: {
     bars: {show:true, barWidth: 0.6}
 },
 grid: { show:false, hoverable: true, clickable: false, autoHighlight: true, borderWidth:0   },
 yaxis: { min: 0, max: 23 }
});
    // End Fundraiser chart
});




</script>
</body>
</html>

<?php ob_flush(); ?>