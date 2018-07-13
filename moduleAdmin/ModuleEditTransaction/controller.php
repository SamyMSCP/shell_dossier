<?php
require_once("class/core/ModuleAdmin.php");
class ModuleEditTransaction extends ModuleAdmin
{
	private static				$id_mscpi = "id";

	public function updateAlTransId() {
		// Preparation des donnees pour l'importation
		foreach (SCPI::getAll() as $v)
			if ($v->id == $_POST['scpi'])
				$scpi = ft_crypt_information($v->name);
		$_POST['date'] = DateTime::createFromFormat("Y-m-d", $_POST['date'])->format("d/m/Y");
		if (empty($_POST['duree']))
			$_POST['duree'] = "0";
		if ($_POST['typepro'] === "Pleine propriété")
			$_POST['cle'] = "100";
		foreach ($_POST as $key => $value)
			if ($key != "id" && $key != "scpi" && $key != "nbrpart"
				&& $key != "prix" && $key != "duree" && $key != "info_trans")
				$_POST[$key] = ft_crypt_information($value);
		$_POST['prix'] = str_replace(",", ".", $_POST["prix"]);
		$_POST['prix'] = floatval(str_replace(" ", "", $_POST["prix"]));
		Transaction::setTransactionById($_POST['id'], $_POST['commentaire'], $_POST['marcher'], $_POST['info_trans'], $scpi, $_POST['scpi'], $_POST['date'], $_POST['nbrpart'], $_POST['prix'], $_POST['typepro'], $_POST['duree'], $_POST['cle']);
		Dh::getById($GLOBALS['GET']["client"])->regenerateCacheArrayTable();
		Header('Location: admin_lkje5sjwjpzkhdl42mscpi.php?client=' . $GLOBALS['GET']['client'] . '&p=EditTransaction');
	}
}
