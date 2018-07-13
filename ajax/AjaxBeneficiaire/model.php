<?php
$data = $_POST['data'];
if (!empty($_POST['subreq']))
{
	if ($_POST['subreq'] == 'add')
	{
		$this->AddBeneficiaire($data);
	}
}