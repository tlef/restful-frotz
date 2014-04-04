<?

	$HANDLER_SLACK_INCOMING_WEBHOOK = "https://tlef.slack.com/services/hooks/incoming-webhook?token=KANhXkFDyasG5rfA7ZXh9Kbf";
	$HANDLER_SLACK_ATTACH_COLOR 	= '333342';

	#
	# Slack specific input handler. Will convert the slack outgoign webhook
	# data to what's required for restful-frotz
	#
	function handler_input(&$_REQUEST){

		$command = str_replace($_REQUEST['trigger_word'], "", $_REQUEST['text']);
		if (substr($command, 0, 1) != " "){
			#
			# The trigger was not followed by a space,
			# so they might have just started a sentance with
			# the trigger word, so bail with no output.
			#
			die;
		}

		$_REQUEST['command'] = $command;
	}

	#
	# Slack specific output handler. Will convert the restful-frotz
	# data to what's required for a Slack incomign webhook, and call 
	# the hook.
	#
	function handler_output($data){

		global $HANDLER_SLACK_INCOMING_WEBHOOK;
		global $HANDLER_SLACK_ATTACH_COLOR;

		if ($data['error']){
			$attachment = array(
				'text' 	   => $data['error'],
				'color'    => $HANDLER_SLACK_ATTACH_COLOR,
				'fallback' => $data['error'],
			);

		}else{
			$attachment = array(
				'title'    => $data['title'],
				'text'     => $data['message'],
				'fallback' => $title,
				'color'    => $HANDLER_SLACK_ATTACH_COLOR,
			);
		}

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $HANDLER_SLACK_INCOMING_WEBHOOK);
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => json_encode(array('attachments' => array($attachment))))); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_exec($ch); 
		curl_close($ch); 
	}

