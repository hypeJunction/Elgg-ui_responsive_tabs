require(['jquery'], function ($) {
	$(document).on('click', '.elgg-menu-filter > li > a, .elgg-tabs > li > a', function (e) {
		$(this).closest('ul').toggleClass('elgg-state-active');
		var $parent = $(this).parent();
		if ($parent.is('.elgg-state-selected')) {
			e.preventDefault();
		}
	});
});
