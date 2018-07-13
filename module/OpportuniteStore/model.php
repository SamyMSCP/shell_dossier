<?php
//if (isset($this->isAdmin) && $this->isAdmin == true)
	//$this->lstOpportunite = Opportunity::getAllForStore();
//else
$this->lstOpportunite = Opportunity::getAllForFrontStore();
$this->all = Scpi::getAll();
