<?php
	if (empty($_POST))
		http_response_code(400);
	else {
		switch ($_POST['action'])
		{
			case 'emit':
				EventListener::emit($_POST['data']['event']);
				break;
			default:
				http_response_code(400);
		}
	}