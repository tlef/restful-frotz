<?
	#
	# FROTZ_EXE_PATH is the path to your dfrotz executable
	# required: read permissions
	#
	$FROTZ_EXE_PATH 	= '/usr/local/bin/dfrotz';

	#
	# FROTZ_SAVE_PATH - The path to access/store your frotz save files
	# required: read/write permissions
	#
	$FROTZ_SAVE_PATH 	= '/opt/frotz/saves';

    #
	# FROTZ_SLOT_SAVES_ENABLED - Boolean value to indicate whether explicit saves are
	# permitted.
	#
	$FROTZ_SLOT_SAVES_ENABLED = True;

	#
    # FROTZ_SAVE_SLOTS - Numeric value indicating the number of save games available
    # for each session.  If not specified the default is 5.  FROTZ_SAVES_ENABLED
    # must be true for this to apply, of course.
    #
	$FROTZ_SAVE_SLOTS = 5;

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
			'path'		=> '/opt/frotz/data/ZORK1.z3',
			'header'	=> 13,
			'load'		=> 6,
			'save'		=> 3,
		),

		'zork2' => array(
			'path'		=> '/opt/frotz/data/ZORK1.z3',
			'header'	=> 15,
			'load'		=> 6,
			'save'		=> 3,
		),

		'zork3' => array(
			'path'		=> '/opt/frotz/data/ZORK1.z3',
			'header'	=> 24,
			'load'		=> 6,
			'save'		=> 3,
		),
	);

	#
	# STREAM_PATH - The path to access/store the stream files
	# required: read/write permissions
	#
	$STREAM_PATH		= '/opt/frotz/streams';
