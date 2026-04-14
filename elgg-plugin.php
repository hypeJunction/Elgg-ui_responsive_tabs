<?php

return [
	'plugin' => [
		'id' => 'ui_responsive_tabs',
		'name' => 'Responsive Tabs',
		'version' => '1.1.0',
		'description' => 'Responsive tab navigation for Elgg.',
		'author' => 'Ismayil Khayredinov',
		'category' => 'ui',
	],

	'view_extensions' => [
		'elements/components.css' => [
			'elements/navigation/tabs.css' => [],
		],
		'elgg.js' => [
			'elements/navigation/tabs.js' => [],
		],
	],
];
