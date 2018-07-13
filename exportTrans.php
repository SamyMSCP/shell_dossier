<?php
require('app.php');
$trans = Transaction::getAll();

echo "id,dh,type_pro,cle,transaction mscpi ?\n";
foreach ($trans as $key => $val) {
	if ($val->getTypePro() == "Pleine propriété")
		continue ;
	$mscpi = $val->doByMscpi() ? 'oui' : 'non';
	echo "{$val->id},{$val->getDh()->getShortName()},{$val->getTypePro()},{$val->getClefRepartition()},$mscpi\n";
}
