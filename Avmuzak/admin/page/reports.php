<?php include_once('admin.php'); ?>
<div id="message">
	<script src="assets/js/jquery.flot.min.js"></script>
	<script src="assets/js/jquery.flot.resize.min.js"></script>
	<?php include_once('admin.php'); ?>
	<?php include_once('../classes/reports.class.php'); ?>
	<fieldset>

		<legend><?php _e('Registered Users'); ?></legend><br>

	<!-- Datepicker form --><div id="message">

	<form method="post" action="page/reports.php" id="reports-date-form" class="form-inline">
		<?php _e('From:'); ?> <input name="start_date" value="<?php echo date('Y-m-d', $jigowatt_reports->start_date); ?>" id="from" type="date" class="hasDatePicker input-small">
		<?php _e('To:'); ?> <input name="end_date" value="<?php echo date('Y-m-d', $jigowatt_reports->end_date); ?>" id="to" type="date" class="hasDatePicker input-small">
		<button type="submit" id="reports-date-submit" class="btn" type="submit" data-loading-text="<?php _e('submitting...'); ?>"><?php _e('Submit'); ?></button>
	</form>


	<!-- Totals -->
	<div class="span3" style="margin-left:0">
		<div class="span3 thumbnail" style="margin-left:0">
			<h2 style="font-weight:normal;"><?php _e('Total'); ?></h2>
			<h4><?php echo $jigowatt_reports->countRegisteredUsers(); ?> <small><?php _e('Registered'); ?></small></h4>
			<?php foreach ($jigowatt_reports->socialMethods as $method => $color) : ?>
			<h4><?php echo $jigowatt_reports->countSocialUsers($method); ?> <small><?php echo ucwords($method) . ' users'; ?></small></h4>
			<?php endforeach; ?>
		</div>

		<div class="span3 thumbnail" style="margin-top:20px; margin-left:0">
			<h2 style="font-weight:normal;"><?php _e('Range'); ?></h2>
			<h4><?php echo array_sum($jigowatt_reports->newUsers); ?> <small><?php _e('Registered'); ?></small></h4>
			<?php foreach ($jigowatt_reports->socialMethods as $method => $color) : ?>
			<h4><?php echo $jigowatt_reports->countSocialUsers($method, true); ?> <small><?php echo ucwords($method) . ' users'; ?></small></h4>
			<?php endforeach; ?>
		</div>

		<div class="span3 thumbnail" style="margin-top:20px; margin-left:0">
			<div class="control-group">
				<div class="controls" id="choices"></div>
				<p class="help-block"><?php _e('<strong>Tip:</strong> Hover over the points on the graph!'); ?></p>
			</div>
		</div>

	</div>

	<!-- Chart -->
	<div class="span7">
		<div id="registeredUsersGraph" style="width:100%; overflow:hidden; height:368px; position:relative;"></div>
	</div>
	</fieldset>

	<fieldset>
		<legend><?php _e('Most Frequent Users'); ?></legend><br>
	<!-- Totals -->
	<div class="span3" style="margin-left:0">
		<div class="span3 thumbnail" style="margin-left:0">
			<h2 style="font-weight:normal;"><?php _e('Top 10'); ?></h2>
			<table class="table">
				<thead>
				<tr>
					<th><?php _e('Username'); ?></th>
					<th><?php _e('Logins'); ?></th>
				</tr>
				<tbody>
				<?php echo $jigowatt_reports->displayTopUsers(); ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Chart -->
	<div class="span7">
		<div id="topUsers" style="width:100%; height:368px;"></div>
	</div>

	</fieldset>

	<script>
	function weekendAreas(axes) {
		var markings = [];
		var d = new Date(axes.xaxis.min);
		// go to the first Saturday
		d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
		d.setUTCSeconds(0);
		d.setUTCMinutes(0);
		d.setUTCHours(0);
		var i = d.getTime();
		do {
			// when we don't set yaxis, the rectangle automatically
			// extends to infinity upwards and downwards
			markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
			i += 7 * 24 * 60 * 60 * 1000;
		} while (i < axes.xaxis.max);

		return markings;
	}
	var datasets = {
		"newUsers" : {
			label: "<?php _e('New users'); ?>",
			color: "#46a546",
			data: [<?php
				$counts = array();
				foreach ($jigowatt_reports->newUsers as $stamp => $count) $counts[] = "[$stamp, $count]";
				echo implode(',', $counts);
			?>]
			},
		<?php foreach ($jigowatt_reports->socialMethods as $method => $color) : ?>
		"<?php echo $method; ?>" : {
			label: "<?php echo ucwords($method) . ' users'; ?>",
			color: "#<?php echo $color; ?>",
			data: [<?php
				$counts = array();
				$users = $jigowatt_reports->socialGraph($method);
				foreach ($users as $stamp => $count) $counts[] = "[$stamp, $count]";
				echo implode(',', $counts);
			?>]
		},
		<?php endforeach; ?>
	};

	// insert checkboxes
	var choiceContainer = $("#choices");
	$.each(datasets, function(key, val) {
		choiceContainer.append('\
		<label class="checkbox" for="id' + key + '">\
			<input type="checkbox" checked="checked" name="' + key + '" id="id' + key + '">\
			<span class="choiceLabel"></span>' + val.label + ' \
		</label>');
	});
	choiceContainer.find("input").click(plotAccordingToChoices);

	function plotAccordingToChoices() {
		var data = [];

		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key])
				data.push(datasets[key]);
		});

		if (data.length > 0)
			$.plot($("#registeredUsersGraph"), data, {
				series: {
					lines: { show: true },
					points: { show: false }
				},
				grid: {
					show: true,
					aboveData: false,
					color: '#ccc',
					backgroundColor: '#fff',
					borderWidth: 1,
					borderColor: '#ccc',
					clickable: false,
					hoverable: true,
					markings: weekendAreas
				},
				xaxis: {
					mode: "time",
					timeformat: "%d %b",
					tickLength: 1,
					minTickSize: [1, "day"]
				},
				yaxes: [ { min: 0, tickSize: 1, tickDecimals: 0 }, { position: "right", min: 0, tickDecimals: 2 } ]
			});
	}

	plotAccordingToChoices();
	$("#registeredUsersGraph").resize();

	$('.legendColorBox > div').each(function(i){
		$(this).clone().prependTo(choiceContainer.find(".choiceLabel").eq(i));
	});

	function showTooltip(x, y, contents) {


		$mainDiv = $('<div class="tooltip fade top in" id="tooltip">\
						<div class="tooltip-arrow"></div>\
						<div class="tooltip-inner">' + contents + '</div>\
					  </div>').css({
								position: 'absolute',
								display: 'none',
								top: y - 45,
								left: x - 65,
							});

		$($mainDiv).appendTo('body').fadeIn(100);

	}

	$("#registeredUsersGraph").bind("plothover", function (event, pos, item) {
		var graph = $(this)
		if (item) {
			var parent = graph.offset();
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$('#tooltip').remove();

				var d = new Date(item.datapoint[0]);
				var formattedDateString = $.plot.formatDate(d, "%b %d");

				showTooltip(item.pageX, item.pageY, item.datapoint[1] + " " + item.series.label.toLowerCase() + " on " + formattedDateString + ".");

			}
		}
		else {
			$('#tooltip').remove();
			previousPoint = null;
		}
	});

	var topUsers = [
		{
			label: "<?php _e('Users'); ?>",
			data: [<?php
				$counts = array();
				$topUsers = $jigowatt_reports->topUsers();
				foreach ($topUsers as $key => $value) foreach ($value as $user => $count) $counts[] = "['$key', $count]";
				echo implode(',', $counts);
			?>]
		}
	];

	$.plot($("#topUsers"), topUsers, {
		series: {
			bars: { show: true },
			points: { show: false }
		},
		grid: {
			show: true,
			aboveData: false,
			color: '#ccc',
			backgroundColor: '#fff',
			borderWidth: 1,
			borderColor: '#ccc',
			clickable: false,
			hoverable: true
		},
		xaxis: {
			ticks: [<?php
					$counts = array();
					foreach ($topUsers as $key => $value) foreach ($value as $user => $count) $counts[] = "[$key, '$user']";
					echo implode(',', $counts);
				?>]
		}
	});
	</script>
</div>

<script>
$('.hasDatePicker').datepicker({
	format: 'yyyy-mm-dd'
});

$('#reports-date-form').submit(function (e) {
	"use strict";

    e.preventDefault();
    $('#reports-date-submit').button('loading');

    var post = $('#reports-date-form').serialize();
    var action = $("#reports-date-form").attr('action');

    $("#message").fadeOut(350, function () {

        $('#message').hide();

        $.post(action, post, function (data) {
            $('#message').html(data);
            $('#message').fadeIn('slow');
            if (data.match('Registered Users') !== null) {
                $('#reports-date-submit').button('reset');
            } else {
                $('#reports-date-submit').button('reset');
            }
        });
    });
});

</script>