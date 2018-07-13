<?php
	$this->dh = Dh::getById($GLOBALS['GET']["client"]);
	$this->loadModuleAdmin("Nav", "Nav", array("id" => $this->dh->id_dh));
