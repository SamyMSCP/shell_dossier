<?php
/*
$this->lstPersonnePhysique = [];
foreach ($this->dh->getAllPersonnePhysique() as $key => $elm)
{
	$this->lstPersonnePhysique[] = $elm->getForStore();
}
*/

$this->lstPersonnePhysique = $this->dh->getPersonnePhysiqueForStore();
