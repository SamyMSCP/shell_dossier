<?php

$this->modal_content .= $this->generateCacheModal($this->dh->id_dh);

if (isset($_POST['button2id']) && $_POST['button2id'] == 'addTransaction')
	$this->insertNewTransaction();

if (
	isset($_POST["date_sell"]) &&
	isset($_POST["nbr_part_sell"]) &&
	isset($_POST["prix_part_sell"]) &&
	isset($_POST["transaction_id"])
	)
{
	$rt = Transaction::createNewSellTransaction(
		$_POST["transaction_id"],
		$_POST["date_sell"],
		$_POST["nbr_part_sell"],
		$_POST["prix_part_sell"],
		$this->data
	);
	$params = [
		"objet" => "Ajout d'une transaction de vente",
		"transaction_id" => $_POST["transaction_id"],
		"scpi_name" => Transaction::getFromId($_POST["transaction_id"])[0]->getScpi()->name,
		"date" => $_POST["date_sell"],
		"nbr_part" => $_POST["nbr_part_sell"],
		"prix" => $_POST["prix_part_sell"],
	];
	Logger::setNew("Ajout d'une transaction front client", Dh::getCurrent()->id_dh, $this->dh->id_dh, $params);
	$this->dh->regenerateCacheArrayTable();
	if ($rt) {
		Notif::set("VenteTransaction", "La transaction de vente a bien été enregistrée.");
	}
	header("Location: ?p=Portefeuille");
	exit();
}

