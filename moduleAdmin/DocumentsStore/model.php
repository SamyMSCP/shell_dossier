<?php
$this->typeDocuments = TypeDocument::getAll();
$this->entity = Entity::getAll();
$this->dhDocuments = $this->dh->getDocumentsForStore();
