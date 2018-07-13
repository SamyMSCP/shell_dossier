<?php

if (isset($_POST['action']) && $_POST['action'] === "updateOpportunite")
{
	if (!empty($_FILES["fichier"]['tmp_name'])){
		$type = $_FILES['fichier']['type'];
		$data = ft_encryption_file($_FILES["fichier"]['tmp_name']);
	}
	if (!empty($data))
		Suggestion::updateFromIdImage($_POST['id'], $data, $type);
	if (empty($_POST['right_val']))
		$right_val = 0;
	else
		$right_val = 1;
	if (empty($_POST['right_msg']))
		$_POST['right_msg'] = "";
	Suggestion::updateFromId(
		$_POST['id'],
		$_POST['titlepicto'],
		$_POST['thetitle'],
		$_POST['title'],
		$_POST['left_val'],
		$right_val,
		$_POST['left_msg'],
		$_POST['right_msg'],
		$_POST['content'],
		$_POST['url'],
		isset($_POST['isonline'])
	);
}

if (isset($_POST['action']) && $_POST['action'] === "addTypeOpportunite" && !empty($_FILES["fichier"]['tmp_name']))
{
	$type = $_FILES['fichier']['type'];
	if (empty($_POST['right_val']))
		$right_val = 0;
	else
		$right_val = 1;
	$data = ft_encryption_file($_FILES["fichier"]['tmp_name']);
	Suggestion::insert(
		$_POST['titlepicto'],
		$_POST['thetitle'],
		$_POST['title'],
		$_POST['left_val'],
		$right_val,
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
$this->Suggestion = Suggestion::getAll();
$this->loadModule("SuggestionModule", "SuggestionModule", array());
$this->loadModule("OpportuniteModule", "OpportuniteModule", array());
