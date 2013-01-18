<?php

/**
 * Reset and verify a user password.
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

class Forgot extends Generic {

	// Form vars
	private $key;
	private $password;
	private $password2;

	// Misc vars
	private $error;
	private $name;
	private $email;
	private $user;

	function __construct() {

		// Are they clicking from an email?
		if(isset($_GET['key']) && strlen($_GET['key']) == 32) {
			$this->key = parent::secure($_GET['key']);

			// Has the form been submitted?
			if(isset($_POST['reset'])) {
				$this->password = parent::secure($_POST['password']);
				$this->password2 = parent::secure($_POST['password2']);
			}
		  /** Redirect if not clicking from email, and modal form hasn't been submitted. */
		} else if (!isset($_GET['key']) && !isset($_POST['usernamemail'])) { header('Location: home.php'); exit(); }
	}

	private function validate() {

		// Further security check right here
		if(isset($_POST['reset']) && isset($this->key)) {

			// Just some input validation
			if($this->password != $this->password2) {
				$this->error = '<div class="alert alert-error">'._('Girdiğiniz Parolalar Eşleşmedi. Tekrar Deneyin.').'</div>';
			} else if(strlen($this->password) < 5) {
				$this->error = '<div class="alert alert-error">'._('Parolanız En Az 5 Karakterden Oluşmalıdır.').'</div>';
			}

			// No errors, then lets double check the key
			if(empty($this->error) && isset($this->key)) {

				$params = array( ':key' => $this->key );
				$stmt = parent::query("
						SELECT `login_confirm`.`email`, `login_confirm`.`key`, `login_users`.`email`, `login_users`.`name`, `login_users`.`username`
						FROM   `login_confirm`,         `login_users`
						WHERE  `login_confirm`.`key`  =  :key
						AND    `login_users`.`email`  = `login_confirm`.`email`
						AND    `login_confirm`.`type` = 'forgot_pw';
						", $params);

				$row = $stmt->fetch();

				/** Key is invalid, nice try sucka. */
				if( $stmt->rowCount() < 1 ) {
					$this->error = '<div class="alert alert-error">'._('Doğrulama Başarısız.').'</div>';
				} else {
					$this->email = $row['email'];
					$this->name  = $row['name'];
					$this->user  = $row['username'];
				}
			}

		}
	}

	private function resetpw() {

		// Further security
		if(empty($this->error) && isset($_POST['reset']) && isset($this->key)) {

			// Delete the recovery key so it can't be reused
			$params = array( ':email' => $this->email );
			parent::query("DELETE FROM `login_confirm` WHERE `email` = :email AND `type` = 'forgot_pw'", $params);

			// Resets their password
			$params = array(
				':password' => parent::hashPassword($this->password),
				':email'    => $this->email
			);
			parent::query("UPDATE `login_users` SET `password` = :password WHERE `email` = :email;", $params);

			$shortcodes = array(
				'site_address'	=>	SITE_PATH,
				'full_name'		=>	$this->name,
				'username'		=>	$this->user
			);

			$subj = parent::getOption('email-forgot-success-subj');
			$msg = parent::getOption('email-forgot-success-msg');

			// Send an email confirming their password reset
			if(!parent::sendEmail($this->email, $subj, $msg, $shortcodes))
				$this->error = "ERROR. Mail not sent";

			echo "<div class='alert alert-success'>"._('Parolanız Başarıyla Değiştirldi.')."</div>";
			echo "<h2>"._('Account Recovery')."</h2>";
			echo "<p>"._('Eğer daha fazla yardıma ihtiyacınız varsa web yöneticinizle irtibata geçiniz:')." " . address . "</p>";
			include_once('footer.php');
			exit();

		} else echo $this->error;

	}

	private function reset_form() {

		if(isset($this->key)) { ?>
			<div class="row">
				<div class="span6">
					<form class="form-horizontal" method="post">
						<fieldset>
							<legend><?php _e('Parola Yenileme'); ?></legend>
							<div class="control-group">
								<label class="control-label" for="password"><?php _e('Yeni PArola'); ?></label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="password" name="password">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="password2"><?php _e('Yeni PArola Tekrar'); ?></label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="password2" name="password2">
								</div>
							</div>
						</fieldset>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary" name="reset"><?php _e('Parolayı Yenile'); ?></button>
						</div>
					</form>
				</div>
			</div>
<?php	}
	}

	public function modal_process() {

		if(isset($_POST['usernamemail'])) {

			$usernamemail = parent::secure($_POST['usernamemail']);

			// The input field wasn't filled out
			if (empty($usernamemail)) {
				$this->error = '<div class="alert alert-error">'._('Kullanıcı Adınızı veya Email Adresinizi Girin.').'</div>';
			} else {

				$params = array( ':usernameEmail' => $usernamemail );
				$stmt   = parent::query("SELECT * FROM `login_users` WHERE `username` = :usernameEmail OR `email` = :usernameEmail;", $params);

				 if( $stmt->rowCount() > 0 ) {
					$row = $stmt->fetch();

					// Reuse the email variable.
					$email = $row['email'];

					// Check that a recovery key doesn't already exist, if it does, remove it.
					$params = array( ':email' => $email );
					$stmt   = parent::query("SELECT * FROM `login_confirm` WHERE `email` = :email AND `type` = 'forgot_pw';", $params);

					if ($stmt->rowCount() > 0)
						parent::query("DELETE FROM `login_confirm` WHERE email = :email AND `type` = 'forgot_pw';", $params);

					// Generate a new recovery key
					$key    = md5(uniqid(mt_rand(),true));
					$params = array(
						':email' => $email,
						':key'   => $key
					);
					parent::query("INSERT INTO `login_confirm` (`email`, `key`, `type`) VALUES (:email, :key, 'forgot_pw');", $params);

					$shortcodes = array(
						'site_address'  =>  SITE_PATH,
						'full_name'     =>  $row['name'],
						'username'      =>  $row['username'],
						'reset'         =>  SITE_PATH . "forgot.php?key=$key"
					);

					$subj = parent::getOption('email-forgot-subj');
					$msg  = parent::getOption('email-forgot-msg');

					// Send an email confirming their password reset
					if(!parent::sendEmail($email, $subj, $msg, $shortcodes))
						$this->error = '<div class="alert alert-error">'._('Hata! Email Gönderilemedi.').'</div>';
					else
						$this->error = "<div class='alert alert-success'>"._('Parolanızı Sıfırlamınız İçin Size Bir Email Gönderildi. Lütfen Talimatları Uygulayın.')."</div>";

				} else { $this->error = '<div class="alert alert-error">'._('Yapılan Aramda Sonuç Bulunamadı :(').'</div>'; }
			}

			echo $this->error;

		}

	}

	public function process() {

		// Only allow guests to view this page
		parent::guestOnly();

		// Check for correct and complete values
		$this->validate();

		// If there are no errors, let's reset the password
		$this->resetpw();

		// Show the form if $_GET key is set
		$this->reset_form();

	}

}