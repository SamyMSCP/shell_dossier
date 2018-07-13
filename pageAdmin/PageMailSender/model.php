<?php
$this->collaborateur = Dh::getCurrent();

if (isset($_POST['action']) && $_POST['action'] == "sendMail")
	$this->sendMail();

$this->lstci = (!empty($GLOBALS['GET']['lstci'])) ? json_encode($GLOBALS['GET']['lstci']) : null ;
$this->lstscpi = (!empty($GLOBALS['GET']['lstscpi'])) ? json_encode($GLOBALS['GET']['lstscpi']) : null ;

$this->title = "";
$this->message = "";

if (!empty($GLOBALS['GET']['get_actu']))
{
	$req = Database::getNoClass('mscpi_db',"SELECT `actu` FROM `cache_actualite` WHERE `id` = ?", [$GLOBALS['GET']['get_actu']]);
	if ($req)
	{
		$this->actu = unserialize($req[0]['actu']);
		$lnk = '<a href="https://www.meilleurescpi.com/actualites/'.$this->actu->token.'-'.$this->actu->slug.'">'.$this->actu->title.'</a>';
		$ct = CommunicationTemplate::getById(17);
		$this->title = "Une nouvelle actualité vient d'être publiée !";;
		$this->message = $ct->render($this->collaborateur , $lnk);
	}
}


$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModuleAdmin('ScpiStore','ScpiStore', ['dh' => $this->collaborateur]);

$this->loadModule("ckEditor", "ckEditor");
$this->loadModule("ToolTip", "ToolTip");

$this->listTemplates = CommunicationTemplate::getAll();

$this->loadModule('CentreInteretStore', 'CentreInteretStore', []);
