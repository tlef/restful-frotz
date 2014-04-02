<?
	#
	# Frotz-Post
	#

	$FROTZ_EXE_PATH 	= '/home/tlef/frotz-src/frotz/dfrotz';
	$FROTZ_DATA_PATH 	= '/home/tlef/frotz/zork1/DATA';
	$FROTZ_SAVE_PATH 	= '/home/tlef/frotz/saves';
	$FROTZ_DATA_MAP		= array(
		'zork1' => 'ZORK1.DAT'
	);

	$STREAM_PATH		= '/home/tlef/frotz/streams';

	$session_id = $_REQUEST['session_id'];
	if (!$session_id){
		die(json_encode(array('ok'=>0, 'error'=>'missing session_id')));
	}

	$data_id = $_REQUEST['data_id'];
	if (!$data_id){
		die(json_encode(array('ok'=>0, 'error'=>'missing data_id')));
	}

	$data_file = $FROTZ_DATA_MAP[strtolower($data_id)];
	if (!$data_file){
		die(json_encode(array('ok'=>0, 'error'=>'invalid data_id')));
	}

	$output_type = $_REQUEST['output_type'];
	if (!$output_type){
		$output_type = 'screen';
	}

	$command = $_REQUEST['command'];
	if (!$command){
		die(json_encode(array('ok'=>0, 'error'=>'missing command')));
	}

	$save_path = "{$FROTZ_SAVE_PATH}/{$session_id}.SAV";


	# Restore from saved path
	# \lt - Turn on line identification
	# \cm - Dont show blank lines
	# \w  - Advance the timer to now
	# Command
	# Save to save path - override Y, if file exists
	#
	$overwrite = "";
	if (file_exists($save_path)){
		$overwrite = "\ny";
	}
	$input_data = "restore\n{$save_path}\n\\lt\n\\cm\\w\n{$command}\nsave\n{$save_path}{$overwrite}\n";


	$input_stream = "{$STREAM_PATH}/{$session_id}.f_in";
	$input_handle = fopen($input_stream, "w+");
	if (!$input_handle){
		die(json_encode(array('ok'=>0, 'error'=>'could not open/create input stream')));
	}

	if (!fwrite($input_handle, $input_data)){
		die(json_encode(array('ok'=>0, 'error'=>'could not write to input stream')));
	}

	fclose($input_handle);

	exec("{$FROTZ_EXE_PATH} {$FROTZ_DATA_PATH}/{$data_file} <{$STREAM_PATH}/$session_id.f_in", $output);

	$lines = strip_header_and_footer($output);

	$split = preg_split('/\s+/', $lines[0]);
	$data = array();
	$data['moves'] = $split[count($split)-1];
	$data['score'] = $split[count($split)-3];
	$data['location'] = trim(implode(" ", array_slice($split, 2, count($split)-6)));
	$data['title'] = trim($lines['1']);
	$data['message'] = array_slice($lines, 2);

	switch ($output_type){
		case 'screen':
			echo json_encode($data);
			break;
		default:
			die(json_encode(array('ok'=>0, 'error'=>'invalid output_type')));
			break;
}

	#
	# Since each entry will generate the default lines, before we restore our state, 
	# and the restore and save command's themselves, we need to strip them from the
	# lines.
	#
	function strip_header_and_footer($lines){

		$starting_header = explode("\n",
			"0:  West of House                               Score: 0        Moves: 0
			1: 
			2: ZORK I: The Great Underground Empire
			3: Copyright (c) 1981, 1982, 1983 Infocom, Inc. All rights reserved.
			4: ZORK is a registered trademark of Infocom, Inc.
			5: Revision 88 / Serial number 840726
			6: 
			7: West of House
			8: You are standing in an open field west of a white house, with a boarded
			9: front door.
			10: There is a small mailbox here.
			11: 
			12: >Please enter a filename []:  West of House                               Score: 0        Moves: 7
			13: 
			14: Ok.
			15: 
			16: >Line-type display ON
			17: >Compression mode MAX, hiding top 0 lines");


		$ending_footer = explode("\n",
			"19: >Please enter a filename [/home/tlef/frotz/saves/1.SAV]: Overwrite existing file? Ok.
			20: >
			");

		$stripped_lines = array();

		foreach ($lines as $idx=>$line){

			if ($idx >= count($starting_header)){
				$stripped_lines[] = trim($line);
			}

			if ($idx + count($ending_footer) >= count($lines)){
				break;
			}
		}
		return $stripped_lines;
	}

