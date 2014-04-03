<?
	#
	# Frotz-Post
	#

	$FROTZ_EXE_PATH 	= '/home/tlef/frotz-src/frotz/dfrotz';
	$FROTZ_SAVE_PATH 	= '/home/tlef/frotz/saves';
	$FROTZ_DATA_MAP		= array(
		'zork1' => '/home/tlef/frotz/zork1/DATA/ZORK1.DAT'
	);

	$STREAM_PATH		= '/home/tlef/frotz/streams';

	if ($_REQUEST['handler']){
		$plugin = 'plugins/plugin_'.$_REQUEST['handler'].'.php';
		if (file_exists($plugin)){
			include $plugin;
			frotz_restful_input($_REQUEST);
		}else{
			die(json_encode(array('ok'=>0, 'error'=>'missing handler plugin '.$plugin)));
		}
	}



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

	$save_path = "{$FROTZ_SAVE_PATH}/{$session_id}.SAV";

	# Restore from saved path
	# \lt - Turn on line identification
	# \cm - Dont show blank lines
	# \w  - Advance the timer to now
	# Command
	# Save to save path - override Y, if file exists
	#
	$overwrite = "";
	$had_save = file_exists($save_path);
	if ($had_save){
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

	exec("{$FROTZ_EXE_PATH} {$data_file} <{$STREAM_PATH}/$session_id.f_in", $output);

	$lines = strip_header_and_footer($output, !$had_save);

	$data = array();
	if (strpos($lines[0], 'Score:') !== false && strpos($lines[0], 'Moves:') !== false){
		$split = preg_split('/\s+/', $lines[0]);
		$data['moves'] 	  = $split[count($split)-1];
		$data['score'] 	  = $split[count($split)-3];
		$data['location'] = trim(implode(" ", array_slice($split, 0, count($split)-4)));
		$data['title'] 	  = trim($lines['1']);
		$data['message']  = array_slice($lines, 2);
	}else{
		$data['error']  = trim($lines[0]);
	}

	frotz_restful_output($data);
	switch ($output_type){
		case 'screen':
			//echo json_encode($data);
			break;
		case 'slack':
//			include "plugins/plugin_slack.php";
			frotz_restful_output($data);
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
	function strip_header_and_footer($lines, $show_intro){

		$header = explode("\n",
			"West of House                               Score: 0        Moves: 0
			
			ZORK I: The Great Underground Empire
			Copyright (c) 1981, 1982, 1983 Infocom, Inc. All rights reserved.
			ZORK is a registered trademark of Infocom, Inc.
			Revision 88 / Serial number 840726
			 
			West of House
			You are standing in an open field west of a white house, with a boarded
			front door.
			There is a small mailbox here.
			\n");

		$load = explode("\n",
			">Please enter a filename []:  West of House                               Score: 0        Moves: 7
			 
			 Ok.
			 
			 >Line-type display ON
			 >Compression mode MAX, hiding top 0 lines");


		$save = explode("\n",
			">Please enter a filename [/home/tlef/frotz/saves/1.SAV]: Overwrite existing file? Ok.
			>
			");


		if ($show_intro){
			#
			# Modify lines so the intro matches Line-type display
			#
			$lines[0] = "> >".$lines[0];
			unset($lines[1]);
		}

		$stripped_lines = array();

		foreach ($lines as $idx=>$line){
			$line = str_replace("> > ", "", $line);
			if ($idx < count($header)-1){
				if ($show_intro){
					$stripped_lines[] = trim($line);
				}

			}elseif ($idx < (count($header)+count($load))-1){
				#
				# Skip the load data
				#

			}elseif (!$show_intro && ($idx + count($save) >= count($lines)+1)){
				#
				# Skip the save data
				#

			}elseif (!$show_intro){
				$stripped_lines[] = trim($line);
			}
		}

		return $stripped_lines;
	}

