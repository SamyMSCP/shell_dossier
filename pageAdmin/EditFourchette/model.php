<?php
$this->dh = Dh::getCurrent();
$this->loadModule("MessageBox", "MessageBox", array());
$this->loadModuleAdmin("Nav", "Nav", ["collaborateur" => $this->dh]);
$this->loadModuleAdmin("ModuleFourchetteRemuneration", "ModuleFourchetteRemuneration", ["collaborateur" => $this->dh]);
$this->loadModuleAdmin("ScpiStore", "ScpiStore",  ['dh' => $this->dh]);
$this->loadModuleAdmin("SocieteGestionStore", "SocieteGestionStore",  ['dh' => $this->dh]);

