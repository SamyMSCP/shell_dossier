<?php
require_once("class/core/Ajax.php");
class AjaxTransaction extends Ajax
{
	public function getDataFiltered($d_start, $d_end, $who, $socgest, $d_sel) {
		$lst = Transaction::getAllForStore();
		$lst_ret = [];
		$vol_per_conseiller = [];
		$vol['volume'] = 0;
		$vol['parts'] = 0;
		$d_start = intval($d_start);
		$d_end = intval($d_end);
		foreach ($lst as $elm) {
			$name = strtolower($elm->prenom . " " . $elm->nom);

			$a = in_array('mod', $d_sel);
			$b = $d_start < $elm->date_edit_trans && $elm->date_edit_trans < $d_end;
			$c = in_array('enr', $d_sel);
			$d = $d_start < $elm->enr_date && $elm->enr_date < $d_end;

			$g = true;
			$h = true;

			$i = ($a * $b) + (!$a);
			$i *= ($c * $d) + (!$c);
			$j = true;
			$k = ($g * $h) + !$g;
			$keep = $i * $j * $k;


			if ($keep)
			{
				$lst_ret[] = $elm;
				$vol['volume'] += $elm->nbr_part * $elm->prix_part;
				$vol['parts'] += $elm->nbr_part;
				if (!isset($vol_per_conseiller[$elm->conseiller]))
					$vol_per_conseiller[$elm->conseiller] = 0;
				$vol_per_conseiller[$elm->conseiller] += $elm->nbr_part * $elm->prix_part;
			}
		}
		$d['transactions'] = $lst_ret;
		$d['volume']['volume'] = 0;
		$d['volume']['parts'] = 0;
		$d['conseillers_stats'] = $vol_per_conseiller;
		$d['who'] = $who;
		return ($d);
	}
}
