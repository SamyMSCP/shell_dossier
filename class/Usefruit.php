<?php
class Usefruit
 {
 	private static $instance = null;

 	public static function getInstance(){
 		if (empty(self::$instance))
 			self::$instance = new Usefruit();
 		return (self::$instance);
 	}
 	private function __construct(){}
 	
 	private function day_start($date_acquisition, $cycle){
		$time = str_replace('/', '-', $date_acquisition);
		$time = explode('-', $time);
		$time[0] = '01';
		$nstr = $time[0] . '-' . $time[1] . '-' . $time[2];
		return (strtotime("+" . $cycle . " month", strtotime($nstr)));
	}
	private function ft_date_fin($date_debut, $annee){
		return (strtotime("+" . $annee . " year", $date_debut) - (24 * 60 * 60));
	}
 	private function ft_day_rest($dates, $datef){
		return (round(($datef - $dates) / (60*60*24)));
	}
 	public function getUsefruit($id_scpi, $cle, $prix_part_pleine, $annee, $date_acquisition){
		if ($date_acquisition === "-")
			return (0);
 		$b20 = ($cle / 100) * $prix_part_pleine;
 		$date_s =  DelaiJouissance::getDateTimeFromDateId($id_scpi, $date_acquisition)->getTimestamp();//API  //day_start($date_acquisition, $cycle);
 		$date_f = $this->ft_date_fin($date_s, $annee);
		return (round(($this->ft_day_rest(time(), $date_f) / $this->ft_day_rest($date_s, $date_f)) * $b20, 2));
 	}
 }
 ?>
