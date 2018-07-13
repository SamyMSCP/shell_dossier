<?php
if (!empty($_POST["action"]) && $_POST["action"] == "addDocument")
{
	if (count($_FILES)) {
		$type = $_FILES['fichier']['type'];
		$data = ft_encryption_file($_FILES["fichier"]['tmp_name']);
		$dateExecution = "";
		if (isset($_POST['dateExecution']))
			$dateExecution = $_POST['dateExecution'];
		Document::insertNewWithOnline(
			$_POST['idTypeDocument'],
			$_POST['idEntity'],
			NULL,
			$data,
			$type,
			$_FILES['fichier']['name'],
			$dateExecution,
			isset($_POST['online'])
		);
		Notif::set("MsgUploadDocument", "Le document a bien ete enregistre");
	}
}

if (!empty($_POST["action"]) && $_POST["action"] == "updateDocument")
{
	Document::updateNewWithOnline(
		$_POST['idDoc'],
		isset($_POST['online'])
	);
	Notif::set("MsgUploadDocument", "Le document a bien ete Modifie");
}
$this->allTypeDocuments = Mscpi::getRequiredTypeDocument();
$this->Document = Mscpi::getAllDocument();
