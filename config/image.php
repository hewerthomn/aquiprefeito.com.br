<?php return [
	'library' 	 	=> 'imagick',
	'upload_dir' 	=> '/imgs',
	'upload_path' => public_path() . '/imgs/',
	'quality'     => '85',
	'overwrite'   => true,

	'dimensions'  => [
		'sm' => [60, 	60,  false, 100],
		'md' => [120, 120, false, 100],
		'lg' => [320, 240, false, 100]
	],
];
