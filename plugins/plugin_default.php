<?
	#
	# plugin_default
	# The default plugin for restful-frotz
	#

	#
	# Default input handler doesn't need to do anything
	#
	function handler_input(&$params){

		# nothing
	}

	#
	# Default output handler just outputs to the body
	#
	function handler_output($data){

		print_r(json_encode($data));
		return array('ok' => 1);
	}

	#
	# Default error handler just outputs to the body
	#
	function handler_error($error){

		die(json_encode(array('ok' =>0, 'error' => $error)));
	}

