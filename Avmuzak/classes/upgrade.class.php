<?php

/**
 * Runs database updates if required.
 *
 * LICENSE:
 *
 * This source file is subject to the licensing terms that
 * is available through the world-wide-web at the following URI:
 * http://codecanyon.net/wiki/support/legal-terms/licensing-terms/.
 *
 * @author       Jigowatt <info@jigowatt.co.uk>
 * @author       Matt Gates <matt.gates@jigoshop.com>
 * @copyright    Copyright © 2009-2012 Jigowatt Ltd.
 * @license      http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
 * @link         http://codecanyon.net/item/php-login-user-management/49008
 */

include_once ( 'generic.class.php' );

class PHPLogin_upgrade extends Generic {

	function __construct() {

		// Begin !
		$this->jigowatt_upgrade();

		// Message shown to user
		if(!empty($this->result)) parent::displayMessage($this->result, false);

	}

	/**
	 * Checks if an update is required.
	 *
	 * First grabs the db version from the database. If that
	 * version equals the latest db version, then do nothing.
	 * Otherwise, run the respective update.
	 */
	private function jigowatt_upgrade() {

		$phplogin_db_version = parent::getOption('phplogin_db_version');

		// Nothing to do here...Move along.
		if( $phplogin_db_version == phplogin_db_version )
			return false;

		$this->result = '
		<div class="alert alert-block alert-danger fade in">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			<h4 class="alert-danger">' . _('Database update required') . '</h4>
			<p>Your database needs to be updated. Promise me you\'ll <strong>backup</strong> your database before upgrading?</p>
			<p><a href="?update=1" class="btn btn-danger">I\'ve backed up, let\'s do this!</a></p>
		</div>';

		if (!empty($_GET['update'])) :

			if ( $phplogin_db_version < 1203040 )
				$this->upgrade_250();

			if ( $phplogin_db_version < 1203080 )
				$this->upgrade_251();

			if ( $phplogin_db_version < 1203090 )
				$this->upgrade_252();

			if ( $phplogin_db_version < 1204160 )
				$this->upgrade_255();

			if ( $phplogin_db_version < 1204300 )
				$this->upgrade_256();

			if ( $phplogin_db_version < 1205180 )
				$this->upgrade_257();

			if ( $phplogin_db_version < 1206210 )
				$this->upgrade_300();

			$this->result = "<div class='alert alert-success'>Your database has been successfully updated !</div>";

		endif;

	}

	private function upgrade_250() {

		// Settings table
		parent::query("
			CREATE TABLE IF NOT EXISTS `login_settings` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `option_name` varchar(255) NOT NULL,
			  `option_value` longtext NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `id` (`id`)
			)
		");

		// Profiles table
		parent::query("
			CREATE TABLE IF NOT EXISTS `login_profiles` (
			  `p_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
			  `profile_label` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `profile_value` longtext CHARACTER SET utf8,
			  PRIMARY KEY (`p_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;
		");

		// Attempt to insert current config settings to the database
		@include('config.php');

		parent::query("
			INSERT INTO `login_settings` (`option_name`, `option_value`) VALUES
			('site_address', '".SITE_PATH."'),
			('default_session', '$minutes'),
			('admin_email', '$address'),
			('block-msg-enable', '1'),
			('block-msg', '<h1>Sorry, Hank.</h1>\r\n\r\n<p>We have detected that your user level does not entitle you to view the page requested.</p>\r\n\r\n<p>Please contact the website administrator if you feel this is in error.</p>\r\n\r\n<h5>What to do now?</h5>\r\n<p>To see this page you must <a href=''logout.php''>logout</a> and login with sufficiant privileges.</p>'),
			('block-msg-out', 'You need to login to do that.'),
			('block-msg-out-enable', '1'),
			('email-welcome-msg', 'Hello {{full_name}} !\r\n\r\nThanks for registering at {{site_address}}. Here are your account details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}\r\nPassword: *hidden*\r\n\r\nYou will first have to activate your account by clicking on the following link:\r\n\r\n{{activate}}'),
			('email-activate-msg', 'Hi there {{full_name}} !\r\n\r\nYour account at {{site_address}} has been successfully activated :). \r\n\r\nFor your reference, your username is <strong>{{username}}</strong>. \r\n\r\nSee you soon!'),
			('email-activate-subj', 'You''ve activated your account at Jigowatt !'),
			('email-activate-resend-subj', 'Here''s your activation link again for Jigowatt'),
			('email-activate-resend-msg', 'Why hello, {{full_name}}. \r\n\r\nI believe you requested this:\r\n{{activate}}\r\n\r\nClick the link above to activate your account :)'),
			('email-welcome-subj', 'Thanks for signing up with Jigowatt :)'),
			('email-forgot-success-subj', 'Your password has been reset at Jigowatt'),
			('email-forgot-success-msg', 'Welcome back, {{full_name}} !\r\n\r\nI''m just letting you know your password at {{site_address}} has been successfully changed. \r\n\r\nHopefully you were the one that requested this password reset !\r\n\r\nCheers'),
			('email-forgot-subj', 'Lost your password at Jigowatt?'),
			('email-forgot-msg', 'Hi {{full_name}},\r\n\r\nYour username is <strong>{{username}}</strong>.\r\n\r\nTo reset your password at Jigowatt, please click the following password reset link:\r\n{{reset}}\r\n\r\nSee you soon!'),
			('email-add-user-subj', 'You''re registered with Jigowatt !'),
			('email-add-user-msg', 'Hello {{full_name}} !\r\n\r\nYou''re now registered at {{site_address}}. Here are your account details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}\r\nPassword: {{password}}'),
			('profile-fields', 'a:1:{s:11:\"textarea[0]\";s:3:\"Bio\";}'),
			('phplogin_version', '2.50'),
			('phplogin_db_version', '1203040');
		");

	}

	private function upgrade_251() {

		parent::updateOption('phplogin_db_version', 1203080);
		parent::updateOption('phplogin_version', 2.51);
		parent::updateOption('pw-encrypt-force-enable', 0);
		parent::updateOption('pw-encryption', 'MD5');

	}

	private function upgrade_252() {

		parent::updateOption('phplogin_db_version', 1203090);
		parent::query("ALTER IGNORE TABLE  `login_users` CHANGE  `password`  `password` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		parent::query("ALTER TABLE `login_settings` ADD UNIQUE (`option_name`)");

	}

	private function upgrade_255() {

		parent::query("
			CREATE TABLE IF NOT EXISTS `login_confirm` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `data` varchar(255) NOT NULL,
			  `username` varchar(255) NOT NULL,
			  `email` varchar(255) NOT NULL,
			  `key` varchar(255) NOT NULL,
			  `type` varchar(25) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		");

		parent::query("
			CREATE TABLE IF NOT EXISTS `login_profile_fields` (
			  `id` int(255) NOT NULL AUTO_INCREMENT,
			  `section` varchar(255) NOT NULL,
			  `type` varchar(25) NOT NULL,
			  `label` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
		");

		parent::query("
			CREATE TABLE IF NOT EXISTS `login_integration` (
			  `user_id` int(255) NOT NULL,
			  `facebook` varchar(255) NOT NULL,
			  `twitter` varchar(255) NOT NULL,
			  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`user_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
		");

		parent::query("
			CREATE TABLE IF NOT EXISTS `login_timestamps` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `ip` varchar(255) NOT NULL,
			  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		");

		/** Add a new column for redirecting certain levels. */
		parent::query("ALTER TABLE  `login_levels` ADD  `redirect` VARCHAR( 255 ) NULL");

		/** Unserialize all timestamps. */
		$sql = "SELECT * FROM `login_profiles` WHERE `profile_label` = 'p-timestamp'";
		$result = parent::query($sql);

		while($row = $result->fetch(PDO::FETCH_ASSOC)) :

			$timestamps = unserialize($row['profile_value']);

			foreach($timestamps as $time => $location) :

				$sql = sprintf("INSERT INTO `login_timestamps` (`user_id` ,`ip` ,`timestamp`) VALUES ('%s',  '%s', '%s');", $row['user_id'], $location, date("Y-m-d H:i:s",$time));

				parent::query($sql);

			endforeach;

			$sql = "DELETE FROM `login_profiles` WHERE `profile_label` = 'p-timestamp'";
			parent::query($sql);

		endwhile;

		/** Unserialize all user profile fields. */
		$profileFields = unserialize(parent::getOption('profile-fields'));

		if (!empty($profileFields)) :
			foreach($profileFields as $type => $label) :
				$sql = sprintf("INSERT INTO `login_profile_fields` (`section` ,`type` ,`label`) VALUES ('%s',  '%s', '%s');", "Profile", substr_replace($type, '', -3), $label);
				parent::query($sql);
			endforeach;
		endif;

		$sql = "DELETE FROM `login_settings` WHERE `option_name` = 'profile-fields'";
		parent::query($sql);

		/** Merge `login_activate` & `login_forgot` into `login_confirm`. */
		$sql = "SELECT * FROM `login_activate`";
		$result = parent::query($sql);

		while($row = $result->fetch(PDO::FETCH_ASSOC)) :
			$sql = sprintf("INSERT INTO `login_confirm` (`username`, `key`, `email`, `type`) VALUES ('%s', '%s', '%s', '%s');", $row['username'], $row['code'], $row['email'], 'new_user');
			parent::query($sql);
		endwhile;
		parent::query("DROP TABLE `login_activate`");

		$sql = "SELECT * FROM `login_forgot`";
		$result = parent::query($sql);

		while($row = $result->fetch(PDO::FETCH_ASSOC)) :
			$sql = sprintf("INSERT INTO `login_confirm` (`key`, `email`, `type`) VALUES ('%s', '%s', '%s');", $row['code'], $row['email'], 'forgot_pw');
			parent::query($sql);
		endwhile;
		parent::query("DROP TABLE `login_forgot`");

		/** Update db version. */
		parent::updateOption('phplogin_db_version', 1204160);

		parent::query("
		 INSERT INTO `login_settings` (`option_name`, `option_value`) VALUES
		  ('guest-redirect', '" . SITE_PATH . "login.php?e=1'),
		  ('email-acct-update-subj', 'Confirm your account changes'),
		  ('email-acct-update-msg', 'Hi {{full_name}} !\r\n\r\nYou ( {{username}} ) requested a change to update your password or email. Click the link below to confirm this change.\r\n\r\n{{confirm}}\r\n\r\nThanks!\r\n{{site_address}}'),
		  ('email-acct-update-success-subj', 'Your account has been updated'),
		  ('signout-redirect-referrer-enable', 1),
		  ('signin-redirect-referrer-enable', 1),
		  ('email-acct-update-success-msg', 'Hello {{full_name}},\r\n\r\nYour account details at {{site_address}} has been updated. \r\n\r\nYour username: {{username}}\r\n\r\nSee you around!'),
		  ('default-level', 'a:1:{i:0;s:1:\"3\";}');"
		);

	}

	private function upgrade_256() {

		parent::query('
			ALTER TABLE  `login_integration`
			ADD  `google` VARCHAR( 255 ) NULL ,
			ADD  `yahoo` VARCHAR( 255 ) NULL ,
			ADD  `openid` VARCHAR( 255 ) NULL ,
			CHANGE  `fb_id`  `facebook` VARCHAR( 255 ) NOT NULL ,
			CHANGE  `twit_id`  `twitter` VARCHAR( 255 ) NOT NULL
		');

		parent::query('ALTER TABLE  `login_users` CHANGE  `username`  `username` VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;');

		parent::query("
			INSERT INTO `login_settings` (`option_name`, `option_value`) VALUES
			 ('new-user-redirect', '" . SITE_PATH . "profile.php'),
			 ('user-activation-enable', '1');"
		);

		parent::updateOption('phplogin_db_version', 1204300);

	}

	private function upgrade_257() {

		/* Add the profile id to each current profile id */
		parent::query("ALTER TABLE  `login_profiles` ADD  `pfield_id` INT( 255 ) NOT NULL AFTER  `p_id`");

		$sql = "SELECT DISTINCT `profile_label` FROM `login_profiles`;";
		$stmt = parent::query($sql);

		$fields = array();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			$fields[] = substr($row['profile_label'], 2);

		if (!empty($fields)) {

			foreach ($fields as $key => $label) :
				$params = array( ':label' => $label, ':oldLabel' => 'p-'.$label );
				$sql = "UPDATE `login_profiles` SET `pfield_id` = (SELECT DISTINCT `id` FROM `login_profile_fields` WHERE `label` = :label) WHERE `profile_label` = :oldLabel";
				parent::query($sql, $params);
			endforeach;

		}

		parent::updateOption('phplogin_db_version', 1205180);

	}

	private function upgrade_300() {

		/* Admin signup notifications */
		$sql = "INSERT INTO `login_settings` (`option_name`, `option_value`) VALUES
				('email-new-user-subj', 'A new user has registered !'),
				('email-new-user-msg', 'Hello,\r\n\r\nThere''s been a new registration at &lt;a href=&quot;{{site_address}}&quot;&gt;your site&lt;/a&gt;.\r\n\r\nHere''s the user''s details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}');
				";

		parent::query($sql);

		/* Signup fields for profiles. */
		$sql = "ALTER TABLE  `login_profile_fields` ADD  `public` TINYINT NOT NULL, ADD `signup` VARCHAR( 255 ) NOT NULL";
		parent::query($sql);
		
		/* Support for welcome email on levels. */
		$sql = "ALTER TABLE  `login_levels` ADD  `welcome_email` TINYINT NOT NULL DEFAULT  '0'";
		parent::query($sql);

		parent::updateOption('phplogin_db_version', 1206210);

	}

}

$upgrade = new PHPLogin_upgrade();