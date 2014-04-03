<?

	function frotz_restful_input(&$_REQUEST){

		$_REQUEST['command'] = $_REQUEST['text'];

	}

	function frotz_restful_output($data){

		$attachment = array(
			'text' => "thetitle"
		);

		$data = array('text'=>$data['error'],
			'attachments'=>array($attachment));

		echo json_encode($data, true);
	}