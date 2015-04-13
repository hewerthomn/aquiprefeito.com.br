<?php return [
	'library' 	 	=> 'imagick',
	'upload_dir' 	=> '/img',
	'upload_path' => public_path() . '/img/',
	'quality'     => '85',
	'overwrite'   => true,

	'dimensions'  => [
//		    width  height crop  quality
		'sm' => [60, 	60,  false, 90],
		'md' => [120, 120, false, 90],
		'lg' => [320, 240, false, 95]
	],
];
