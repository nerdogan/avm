<!-- Footer
================================================== -->
<?php 
/*
$dsn = 'mysql:host=localhost;dbname=arge_avm';
$user = 'arge_av';
$password = 'nmk171717';
 
try {
   $magaza = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
}  
$statement="select * from magaza";
$select=$generic->query($statement);
$total_column = $select->columnCount();
var_dump($total_column);

for ($counter = 0; $counter <= $total_column; $counter ++) {
    $meta = $select->getColumnMeta($counter);
    $column[] = $meta['name'];
}
print_r($column);*/
?>
<?php if( protectThis("*") ) : ?>

<div class="charms">
    
    <img src="./assets/images/duyuru.PNG">
     <table class="" border="0" cellpadding="5" cellspacing="1" style="" >
  
  <?php

  $number=0;  
  $liste=$generic->query('SELECT * FROM duyuru ');
  foreach( $liste as $row) {
      $number++;
      echo "<tr><td style='width:90px;'><img style='width:90px;height:60px;' src='",$row[3],"'></td><td><h4>",$row[1],"</h4><p>",$row[2],"</p></td></tr>\n";
  }


?>
     </table>
        <br>  
           <img src="./assets/images/reklam.PNG"> <br>
           <img src="./assets/images/reklamtest.jpg">
</div> 
<?php endif; ?>

<div class="app-bar2">
    
    
</div>
	<footer>
		
		<p class="navbar-fixed-bottom fg-color-white" style="font-size: 30px">
                   
              <a href="http://onlinearge.com" target="_TOP" class="fg-color-darken"> &copy; Online Arge 2013 | v.1.0.0 </a>
			
		</p>
	</footer>
 <!-- /.container -->

	<!-- Le javascript -->
	<!-- Le javascript -->
	<!-- Le javascript 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> -->
	<script src="assets/js/bootstrap-transition.js"></script>
	<script src="assets/js/bootstrap-collapse.js"></script>
	<script src="assets/js/bootstrap-modal.js"></script>
	<script src="assets/js/bootstrap-dropdown.js"></script>
	<script src="assets/js/bootstrap-button.js"></script>
	<script src="assets/js/bootstrap-tab.js"></script>
	<script src="assets/js/bootstrap-alert.js"></script>
	<script src="assets/js/bootstrap-tooltip.js"></script>
	<script src="assets/js/jquery.ba-hashchange.min.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/jquery.placeholder.min.js"></script>
	<script src="assets/js/jquery.jigowatt.js"></script>

  </body>
</html>
<?php ob_flush(); ?>