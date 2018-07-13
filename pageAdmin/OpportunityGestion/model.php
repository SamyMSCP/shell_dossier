<?php
$this->is_back = true;
$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModuleAdmin('OpportuniteAdminStore','OpportuniteAdminStore', array());
$this->loadModuleAdmin('ScpiStore','ScpiStore', array());
$this->loadModuleAdmin("OpportunityEdit", "OpportunityEdit", array());
$this->loadModuleAdmin("OpportunityStats", "OpportunityStats", array());
$this->loadModule("OpportunityCreator", "OpportunityCreator", array());

