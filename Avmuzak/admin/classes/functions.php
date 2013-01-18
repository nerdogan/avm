<?php

/**
 * Couple functions, including a mammoth pagination one.
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

/* Number of rows per page. */
if ( !empty($_POST['showUsers']) )
	$_SESSION['jigowatt']['users_page_limit'] = $_POST['showUsers'];

if ( !empty($_POST['showLevels']) )
	$_SESSION['jigowatt']['levels_page_limit'] = $_POST['showLevels'];

/* Retrieve a user in table format */
function displayUsers($row) {

	global $generic;

	if(empty($row)) return false;

	/* Admin user */
	$admin = in_array(1, unserialize($row['user_level']))
			 ? " <span class='label label-important'>" . _('admin') . "</span>"
			 : '';

	/* Restricted user */
	$restrict = !empty($row['restricted'])
				? " <span class='label label-warning'>"._('restricted')."</span>"
				: '';

	/* Registered date */
	$timestamp = strtotime($row['timestamp']);
	$reg_date  = date('M d, Y', $timestamp) . ' ' . _('at') . ' ' . date('h:i a', $timestamp);

	/* Last login */
	$params    = array( ':user_id'=> $row['user_id'] );
	$stmt      = $generic->query("SELECT `timestamp` FROM `login_timestamps` WHERE `user_id` = :user_id ORDER BY `timestamp` DESC LIMIT 0,1", $params);
	$timeRow   = $stmt->fetch(PDO::FETCH_NUM);
	$lastLogin = !empty($timeRow)
				 ? date('M d, Y', strtotime($timeRow[0])) . ' ' . _('at') . ' ' . date('h:i a', strtotime($timeRow[0]))
				 : '-';

	/* Email address */
	$email = $row['email'];

	/* Output */
	?>
	<tr>
		<td><a href="users.php?uid=<?php echo $row['user_id']; ?>"><?php echo $generic->get_gravatar($email, true, 20, 'mm', 'g', array('style' => '1')); ?> <?php echo $row['username']; ?></a><?php echo $admin . $restrict; ?></td>
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $email; ?></td>
		<td><?php echo $reg_date; ?></td>
		<td><?php echo $lastLogin ; ?></td>
	</tr>
	<?php

}

/* List recently registered users */
function list_registered() {

	$pagination = pagination('login_users','ORDER BY timestamp DESC');
	global $generic, $sql, $query;

	/** Check that at least one row was returned. */
	$query = $generic->query($sql);
	if($query->rowCount() > 0) {

	/** Display table of recently registered users. */
	?>
	<table class="table">
		<thead>
			<tr>
				<th><?php echo _('Username'); ?></th>
				<th><?php echo _('Name'); ?></th>
				<th><?php echo _('Email'); ?></th>
				<th><?php echo _('Registered Date'); ?></th>
				<th><?php echo _('Last Login'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayUsers($row);
		?>
		</tbody>
	</table>

	<?php

	echo $pagination;
	} else { echo _('Sorry, there are no recently registered users.'); }

}

/* Find users in the current level */
function in_level() {

	global $generic;

	if(!empty($_GET['lid'])) :

		$lid = $_GET['lid'];
		$page = (!empty($_GET['page']) && $_GET['page'] > 0) ? (int) $_GET['page'] : 1;
		$limit = 10;
		$StartIndex = $limit*($page-1);

		$sql = "SELECT * FROM login_users";
		$stmt = $generic->query($sql);

		$count = 0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			if( array_intersect(array($lid),unserialize($row['user_level'])) ) $count++;

		if ($count < 1) {
			echo '<p>'._('No users found!').'</p>';
			return false;
		}

		?>

		<table class="table">
			<thead>
				<tr>
					<th><?php echo _('Username'); ?></th>
					<th><?php echo _('Name'); ?></th>
					<th><?php echo _('Email'); ?></th>
					<th><?php echo _('Registered Date'); ?></th>
					<th><?php echo _('Last Login'); ?></th>
				</tr>
			</thead>
			<tbody>

		<?php

		/* Print out each user of this level */
		$params = array( ':user_level' => "%:\"$lid\";%" );
		$sql = "SELECT * FROM login_users WHERE user_level LIKE :user_level ORDER BY timestamp DESC LIMIT $StartIndex,$limit";
		$stmt = $generic->query($sql, $params);
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			echo displayUsers($row);

		?>

			</tbody>
		</table>

		<?php

		echo pagination('login_users','ORDER BY timestamp DESC',"$count");

	endif;

}

function user_levels() {

	$pagination = pagination('login_levels');

	global $sql, $query, $generic;

	/* Check that at least one row was returned */
	$stmt = $generic->query($sql);
	if($stmt->rowCount() < 1) return false;

	/* Manage levels */
	?><table class='table'>
			<thead>
				<tr>
					<th><?php echo _('Name'); ?></th>
					<th><?php echo _('Level'); ?></th>
					<th><?php echo _('Active Users'); ?></th>
					<th><?php echo _('Redirect'); ?></th>
				</tr>
			</thead>
			<tbody>

			<?php

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :

				/* Count of users in this level */
				$lid = $row['id'];
				$params = array( ':user_level' => "%:\"$lid\";%" );
				$query = $generic->query("SELECT COUNT(user_level) as num FROM login_users WHERE user_level LIKE :user_level", $params);
				$count = $query->fetch(PDO::FETCH_ASSOC);
				$count = $count['num'];

				/* Admin level? */
				$admin = ($row['level_level'] == 1)
						  ? ' <span class="label label-important">*</span>'
						  : '';

				/* Disabled level? */
				$status = !empty($row['level_disabled'])
						  ? ' <span class="label label-warning">'._('Disabled').'</span>'
						  : '';
			?>

				<tr>
					<td><a href="levels.php?lid=<?php echo $lid; ?>"><?php echo $row['level_name']; ?></a><?php echo $status; ?></td>
					<td width="15%"><?php echo $row['level_level']; ?></td>
					<td width="15%"><?php echo $count; ?></td>
					<td><a href="<?php echo $row['redirect']; ?>"><?php echo $row['redirect']; ?></a></td>
				</tr>

			<?php endwhile; ?>
			</tbody>
			</table>

	<?php echo $pagination;

}

function pagination($table, $args = '',$total_pages = '') {

	global $sql, $query, $generic;

	/** Hashtags, a workaround for when switching pages and not being redirected to the tab. */
	$hash  = '';

	/** Desired rows per page. */
	$limit = 10;

	/* Setting the page limit and hash. */
	if($table == 'login_levels') :
		$hash = '#level-control';
		if (!empty($_SESSION['jigowatt']['levels_page_limit']))
			$limit = $_SESSION['jigowatt']['levels_page_limit'];
	endif;

	if($table == 'login_users') :
		$hash = '#user-control';
		if (!empty($_SESSION['jigowatt']['users_page_limit']))
			$limit = $_SESSION['jigowatt']['users_page_limit'];
	endif;

	/** The page number to retrieve. */
	$page = (!empty($_GET['page']) && $_GET['page'] > 0) ? (int)$_GET['page'] : 1;

	if (!empty($_GET['info'])) {
		if ($_GET['info'] != $table)
			$page = 1;
	}

	$StartIndex = $limit*($page-1);
	$stages = 3;

	$sql = "SELECT * FROM $table $args LIMIT $StartIndex, $limit";
	$query = "SELECT COUNT(*) as num FROM $table $args";

	$next = $page + 1; $previous = ($page - 1 != 0) ? $page - 1 : $page;

	if (empty($total_pages)) :
		$stmt = $generic->query($query);
		$total_pages = $stmt->fetch();
		$total_pages = $total_pages['num'];
	endif;
	$lastPage = ceil($total_pages/$limit);
	$lastPage1 = $lastPage - 1;

	$paginate = '';
	if($lastPage > 0) :

		$paginate = '<div class="pagination"><ul>';

		// Previous.
		$paginate .= ($page > 1) ? '<li class="prev"><a href="?' . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$previous"))) . $hash . '">&larr; '._('Previous').'</a></li>' : '<li class="prev disabled"><a href="#">&larr; '._('Previous').'</a></li>';

		if($lastPage < 7 + ($stages * 2)) {
			for ($counter = 1; $counter <= $lastPage; $counter++)
				$paginate .= ($counter == $page) ? "<li class='active'><a href='#'>$counter</a></li>" : "<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$counter"))) . "$hash'>$counter</a></li>";
		}
		elseif($lastPage > 5 + ($stages * 2)) {

			/** Hide end pages. */
			if($page < 1 + ($stages * 2)) {
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
					$paginate .= ($counter == $page) ? "<li class='active'><a href='#'>$counter</a></li>" : "<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$counter"))) . "$hash'>$counter</a></li>";

				$paginate .= "
							<li><a href='#'>&hellip;</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$lastPage1"))) . "$hash'>$lastPage1</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$lastPage"))) . "$hash'>$lastPage</a></li>
							";
			}

			/** Hide start & end pages. */
			elseif($lastPage - ($stages * 2) > $page && $page > ($stages * 2)) {

				$paginate .= "
							<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "1"))) . "$hash'>1</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "2"))) . "$hash'>2</a></li>
							<li><a href='#'>&hellip;</a></li>
							";

				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
					$paginate .= ($counter == $page) ? "<li class='active'><a href='#'>$counter</a></li>" : "<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$counter"))) . "$hash'>$counter</a></li>";

				$paginate .= "
							<li><a href='#'>&hellip;</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$lastPage1"))) . "$hash'>$lastPage1</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$lastPage1"))) . "$hash'>$lastPage</a></li>
							";
			}

			/** Hide start pages. */
			else {

				$paginate .= "
							<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "1"))) . "$hash'>1</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "2"))) . "$hash'>2</a></li>
							<li><a href='#'>&hellip;</a></li>
							";
				for ($counter = $lastPage - (2 + ($stages * 2)); $counter <= $lastPage; $counter++)
					$paginate .= ($counter == $page) ? "<li class='active'><a href='#'>$counter</a></li>" : "<li><a href='?" . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$counter"))) . "$hash'>$counter</a></li>";

			}
		}

		/** Next button. */
		$paginate .= ($lastPage != $page) ? '<li class="next"><a href="?' . http_build_query(array_merge($_GET, array('info' => $table, "page" => "$next"))) . $hash . '">'._('Next').' &rarr;</a></li>' : '<li class="next disabled"><a href="#">'._('Next').' &rarr;</a></li>';
		$paginate .= '</ul></div>';

	endif;

	return $paginate;

}