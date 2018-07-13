<?php
require_once("class/core/Ajax.php");
class UpdateValeurRealisation extends Ajax
{
	public function setValue($data)
	{
		$id_scpi = intval($data['id_scpi']);
		$value = floatval($data['value']);
		$id_valeur = ValeurRealisation::saveValue($id_scpi, $value);
		if (empty($id_scpi))
		{
			http_response_code(404);
			echo json_encode([]);
			exit();
		}
		return (ValeurRealisation::getFromScpiId($id_scpi)[0]);
	}
}
