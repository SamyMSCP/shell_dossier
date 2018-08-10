<?php

$yoda = ($this->collaborateur->type == "yoda");
$access = $GLOBALS["acces" . UcFirst($this->collaborateur->getType())];
$list = ["MailResearch",
	"Clients",
	"SeeTransaction",
	"Ordres",
	"OpportunityViewer",
	"VisuDj",
	"GestionScpi",
	"GererValeurRealisation",
	"TypeDocumentPage",
	"AbsorptionPage",
	"GestTemplate",
	"GestionSuggestion",
	"GestionOpportunite",
	"OrderGest",
	"OpportunityGest",
	"EditTransaction",
	"EditionObjectifsList",
	"PageMailSender",
	"SeeLogs",
	"VoirAvisClients",
	"CsvImport",
	"ScpiImport",
	"ExportTransaction",
	"StatDividendes2",
	"TransactViewer",
    "SimulateurUsufruit",
    "TableauTransaction",
    "StatInscription"
];
$right = [];
foreach ($list as $key) {
	$right[$key] = (in_array($key, $GLOBALS['accesCollaborateurs']) || in_array($key, $access));
}
// dbg($right);
?>

<li style="cursor: pointer;"><a href="?p=Accueil">Accueil</a></li>
<li class="divider"></li>
<?php if ($right['MailResearch']) { ?><li><a href="?p=MailResearch">Rechercher par mail/t&eacute;l&eacute;phone</a></li><?php } ?>
<?php if ($right['Clients']) { ?><li><a href="?p=Clients">Voir tous les clients</a></li><?php } ?>
<?php if ($right['ShowClientMscpi']) { ?><li><a href="?p=ShowClientMscpi">Voir les clients MSCPI</a></li><?php } ?>
<?php if ($right['SeeTransaction']) { ?><li><a href="?p=SeeTransaction">Voir toutes les transactions</a></li><?php } ?>
<?php if ($right['Ordres']) { ?><li><a href="?p=Ordres">Voir les carnets d'ordres</a></li><?php } ?>
<?php if ($right['OpportunityViewer']) { ?><li><a href="?p=OpportunityViewer">Voir les opportunites</a></li><?php } ?>
<?php if ($right['VisuDj']) { ?><li><a href="?p=VisuDj">Voir les délais de jouissance</a></li><?php } ?>
<?php if ($right['TransactViewer']) { ?><li><a href="?p=TransactViewer">Voir les Transactions en détails</a></li><?php } ?>
<?php if ($right['TableauTransaction']) { ?><li><a href="?p=TableauTransaction">Voir les Transactions en détails Andréa</a></li><?php } ?>
<?php if ($right['StatInscription']) { ?><li><a href="?p=StatInscription">Voir les statistiques d'inscriptions</a></li><?php } ?>
<li class="divider"></li>
<?php if ($right['GestionScpi']) { ?><li><a href="?p=GestionScpi">Gérer les SCPI</a></li><?php } ?>
<?php if ($right['GererValeurRealisation']) { ?><li><a href="?p=GererValeurRealisation">Gérer les valeurs de réalisation</a></li><?php } ?>
<?php if ($right['TypeDocumentPage']) { ?><li><a href="?p=TypeDocumentPage">Gestion des types de documents MSCPI</a></li><?php } ?>
<?php if ($right['AbsorptionPage']) { ?><li><a href="?p=AbsorptionPage">Gérer les Absorptions</a></li><?php } ?>
<?php if ($right['GestTemplate']) { ?><li><a href="?p=GestTemplate">Gérer les Templates</a></li><?php } ?>
<?php if ($right['GestionSuggestion']) { ?><li><a href="?p=GestionSuggestion">Gérer les Suggestions</a></li><?php } ?>
<?php if ($right['GestionOpportunite']) { ?><li><a href="?p=GestionOpportunite">Gérer les Opportunités</a></li><?php } ?>
<?php if ($right['OrderGest']) { ?><li><a href="?p=OrderGest">Gérer les Carnets d'Ordres</a></li><?php } ?>
<?php if ($right['OpportunityGest']) { ?><li><a href="?p=OpportunityGest">Gestionnaire d'opportunités</a></li><?php } ?>
<li class="divider"></li>
<?php if ($right['EditTransaction']) { ?><li><a href="?p=EditTransaction">Éditer les transactions</a></li><?php } ?>
<?php if ($right['EditionObjectifsList']) { ?><li><a href="?p=EditionObjectifsList">Éditer la liste des objectifs</a></li><?php } ?>
<?php if ($yoda) { ?><li><a href="?p=EditFourchette">Éditer les fourchettes de rémunération</a></li><?php } ?>
<li class="divider"></li>
<?php if ($right['PageMailSender']) { ?><li><a href="?p=PageMailSender">Envoyer des e-mails</a></li><?php } ?>
<?php if ($right['SeeLogs']) { ?><li><a href="?p=SeeLogs">Voir les log clients</a></li><?php } ?>
<?php if ($right['VoirAvisClients']) { ?><li><a href="?p=VoirAvisClients">Voir les avis clients</a></li><?php } ?>
<?php if ($right['CsvImport']) { ?><li><a href="?p=CsvImport">Importer un CSV de clients</a></li><?php } ?>
<?php if ($right['ScpiImport']) { ?><li><a href="?p=ScpiImport">Importer un CSV de transactions</a></li><?php } ?>
<?php if ($right['ExportTransaction']) { ?><li><a href="?p=ExportTransaction&config=all">Exporter toutes les transactions</a></li><?php } ?>
<?php if ($right['SimulateurUsufruit']) { ?><li><a href="?p=SimulateurUsufruit">Simulateur Usufruit</a></li><?php } ?>
<li class="divider"></li>
<?php if (isset($GLOBALS['GET']['client']) && $right['StatDividendes2']) {?>
	<li><a href="?p=StatDividendes2&client=<?= $GLOBALS['GET']['client'] ?>">Voir les stats dividendes V2</a></li>
	<li class="divider"></li>
<?php } ?>
<li><a <?php echo 'href="admin_lkje5sjwjpzkhdl42mscpi.php?logout=' . ft_decrypt_crypt_information($_COOKIE['token']) . '"'; ?>>Déconnexion</a></li>
