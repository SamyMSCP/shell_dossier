<?php

if (!empty($_POST['data']) && !empty($_POST['action']))
{
	switch ($_POST['action']) {
		case 'create':
			$this->createCentreInteret($_POST['data']);
			break;
		case 'update':
			$this->updateCentreInteret($_POST['data']);
			break;
		case 'delete':
			$this->deleteCentreInteret($_POST['data']);
			break;
	}
}