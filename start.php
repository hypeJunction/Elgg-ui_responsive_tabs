<?php

/**
 * Responsive tabs
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';

elgg_register_event_handler('init', 'system', 'ui_responsive_tabs_init');

/**
 * Initialize the plugin
 * @return void
 */
function ui_responsive_tabs_init() {

	elgg_extend_view('elements/components.css', 'elements/navigation/tabs.css');
	elgg_extend_view('elgg.js', 'elements/navigation/tabs.js');
}
