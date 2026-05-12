<?php

return [
	'plugin' => [
		'id' => 'ui_responsive_tabs',
		'name' => 'Responsive Tabs',
		'version' => '7.0.0',
		'description' => 'Responsive tabs for Elgg',
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
