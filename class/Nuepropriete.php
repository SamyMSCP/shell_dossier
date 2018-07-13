<?php
class Nuepropriete
{
	private static $instance = NULL;
	public static function getInstance(){
		if (empty(self::$instance))
			self::$instance = new Nuepropriete();
		return (self::$instance);
	}
	private function __construct(){}
	public function getVal($obj)
	{
		if (ft_decrypt_crypt_information($obj->enr_date) == "-")
			return (0);
		$dates = $obj->getDateTimeEntreeJouissance()->getTimestamp();
		$datef = $this->ft_date_fin($dates, $obj->dt);
		$val_pleinepro = $obj->getactualvalueonepart();
		$price = $obj->prix_part;
		$cle = $obj->cle_repartition;
		return ($this->ft_val_cession(date("d-m-Y", $dates), date("d-m-Y", $datef), $val_pleinepro, $price, ft_decrypt_crypt_information($cle)));
	}
	private function ft_date_fin($date_debut, $annee){
		return (strtotime("+" . $annee . " year", $date_debut) - (24 * 60 * 60));
	}
	public function getDateFinDemembrement($obj)
	{
		if (ft_decrypt_crypt_information($obj->enr_date) == "-")
			return (0);
		$dates = $obj->getDateTimeEntreeJouissance()->getTimestamp();
		$datef = $this->ft_date_fin($dates, $obj->dt);
		$rt = new DateTime();
		$rt->setTimestamp($datef);
		return ($rt);
	}
	private function ft_val_nuepro($price, $cle){
		return ($price * $cle / 100);
	}
	private function ft_day_rest($dates, $datef){
		return (round((strtotime(str_replace('/', '-', $datef)) - strtotime(str_replace('/', '-', $dates))) / (60*60*24)));
	}
	private function ft_taux_actualisation_journalier($valeur_revente, $val_nuepro, $nbr_day){ // val real
		if ($val_nuepro == 0)
			return (null);
											// to day,        cle * prix de la part
		return (pow($valeur_revente / $val_nuepro,
			(1 / $nbr_day)) - 1);
	}
	private function ft_val_cession($dates, $datef, $val_pleinepro, $price, $cle){
		if (pow(1 + $this->ft_taux_actualisation_journalier($val_pleinepro, $this->ft_val_nuepro($price, $cle), $this->ft_day_rest($dates, $datef)), $this->ft_day_rest(date("d-m-Y"), $datef)) == 0)
			return (0);
		return ($val_pleinepro / pow(1 + $this->ft_taux_actualisation_journalier($val_pleinepro, $this->ft_val_nuepro($price, $cle), $this->ft_day_rest($dates, $datef)), 
		$this->ft_day_rest(date("d-m-Y"), $datef)));
	}
}
?>
