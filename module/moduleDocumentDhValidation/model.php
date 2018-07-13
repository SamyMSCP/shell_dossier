<?php

if (
	isset($GLOBALS['haveNotif']) &&
	$GLOBALS['haveNotif'] == true
)
{

}
else
{
	$documents = $this->dh->getDocumentNotValidateFromTypeName($this->documentTypeName);

	if (isset($_POST['validateDocument_' . $this->documentTypeName]))
	{
		if (isset($_POST['isValidate']))
		{
			$this->dh->setDocumentValidateFromTypeName($this->documentTypeName);
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}
		//Notif::set('NeedValidationForce', "Vous ne pouvez pas continuer sans valider ces documents");
	}

	if (count($documents))
	{
		$GLOBALS['haveNotif'] = true;
		ob_start();
		include("toValidate.php");
		$content = ob_get_contents();
		ob_end_clean();
		Notif::setNoCloseBig('NeedValidation', $content);
	}
}
