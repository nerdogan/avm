<?php

/**
 * Modify an existing level.
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

include_once('../classes/generic.class.php');

class Edit_level extends Generic {

	public $error;
	public $results;

	public $search_q;
	public $options = array();

	public $isAdmin = false;

	function __construct() {

		// Save level and auth
		if(!empty($_GET['lid']))
			$this->retrieveInfo();

		if(isset($_POST['do_edit'])) :

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

			$this->options['level_disabled'] = !empty($_POST['disable']) ? 'checked' : '';
			$this->options['welcome_email'] =  !empty($_POST['welcome_email']) ? 'checked' : '';

			// Validate fields
			$this->validate();

		endif;

		if(!empty($this->error))
			parent::displayMessage("<div class='alert alert-warning'>$this->error</div>", false);

		if(!empty($this->result))
			parent::displayMessage("<div class='alert alert-success'>$this->result</div>", false);

	}

	public function getValue($name) {

		if(!empty($this->options[$name]))
			return $this->options[$name];

	}

	private function retrieveInfo() {

		$this->options['level_id'] = (int) $_GET['lid'];

		$params = array( ':level_id' => $this->options['level_id'] );
		$stmt   = parent::query("SELECT * FROM `login_levels` WHERE `id` = :level_id;", $params);

		if ($stmt->rowCount() < 1) :
			$this->error = _("Level doesn't exist!");
			return false;
		endif;

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :

			foreach ($row as $key => $value)
				$this->options[$key] = $value;

		endwhile;
		

		$this->options['level_level2'] = $this->options['level_level'];
		$this->options['level_disabled'] = !empty($this->options['level_disabled']) ? 'checked' : '';
		$this->options['welcome_email'] =  !empty($this->options['welcome_email'])  ? 'checked' : '';

		if ($this->options['level_level'] == 1 || $this->options['level_level2'] == 1 || $this->options['level_id'] == 1) {
			$this->isAdmin = true;
		}

	}

	private function validate() {

		if(!empty($this->options['delete'])) {
			$this->process(true);
			return false;
		}

		if(empty($this->options['level_name'])) {
			$this->error = _('You must enter a level name.');
			return false;
		}

		if (empty($this->options['level_level'])) {
			$this->error = _('You must enter an auth level.');
			return false;
		}

		$params = array( ':level' => $this->options['level_level'] );
		$stmt   = parent::query("SELECT * FROM `login_levels` WHERE `level_level` = :level;", $params);

		if( $stmt->rowCount() > 0 && $this->options['level_level'] != $this->options['level_level2'] )
			$this->error = sprintf(_('Auth level %s already exists'), $this->options['level_level']);

		// Process form
		if(empty($this->error))
			$this->process();

	}

	private function process($delete = false) {

		if ( !empty($this->error) )
			return false;

		if ($delete) :

			$params = array( ':level' => '%:"' . $this->options['level_id'] . '";%' );
			$stmt   = parent::query("SELECT COUNT(user_level) FROM login_users WHERE user_level LIKE :level;", $params);

			$result = $stmt->fetch();

			if ($result[0] > 0) :
				$this->error = _("This level still has users in it!");
				return false;
			endif;

			$params = array( ':level' => $this->options['level_id'] );
			$stmt = parent::query("DELETE FROM `login_levels` WHERE `id` = :level;", $params);
			$this->result = sprintf(_('Level <b>%s</b> removed from database.'), $this->options['level_name']);

		else :

			$params = array(
				':name'     => $this->options['level_name'],
				':level'    => !$this->isAdmin ? $this->options['level_level'] : 1,
				':welcome' =>  !empty($this->options['welcome_email']) ? 1 : 0,
				':disabled' => (!empty($this->options['level_disabled']) && !$this->isAdmin) ? 1 : 0,
				':redirect' => $this->options['redirect'],
				':id'       => $this->options['level_id']
			);

			$stmt = parent::query("UPDATE login_levels SET level_name = :name, level_level = :level, level_disabled = :disabled, redirect = :redirect, `welcome_email` = :welcome WHERE id = :id;", $params);
			$this->result = sprintf(_('Information updated for level <b>%s</b>.'), $this->options['level_name']);

		endif;

	}

}

$Edit_level = new Edit_level;