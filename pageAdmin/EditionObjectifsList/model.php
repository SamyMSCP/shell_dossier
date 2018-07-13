<?php

$this->objs = ObjectifsList::getAll();


$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModule("MessageBox", "MessageBox", array());
$this->loadModule("ckEditor", "ckEditor");
