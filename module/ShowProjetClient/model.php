<?php
$this->loadModule("ProjetComponent", "ProjetComponent");
$this->loadModule("ProjetFrontStore", "ProjetFrontStore", ["dh" => $this->dh]);

$this->loadModule("PpFrontStore", "PpFrontStore", ["dh" => $this->dh]);
$this->loadModule("SeeProfilComponent", "SeeProfilComponent", ["dh" => $this->dh]);

