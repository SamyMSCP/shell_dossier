<?php

require_once("class/core/Module.php");

class SetSituationFiscaleMorale extends Module
{
	public function insertSituationFiscale() {

		if (
			!isset($_POST['regime_imposition']) ||
			!isset($_POST['frottement_regime']) ||
			$_POST['regime_imposition'] < 0 || $_POST['regime_imposition'] > 3 ||
			$_POST['frottement_regime'] <= 0 || $_POST['frottement_regime'] > 100
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (Manque info)");
			return;
		}
		$regime_imposition = intval($_POST['regime_imposition']);
		$frottement_regime = intval($_POST['frottement_regime']);
		$rt = SituationFiscaleMorale::insertNew($this->Pm->getOrCreateSituation(), time(), time() + TIME_SITUATION_VALID,
			$regime_imposition,
			$frottement_regime
		);
//		Notif::set('msgAddSituation', "La situation a bien ete enregistre");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
		exit();
	}
}
