<?php
$this->allAvis = Avis::getAll();

function sortAvis($a, $b)
{
	if (empty($a->getDateAjout()))
	{
		return (-1);
	}
	if (empty($b->getDateAjout()))
	{
		return (1);
	}
	return ($a->getDateAjout()->getTimestamp() < $b->getDateAjout()->getTimestamp());
}

usort($this->allAvis, "sortAvis");


if (isset($_POST['action']) && $_POST['action'] == "Enregistrer")
{
	$this->updateAvis();
}

// On recupere les instances des dh 
foreach ($this->allAvis as $key => $elm)
{
	$this->allAvis[$key]->dh = Dh::getById($elm->id_dh);
	$this->allAvis[$key]->pp = $this->allAvis[$key]->dh->getPersonnePhysique();
}
