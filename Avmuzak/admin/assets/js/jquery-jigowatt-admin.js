window.prettyPrint && prettyPrint()

$('.nav-tabs a[href="#user-control"]').tab('show');
$('.nav-tabs a[href="#general-options"]').tab('show');

/* Ajax search. */
function searchSuggest(event) {

	$.post($(event.target.form).attr('action'), $(event.target.form).serialize(), function (data) {
		$('#search_suggest').hide().html(data).fadeIn('fast');
	});

}

/* Save settings */
$('#settings-form').submit(function (e) {
	"use strict";

    e.preventDefault();
    $('#save-settings').button('loading');

    var post = $('#settings-form').serialize();
    var action = $("#settings-form").attr('action');

    $("#message").slideUp(350, function () {

        $('#message').hide();

        $.post(action, post, function (data) {
            $('#message').html(data);
            $('#message').slideDown('slow');
            if (data.match('success') !== null) {
                $('#save-settings').button('reset');
            } else {
                $('#save-settings').button('reset');
            }
        });
    });
});

/* Awesome Chosen jQuery plugin. */
 $(".chzn-select").chosen();

/* Some pretty checkbox features. */
function checkboxToggles() {
	$('input:.collapsed').click(unhideHidden);
	$('input:.uncollapsed').click(hideHidden);

	if ($('input:checked.collapsed')) {
		$('input:checked.collapsed').parent().next().hide().removeClass('hidden').fadeIn();
	}

	if ($('input:checked.uncollapsed')) {
		$('input:checked.uncollapsed').parent().next().hide().addClass('hidden');
	}
}

checkboxToggles();

function unhideHidden() {

	jQuery(':input:not(:checked).collapsed').parent().next().hide().addClass('hidden');

	if ($(this).attr('checked')) {
		$(this).parent().nextAll().hide().removeClass('hidden').fadeIn();
	}
	else {
		$(this).parent().nextAll().each(
		function(){
			if ($(this).filter('.last').length) {
				$(this).fadeOut(function() { $(this).addClass('hidden') });
				return false;
				}
			$(this).fadeOut(function() { $(this).addClass('hidden') });
		});

	}
}

function hideHidden() {
	if ($(this).attr('checked')) {
		$(this).parent().nextAll().each(
		function(){
			if ($(this).filter('.last').length) {
				$(this).fadeOut(function() { $(this).addClass('hidden') });
				return false;
				}
			$(this).fadeOut(function() { $(this).addClass('hidden') });
		});
	}
	else {
		$(this).parent().nextAll().hide().removeClass('hidden').fadeIn();
	}
}

/* Function necessary to retrieve pagination or other GET variables and pass them to the page we're retrieving. */
function getParameters() {
	var searchString = window.location.search.substring(1) , params = searchString.split("&") , hash = '';
		if ( searchString ) {
			for (var i = 0; i < params.length; i++) {
				var val = params[i].split("=");
				if ( i == 0 ) hash += "?";
				hash += unescape(val[0]) + "=" + unescape(val[1]);
				if ( i + 1 < params.length ) { hash += "&"; }
			}
		}
			return hash;
	}

/* Show the first tab by default. */
$('.nav-tabs a:first').tab('show');

$('a[data-toggle="tab"]').on('shown', function (e) {
	var divId = $(e.target).attr('href').substr(1);

	if (divId.substr(0, 4) == 'usr-') return false;

	$.get( 'page/' + divId + '.php' + getParameters() ).success(function(data){
		$("#"+divId).html(data);
		$(".chzn-select").chosen();
		checkboxToggles();
		$('[data-rel="tooltip"]').tooltip();
	});

});