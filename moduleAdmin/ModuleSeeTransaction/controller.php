<?php
require_once("class/core/ModuleAdmin.php");
class ModuleSeeTransaction extends ModuleAdmin
{
	private static				$id_mscpi = "id_excel";

	public function updateAlTransId() {
		// Preparation des donnees pour l'importation
		$allTrans = array();
		foreach ($_POST as $key => $elm)
		{
			if (empty($elm))
				continue;
			if (strncmp($key, "id_mscpi_", 9) == 0)
			{
				$allTrans[substr($key, 9)] = $elm;
			}
		}

		$insertion = array();

		foreach ($allTrans as $key => $elm)
		{
			//on verifie si la donne $elm est pas deja utilisee pour une autre transaction
			$check = Transaction::getFromKeyValue(self::$id_mscpi, $elm);
			if (count($check))
			{
				Notif::set("msgCantUpdate_" . $key . "_" . $elm, "L'id_excel [" . $elm . "] ne peux pas etre affecte a la transaction [" . $key . "] car il est deja utillise par la transaction ayant l'id " . $check[0]->id);
				continue ;
			}
			$trans = Transaction::getFromId($key);
			if (count($trans) == 0)
			{
				Notif::set("msgCantUpdate_" . $key . "_" . $elm, "La transaction ayant l'id " . $key . " n'a pas pu etre trouvee");
				continue ;
			}
			$trans = $trans[0];
			$rt = $trans->updateOneColumn(self::$id_mscpi, $elm);
			if (empty($rt))
			{
				Notif::set("msgCantUpdate_" . $key . "_" . $elm, "La transaction ayant l'id " . $key . " n'a pas pu etre mise a jour avec l'id_excel " . $elm . " pour une raison inconnue");
			}
			else
			{
				$insertion[$key] = $elm;
			}
		}
		if (count($insertion))
		{
			$str = "Contrendu des mise a jours <br />";
			$str .= "Les transaction suivantes ont ete mise a jours avec les id suivants : <br /><br />";
			$str .= "
			<table border='1' class='contrendu'>
				<thead>
					<tr>
						<th>id</th>
						<th>id_mscpi</th>
					</tr>
				</thead>
				<tbody>
			";
			foreach ($insertion as $key => $elm)
			{
				$str .= "
					<tr>
						<td>" . $key . "</td>
						<td>" . $elm . " </td>
					</tr>
				";
			}
			$str .= "
				</tbody>
			</table>
			";
			Notif::set("msgOkayUpdate", $str);
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}
		else
		{
			Notif::set("msgOkayUpdate", "Aucune mise a jour n'a ete faite");
		}
	}
}
