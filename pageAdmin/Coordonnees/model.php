<?php
	$this->dh = Dh::getById($GLOBALS['GET']["client"]);
	$this->loadModuleAdmin("Nav", "Nav", array("id" => $this->dh->id_dh));
	$this->loadModuleAdmin("CoordonneesDh", "CoordonneesDh", array("dh" => $this->dh));
	$this->loadModuleAdmin("MiniUserInfo", "MiniUserInfo", array("dh" => $this->dh));
