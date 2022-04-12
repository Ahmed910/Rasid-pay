<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',

    	// ...
	'font_path' => base_path('public/dashboardAssets/fonts/Cairo-VariableFont_wght.ttf'),
	'font_data' => [
		'examplefont' => [
			'R'  => 'Cairo-VariableFont_wght',    // regular font
			'B'  => 'Cairo-VariableFont_wght',       // optional: bold font
			'I'  => 'Cairo-VariableFont_wght',     // optional: italic font
			'BI' => 'Cairo-VariableFont_wght', // optional: bold-italic font
			'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		]
		// ...add as many as you want.
	]
	// ...
];
