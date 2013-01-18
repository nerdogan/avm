<?php

include_once( dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1");

if(empty($_POST))
	include_once('header.php');

include_once('classes/settings.class.php');
$settings = new Settings();
?>

	<div id="message"></div>

	  <div class="tabbable tabs-left">

		<ul class="nav nav-tabs">
			<li><a href="#general-options" data-toggle="tab"><i class="icon-cog"></i> <?php _e('Genel'); ?></a></li>
			<li><a href="#denied" data-toggle="tab"><i class="icon-exclamation-sign"></i> <?php _e('Reddedilenler'); ?></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-envelope"></i> <?php _e('Email'); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#emails-welcome" data-toggle="tab"><?php _e('Hoşgeldiniz'); ?></a></li>
                <li><a href="#emails-activate" data-toggle="tab"><?php _e('Aktif'); ?></a></li>
                <li><a href="#emails-forgot" data-toggle="tab"><?php _e('Unutulan'); ?></a></li>
                <li><a href="#emails-add-user" data-toggle="tab"><?php _e('Yeni Kullanıcı'); ?></a></li>
                <li><a href="#emails-acct-update" data-toggle="tab"><?php _e("'Hesabım' deıiğtir"); ?></a></li>
              </ul>
            </li>
			<li><a href="#user-profiles" data-toggle="tab"><i class="icon-user"></i> <?php _e('Profil'); ?></a></li>
			<li><a href="#integration" data-toggle="tab"><i class="icon-random"></i> <?php _e('Bütünleştirme'); ?></a></li>
			<li><a href="#update" data-toggle="tab"><i class="icon-flag"></i> <?php _e('Güncelle'); ?> <?php if($settings->newUpdate()) : ?><span class="label label-info"><?php _e('new'); ?></span><?php endif; ?></a></li>
		</ul>

		<form class="form-horizontal" method="post" action="settings.php" id="settings-form">

			<div class="tab-content">

				<!-- - - - - - - - - - - - - - - - -

						General

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="general-options">
					<?php include_once('page/general-options.php'); ?>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Denied messages

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="denied"></div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Welcome

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-welcome"></div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Activate

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-activate"></div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Forgot

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-forgot"></div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Add User

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-add-user"></div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Account update

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-acct-update"></div>

				<!-- - - - - - - - - - - - - - - - -

						Profiles

				- - - - - - - - - - - - - - - - - -->

				<div class="tab-pane fade" id="user-profiles"></div>

				<!-- - - - - - - - - - - - - - - - -

						Integration

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="integration"></div>

				<!-- - - - - - - - - - - - - - - - -

						Update

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="update"></div>

			</div>
			<div class="span12">
				<div class="form-actions">
					<button type="submit" data-loading-text="<?php _e('kaydediyor...'); ?>" data-complete-text="<?php _e('Changes saved'); ?>" name="save-settings" class="btn btn-primary" id="save-settings"><?php _e('Ayarları Kaydet'); ?></button>
				</div>
			</div>
		</form>
	  </div>

<?php include_once('footer.php'); ?>