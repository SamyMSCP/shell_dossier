<?php
require_once("class/core/Ajax.php");
class AjaxTemplate extends Ajax
{
	public function updateTemplate($data) {
		if ($data['id'] == "undefined")
			error("Une valeur est incorrecte !");
		if (CommunicationTemplate::updateTemplate($data))
		{
//		var_dump($data);
			self::printTemplate();
			return false;
		}
		return (true);
	}
	public function createTemplate($data) {
		$ret = CommunicationTemplate::insertNew($data['name'], $data['content'], $data['categorie'], "" . $data['on_client']);
		if (!empty($ret)){
			self::printTemplate();
			return;
		}
		error("Impossible de creer le template");
	}

	public function printTemplate() {
		$type = [];
		foreach (CommunicationTemplate::getTypeCommunication() as $key => $elm){
			$type[] = $elm->classname;
		}
		$listTemplates = CommunicationTemplate::getAll();

		echo json_encode(["categorie" => $type, "template" => $listTemplates]);
	}
}