<?php

include_once( dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1");

if ( !isset($_POST['add_user']) && !isset($_POST['add_level']) && !isset($_POST['searchUsers']) )
	include_once('header.php');

?>

		<div class="tabbable tabs-left">
			<div id="search_suggest"></div>
			<ul class="nav nav-tabs">
				<li><a href="#user-control" data-toggle="tab"><i class="icon-list"></i> <?php _e('Kullanıcılar'); ?></a></li>
				<li><a href="#level-control" data-toggle="tab"><i class="icon-list"></i> <?php _e('Erişim'); ?></a></li>
				<li><a href="#reports" data-toggle="tab"><i class="icon-folder-open"></i> <?php _e('Raporlar'); ?></a></li>
				<li><a href="#send-email" data-toggle="tab"><i class="icon-envelope"></i> <?php _e('Mail Gönder'); ?></a></li>
				<li><a href="settings.php"><i class="icon-cog"></i> <?php _e('Ayarlar'); ?></a></li>
			</ul>

			<div class="tab-content">

				<!-- - - - - - - - - - - - - - - - -

						Control users

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="user-control">
					<?php include_once('page/user-control.php'); ?>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Modify levels

				- - - - - - - - - - - - - - - - - -->

				<div class="tab-pane fade" id="level-control"></div>

				<!-- - - - - - - - - - - - - - - - -

						Reports

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="reports"></div>

				<!-- - - - - - - - - - - - - - - - -

						Send email

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="send-email"></div>

		</div>
		</div>

<?php include_once('footer.php'); ?>