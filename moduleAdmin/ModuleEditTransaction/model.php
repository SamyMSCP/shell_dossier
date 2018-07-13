<?php
if (!empty($GLOBALS['GET']['client']))
{
	$this->transactions = Dh::getById($GLOBALS['GET']["client"])->getTransaction();
	foreach ($this->transactions as $key => $elm)
		$this->transactions[$key]->getDh()->getPersonnePhysique();
}
if (isset($_POST['actionUpdateTrans']) && $_POST['actionUpdateTrans'] == "updateIt")
	$this->updateAlTransId();
