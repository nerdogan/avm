<?php include_once('admin.php'); ?>

<fieldset>
	<legend><?php _e('Modify levels'); ?>

		<form method="post" id="search-levels-form" class="pull-right" action="classes/add_level.class.php">
			<div class="control-group">
			  <div class="controls">
				<div class="input-prepend">
				  <button id="create_new_level_btn" class="btn btn-small"><?php _e('Create new level'); ?></button>
				  <input type="number" class="input-mini" min="0" id="showLevels" name="showLevels" placeholder="<?php _e('Show'); ?>" value="<?php echo !empty($_SESSION['jigowatt']['levels_page_limit']) ? $_SESSION['jigowatt']['levels_page_limit'] : 10; ?>">
				  <span class="add-on">
				    <label for="levelSearch"><a href="#" data-rel="tooltip-bottom" title="<?php _e('Search by Name, Level, ID, or Redirect URL.'); ?>"><i class="icon-search"></i></a></label>
				  </span>
				  <input style="margin:0;" class="span2" type="text" placeholder="<?php _e('Level search'); ?>" onkeyup="searchSuggest(event);" name="searchLevels" id="searchLevels">
				</div>
			  </div>
			</div>
		</form>
	</legend>

	<div id="create_level" class="hide">
		<?php include_once('level-create.php'); ?>
	</div>

	<?php user_levels(); ?>
</fieldset>

<script>
$('#create_new_level_btn').click(function(e) {

	e.preventDefault();
	$('#create_level').slideToggle();

});

$('#showLevels').blur(function() {
	$.post('classes/functions.php', {'showLevels' : $(this).val()});

	/* Little hack to refresh the page silently... */
	$('a[href="#user-control"]').tab('show');
	$('a[href="#level-control"]').tab('show');
});
</script>