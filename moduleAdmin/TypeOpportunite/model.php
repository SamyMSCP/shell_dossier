<?php
if (isset($_POST['action']) && $_POST['action'] === "updateOpportunite")
{
	if (!empty($_FILES["fichier"]['tmp_name'])){
		$type = $_FILES['fichier']['type'];
		$data = ft_encryption_file($_FILES["fichier"]['tmp_name']);
	}
	if (!empty($data))
		Opportunite::updateFromIdImage($_POST['id'], $data, $type);
	Opportunite::updateFromId(
		$_POST['id'],
		$_POST['titlepicto'],
		$_POST['thetitle'],
		$_POST['title'],
		$_POST['left_val'],
		$_POST['right_val'],
		$_POST['left_msg'],
		$_POST['right_msg'],
		$_POST['content'],
		$_POST['url'],
		isset($_POST['isonline'])
	);
}

if (isset($_POST['action']) && $_POST['action'] === "addTypeOpportunite" && !empty($_FILES))
{
	$type = $_FILES['fichier']['type'];
	$data = ft_encryption_file($_FILES["fichier"]['tmp_name']);
	Opportunite::insert(
		$_POST['titlepicto'],
		$_POST['thetitle'],
		$_POST['title'],
		$_POST['left_val'],
		$_POST['right_val'],
		$_POST['left_msg'],
		$_POST['right_msg'],
		$_POST['content'],
		$_POST['url'],
		isset($_POST['isonline']),
		$data,
		$type
	);
}
$this->allTypeDocuments = TypeDocument::getAll();
$this->allTypeDocumentsEntity = TypeDocumentEntity::getAll();
$this->allEntity = Entity::getAll();
$this->Opportunite = Opportunite::getAll();
$this->loadModule("SuggestionModule", "SuggestionModule", array());
$this->loadModule("OpportuniteModule", "OpportuniteModule", array());
