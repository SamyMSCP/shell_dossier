<?php
$this->collaborateur = Dh::getCurrent();

$this->loadModuleAdmin('ScpiStore','ScpiStore');

$this->loadModuleAdmin('Nav', 'Nav', ['collaborateur' => $this->collaborateur]);
$this->loadModuleAdmin('ModuleSeeTransaction2','ModuleSeeTransaction2');