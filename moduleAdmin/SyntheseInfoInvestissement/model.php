<?php
$this->tabcrm = get_crm($this->dh->id_dh);
$this->c = count($this->tabcrm);
$tab = get_scpi($this->dh->id_dh);
$len = count($tab);
$this->nbr = 0;
$this->date = 0;
$this->part = 0;
$this->m = 0;

for ($i=0; $i < $len; $i++) { 
	$this->nbr += $tab[$i]["prix_part"];
	$this->part += $tab[$i]["nbr_part"];
	$this->m += $tab[$i]["prix_part"] * $tab[$i]["nbr_part"];
	$get_array = explode('/', ft_decrypt_crypt_information($tab[$i]["enr_date"]));
	if (count($get_array) == 3){
		$day = $get_array[0];
		$month = $get_array[1];
		$year = $get_array[2];
		$time_Stamp = mktime(0,0,0,$month,$day,$year);
		if ($time_Stamp > $this->date)
			$this->date = $time_Stamp;
	}
}
$this->i = $i;
