<?php

$data = $_POST['data'];
$action = $_POST['action'];

if ($action == "updateName") {
	$rt = $this->updateName($data);
}
else if ($action == "setStatus3") {
	$rt = $this->setStatus3($data);
	if (empty($rt))
		error("Le status du projet n'a pas pu etre défini a 4");
	success($rt);
}
else if ($action == "setStatus4") {
	$rt = $this->setStatus4($data);
	if (empty($rt))
		error("Le status du projet n'a pas pu etre défini a 4");
	success($rt);
}
else if ($action == "contactProjet")
	$this->contactProjet($data);
