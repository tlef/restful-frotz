<?
	#
	# plugin_text
	# The text plugin for restful-frotz
	#

	#
	# Text input handler doesn't need to do anything
	#
	function handler_input(&$params){

		# nothing
	}

	#
	# Text output handler just outputs to the body
	#
	function handler_output($data){

		if ($data['error']){
			echo $data['error']."\n";
		}else{
			echo $data['title']."\n";
			echo $data['message']."\n";
		}
	
		return array('ok' => 1);
	}

	#
	# Text error handler just outputs to the body
	#
	function handler_error($error){

		error_log("restful-frotz [text] error: ".$error);
		die($error);
	}

