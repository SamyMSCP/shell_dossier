<?php

$this->canChangeMail = $this->collaborateur->getType() == "yoda" || $this->collaborateur->getType() == "backoffice";

if ($this->canChangeMail && isset($_POST['action']) && $_POST['action'] == 'changeMailDh')
{
	$this->changeMailDh();
}

if (isset($_POST['action']) && $_POST['action'] == 'toogleVip')
{
	$this->toogleVip();
}

if (isset($_POST['action']) && $_POST['action'] == 'toogleKo')
{
	$this->toogleKo();
}

if ($this->canChangeMail && isset($_POST['action']) && $_POST['action'] == 'non_sollicitation_par_mail')
{
	$this->nonSollicitationParMail($_POST['non_sollicitation_par_mail']);
}

$this->RequiredDocumentDh = Dh::getRequiredTypeDocument();
$this->NeedValidationDh = Dh::getTypeDocumentNeedDhValidation();

