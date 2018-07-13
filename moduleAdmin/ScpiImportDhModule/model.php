<?php

@mkdir("../cache/importsCsv/SCPI/old/", 0777, true);

foreach ($_POST as $key => $elm)
	$_POST[$key] = trim($elm);
$vue = 0;
// -1 : bug
// 0 : Afficher le formulaire d'upload
// 1 : Copie du fichier plus premiere lecture
// 2 : Recuperation dans las post
// 3 : Insertion dans la Bdd
if (count($_FILES)) {
	$target_file = "../cache/importsCsv/SCPI/BddScpi.csv";
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
	{
		$vue = 1;
		setcookie("separateur", $_POST['separateur']);
		$this->data = ParseCsvTransaction::getTransactionCsvData("../cache/importsCsv/SCPI/BddScpi.csv", $_POST['separateur']);
	}
	else
	{
		$vue = -1;
	}
}
else if (isset($GLOBALS['GET']['oldImport'])) {
	$vue = 3;
	$this->newData = unserialize(file_get_contents(
		"../cache/importsCsv/SCPI/old/" . $GLOBALS['GET']['oldImport']));
}
else if (isset($_POST['what']) && ($_POST['what'] === "Actualiser")){
	$vue = 2;
	$this->data = $this->getPostData();
}
else if (isset($_POST['what']) && $_POST['what'] == "Valider")
{
	$vue = 3;
	$this->newData = $this->insert($this->getPostData());
	$dateNow = date("Y-m-d-H-i-s");
	file_put_contents("../cache/importsCsv/SCPI/old/" . $dateNow,
		serialize($this->newData),
		LOCK_EX
	);
}
else if (isset($GLOBALS['GET']['haveData']) && $GLOBALS['GET']['haveData'] == "1")
{
	$vue = 1;
	$this->data = ParseCsvTransaction::getTransactionCsvData("../cache/importsCsv/SCPI/BddScpi.csv", $_COOKIE['separateur']);
}
