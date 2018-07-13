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

			/*
			 * A: Select last modification ?
			 * B: Last Modification is in range
			 * C: Select enregistrement date ?
			 * D: Date Enregistrment is in range
			 *
			 * E: Who for sort by DH name ?
			 * F: Dh name contain the who ?
			 *
			 * G: Specific SocGest or get All
			 * H: SocGest is correct
			 *
			 * I: Check all the ranges
			 * J: Check Name
			 * K: Check SocGest
			 *
			 * Calculs:
			 * I = (A * B * C * D) + (A * B * !C) + (C * D * !A) + (!A * !C)
			 *           All           Only Mod        Only enr     Nothing
			 * J = (E * F) + (!E)
			 *      Value     No
			 * K = (G * H) + (!G)
			 *      Value     No
			 *
			 * J & K: Check if value is ok and need check. If not need to check, it's OK (Second part of equation)
			 */

			$a = in_array('mod', $d_sel);
			$b = $d_start < $elm->date_edit_trans && $elm->date_edit_trans < $d_end;
			$c = in_array('enr', $d_sel);
			$d = $d_start < $elm->enr_date && $elm->enr_date < $d_end;

//			$e = $who !== "";
//			if ($e)
//				$f = (strlen(strstr($name, strtolower($who))) > 0);
//			else
//				$f = false;

//			$g = ($socgest === -1);
//			$h = intval($elm->id_scpi) === $socgest;
			$g = true;
			$h = true;

//			$i = ($a * $b * $c * $d) + ($a * $b * !$c) + ($c * $d * !$a) + (!$a * !$c);//Check date inside range and set
			$i = ($a * $b) + (!$a);
			$i *= ($c * $d) + (!$c);
//			$j = ($e * $f) + !$e;//Check who is set and ok
			$j = true;//Disabled 'cause front
			$k = ($g * $h) + !$g;//Check socgest is set and OK
			$keep = $i * $j * $k;//Check all conditions work together
// DEBUG
/*
			echo "[ A - " . (($a) ? $a : "0") . " ]";
			echo "[ B - " . (($b) ? $b : "0") . " ]";
			echo "[ C - " . (($c) ? $c : "0") . " ]";
			echo "[ D - " . (($d) ? $d : "0") . " ]";
			echo "[ E - " . (($e) ? $e : "0") . " ]";
			echo "[ F - " . (($f) ? $f : "0") . " ]";
			echo "[ G - " . (($g) ? $g : "0") . " ]";
			echo "[ H - " . (($h) ? $h : "0") . " ]";
			echo "[ I - " . (($j) ? $j : "0") . " ]";
			echo "[ J - " . (($j) ? $j : "0") . " ]";
			echo "[ K - " . (($k) ? $k : "0") . " ]";
			echo "[ KEEP - " . $keep . " ]<br/>";
//*/

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
//		$d['volume'] = $vol;
		$d['volume']['volume'] = 0;
		$d['volume']['parts'] = 0;
		$d['conseillers_stats'] = $vol_per_conseiller;
		$d['who'] = $who;
		return ($d);
	}
}
