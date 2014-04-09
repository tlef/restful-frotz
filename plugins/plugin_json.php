<?
	#
	# plugin_json
	# The JSON plugin for restful-frotz
	#

	#
	# JSON input handler doesn't need to do anything
	#
	function handler_input(&$params){

		# nothing
	}

	#
	# JSON output handler just outputs to the body
	#
	function handler_output($data){

		print_r(json_encode($data));
		return array('ok' => 1);
	}

	#
	# JSON error handler just outputs to the body
	#
	function handler_error($error){

		error_log("restful-frotz [json] error: ".$error);
		die(json_encode(array('ok' =>0, 'error' => $error)));
	}

