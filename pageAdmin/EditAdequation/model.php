<?php
$this->dh = Dh::getCurrent();
$this->loadModule("MessageBox", "MessageBox", array());
$this->loadModuleAdmin("Nav", "Nav", ["collaborateur" => $this->dh]);
$this->loadModuleAdmin("ModuleEditAdequation", "ModuleEditAdequation", ["collaborateur" => $this->dh]);
$this->loadModuleAdmin("ScpiStore", "ScpiStore",  ['dh' => $this->dh]);
