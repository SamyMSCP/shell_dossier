<?php
if (isset($GLOBALS['GET']['conf']) && $GLOBALS['GET']['conf'] == "haveIndexMscpi")
	$this->transactions = Transaction::getMscpiTransaction();
else
	$this->transactions = Transaction::getAll();
if (isset($_POST['actionUpdateTrans']) && $_POST['actionUpdateTrans'] == "updateIt")
{
	$this->updateAlTransId();
}

foreach ($this->transactions as $key => $elm)
{
	$this->transactions[$key]->getDh()->getPersonnePhysique();
}
