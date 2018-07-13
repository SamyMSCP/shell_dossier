<?php
require_once("class/core/AjaxClient.php");
class RestDocuments extends AjaxClient
{
	public function getDocument($id_doc)
	{
		global $curDh;

		if (!isset($curDh))
			$curDh = Dh::getCurrent();

		if (empty($id_doc)
			|| empty(($doc = Document::getFromId($id_doc)))
			|| (
				isProd() &&
				$doc[0]->getEntity()[0]->id_donneur_ordre != $curDh->id_dh
			)
		)
			error("Non");
		else
		{
			header('Content-Type: '. $doc[0]->type);
			header('Content-Disposition: inline');
			//echo ft_decode_file($doc[0]->data);
			echo $doc[0]->getData();
			exit();			
		}
	}
}
