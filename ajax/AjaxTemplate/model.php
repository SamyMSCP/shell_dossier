<?php

if (!empty($_POST['action']))
{

	$data = $_POST['data'];
	switch ($_POST['action'])
	{
		case 'create':
			$this->createTemplate($data);
			break;
		case 'update':
			if ($this->updateTemplate($data))
				error("Impossible de mettre a jour le template !");
			break ;

		default:
			error("Action inconnue");
			break;
/*
		case '':

		break;
*/	}
}