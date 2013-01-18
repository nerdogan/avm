<?php

/**
 * Add a new user to the database.
 *
 * A random password is generated and emailed to the user.
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

include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Add_user extends Generic {

	private $result;
	private $error;

	private $username;
	private $name;
	private $email;
	private $password;

	function __construct() {

		if(isset($_POST['searchUsers'])) {
			$this->searchUsers();
			exit();
		}

		// jQuery form validation
		parent::checkExists();

		if(isset($_POST['add_user'])) {
			$this->name = parent::secure($_POST['name']);
			$this->username = parent::secure($_POST['username']);
			$this->email = parent::secure($_POST['email']);
			$this->password = substr(md5(rand().rand()), 0, 6);

			// Confirm all details are correct
			$this->verify();

			// Create the user
			$this->adduser();

			if(!empty($this->error)) parent::displayMessage($this->error);
				else echo $this->result;
			exit();

		}

	}

	/** @todo: Should be in a different class, not add_user. */
	private function searchUsers() {

		if(empty($_POST['searchUsers'])) return false;

		$params = array( ':searchQ' => $_POST['searchUsers'] . '%' );
		$sql = "SELECT distinct username as suggest, user_id
				FROM login_users
				WHERE username LIKE :searchQ
				OR name LIKE :searchQ
				OR user_id LIKE :searchQ
				ORDER BY username
				LIMIT 0, 5";

		$stmt = parent::query($sql, $params);

		if ( $stmt->rowCount() < 1 ) {
			echo '<h3>' . _('No suggestions') . '</h3>
				  <p class="help-block">' . _('Try searching by username, name, or user id.') . '</p>';
			return false;
		}

		echo '<h2>' . _('Suggestions') . '</h2>';

		while($suggest = $stmt->fetch(PDO::FETCH_ASSOC))
			echo "<p><a href='users.php?uid=" . $suggest['user_id'] . "'>" . $suggest['suggest'] . "</a></p>\n";

	}

	// Return a value if it exists
	public function getPost($var) {

		if(!empty($this->$var)) {
			return $this->$var;
		} else return false;

	}

	private function verify() {

		if(empty($this->name)) {
			$this->error = '<div class="alert alert-error">'._('You must enter a name.').'</div>';
			return false;
		}

		if(empty($this->username)) {
			$this->error = '<div class="alert alert-error">'._('You must enter a username.').'</div>';
			return false;
		}

		if (!parent::isEmail($this->email)) {
			$this->error = '<div class="alert alert-error">'._('You have entered an invalid e-mail address, try again.').'</div>';
			return false;
		}

		$params = array( ':email' => $this->email );
		$stmt = parent::query("SELECT * FROM `login_users` WHERE `email` = :email", $params);

		if ($stmt->rowCount() > 0) {
			$this->error = '<div class="alert alert-error">'._('That email address has already been taken.').'</div>';
			return false;
		}

		$params = array( ':username' => $this->username );
		$stmt = parent::query("SELECT * FROM `login_users` WHERE `username` = :username", $params );

		if($stmt->rowCount() > 0) {
			$this->error = '<div class="alert alert-error">'._('Sorry, username already taken.').'</div>';
			return false;
		}

	}

	private function adduser() {

		if (!empty($this->error)) return false;

		$params = array(
			':user_level' => parent::getOption('default-level'),
			':name'       => $this->name,
			':email'      => $this->email,
			':username'   => $this->username,
			':password'   => parent::hashPassword($this->password)
		);

		parent::query("INSERT INTO `login_users` (`user_level`, `name`, `email`, `username`, `password`)
						VALUES (:user_level, :name, :email, :username, :password);", $params);

		$shortcodes = array(
			'site_address'	=>	SITE_PATH,
			'full_name'		=>	$this->name,
			'username'		=>	$this->username,
			'email'			=>	$this->email,
			'password'		=>	$this->password
		);

		$subj = parent::getOption('email-add-user-subj');
		$msg = parent::getOption('email-add-user-msg');

		if(!parent::sendEmail($this->email, $subj, $msg, $shortcodes))
			$this->error = _('ERROR. Mail not sent');

		$this->result = "<div class='alert alert-success'>" . sprintf(_('Successfully added user <b>%s</b> to the database. Credentials sent to user.'), $this->username) . "</div>";

	}

}

$addUser = new Add_user();