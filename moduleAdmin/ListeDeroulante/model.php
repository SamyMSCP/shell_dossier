<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
if (isset($_POST['submit']) && $_POST['submit'] == "Envoyer le document")
{
	if (count($_FILES)) {
		$type = $_FILES['fichier']['type'];
		$data = ft_encryption_file($_FILES["fichier"]['tmp_name']);
		$dateExecution = "";
		if (isset($_POST['dateExecution']))
			$dateExecution = $_POST['dateExecution'];
		
		Document::insertNew(
			$_POST['idTypeDocument'],
			$_POST['idEntity'],
			$_POST['linkEntity'],
			$data,
			$type,
			$_FILES['fichier']['name'],
			$dateExecution
		);
		Notif::set("MsgUploadDocument", "Le document a bien ete enregistre");
	}
}
