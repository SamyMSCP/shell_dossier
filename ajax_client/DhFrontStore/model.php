<?php
if (!isset($curDh))
	$this->dh = Dh::getCurrent();
else
	$this->dh = $curDh;

if (!empty($_POST['action']))
{
	switch($_POST['action'])
	{
		case 'count_dh_ci':
			$this->count_dh_ci();
			break ;
		case 'count_dh_ciscpi':
			$this->count_dh_ciscpi();
			break ;
		case 'precalcul':
			$this->precalcul();
			break ;
		case 'update_ci':
			$this->update_ci();
			break ;
		case 'update_ciscpi':
			$this->update_ciscpi();
			break ;
	}
}