<?php
$scpi = get_scpi($this->dh->id_dh, 2);
$ln = count($scpi);
$i = 0;
$montant = 0;
while ($i < $ln){
//	$montant += ft_portefeuille(ft_decrypt_crypt_information($scpi[$i]['Name']), $scpi[$i]['nbr_part2']);
	$i += 1;
}
/*
echo "Morris.Donut({
	element: 'tutoriel',
	data: [";
		$i = 0;
		while ($ln > ($i + 1)) {
			echo "{value: " . number_format((ft_portefeuille(ft_decrypt_crypt_information($scpi[$i]['Name']), $scpi[$i]['nbr_part2']) * 100 / $montant), 2, '.', '') . ", label: '" . htmlspecialchars(ft_decrypt_crypt_information($scpi[$i]['Name'])) . "'},
			";
			$i += 1;
		}
		if ($len > $i)
			echo "{value: " . number_format((ft_portefeuille(ft_decrypt_crypt_information($scpi[$i]['Name']), $scpi[$i]['nbr_part2']) * 100 / $montant), 2, '.', '') . ", label: '" . htmlspecialchars(ft_decrypt_crypt_information($scpi[$i]['Name'])) . "'}";
		echo "]
	});"
?>
*/
