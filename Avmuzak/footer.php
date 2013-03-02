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

	<footer>
		
		<p class="navbar-fixed-bottom fg-color-white" style="font-size: 30px">
                   
              <a href="http://onlinearge.com" target="_TOP" class="fg-color-darken"> &copy; Online Arge 2013 | v.1.0.0 </a>
			
		</p>
	</footer>

</div> <!-- /.container -->

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