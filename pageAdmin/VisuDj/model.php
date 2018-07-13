<?php

$this->dh = Dh::getCurrent();
$this->loadModule("MessageBox", "MessageBox", array());
$this->loadModuleAdmin('ModuleGestionDelaiJouissance','ModuleGestionDelaiJouissance', []);
$this->loadModuleAdmin("Nav", "Nav", ["collaborateur" => $this->dh]);

$this->scpi = Scpi::getAll();
