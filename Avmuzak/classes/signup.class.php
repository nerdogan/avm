<?php

/**
 * Process and validate the sign up form.
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

include_once( 'generic.class.php' );

class SignUp extends Generic {

	private $token;
	private $error;
	private $captchaError;
	private $settings = array();

	function __construct() {

		// Only allow guests to view this page
		parent::guestOnly();

		/* Has the admin disabled user registrations? */
		$disable = parent::getOption('disable-registrations-enable');
		if ( $disable ) {
			$this->error = sprintf( '<div class="alert alert-block alert-error">%s</div>', _('<h4 class="alert-heading">Registrations disabled.</h4><p>Already have an account? <a href="login.php">Sign in here</a>!</p>') );
			parent::displayMessage($this->error, true);
		}

		// jQuery form validation
		parent::checkExists();

		// Generate a unique token for security purposes
		parent::generateToken();

		// Has the form been submitted?
		if(!empty($_POST)) {

			// Sign up form post data
			foreach ($_POST as $field => $value)
				$this->settings[$field] = parent::secure($value);

			$this->process();

		}

		if (isset($_GET['new_social']))
			$this->error = sprintf( '<div class="alert alert-success">%s</div>', _('We don\'t see you as a registered user. Perhaps you\'d like to sign up :)') );

		parent::displayMessage($this->error, false);

	}

	public function profileSignUpFields() {

		$sql = 'SELECT * FROM `login_profile_fields` WHERE `signup` <> "hide";';
		$stmt = parent::query($sql);

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
			$option = array(
				'name'  => $row['label'],
				'id'    => $row['id'],
				'type'  => $row['type'],
				'class' => $row['signup'] === 'require' ? 'required' : '',
			);
			parent::profileFieldTypes($option, true);
		endwhile;

	}

	public function doCaptcha($display = true) {

		$captcha = parent::getOption('integration-captcha');
		switch ( $captcha ) :

			case 'reCAPTCHA' :

				require_once('captcha/recaptcha-1.11/recaptchalib.php');
				$publickey  = parent::getOption('reCAPTCHA-public-key');
				$privatekey = parent::getOption('reCAPTCHA-private-key');

				/* Captcha has been submitted. */
				if ( ! empty($_POST['recaptcha_response_field'])) {

					$resp = recaptcha_check_answer( $privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"] );
					if ( !$resp->is_valid ) $this->captchaError = $resp->error;

				} else {

					$this->captchaError = true;

				}

				if ( $display )
					echo recaptcha_get_html($publickey, $this->captchaError);

				break;

			case 'playThru' :

				if ( !defined ('AYAH_PUBLISHER_KEY') )    define( 'AYAH_PUBLISHER_KEY'   , parent::getOption('playThru-publisher-key') );
				if ( !defined ('AYAH_SCORING_KEY') )      define( 'AYAH_SCORING_KEY'     , parent::getOption('playThru-scoring-key') );
				if ( !defined ('AYAH_WEB_SERVICE_HOST') ) define( 'AYAH_WEB_SERVICE_HOST', 'ws.areyouahuman.com' );

				require_once('captcha/ayah-1.0.2/ayah.php');

				$integration = new AYAH();

				if ( (!$display && !empty($_POST)) && !$integration->scoreResult() )
					$this->captchaError = true;

				/* Show the captcha form. */
				if ( $display )
					echo $integration->getPublisherHTML();

				break;

		endswitch;

	}

	private function process() {

		// Check that the token is valid, prevents exploits
		if(!parent::valid_token($this->settings['token']))
			$this->error = '<div class="alert alert-error">'._('Invalid signup attempt').'</div>';

		/* Check the captcha response. */
		$this->doCaptcha(false);

		// See if all the values are correct
		$this->validate();

		// Sign um up!
		$this->register();

	}

	private function validate() {

		if(empty($this->settings['username'])) {
			$this->error .= '<li>'._('You must enter a username.').'</li>';
		} else {
			$params = array( ':username' => $this->settings['username'] );
			$stmt   = parent::query("SELECT * FROM `login_users` WHERE `username` = :username", $params);
			if ($stmt->rowCount() > 0) $this->error .= '<li>Sorry, username already taken.</li>';
		}
		if(strlen($this->settings['username']) > 11) {
			$this->error .= '<li>'._('Your username must be under 11 characters').'</li>';
		}
		if(empty($this->settings['name'])) {
			$this->error .= '<li>'._('You must enter your name.').'</li>';
		}
		if (!empty($this->settings['email'])) {
			$params = array( ':email' => $this->settings['email'] );
			$stmt = parent::query("SELECT * FROM login_users WHERE email = :email;", $params);
			if ($stmt->rowCount() > 0)
			$this->error .= '<li>'._('That email address has already been taken.').'</li>';
		}
		if (!parent::isEmail($this->settings['email'])) {
			$this->error .= '<li>'._('You have entered an invalid e-mail address, try again.').'</li>';
		}
		if($this->settings['password'] != $this->settings['password_confirm']) {
			$this->error .= '<li>'._('Your passwords did not match.').'</li>';
		}
		if(strlen($this->settings['password']) < 5) {
			$this->error .= '<li>'._('Your password must be at least 5 characters.').'</li>';
		}
		if(!empty($this->captchaError)) {
			$this->error .= '<li>'._('Please enter the correct captcha!').'</li>';
		}

		// Checkbox handling
		$sql = "SELECT * FROM `login_profile_fields` WHERE `signup` <> 'hide';";
		$stmt = parent::query($sql);

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :

			$name = 'p-' . $row['id'];

			if( $row['type'] == 'checkbox' )
				$this->settings[$name] = !empty($this->settings[$name]) ? 1 :0;

			/* Required signup fields validation. */
			if( $row['signup'] == 'require' && empty($this->settings[$name]) )
				$this->error .= '<li>' . sprintf('The field "%s" is required!', $row['label']) . '</li>';

		endwhile;

		// Output the errors in a pretty format :]
		$this->error = (isset($this->error)) ? "<div class='alert alert-error alert-block'><h4 class='alert-heading'>"._('Attention!')."</h4>$this->error</div>" : '';

	}

	// Return a value if it exists
	public function getPost($var) {

		if ( !empty($_SESSION['jigowatt']['openIDMisc']) ) :

			$misc = $_SESSION['jigowatt']['openIDMisc'];

			switch ($var) :

				case 'email' :
					return $misc['contact/email'];
					break;

				case 'name' :
					return $misc['namePerson/first'] . ' ' . $misc['namePerson/last'];
					break;

			endswitch;

		endif;

		if ( !empty($_SESSION['jigowatt']['facebookMisc']) ) :

			$misc = $_SESSION['jigowatt']['facebookMisc'];

			switch ($var) :

				case 'email' :
					return $misc['email'];
					break;

				case 'name' :
					return $misc['name'];
					break;

			endswitch;

		endif;

		if ( !empty($_SESSION['jigowatt']['twitterMisc']) ) :

			$misc = $_SESSION['jigowatt']['twitterMisc'];

			switch ($var) :

				case 'username' :
					return $misc['username'];
					break;

				case 'name' :
					return $misc['name'];
					break;

			endswitch;

		endif;

		return empty($this->settings[$var]) ? '' : $this->settings[$var];

	}

	// Once everything's filled out
	private function register() {

		if(empty($this->error)) {

			/* See if the admin requires new users to activate */
			$requireActivate = parent::getOption('user-activation-enable');

			/* Log user in when they register */
			$_SESSION['jigowatt']['username'] = $this->settings['username'];

			/* Apply default user_level */
			$_SESSION['jigowatt']['user_level'] = unserialize(parent::getOption('default-level'));

			if ( $requireActivate )
				$_SESSION['jigowatt']['activate'] = 1;

			$_SESSION['jigowatt']['gravatar'] = parent::get_gravatar($this->settings['email'], true, 26);

			/* Create their account */
			$sql = "INSERT INTO login_users (user_level, name, email, username, password)
						VALUES (:user_level, :name, :email, :username, :password);";
			$params = array(
				':user_level' => parent::getOption('default-level'),
				':name'       => $this->settings['name'],
				':email'      => $this->settings['email'],
				':username'   => $this->settings['username'],
				':password'   => parent::hashPassword($this->settings['password'])
			);
			parent::query($sql, $params);

			$user_id = parent::$dbh->lastInsertId();
			$_SESSION['jigowatt']['user_id'] = $user_id;

			/* Social integration. */
			if ( !empty($_SESSION['jigowatt']['facebookMisc']) ) {
				$link = 'facebook';
				$id = $_SESSION['jigowatt']['facebookMisc']['id'];
			}

			if ( !empty($_SESSION['jigowatt']['openIDMisc']) ) {
				$link = $_SESSION['jigowatt']['openIDMisc']['type'];
				$id = $_SESSION['jigowatt']['openIDMisc'][$link];
			}

			if ( !empty($_SESSION['jigowatt']['twitterMisc']) ) {
				$link = 'twitter';
				$id = $_SESSION['jigowatt']['twitterMisc']['id'];
			}

			if ( !empty($link) ) {

				$params = array(
					':user_id' => $user_id,
					':id'      => $id,
				);
				parent::query("INSERT INTO `login_integration` (`user_id`, `$link`) VALUES (:user_id, :id);", $params);

			}

			// Update profile fields
			foreach($this->settings as $field => $value) :
				if(strstr($field,'p-')) {
					$field = str_replace('p-', '', $field);
					parent::updateOption($field, $value, true, $user_id);
				}
			endforeach;

			/* Create the activation key */
			if ( $requireActivate ) :
				$key = md5(uniqid(mt_rand(),true));
				$sql = sprintf("INSERT INTO `login_confirm` (`username`, `key`, `email`, `type`)
								VALUES ('%s', '%s', '%s', '%s');",
								$this->settings['username'], $key, $this->settings['email'], 'new_user');
				parent::query($sql);
			endif;

			/* Send welcome email to new user. */
			$msg  = parent::getOption('email-welcome-msg');
			$subj = parent::getOption('email-welcome-subj');

			$shortcodes = array(
				'site_address' => SITE_PATH,
				'full_name'    => $this->settings['name'],
				'username'     => $this->settings['username'],
				'email'        => $this->settings['email'],
				'activate'     => $requireActivate ? SITE_PATH . "activate.php?key=$key" : ''
			);

			if(!parent::sendEmail($this->settings['email'], $subj, $msg, $shortcodes))
				$this->error = _('ERROR. Mail not sent');

			/* Admin notification of new user. */
			$notifyNewUsers = parent::getOption('notify-new-user-enable');
			if ( !empty($notifyNewUsers) ) :

				$msg  = parent::getOption('email-new-user-msg');
				$subj = parent::getOption('email-new-user-subj');
				unset($shortcodes['activate']);

				$userGroup = parent::getOption('notify-new-users');
				if ( !empty($userGroup) ) :
					$userGroup = unserialize($userGroup);

					/* Variable to store all the email addresses of each chosen group. */
					$emails = array();

					foreach ( $userGroup as $level_id ) :

						/* Grab all users within the user group. */
						$params = array( ':level_id' => '%:"' . $level_id . '";%' );
						$sql = "SELECT * FROM `login_users` WHERE `user_level` LIKE :level_id";
						$stmt = parent::query($sql, $params);

						/* Send email to each user in group. */
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$emails[] = $row['email'];
						endwhile;

					endforeach;

					/* Remove duplicates for users with multiple user groups. */
					$emails = array_unique($emails);

					if(!parent::sendEmail($emails, $subj, $msg, $shortcodes, true))
						$this->error = _('ERROR. Mail not sent');

				endif;

			endif;

			unset(
				$_SESSION['jigowatt']['referer'],
				$_SESSION['jigowatt']['token'],
				$_SESSION['jigowatt']['facebookMisc'],
				$_SESSION['jigowatt']['twitterMisc'],
				$_SESSION['jigowatt']['openIDMisc']
			);

			/* After registering, redirect to the page the admin has set in Settings > General > Redirect Options. */
			header('Location: ' . parent::getOption('new-user-redirect') );
			exit();

		}

	}

}

$signUp = new SignUp();