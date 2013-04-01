<?php

/**
 * Verify and execute the login process.
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

include_once( 'integration.class.php' );

class Login extends jigowatt_integration {

	// Post vars
	private $user;
	private $pass;

	// Misc vars
	private $token;
	private $valid;
	private $result;
	private $error;
	private $msg;

	function __construct() {

		// Redirect the logging in user
		if ( parent::getOption('signin-redirect-referrer-enable') )
			$_SESSION['jigowatt']['referer'] = (!empty($_SESSION['jigowatt']['referer'])) ? $_SESSION['jigowatt']['referer'] : 'home.php';
		else
			$_SESSION['jigowatt']['referer'] = parent::getOption('signin-redirect-url');

		// Are they attempting to access a secure page?
		$this->isSecure();

		// Only allow guests to view this page
		parent::guestOnly();

		// Generate a unique token for security purposes
		parent::generateToken();

		// Login form post data
		if(isset($_POST['login'])) :
			$this->user = parent::secure($_POST['username']);
			$this->pass = parent::secure($_POST['password']);

			$this->token = !empty($_POST['token']) ? $_POST['token'] : '';
			$this->process();
		endif;

		if( !empty($_GET['login']) || !empty($_GET['link']) )
			!empty($_GET['link']) ? parent::link_account($_GET['link'], true) : parent::link_account($_GET['login'], true);

		foreach (parent::$socialLogin as $provider) :
			if (!empty($_SESSION['jigowatt'][$provider])) {
				$this->social_login($provider);
				break;
			}
		endforeach;

		// Display the errors and do not exit the page
		$this->error ? parent::displayMessage($this->error, false) : parent::displayMessage($this->msg, false);

	}

	private function social_login($provider) {

		$params = array( ':session' => $_SESSION['jigowatt'][$provider] );
		$stmt = parent::query("SELECT `user_id` FROM `login_integration` WHERE `$provider` = :session;", $params);

		if ($stmt->rowCount() > 0) {

			$result = $stmt->fetch();

			$params = array( ':user_id' => $result['user_id'] );
			$stmt = parent::query("SELECT * FROM `login_users` WHERE `user_id` = :user_id;", $params);

			$this->result = $stmt->fetch();
			$this->user = $this->result['username'];

			$this->login();

		} else {

			unset(
				$_SESSION['jigowatt']['ot'],
				$_SESSION['jigowatt']['ots'],
				$_SESSION['jigowatt'][$provider]
			);

			header('Location: sign_up.php?new_social');
			exit();

		}

	}

	private function isSecure() {

		if(isset($_GET['e'])) :
			if (parent::getOption('block-msg-out-enable'))
				$this->msg = '<div class="alert alert-error">'.parent::getOption('block-msg-out').'</div>';
		endif;
	}

	private function process() {

		// Check that the token is valid, prevents exploits
		if(!parent::valid_token($this->token)) {
			$this->error = '<div class="alert alert-error">'._('Geçersiz Giriş Denemesi').'</div>';
			return false;
		}

		// Confirm all details are correct
		$this->validate();

		// Log the user in
		$this->login();
	}

	private function validate() {

		if(!empty($this->error)) return false;

		if(empty($this->user)) {
			$this->error = '<div class="alert alert-error">'._('Lütfen Kullanıcı Adınızı Giriniz').'</div>';
			return false;
		}

		if(empty($this->pass)) {
			$this->error = '<div class="alert alert-error">'._('Lütfen Parolanızı Giriniz.').'</div>';
			return false;
		}

		$params = array( 'username' => $this->user );
		$stmt = parent::query("SELECT * FROM login_users WHERE username = :username", $params);

		$this->result = $stmt->fetch();

		if(!parent::validatePassword($this->pass, $this->result['password']))
			$this->error = "<div class=\"alert alert-error\">"._('Yanlış Kullanıcı Adı veya Parola.')."</div>";

	}

	// Once everything's filled out
	public function login() {

		// Just double check there are no errors first
		if( !empty($this->error) ) return false;

		// Session expiration
		$minutes = parent::getOption('default_session');
		ini_set('session.cookie_lifetime', 60 * $minutes);

		session_regenerate_id();

		/* See if the admin requires new users to activate */
		if ( parent::getOption('user-activation-enable') ) :

			/** Check if user still requires activation. */
			$params = array( ':user' => $this->user );
			$stmt = parent::query("SELECT * FROM `login_confirm` WHERE `username` = :user AND `type` = 'new_user'", $params);

			$count = $stmt->rowCount();

			if ($count > 0) $_SESSION['jigowatt']['activate'] = 1;

		endif;

		// Save if user is restricted
		if ( !empty($this->result['restricted']) ) $_SESSION['jigowatt']['restricted'] = 1;

		// Is the admin forcing a password update if encryption is not the desired method?
		if (parent::getOption('pw-encrypt-force-enable')) :

			$type = $this->getOption('pw-encryption');

			if (strlen($this->result['password']) == 32 && $type == 'SHA256')
				$_SESSION['jigowatt']['forcePwUpdate'] = 1;

			if (strlen($this->result['password']) != 32 && $type == 'MD5')
				$_SESSION['jigowatt']['forcePwUpdate'] = 1;

		endif;

		// Save user's current level
		$user_level = unserialize($this->result['user_level']);
		$_SESSION['jigowatt']['user_level'] = $user_level;

		$_SESSION['jigowatt']['email'] = $this->result['email'];

		$_SESSION['jigowatt']['gravatar'] = parent::get_gravatar($this->result['email'], true, 75);

		/** Check whether the user's level is disabled. */
		$params = array( ':level' => $user_level[0] );
		$stmt = parent::query("SELECT `level_disabled`, `redirect` FROM `login_levels` WHERE `level_level` = :level;", $params);

		$disRow = $stmt->fetch();

		if ( !empty($disRow['level_disabled']) ) $_SESSION['jigowatt']['level_disabled'] = 1;
		if ( !empty($disRow['redirect']) ) $redirect = $disRow['redirect'];

		// Stay signed via checkbox?
		if(isset($_POST['remember'])) {
			ini_set('session.cookie_lifetime', 60*60*24*100); // Set to expire in 3 months & 10 days
			session_regenerate_id();
		}

		/** Store a timestamp. */
		if( parent::getOption('profile-timestamps-enable') ) {

			$params = array(
				':user_id'    => $this->result['user_id'],
				':ip'         => $this->getIPAddress()
			);
			$stmt = parent::query("INSERT INTO `login_timestamps` (`user_id` ,`ip` ,`timestamp`) VALUES (:user_id, :ip, CURRENT_TIMESTAMP);", $params);

		}

		// And our magic happens here ! Let's sign them in
		$_SESSION['jigowatt']['username'] = $this->result['username'];
                $_SESSION['jigowatt']['name'] = $this->result['name'];

		// User ID of the logging in user
		$_SESSION['jigowatt']['user_id'] = $this->result['user_id'];

		if ( empty($redirect) ) $redirect = $_SESSION['jigowatt']['referer'];

		unset(
			$_SESSION['jigowatt']['referer'],
			$_SESSION['jigowatt']['token'],
			$_SESSION['jigowatt']['facebookMisc'],
			$_SESSION['jigowatt']['twitterMisc'],
			$_SESSION['jigowatt']['openIDMisc']
		);

		// Redirect after it's all said and done
		header("Location: " . $redirect);
		exit();

	}

}

$login = new Login();