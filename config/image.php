<?php return [
	'library' 	 	=> 'imagick',
	'upload_dir' 	=> '/img',
	'upload_path' => public_path() . '/img/',
	'quality'     => '85',
	'overwrite'   => true,

	'dimensions'  => [
//		    width  height crop  quality
		'sm' => [120,	60,  false, 100],
		'md' => [240, 120, false, 100],
		'lg' => [340, 240, false, 100]
	],
];
