<?php
$this->trans = $this->dh->getTransactionAbsorbedNotComplete();
if (count($this->trans))
{
	foreach ($this->trans as $key => $elm)
	{
		if ($elm->getCompletionAbsorption())
		{
			$this->scpiBefore = $elm->getScpi();
			$this->scpiAfter = $elm->getScpiParent();
			$this->Absorption = $elm->getAbsorption();
			ob_start();
			include('formAbsorption.php');
			$data = ob_get_contents();
			ob_end_clean();
			Notif::setNoClose("InformationAbsorption", $data);
		}
	}
}
