<?php
if (!empty($_POST['action_isf']))
{
	$isf = (!empty($_POST['isf']) && $_POST['isf'] == "on") ? 1 : 0 ;
	$this->dh->updateOneColumn("isf", $isf);
	Logger::setNew("Changement assujettissement ISF", Dh::getCurrent()->id_dh, $this->dh->id_dh,["valeur" => ($isf)? "oui" : "non"]);

	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

if (!empty($_POST['action']) && $_POST['action'] == 'sendId')
{
	$ct = (is_null($this->dh->password))? CommunicationTemplate::getByName('tmp_login_details') : CommunicationTemplate::getByName('reinit_passwd');
	$mdp = $this->dh->setTmpPassword();
	// Débloque le compte au passage
	$this->dh->updateOneColumn('fraude', '-1');
	$recip = [];
	try {
		if ($this->dh->getConseiller() == null)
			throw new Exception("Empty");
	$recip[$this->dh->getLogin()] = ['login' => $this->dh->getLogin(),
				'short_name' => $this->dh->getShortName(),
				'conseiller' => $this->dh->getConseiller()->getShortName(),
				//'conseiller_telephone' => $this->dh->getConseiller()->getTelephone(),
				//'conseiller_mail' => $this->dh->getConseiller()->getLogin(),
				'tmp_passwd' => $mdp];
	}
	catch (Exception $e) {
		$recip[$this->dh->getLogin()] = ['login' => $this->dh->getLogin(),
				'short_name' => $this->dh->getShortName(),
				'conseiller' => 'admin',
				//'conseiller_telephone' => $this->dh->getConseiller()->getTelephone(),
				//'conseiller_mail' => $this->dh->getConseiller()->getLogin(),
				'tmp_passwd' => $mdp];
	}

	MailSender::sendBatch("Votre accès à Mon Compte SCPI", $ct->getContent(), '', $recip);
	Logger::setNew("Mot de passe change", $this->collaborateur->id_dh, $this->dh->id_dh, ['Mot de passe provisoire' => $mdp]);

	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

$this->loadModuleAdmin("SetParrainComponent", "SetParrainComponent", []);
$this->loadModuleAdmin("SetAdresseValideComponent", "SetAdresseValideComponent", []);

if ($this->collaborateur->getType() != "prospecteur")
{
	$this->loadModule("CentreInteretStore", "CentreInteretStore", ["dh" => $this->dh]);
	$this->loadModule('CentreInteretComponent', 'CentreInteretComponent', ['dh' => $this->dh, 'template' => '#centreinteretscomponent']);
}
