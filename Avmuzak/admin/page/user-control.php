<?php include_once('admin.php'); ?>

<fieldset>

	<legend><?php _e('Control users'); ?>
	<form method="post" id="search-users-form" action="classes/add_user.class.php" class="pull-right">
		<div class="control-group">
		  <div class="controls">
			<div class="input-prepend">
			  <button id="add_new_user_btn" class="btn btn-small"><?php _e('Add new user'); ?></button>
			  <input type="number" class="input-mini" min="0" id="showUsers" name="showUsers" placeholder="<?php _e('Show'); ?>" value="<?php echo !empty($_SESSION['jigowatt']['users_page_limit']) ? $_SESSION['jigowatt']['users_page_limit'] : 10; ?>">
			  <span class="add-on">
				<label for="username-search"><a href="#" data-rel="tooltip-bottom" title="<?php _e('Search by Username, Name, or ID!'); ?>"><i class="icon-search"></i></a></label>
			  </span>
			  <input class="span2" style="margin:0" id="username-search" type="text" name="searchUsers" onkeyup="searchSuggest(event);" placeholder="<?php _e('User search'); ?>">
			</div>
		  </div>
		</div>
	</form>
	</legend>

	<div id="add_user" class="hide">
		<?php include_once('user-add.php'); ?>
	</div>

	<div id="user_list">
		<?php list_registered(); ?>
	</div>

</fieldset>

<script>
$('#add_new_user_btn').click(function(e) {

	e.preventDefault();
	$('#add_user').slideToggle();

});

$('#showUsers').blur(function() {
	$.post('classes/functions.php', {'showUsers' : $(this).val()});

	/* Little hack to refresh the page silently... */
	$('a[href="#level-control"]').tab('show');
	$('a[href="#user-control"]').tab('show');
});
</script>