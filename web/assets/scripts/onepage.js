$(window).load(function() {	
	// start up after 2sec
    window.setTimeout(function(){
        $('body').removeClass('loading').addClass('loaded');
		$('.home-body-max').fadeTo(800, 1);
    }, 800);

	$('.selectpicker').selectpicker();
	$('#myTab a').click(function (e) {
  		e.preventDefault()
  		$(this).tab('show')
	})
	$('#print-acc').tooltip();
	$('#create-acc').tooltip();
	$('#search-btn').tooltip();
	$('.schedule-delete').tooltip();
	$('.panel-schedule').popover({
		html: true,
		title: function() {
			return $('.popover-title').html();
		},
		content: function() {
			return $('.popover-message').html();
		}
	});
    
	$('#myTab a[href="#profile"]').tab('show') // Select tab by name
	$('#myTab a:first').tab('show') // Select first tab
	$('#myTab a:last').tab('show') // Select last tab
	$('#myTab li:eq(2) a').tab('show') // Select third tab (0-indexed)

	if($.cookie('sidebar-active') == 'true') {
		$('.minimize').parent('div').parent('div').addClass('minified-sidebar-active');
		$('.side-name').hide();
		$('.maximize').show();
		$('.minimize').hide();
		$('.schedule-title').parent('div').addClass('home-body-min').removeClass('home-body-max');
	} else {
		$('.maximize').parent('div').parent('div').removeClass('minified-sidebar-active');
	}
	
	var href = window.location.pathname;
	$('.header-anchor').children('a').each(function() {
		if(href == $(this).attr('href')) {
			$(this).children('div').addClass('current');
		}
    });
	
	$('.sidebar-link').children('a').each(function() {
		if(href == $(this).attr('href')) {
			$(this).children('div').addClass('current-sidebar');
			$(this).children('div').children('p').children('span').children('.arrow-right').show();
		}
    });
	
	$('.minimize').click(function(e) {
        e.preventDefault();
		$(this).parent('div').parent('div').addClass('minified-sidebar');
		$('.side-name').hide();
		$('.maximize').show();
		$('.minimize').hide();
		$('.schedule-title').parent('div').addClass('home-body-min').removeClass('home-body-max');
		$.cookie('sidebar-active', 'true');
    });
	
	$('.maximize').click(function(e) {
        e.preventDefault();
		$('.schedule-title').parent('div').addClass('home-body-max').removeClass('home-body-min');
		$(this).parent('div').parent('div').removeClass('minified-sidebar');
		$(this).parent('div').parent('div').removeClass('minified-sidebar-active');
		$('.maximize').hide();
		$('.minimize').show();
		$('.side-name').show();
    	$.cookie('sidebar-active', 'false');
	});
	
	$('.panel-schedule-body').click(function(e) {
		$('.edit-schedule').children('[name="schedule-id"]').attr('value', $(this).children('.schedule-id').text());
        $('.edit-schedule').children('[name="schedule-code"]').attr('value', $(this).children('.schedule-code').text());
		$('.edit-schedule').children('[name="schedule-name"]').attr('value', $(this).children('.schedule-name').text());
		$('.edit-schedule').children('[name="schedule-day"]').attr('value', $(this).children('.schedule-day').text());
		$('.edit-schedule').children('[name="schedule-time"]').attr('value', $(this).children('.schedule-time').text());
		$('.edit-schedule').children('[name="schedule-faculty"]').children('.option-active')
			.attr('value', $(this).children('.schedule-faculty').text()).text($(this).children('.schedule-faculty').text());
    });
	
	$('.schedule-delete').click(function(e) {
        var removeSchedule = confirm('Do you wish to delete?');
		if(removeSchedule == true) {
			$('.delete-schedule').children('[name="delete-id"]')
				.attr('value', $(this).parent('div').siblings('.schedule-id').text());
			$('.delete-schedule').children('[name="delete-code"]')
				.attr('value', $(this).parent('div').siblings('.schedule-code').text());
			$('.delete-schedule').children('[name="delete-subject"]')
				.attr('value', $(this).parent('div').siblings('.schedule-name').text());
			$('.delete-schedule').children('[name="delete-day"]')
				.attr('value', $(this).parent('div').siblings('.schedule-day').text());
			$('.delete-schedule').children('[name="delete-time"]')
				.attr('value', $(this).parent('div').siblings('.schedule-time').text());
			$('.delete-schedule').children('[name="delete-faculty"]')
				.attr('value', $(this).parent('div').siblings('.schedule-faculty').text());
			$('.btn-delete-schedule').click();
		}
		
		return false;
    });
	
	$('.panel-student-account').click(function(e) {
		var name = $(this).children('.sa-name').text();
		var arrname = name.split(',');
        $('.edit-sa').children('[name="sa-"]').attr('value', $(this).children('.sa-name').text());
		$('.edit-sa').children('[name="schedule-name"]').attr('value', $(this).children('.schedule-name').text());
		$('.edit-sa').children('[name="schedule-day"]').attr('value', $(this).children('.schedule-day').text());
		$('.edit-sa').children('[name="schedule-time"]').attr('value', $(this).children('.schedule-time').text());
		$('.edit-sa').children('[name="schedule-faculty"]').children('.option-active')
			.attr('value', $(this).children('.schedule-faculty').text()).text($(this).children('.schedule-faculty').text());
    });
	
	$('.register-account').change(function(e) {
       $('.register-account-submit').click(); 
    });
	
	$('.login-btn-forgot').click(function(e) {
        e.preventDefault();
		$('#login-form-head').hide();
		$('#login-forgot-head').show();
		$('#login-form').hide();
		$('#login-forgot-form').show();
		$('.login-btn-forgot').hide();
		$('.login-btn-back').show();
    });
	
	$('.login-btn-back').click(function(e) {
        e.preventDefault();
		$('#login-forgot-head').hide();
		$('#login-form-head').show();
		$('#login-forgot-form').hide();
		$('#login-form').show();
		$('.login-btn-back').hide();
		$('.login-btn-forgot').show();
    });
	
	$('.acc-type').change(function(e) {
        if($('.acc-type').val() == 'student') {
			$('.modal-head-prof').hide();
			$('.modal-professor').hide();
			$('.prof-footer').hide();
			$('.modal-student').show();
			$('.stud-footer').show();
			$('.modal-head-stud').show();
		} else if($('.acc-type').val() == 'professor') {
			$('.modal-student').hide();
			$('.stud-footer').hide();
			$('.modal-head-stud').hide();
			$('.modal-head-prof').show();
			$('.modal-professor').show();
			$('.prof-footer').show();
		}
    });
});

$(document).ready(function(e) {
    $('#slider').cycle({ 
    	fx:     'fade', 
    	delay:	-2000 
	});
	
	$('.main').onepage_scroll({
   		sectionContainer: "section",     // sectionContainer accepts any kind of selector in case you don't want to use section
   		easing: "ease",                  // Easing options accepts the CSS3 easing animation such "ease", "linear", "ease-in", 
                                    // "ease-out", "ease-in-out", or even cubic bezier value such as "cubic-bezier(0.175, 0.885, 0.420, 1.310)"
   		animationTime: 1000,             // AnimationTime let you define how long each section takes to animate
   		pagination: true,                // You can either show or hide the pagination. Toggle true for show, false for hide.
   		updateURL: false,                // Toggle this true if you want the URL to be updated automatically when the user scroll to each page.
   		beforeMove: function(index) {},  // This option accepts a callback function. The function will be called before the page moves.
   		afterMove: function(index) {},   // This option accepts a callback function. The function will be called after the page moves.
   		loop: true,                     // You can have the page loop back to the top/bottom when the user navigates at up/down on the first/last page.
   		keyboard: true,                  // You can activate the keyboard controls
   		responsiveFallback: false        // You can fallback to normal page scroll by defining the width of the browser in which
                                    // you want the responsive fallback to be triggered. For example, set this to 600 and whenever 
                                    // the browser's width is less than 600, the fallback will kick in.
	});

});