<?php
if (isset($_POST['action']) && $_POST['action'] === "updateTypeDocument")
{
	TypeDocument::updateTypeDocument(
		$_POST['id_type_document'],
		$_POST['name'],
		$_POST['duree_validite'],
		isset($_POST['need_signature']),
		isset($_POST['need_read']),
		isset($_POST['need_validate_dh']),
		isset($_POST['need_validate_backoffice']),
		isset($_POST['need_access_frontoffice']),
		GetPrefixedItemsFromArray($_POST, "link")
	);
}

if (isset($_POST['action']) && $_POST['action'] === "addTypeDocument")
{
	TypeDocument::insert(
		$_POST['name'],
		$_POST['duree_validite'],
		isset($_POST['need_signature']),
		isset($_POST['need_read']),
		isset($_POST['need_validate_dh']),
		isset($_POST['need_validate_backoffice']),
		isset($_POST['need_access_frontoffice']),
		GetPrefixedItemsFromArray($_POST, "link")
	);
}
$this->allTypeDocuments = TypeDocument::getAll();
$this->allTypeDocumentsEntity = TypeDocumentEntity::getAll();
$this->allEntity = Entity::getAll();

