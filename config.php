<?


	#
	# FROTZ_EXE_PATH is the path to your dfrotz executable
	# required: read permissions
	#
	$FROTZ_EXE_PATH 	= '/home/tlef/frotz/dfrotz';

	#
	# FROTZ_SAVE_PATH - The path to access/store your frotz save files
	# required: read/write permissions
	#
	$FROTZ_SAVE_PATH 	= '/home/tlef/frotz/saves';

	#
	# FROTZ_DATA_MAP - A mapping of data_id's to the path of frotz data files
	# required: read permissions
	#
	# As of the building of this script, Infocom lets you download Zork 1-3
	# for free at: http://www.infocom-if.org/downloads/downloads.html
	#
	$FROTZ_DATA_MAP		= array(
		'zork1' => '/home/tlef/frotz/data/ZORK1.DAT',
		'zork2' => '/home/tlef/frotz/data/ZORK2.DAT',
		'zork3' => '/home/tlef/frotz/data/ZORK3.DAT',
	);

	#
	# STREAM_PATH - The path to access/store the stream files
	# required: read/write permissions
	#
	$STREAM_PATH		= '/home/tlef/frotz/streams';
