<?php

/**
 * Various dynamic reports based on site performance.
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

class Jigowatt_reports extends Generic {

	public $socialMethods = array(
		'facebook'    =>    '3B5998',
		'twitter'     =>    '08c',
		'google'      =>    'f23437',
		'yahoo'       =>    '670d6d'
	);

	function __construct() {

		$this->findEnabledMethods();
		$this->graphInit();
		$this->newUsersGraph();

	}

	/* @TODO: This is duplicated code from integration.class. Obliterate! */
	private function findEnabledMethods() {

		foreach ( $this->socialMethods as $method => $color )
			if ( !parent::getOption('integration-'.$method.'-enable') )
				unset($this->socialMethods[$method]);

	}

	public function topUsers() {

		$sql = "SELECT login_users.username,
				COUNT( login_timestamps.user_id ) AS counted_logins
				FROM login_users, login_timestamps
				WHERE login_timestamps.user_id = login_users.user_id
				GROUP BY username
				ORDER BY counted_logins DESC
				LIMIT 0,10";

		$query = parent::query($sql);

		$topUsers = array();

		while($row = $query->fetch(PDO::FETCH_ASSOC)) :
			$topUsers[][$row['username']] = $row['counted_logins'];
		endwhile;

		return $topUsers;

	}

	public function displayTopUsers() {

		$topUsers = $this->topUsers();
		$display = '';

		foreach ($topUsers as $key) :

			foreach ($key as $username => $count) :

			$display .= "<tr>
							<td>$username</td>
							<td>$count</td>
						</tr>";
			endforeach;

		endforeach;

		return $display;


	}

	private function graphInit() {

		$this->start_date = (isset($_POST['start_date'])) ? $_POST['start_date'] : '';
		$this->end_date   = (isset($_POST['end_date']))   ? $_POST['end_date']   : '';

		if (!$this->start_date) $this->start_date = date('Ymd', strtotime( date('Ym', time()).'01' ));
		if (!$this->end_date)   $this->end_date   = date('Ymd', time());

		$this->start_date = (int) strtotime($this->start_date);
		$this->end_date   = (int) strtotime($this->end_date);

		$this->newUsers = array();
		$this->socialUsers = array();
		$this->sql_timestamp = array();

		$count = 0;
		$days = ($this->end_date - $this->start_date) / (60 * 60 * 24);
		if ($days==0) $days = 1;

		while ($count < $days) :

			$time = strtotime(date('Ymd', strtotime('+ '.$count.' DAY', $this->start_date))).'000';
			$this->newUsers[$time] = 0;
			$this->socialUsers[$time] = 0;
			$count++;

		endwhile;

	}

	/** New users. */
	private function newUsersGraph() {

		$params = array(
			':start_date' => date('Y-m-d', $this->start_date),
			':end_date'   => date('Y-m-d', $this->end_date)
		);
		$sql = "SELECT `timestamp` FROM `login_users` WHERE date(`timestamp`) >= :start_date AND date(`timestamp`) <= :end_date ORDER BY `timestamp` ASC;";
		$query = parent::query($sql, $params);
		while($row = $query->fetch(PDO::FETCH_ASSOC)) :

			$date = strtotime(date('Ymd', strtotime($row['timestamp']))).'000';
			$this->newUsers[$date] = 0;
			$date = date('Y-m-d', strtotime($row['timestamp']));
			$this->sql_timestamp[$date] = 0;

		endwhile;

		foreach ($this->sql_timestamp as $stamp => $count) {

			$params = array( ':stamp' => $stamp );
			$sql = "SELECT COUNT(`timestamp`) FROM `login_users` WHERE date(`timestamp`) = :stamp;";
			$stmt = parent::query($sql, $params);
			$result = $stmt->fetch(PDO::FETCH_NUM);

			$stamp = strtotime(date('Ymd', strtotime($stamp))).'000';
			$this->newUsers[$stamp] = $result[0];

		}

	}

	/** Integrated users. */
	function socialGraph($type) {

		if(empty($this->socialMethods[$type])) return false;

		$params = array(
			':start_date' => date('Y-m-d', $this->start_date),
			':end_date'   => date('Y-m-d', $this->end_date)
		);
		$sql = "SELECT `timestamp`
				FROM `login_integration`
				WHERE $type IS NOT NULL
				AND trim($type) <> ''
				AND date(`timestamp`) >= :start_date
				AND date(`timestamp`) <= :end_date
				ORDER BY `timestamp` ASC;";

		$query = parent::query($sql, $params);

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) :

			$date = strtotime(date('Ymd', strtotime($row['timestamp']))).'000';
			$this->socialUsers[$date] = 0;
			$date = date('Y-m-d', strtotime($row['timestamp']));
			$this->sql_timestamp[$date] = 0;

		endwhile;

		foreach ($this->sql_timestamp as $stamp => $count) {

			$params = array( ':stamp' => $stamp );
			$sql = "SELECT COUNT(`timestamp`)
					FROM `login_integration`
					WHERE date(`timestamp`) = :stamp
					AND `$type` IS NOT NULL
					AND trim(`$type`) <> '';";

			$query = parent::query($sql, $params);

			if ( $query->rowCount() < 1 ) break;

			$result = $query->fetch(PDO::FETCH_NUM);
			$stamp = strtotime(date('Ymd', strtotime($stamp))).'000';
			$this->socialUsers[$stamp] = $result[0];

		}

		return $this->socialUsers;

	}

	public function countRegisteredUsers() {

		$type = 'timestamp';

		$sql = "SELECT * FROM `login_users` WHERE `timestamp` IS NOT NULL AND trim(`timestamp`) <> '';";
		$query = parent::query($sql);

		return $query->rowCount();

	}

	public function countSocialUsers($type, $range = false) {

		if(empty($this->socialMethods[$type])) return false;

		if (!$range) {
			$sql = "SELECT * FROM `login_integration` WHERE `$type` IS NOT NULL AND trim(`$type`) <> '';";
		} else {
			$sql = sprintf("SELECT * FROM `login_integration`
					WHERE `$type` IS NOT NULL
					AND trim(`$type`) <> ''
					AND date(`timestamp`) >= '%s'
					AND date(`timestamp`) <= '%s'
					ORDER BY `timestamp` ASC;",
					date('Y-m-d', $this->start_date), date('Y-m-d', $this->end_date));
		}

		$query = parent::query($sql);

		return $query->rowCount();

	}

}

$jigowatt_reports = new Jigowatt_reports();
?>