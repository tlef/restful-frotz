<?php
	#
	# FROTZ_EXE_PATH is the path to your dfrotz executable
	# required: read permissions
	#
	$FROTZ_EXE_PATH 	= '/var/www/frotz/dfrotz';

	#
	# FROTZ_SAVE_PATH - The path to access/store your frotz save files
	# required: read/write permissions
	#
	$FROTZ_SAVE_PATH 	= '/var/www/frotz/saves';

	#
	# FROTZ_DATA_MAP - A mapping of data_id's to the path and metadata of frotz data files
	# path - the path of the DAT file - required: read permissions
	# header - the line count of the header output
	# load - the line count of the load output
	# save - the line count of the save output
	#
	# As of the building of this script, Infocom lets you download Zork 1-3
	# for free at: http://www.infocom-if.org/downloads/downloads.html
	#
	$FROTZ_DATA_MAP		= array(
		'zork1' => array(
			'path'		=> '/var/www/frotz/data/ZORK1.DAT',
			'header'	=> 13,
			'load'		=> 6,
			'save'		=> 3,
		),

		'zork2' => array(
			'path'		=> '/var/www/frotz/data/ZORK2.DAT',
			'header'	=> 15,
			'load'		=> 6,
			'save'		=> 3,
		),

		'zork3' => array(
			'path'		=> '/var/www/frotz/data/ZORK3.DAT',
			'header'	=> 24,
			'load'		=> 6,
			'save'		=> 3,
		),
	);

	#
	# STREAM_PATH - The path to access/store the stream files
	# required: read/write permissions
	#
	$STREAM_PATH		= '/var/www/frotz/streams';
