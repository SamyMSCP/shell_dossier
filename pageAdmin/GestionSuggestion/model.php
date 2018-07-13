<?php
$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModuleAdmin("TypeSuggestion", "TypeSuggestion", array());

?>
