<?php
require_once("class/core/Ajax.php");
class AjaxObjList extends Ajax
{
	public function update($data) {
		if (
			!isset($data['id']) ||
			!isset($data['name']) ||
			!isset($data['content'])
		)
			error("La requete est mal formatée");
		$obj = ObjectifsList::getFromId(intval($data['id']));
		if (empty($obj))
			error("L'objectif à mettre a jour n'a pas pu être trouvé sur la base de donnée !");
		$obj = $obj[0];
		$obj->updateOneColumnCheckSecurity("name", htmlspecialchars($data['name']));
		$obj->updateOneColumnCheckSecurity("content", $data['content']);
		success($obj);
	}
}
