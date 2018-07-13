<?php

if (!empty($_POST['action']))
{
	switch ($_POST['action'])
	{
		case 'count':
			$this->count();
		break ;

		case 'send':
			$this->send();
		break ;
/*
		case '':

		break;
*/	}
}