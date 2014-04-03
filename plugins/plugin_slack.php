<?

	function frotz_restful_output($data){

		$attachment = array(
			'text' => "thetitle"
		);

		$data = array('text'=>'test',
			'attachments'=>array($attachment));
		print_r(json_encode($data, true));
	}