<?php

	#
	# If we have a command, lets process the new event
	#
	if ($_REQUEST['action']){

		#
		# We're not error checking here, because we're going to
		# rely on the CURL call to respond appropriately with the
		# proper message.
		#
		$args = array(
			'session_id'	=> $_REQUEST['session_id'],
			'data_id'		=> $_REQUEST['data_id'],
			'handler'		=> $_REQUEST['handler'],
		);

		#
		# CURL it!
		#
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'https://tlef.ca/projects/restful-frotz/?play&'.http_build_query($args) );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $_REQUEST);
		$response = curl_exec( $ch );
		curl_close ( $ch );
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Restful-frotz Tester</title>

	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/3.3.6/yeti/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
</head>
<body>
	<div style="width: 640px; margin-right: auto; margin-left:auto">
		<a href="https://github.com/tlef/restful-frotz"><i class="fa fa-github" style="float:right; font-size: 2rem;"></i></a>
		<h1>Restful Frotz Tester</h1>
		<hr />
		<form method="GET">
			<input type="hidden" name="action" value="1">
			<div class="form-group">
				<label class="control-label" for="session_id">session_id</label>
				<input class="form-control input" type="text" id="session_id" name="session_id" value="<?=$_REQUEST['session_id']?>" />
			</div>
			<div class="form-group" style="float:left; width:49%">
				<label class="control-label" for="data_id">data_id</label>
				<select class="form-control select" id="data_id" name="data_id">
					<option value="zork1" <?php if ($_REQUEST['data_id'] == 'zork1') echo 'selected';?>>Zork 1</option>
					<option value="zork2" <?php if ($_REQUEST['data_id'] == 'zork2') echo 'selected';?>>Zork 2</option>
					<option value="zork3" <?php if ($_REQUEST['data_id'] == 'zork3') echo 'selected';?>>Zork 3</option>
				</select>
			</div>
			<div class="form-group" style="float:right; width:49%">
				<label class="control-label" for="handler">handler</label>
				<select class="form-control select" id="handler" name="handler">
					<option value="text" <?php if ($_REQUEST['handler'] == 'text') echo 'selected';?>>Default (text)</option>
					<option value="json" <?php if ($_REQUEST['handler'] == 'json') echo 'selected';?>>JSON</option>
				</select>
			</div>
			<div style="clear:both"></div>
			<div class="form-group">
				<label class="control-label" for="data_id">command</label>
				<div class="input-group">
					<input type="text" class="form-control" name="command" autofocus>
					<span class="input-group-btn">
					<button class="btn btn-default" type="submit">Submit</button>
					</span>
				</div>
			</div>
		</form>

		Output for <strong><?=$_REQUEST['command']?></strong>:
		<pre><?php
		if ($_REQUEST['handler'] == 'json'){
			$data = json_decode($response, true);
			echo json_encode($data, JSON_PRETTY_PRINT);
		}else{
			echo $response;
		}
		?></pre>
	</div>
</body>
</html>

