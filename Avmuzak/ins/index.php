<?php

/**
 * Installs the PHP Login & User Management database
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

include_once("header.php");

$install = new Install();

class Install {

	private $error;
	private $link;
	private $options = array();
	public static $dbh;

	function __construct() {

		$this->checkInstall($hideError = true);

		if( !empty($_POST) ) :

			foreach ($_POST as $key => $value)
				$this->options[$key] = $value;

			$this->validate();

		endif;

		if(!empty($this->error))
			echo $this->error;

	}

	// Run any ol' query passed into this function
	public function query($query, $params = array()) {

		$stmt = self::$dbh->prepare($query);
		$stmt->execute($params);

		return $stmt;

	}

	// Check for all form fields to be filled out
	private function validate() {

		if(strlen($this->options['adminPass']) < 5)
			$this->error = '<div class="alert alert-error">'._('Password must be at least 5 characters.').'</div>';
		else
			$this->options['adminPass'] = md5($this->options['adminPass']);

		if( empty($this->options['dbHost']) || empty($this->options['dbUser']) || empty($this->options['dbName']) || empty($this->options['scriptPath']) || empty($this->options['email']) || empty($this->options['adminUser']) || empty($this->options['adminPass'] ))
			$this->error = '<div class="alert alert-error">'._('Fill out all the details please').'</div>';

		if(substr($this->options['scriptPath'], -1) != '/')
			$this->options['scriptPath'] = $this->options['scriptPath'] . '/';

		// Check the database connection
		$this->dbLink();

	}

	// See if I can connect to the mysql server
	private function dbLink() {

		if(!empty($this->error)) return false;

		try {
			self::$dbh = new PDO("mysql:host=" . $this->options['dbHost'] . ";dbname=" . $this->options['dbName'], $this->options['dbUser'], $this->options['dbPass']);
			self::$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch (PDOException $e) {
			$this->error = '<div class="alert alert-error">'._('Database error: '). $e->getMessage() . '</div>';
		}

		$this->existingTables();

	}

	// Check for an existing install
	private function existingTables() {

		if(empty($this->error)) :

			$this->insertSQL();
			$this->writeFile();
			$this->checkInstall();

		endif;

	}

	// Begin inserting our SQL goodies
	private function insertSQL() {

		if(empty($this->error)) {

			$this->query("SET NAMES utf8;");

			$this->query("
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

			$this->query("
				CREATE TABLE IF NOT EXISTS `login_integration` (
				  `user_id` int(255) NOT NULL,
				  `facebook` varchar(255) NOT NULL,
				  `twitter` varchar(255) NOT NULL,
				  `google` varchar(255) NOT NULL,
				  `yahoo` varchar(255) NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`user_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
			");

			$this->query("
				CREATE TABLE IF NOT EXISTS `login_levels` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `level_name` varchar(255) NOT NULL,
				  `level_level` int(1) NOT NULL,
				  `level_disabled` tinyint(1) NOT NULL DEFAULT '0',
				  `redirect` varchar(255) NULL,
				  `welcome_email` tinyint(1) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `level_level` (`level_level`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
			");

			$this->query("
				INSERT IGNORE INTO `login_levels` (`id`, `level_name`, `level_level`, `level_disabled`) VALUES
				(1, 'Admin', 1, 0),
				(2, 'Special', 2, 0),
				(3, 'User', 3, 0);
			");

			$this->query("
				CREATE TABLE IF NOT EXISTS `login_profiles` (
				  `p_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				  `pfield_id` INT(255) unsigned NOT NULL,
				  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
				  `profile_value` longtext,
				  PRIMARY KEY (`p_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			");

			$this->query("
				CREATE TABLE IF NOT EXISTS `login_settings` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `option_name` varchar(255) NOT NULL,
				  `option_value` longtext NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `id` (`id`),
				  UNIQUE KEY `option_name` (`option_name`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			");

			$params = array(
				':site_address'      => $this->options['scriptPath'],
				':admin_email'       => $this->options['email'],
				':guest_redirect'    => $this->options['scriptPath'] . 'login.php?e=1',
				':new_user_redirect' => $this->options['scriptPath'] . 'profile.php'
			);
			$this->query("
				INSERT IGNORE INTO `login_settings` (`id`, `option_name`, `option_value`) VALUES
				(1, 'site_address', :site_address),
				(2, 'default_session', '0'),
				(3, 'admin_email', :admin_email),
				(4, 'block-msg-enable', '1'),
				(5, 'block-msg', '<h1>Sorry, Hank.</h1>\r\n\r\n<p>We have detected that your user level does not entitle you to view the page requested.</p>\r\n\r\n<p>Please contact the website administrator if you feel this is in error.</p>\r\n\r\n<h5>What to do now?</h5>\r\n<p>To see this page you must <a href=''logout.php''>logout</a> and login with sufficiant privileges.</p>'),
				(6, 'block-msg-out', 'You need to login to do that.'),
				(7, 'block-msg-out-enable', '1'),
				(8, 'email-welcome-msg', 'Hello {{full_name}} !\r\n\r\nThanks for registering at {{site_address}}. Here are your account details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}\r\nPassword: *hidden*\r\n\r\nYou will first have to activate your account by clicking on the following link:\r\n\r\n{{activate}}'),
				(9, 'email-activate-msg', 'Hi there {{full_name}} !\r\n\r\nYour account at {{site_address}} has been successfully activated :). \r\n\r\nFor your reference, your username is <strong>{{username}}</strong>. \r\n\r\nSee you soon!'),
				(10, 'email-activate-subj', 'You''ve activated your account at Jigowatt !'),
				(11, 'email-activate-resend-subj', 'Here''s your activation link again for Jigowatt'),
				(12, 'email-activate-resend-msg', 'Why hello, {{full_name}}. \r\n\r\nI believe you requested this:\r\n{{activate}}\r\n\r\nClick the link above to activate your account :)'),
				(13, 'email-welcome-subj', 'Thanks for signing up with Jigowatt :)'),
				(14, 'email-forgot-success-subj', 'Your password has been reset at Jigowatt'),
				(15, 'email-forgot-success-msg', 'Welcome back, {{full_name}} !\r\n\r\nI''m just letting you know your password at {{site_address}} has been successfully changed. \r\n\r\nHopefully you were the one that requested this password reset !\r\n\r\nCheers'),
				(16, 'email-forgot-subj', 'Lost your password at Jigowatt?'),
				(17, 'email-forgot-msg', 'Hi {{full_name}},\r\n\r\nYour username is <strong>{{username}}</strong>.\r\n\r\nTo reset your password at Jigowatt, please click the following password reset link:\r\n{{reset}}\r\n\r\nSee you soon!'),
				(18, 'email-add-user-subj', 'You''re registered with Jigowatt !'),
				(19, 'email-add-user-msg', 'Hello {{full_name}} !\r\n\r\nYou''re now registered at {{site_address}}. Here are your account details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}\r\nPassword: {{password}}'),
				(20, 'pw-encrypt-force-enable', '0'),
				(21, 'pw-encryption', 'MD5'),
				(22, 'phplogin_db_version', '1206210'),
				(23, 'email-acct-update-subj', 'Confirm your account changes'),
				(24, 'email-acct-update-msg', 'Hi {{full_name}} !\r\n\r\nYou ( {{username}} ) requested a change to update your password or email. Click the link below to confirm this change.\r\n\r\n{{confirm}}\r\n\r\nThanks!\r\n{{site_address}}'),
				(25, 'email-acct-update-success-subj', 'Your account has been updated'),
				(26, 'email-acct-update-success-msg', 'Hello {{full_name}},\r\n\r\nYour account details at {{site_address}} has been updated. \r\n\r\nYour username: {{username}}\r\n\r\nSee you around!'),
				(27, 'guest-redirect', :guest_redirect),
				(28, 'signout-redirect-referrer-enable', 1),
				(29, 'signin-redirect-referrer-enable', 1),
				(30, 'default-level', 'a:1:{i:0;s:1:\"3\";}'),
				(31, 'new-user-redirect', :new_user_redirect),
				(32, 'user-activation-enable', '1'),
				(33, 'email-new-user-subj', 'A new user has registered !'),
				(34, 'email-new-user-msg', 'Hello,\r\n\r\nThere''s been a new registration at &lt;a href=&quot;{{site_address}}&quot;&gt;your site&lt;/a&gt;.\r\n\r\nHere''s the user''s details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}');
			", $params);

			$this->query("
				CREATE TABLE IF NOT EXISTS `login_users` (
				  `user_id` int(8) NOT NULL AUTO_INCREMENT,
				  `user_level` longtext NOT NULL,
				  `restricted` int(1) NOT NULL DEFAULT '0',
				  `username` varchar(15) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `email` varchar(255) NOT NULL,
				  `password` varchar(128) NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY (`user_id`),
				  UNIQUE KEY `user_id` (`user_id`),
				  UNIQUE KEY `username` (`username`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
			");

			$this->query("
				CREATE TABLE IF NOT EXISTS `login_profile_fields` (
				  `id` int(255) NOT NULL AUTO_INCREMENT,
				  `section` varchar(255) NOT NULL,
				  `type` varchar(25) NOT NULL,
				  `label` varchar(255) NOT NULL,
				  `public` TINYINT NOT NULL,
				  `signup` varchar(255) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
			");

			$this->query("
				CREATE TABLE IF NOT EXISTS `login_timestamps` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_id` int(11) NOT NULL,
				  `ip` varchar(255) NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
			");

			$params = array(
				':admin_user'  => $this->options['adminUser'],
				':admin_email' => $this->options['email'],
				':admin_pass'  => $this->options['adminPass']
			);
			$this->query("
				INSERT IGNORE INTO `login_users` (`user_id`, `user_level`, `restricted`, `username`, `name`, `email`, `password`) VALUES
				(1, 'a:3:{i:0;s:1:\"3\";i:1;s:1:\"1\";i:2;s:1:\"2\";}', 0, :admin_user, 'Demo Admin', :admin_email, :admin_pass),
				(2, 'a:2:{i:0;s:1:\"2\";i:1;s:1:\"3\";}', 0, 'special', 'Demo Special', 'test.special@jigowatt.co.uk', '0bd6506986ec42e732ffb866d33bb14e'),
				(3, 'a:1:{i:0;s:1:\"3\";}', 0, 'user', 'Demo User', 'test.user@jigowatt.co.uk', 'ee11cbb19052e40b07aac0ca060c23ee');
			", $params);

		} else $this->error = 'Your tables already exist! I won\'t insert anything.';
	}

	private function writeFile() {

		if($this->error == '') {

			/** Write config.php if it doesn't exist */
			$fp = @fopen("../classes/config.php", "w");

			if( !$fp ) :
				echo '<div class="alert alert-warning">'._('Could not create <code>/classes/config.php</code>, please confirm you have permission to create the file.').'</div>';
				return false;
			endif;


fwrite($fp, '<?php

////////////////////
// Important ! These must be filled in correctly.
// Database details are required to use this script.

$host = "'.$this->options['dbHost'].'"; // If you don\'t know what your host is, it\'s safe to leave it localhost
$dbName = "'.$this->options['dbName'].'"; // Database name
$dbUser = "'.$this->options['dbUser'].'"; // Username
$dbPass = "'.$this->options['dbPass'].'"; // Password

?>');
			fclose($fp);
		}

	}

	private function checkInstall($hideError = false) {

			if (file_exists('../classes/config.php')) : ?>
				<div class="row">
					<div class="span8">
						<div class="alert alert-success"><?php _e('Hooray ! Installation is all done :)'); ?></div>
						<p><span class='label label-important'><?php _e('Important'); ?></span> <?php _e('Please delete or rename the install folder to prevent intrustion'); ?></p>
					</div>
					<div class="span6">
						<h5><?php _e('What to do now?'); ?></h5>
						<p><?php _e('Check out your'); ?> <a href="../home.php"><?php _e('home'); ?></a> <?php _e('page.'); ?></p>
					</div>
				</div> <?php
				include('footer.php');
				exit();
			else :
				if (!$hideError) $this->error = '<div class="alert alert-error">'._('Installation is not complete.').'</div>';
			endif;
	}

}
?>
<div class="row">
	<div class="span9">
		<form class="form-horizontal" method="post" action="index.php">

			<fieldset>
				<legend><?php _e('Database Info'); ?></legend>
				<div class="control-group">
					<label class="control-label" for="dbHost"><?php _e('Host'); ?></label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="dbHost" name="dbHost" value="<?php if(isset($_POST['dbHost'])) echo $_POST['dbHost']; ?>" placeholder="localhost">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="dbName"><?php _e('Database name'); ?></label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="dbName" name="dbName" value="<?php if(isset($_POST['dbName'])) echo $_POST['dbName']; ?>" placeholder="<?php _e('database_name'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="dbUser"><?php _e('Username'); ?></label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="dbUser" name="dbUser" value="<?php if(isset($_POST['dbUser'])) echo $_POST['dbUser'];?>" placeholder="<?php _e('db username'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="dbPass"><?php _e('Password'); ?></label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="dbPass" name="dbPass" value="<?php if(isset($_POST['dbPass'])) echo $_POST['dbPass']; ?>" placeholder="<?php _e('db password'); ?>">
					</div>
				</div>
			</fieldset>

			<fieldset>
				<legend><?php _e('Site Settings'); ?></legend>
				<div class="control-group">
					<label class="control-label" for="scriptPath"><?php _e('Site address'); ?></label>
					<div class="controls">
						<input type="url" class="input-xlarge" id="scriptPath" name="scriptPath" value="<?php if(isset($_POST['scriptPath'])) echo $_POST['scriptPath']; ?>" placeholder="<?php echo "http://".$_SERVER['HTTP_HOST'].str_replace("install/index.php","",str_replace("functions","",str_replace("\\","/",$_SERVER['SCRIPT_NAME']))); ?>">
						<p class="help-block"><?php _e('This path should be set to where activate.php is located'); ?></p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email"><?php _e('Admin email'); ?></label>
					<div class="controls">
						<input type="email" class="input-xlarge" id="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" placeholder="<?php echo 'no-reply@'.$_SERVER['HTTP_HOST']; ?>">
						<p class="help-block"><?php _e('This email address will be visible to your users'); ?></p>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<legend><?php _e('Admin Account'); ?></legend>
				<div class="control-group">
					<label class="control-label" for="adminUser"><?php _e('Username'); ?></label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="adminUser" name="adminUser" value="<?php if(isset($_POST['adminUser'])) echo $_POST['adminUser']; ?>" placeholder="<?php _e('admin'); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="adminPass"><?php _e('Password'); ?></label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="adminPass" name="adminPass" value="<?php if(isset($_POST['adminPass'])) echo $_POST['adminPass']; ?>" placeholder="<?php _e('admin'); ?>">
					</div>
				</div>
			</fieldset>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary"><?php _e('Install'); ?></button>
			</div>

		</form>

	</div>
</div>

<?php include_once("footer.php"); ?>