<?php
$data = $_POST['data'];
$action = $_POST['action'];

DevLogs::set($_POST, 1);

//if ($data['id'] == 0)
if ($action == "updateCommentaire")
	$rt = $this->updateCommentaire($data);
elseif ($action == "sendFile")
	$rt = $this->saveNewFile($data);
elseif ($action == "deleteDocument")
	$rt = $this->deleteDocument($data);
elseif ($action == "changeSignedDocument")
	$rt = $this->changeSignedDocument($data);
elseif ($action == "changeValidatedDocument")
	$rt = $this->changeValidatedDocument($data);
elseif ($action == "saveDateExecution")
	$rt = $this->saveDateExecution($data);
elseif ($action == "reload")
{
	$rt = Dh::getById(intval($_POST['id_client']));
	if (empty($rt))
		error("Le donneur d'ordre n'a pas pu etre trouvé !");
	success($rt->getDocumentsForStore());
}
