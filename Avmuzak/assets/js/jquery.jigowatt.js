/**
 * jquery.jigowatt.js
 * Author: Online Arge
 */

$(function () {
	"use strict";

	/* Placeholder support for IE6+ */
	$('input[placeholder]').placeholder();

	$('[data-rel="tooltip"]').tooltip()

	$('[data-rel="tooltip-bottom"]').tooltip({
	  placement: "bottom"
	})

    /* focus inputs on load */
    if ($('#CurrentPass').length) {
        $('#CurrentPass').focus();
    } else if ($('#name').length) {
        $('#name').focus();
    } else if ($('#username').length) {
        $('#username').focus();
    }

});

/* checkbox logic */
$('.add-on :checkbox').click(function () {
	"use strict";
    if ($(this).attr('checked')) {
        $(this).parents('.add-on').addClass('active');
    } else {
        $(this).parents('.add-on').removeClass('active');
    }
});

/* forgotten password modal */
$('#forgot-form').bind('shown', function () {
	"use strict";
    $('#usernamemail').focus();
});

$('#forgot-form').bind('hidden', function () {
	"use strict";
    $('#username').focus();
});

$("#sign-up-form").validate({
	rules: {
		name: "required",
		username: {
			required: true,
			minlength: 2,
			remote: {
				url: "classes/signup.class.php",
				type: "post",
				data: { checkusername: "1" }
			}
		},
		password: {
			required: true,
			minlength: 5
		},
		validation: {
			required: true
		},
		password_confirm: {
			required: true,
			minlength: 5,
			equalTo: "#password"
		},
		email: {
			required: true,
			email: true,
			remote: {
				url: "classes/signup.class.php",
				type: "post",
				data: { checkemail: "1" }
			}
		}
	},
	messages: {
		name: "I know you've got one.",
		username: {
			required: "You need a username!",
			minlength: $.format("Enter at least {0} characters"),
			remote: jQuery.format("Username has been taken.")
		},
		password: {
			required: "Create a password",
			minlength: $.format("Enter at least {0} characters")
		},
		password_confirm: {
			required: "Confirm your password",
			minlength: $.format("Enter at least {0} characters"),
			equalTo: "Your passwords do not match."
		},
		email: {
			required: "What's your email address?",
			email: "Doesn't look like a valid email :(",
			remote: jQuery.format("Email address is in use.")
		}
   },
	errorClass: 'error',
	validClass: 'success',
	errorElement: 'p',
	highlight: function(element, errorClass, validClass) {
		$(element).parent('div').parent('div').removeClass(validClass).addClass(errorClass);
	},
	unhighlight: function(element, errorClass, validClass) {
		$(element).parent('div').parent('div').removeClass(errorClass).addClass(validClass);
	},
});

$('#forgotsubmit').click(function(){
	if ( $(this).text() != 'Done') {
		$('#forgotform').submit();
	}
})

$('#forgotform').submit(function (e) {
	"use strict";

	e.preventDefault();
	$('#forgotsubmit').button('loading');

	var post = $('#forgotform').serialize();
	var action = $('#forgotform').attr('action');

	$("#message").slideUp(350, function () {

		$('#message').hide();

		$.post(action, post, function (data) {
			$('#message').html(data);
			document.getElementById('message').innerHTML = data;
			$('#message').slideDown('slow');
			$('#usernamemail').focus();
			if (data.match('success') !== null) {
				$('#forgotform').slideUp('slow');
				$('#forgotsubmit').button('complete');
				$('#forgotsubmit').click(function (eb) {
					eb.preventDefault();
					$('#forgot-form').modal('hide');
				});
			} else {
				$('#forgotsubmit').button('reset');
			}
		});
	});
});

/* The following thanks to @chayner */
/* https://github.com/twitter/bootstrap/pull/581#issuecomment-4828029 */
$(function(){
    // Function to activate the tab
    function activateTab() {
        var activeTab = $('[href=' + window.location.hash.replace('/', '') + ']');
        activeTab && activeTab.tab('show');
    }

    // Trigger when the page loads
    activateTab();

    // Trigger when the hash changes (forward / back)
    $(window).hashchange(function(e) {
        activateTab();
    });

    // Change hash when a tab changes
    $('a[data-toggle="tab"], a[data-toggle="pill"]').on('shown', function () {
        window.location.hash = '/' + $(this).attr('href').replace('#', '');
    });
});