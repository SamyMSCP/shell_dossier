<h1>PROFIL INVESTISSEUR DE <?=mb_strtoupper($this->Pp->getShortName())?></h1>
<div class="orangeBar"></div>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<?php
if (!$this->isAdd)
	include("formProfil.php");
else if (isset($GLOBALS['GET']['Pp']))
{
	$Pp= Pp::getFromId(intval($GLOBALS['GET']['Pp']))[0];
	Notif::set("ResetProfil", "Le profil de " . $Pp->getShortName() . " à bien été enregistré.");
	header("Location: ?p=ListeProjets");
}
else
	include("seeProfil.php");
