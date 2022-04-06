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
	'font_path' => base_path('public/dashboardAssets/fonts/'),
	'font_data' => [
		'examplefont' => [
			'R'  => 'arabic-regular.otf',    // regular font
			'B'  => 'arabic-regular.otf',       // optional: bold font
			'I'  => 'arabic-regular.otf',     // optional: italic font
			'BI' => 'arabic-regular.otf', // optional: bold-italic font
			'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		]
		// ...add as many as you want.
	]
	// ...
];
