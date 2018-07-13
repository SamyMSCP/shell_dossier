<?php
$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModuleAdmin("TypeDocumentAdmin", "TypeDocumentAdmin", array());

?>
