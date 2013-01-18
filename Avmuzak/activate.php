<?php
include_once ('header.php');
include_once ('classes/generic.class.php');

class Activate extends Generic {

	private $key;
	private $user;
	private $error;

	function __construct() {

		// Assign their username to a variable
		if(isset($_SESSION['jigowatt']['username']))
			$this->user = $_SESSION['jigowatt']['username'];

		// Are they clicking from an email?
		if(isset($_GET['key'])) {
			$this->key = parent::secure($_GET['key']);
			$this->getKey();

		// Do they want the key resent?
		} else if(isset($_GET['resend']) && $_GET['resend'] == '1') {
			$this->resendKey();

		// Are they already signed in without a key?
		} else if(isset($this->user) && !isset($this->key)) {
			$this->signedIn();
		} else {
			header('location: home.php');
			exit();
		}

		// Display any errors
		parent::displayMessage($this->error, false);

	}

	private function getKey() {

		$params = array( ':key' => $this->key );
		$stmt   = parent::query("SELECT `login_confirm`.`email`, `login_confirm`.`username`, `login_users`.`name`
							  FROM   `login_confirm`,         `login_users`
							  WHERE  `login_confirm`.`key`      =  :key
							  AND    `login_confirm`.`username` = `login_users`.`username`
							  AND    `login_confirm`.`type`     = 'new_user';", $params);

		if ($stmt->rowCount() < 1) {
			$this->error = '<div class="alert alert-error">' . _('Your activation link is incorrect.') . '</div>
					  <h5>' . _('What to do now?') . '</h5>
					  <p>' . sprintf(_('Go to the <a href="%s"> homepage</a>'), 'home.php') . '</p>';
			return false;
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$username = $row['username'];
		$to = $row['email'];

		// Activate by deleting the activation key
		parent::query("DELETE FROM `login_confirm` WHERE `username` = '$username' AND `type` = 'new_user';");

		// Set user's activate session to false
		if(!empty($_SESSION['jigowatt']['activate'])) unset($_SESSION['jigowatt']['activate']);

		echo "<div class=\"alert alert-success\">"._('Your account has been activated!')."</div>" ._('You can now see the default access granted to new users.')."
			 <p>"._('If you require more access please contact the site admin at')." " . address . "</p>
			 <h5>"._('What to do now?')."</h5>
			 <p>" . sprintf(_('Go to the <a href="%s"> homepage</a>'), 'home.php') . "</p>";

		$shortcodes = array(
			'site_address'	=>	SITE_PATH,
			'full_name'		=>	$row['name'],
			'username'		=>	$username
		);

		$msg = parent::getOption('email-activate-msg');
		$subj = parent::getOption('email-activate-subj');


		if(!parent::sendEmail($to, $subj, $msg, $shortcodes))
			$this->error = "ERROR. Mail not sent";

	}

	private function resendKey() {

		$params = array( ':username' => $this->user );
		$stmt   = parent::query("SELECT `login_confirm`.`email`,  `login_confirm`.`username`, `login_confirm`.`key`, `login_users`.`name`
								FROM    `login_confirm`,          `login_users`
								WHERE   `login_confirm`.`username` = :username
								AND     `login_confirm`.`type`     = 'new_user'
								AND     `login_users`.`username`   = :username;", $params);

		$row = $stmt->fetch();
		$key = $row['key'];

		if ( empty($key) ) {
			$this->error = '<div class="alert alert-error">' . _('You do not have an activation key!') . '</div>
						    <p>' . _('Please contact an admin: ') . address . '</p>';
			return false;
		}

		$shortcodes = array(
			'site_address'	=>	SITE_PATH,
			'full_name'		=>	$row['name'],
			'username'		=>	$this->user,
			'activate'		=>	SITE_PATH . "activate.php?key=$key"
		);

		$subj = parent::getOption('email-activate-resend-subj');
		$msg = parent::getOption('email-activate-resend-msg');
		$to = $row['email'];

		if(parent::sendEmail($to, $subj, $msg, $shortcodes)) {
			$this->error = '<div class="alert alert-success">' . _('Activation link resent to email.') . '</div>
					  <h5>' . _('What to do now?') . '</h5>'
					  . _('Click the link in your email to activate your account.');
		} else $this->error = _('ERROR. Mail not sent');

	}

	private function signedIn() {

		// Check if user needs activation
		$params = array( ':username' => $this->user );
		$stmt   = parent::query("SELECT * FROM `login_confirm` WHERE `username` = :username AND `type` = 'new_user';", $params);

		if ($stmt->rowCount() < 1)
			$this->error = '<div class="alert alert-error">'._('Your account has already been activated.').'</div>
					  <h5>'._('What to do now?').'</h5>
					  <p>' . sprintf(_('Go to the <a href="%s"> homepage</a>'), 'home.php') . '</p>';
		else
			$this->error = '<div class="alert alert-error">'._('You have not activated your account yet.').'</div>
					  <h5>'._('What to do now?').'</h5>'
					 . '<p>' . _('Please follow the link in your email to activate your account.') . '</p>'
					 . '<p>' . sprintf(_('Would you like us to <a href="%s">resend</a> the link?'), 'activate.php?resend=1') . '</p>';
	}

}

$activate = new Activate;

include ('footer.php');