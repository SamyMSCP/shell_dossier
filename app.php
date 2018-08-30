<?php
@session_start();
date_default_timezone_set ("Europe/Paris");

/**
 * Base programme
 */
require_once(__DIR__ . "/../function/config.php");
require_once(__DIR__ . "/../function/tool.php");
require_once(__DIR__ . "/../function/crypto.php");
require_once(__DIR__ . "/../function/spreadsheet.php");

// Importation et instanciation de l'autoprefixer
require_once(__DIR__ . "/lib/autoprefixer-php/lib/Autoprefixer.php");
require_once(__DIR__ . "/lib/autoprefixer-php/lib/AutoprefixerException.php");
$GLOBALS['autoprefixer'] = new Autoprefixer(['last 2 versions']);

if (!isProd() /*|| isBackOffice()*/)
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL & ~ E_DEPRECATED);
	//error_reporting(E_ALL);
}
else
	error_reporting(0);

if (defined("DOMAIN_NAME") === false)
	define("DOMAIN_NAME", "http://www.meilleurescpi.com/");

require_once(__DIR__ . "/class/core/Database.php");
Database::new_connexion();

/**
 * Classes de bases du programme
 */
require_once(__DIR__ . "/class/core/DevLogs.php");
require_once(__DIR__ . "/class/UpdateBdd.php");
require_once(__DIR__ . "/class/AutoTask.php");
require_once(__DIR__ . "/class/core/Table.php");
//require_once(__DIR__ . "/class/core/Api.php");
require_once(__DIR__ . "/class/core/Apiv2.php");
require_once(__DIR__ . "/class/core/Module.php");
require_once(__DIR__ . "/class/core/Page.php");
require_once(__DIR__ . "/class/core/PageAdmin.php");
require_once(__DIR__ . "/class/core/DocumentTrait.php");

//require_once(__DIR__ . "/class/core/Controller.php");

// Code importé pour l'archi v2
require_once(__DIR__ . "/class/core/Access.php");

require_once(__DIR__ . "/class/core/Type.php");
require_once(__DIR__ . "/class/core/TypeMulti.php");
require_once(__DIR__ . "/class/core/TypeRelation.php");
require_once(__DIR__ . "/class/core/ComponentManager.php");
require_once(__DIR__ . "/class/core/ComponentGenerator.php");

require_once(__DIR__ . "/class/core/Procedure.php");

/*
	Le chargement La version manuelle

	require_once(__DIR__ . "/class/Types/TypeInt.php");
	require_once(__DIR__ . "/class/Types/TypeUint.php");
	require_once(__DIR__ . "/class/Types/TypeFloat.php");
	require_once(__DIR__ . "/class/Types/TypeMail.php");
	require_once(__DIR__ . "/class/Types/TypeString.php");
	require_once(__DIR__ . "/class/Types/TypeEncryptedString.php");
	require_once(__DIR__ . "/class/Types/TypeEncryptedMail.php");
	require_once(__DIR__ . "/class/Types/TypeEncryptedName.php");
	require_once(__DIR__ . "/class/Types/TypePhone.php");
	require_once(__DIR__ . "/class/Types/TypeEncryptedPhone.php");
*/
/*
	Chargement de tout les Types contenus dans le répertoire des types
*/
$files = scandir(__DIR__ . "/class/Types/");
foreach ($files as $elm)
{
	if ($elm[0] == ".")
		continue ;
	require_once(__DIR__ . "/class/Types/$elm");
}

require_once(__DIR__ . "/class/core/Table2.php");
require_once(__DIR__ . "/class/core/StoreGenerator.php");
require_once(__DIR__ . "/class/core/StoreModule.php");

require_once(__DIR__ . "/class/Table2/ObjectifsList2.php");
require_once(__DIR__ . "/class/Table2/CategorieProfessionelle.php");
require_once(__DIR__ . "/class/Table2/CodeNaf.php");
require_once(__DIR__ . "/class/Table2/Pays2.php");
require_once(__DIR__ . "/class/Table2/StatusPro2.php");
require_once(__DIR__ . "/class/Table2/DonneurDOrdre.php");
require_once(__DIR__ . "/class/Table2/PersonnePhysique.php");
require_once(__DIR__ . "/class/Table2/PersonneMorale.php");
require_once(__DIR__ . "/class/Table2/SituationPhysique.php");
require_once(__DIR__ . "/class/Table2/Beneficiaire2.php");
require_once(__DIR__ . "/class/Table2/Transaction2.php");
require_once(__DIR__ . "/class/Table2/Projet2.php");
require_once(__DIR__ . "/class/Table2/ProfilInvestisseur2.php");

require_once(__DIR__ . "/class/Procedure/ProcedureCreationProjet.php");

require_once(__DIR__ . "/class/core/GraphApi.php");


require_once(__DIR__ . "/class/Signature.php");
require_once(__DIR__ . "/class/PdfGenerator.php");
require_once(__DIR__ . "/class/TypeLogger.php");
require_once(__DIR__ . "/class/Logger.php");
require_once(__DIR__ . "/class/LoggerSubscription.php");
require_once(__DIR__ . "/class/TypeSubscription.php");


/**
 * Classes de gestion de communications
 */
require_once(__DIR__ . "/class/MailSender.php");
require_once(__DIR__ . "/class/SmsSender.php");
require_once(__DIR__ . "/class/Notifications.php");
require_once(__DIR__ . "/class/CommunicationTemplate.php");
require_once(__DIR__ . "/class/Crm2.php");
require_once(__DIR__ . "/class/CentreInteret.php");
require_once(__DIR__ . "/class/DhCentreInteret.php");
require_once(__DIR__ . "/class/DhCentreInteretSCPI.php");
//require_once(__DIR__ . "/class/CentreInteretCategorie.php");

/**
 * Reflet des tables sql
 */
require_once(__DIR__ . "/class/Valeur_impot.php");
require_once(__DIR__ . "/class/Valeur_impot_fortune.php");
require_once(__DIR__ . "/class/StatClients.php");
require_once(__DIR__ . "/class/Pays.php");
require_once(__DIR__ . "/class/Dh.php");
require_once(__DIR__ . "/class/Transaction.php");
require_once(__DIR__ . "/class/Pp.php");
require_once(__DIR__ . "/class/Pm.php");
require_once(__DIR__ . "/class/Opportunite.php");
require_once(__DIR__ . "/class/Suggestions.php");
require_once(__DIR__ . "/class/Beneficiaire.php");
require_once(__DIR__ . "/class/Document.php");
require_once(__DIR__ . "/class/DocumentDhValidation.php");
require_once(__DIR__ . "/class/TypeDocumentEntity.php");
require_once(__DIR__ . "/class/TypeDocument.php");
require_once(__DIR__ . "/class/Entity.php");
require_once(__DIR__ . "/class/Projet.php");
require_once(__DIR__ . "/class/absorption.php");
require_once(__DIR__ . "/class/Mscpi.php");
require_once(__DIR__ . "/class/Favoris.php");
require_once(__DIR__ . "/class/Situation.php");
require_once(__DIR__ . "/class/SituationJuridique.php");
require_once(__DIR__ . "/class/SituationFinanciere.php");
require_once(__DIR__ . "/class/SituationFiscale.php");
require_once(__DIR__ . "/class/SituationPatrimoniale.php");
require_once(__DIR__ . "/class/SituationJuridiqueMorale.php");
require_once(__DIR__ . "/class/SituationFinanciereMorale.php");
require_once(__DIR__ . "/class/SituationFiscaleMorale.php");
require_once(__DIR__ . "/class/SituationPatrimonialeMorale.php");
require_once(__DIR__ . "/class/Avis.php");
require_once(__DIR__ . "/class/core/DocumentTrait.php");
require_once(__DIR__ . "/class/Logs.php");
require_once(__DIR__ . "/class/ProfilInvestisseur.php");
require_once(__DIR__ . "/class/StatusTransaction.php");
require_once(__DIR__ . "/class/DocumentBibliotheque.php");
require_once(__DIR__ . "/class/Badges.php");
require_once(__DIR__ . "/class/DocumentBibliothequeConsulte.php");
require_once(__DIR__ . "/class/HistoriqueStats.php");
require_once(__DIR__ . "/class/CodeVille.php");
require_once(__DIR__ . "/class/FourchetteRemuneration.php");
require_once(__DIR__ . "/class/ScpiList.php");

require_once(__DIR__ . "/class/ConnuMscpi.php");
require_once(__DIR__ . "/class/CatPro.php");
require_once(__DIR__ . "/class/StatusPro.php");


require_once(__DIR__ . "/../function/insert.php");
/**
 * Reflet du serveur distant a traver l'Api
 */
require_once(__DIR__ . "/class/CategoriesScpi.php");
require_once(__DIR__ . "/class/Scpi.php");
require_once(__DIR__ . "/class/SocieteDeGestion.php");
require_once(__DIR__ . "/class/ScpiGestion.php");
require_once(__DIR__ . "/class/Actuality.php");
require_once(__DIR__ . "/class/Publication.php");
require_once(__DIR__ . "/class/Acquisition.php");


require_once(__DIR__ . "/class/Rec/Rec.php");
require_once(__DIR__ . "/class/ValeurRealisation.php");
require_once(__DIR__ . "/class/DelaiJouissance.php");
require_once(__DIR__ . "/class/Crm.php");
require_once(__DIR__ . "/class/Usefruit.php");
require_once(__DIR__ . "/class/Nuepropriete.php");
require_once(__DIR__ . "/class/ParseCsv.php");
require_once(__DIR__ . "/class/ParseCsvTransaction.php");
require_once(__DIR__ . "/class/ObjectifsList.php");
require_once(__DIR__ . "/class/Opportunity.php");
require_once(__DIR__ . "/class/OpportunityInteract.php");
//require_once(__DIR__ . "/class/ScpiTimeDataList.php");
//require_once(__DIR__ . "/class/ScpiTimeData.php");

require_once(__DIR__ . "/class/LstTransaction.php");
require_once(__DIR__ . "/class/Notif.php");

require_once(__DIR__ . "/../access.php");

require_once(__DIR__ . "/class/Order.php");
require_once(__DIR__ . "/class/OrderScrapList.php");
require_once(__DIR__ . "/class/OrderSociety.php");
require_once(__DIR__ . "/class/OrderHistoric.php");


require_once(__DIR__ . "/class/EventListener.php");
require_once(__DIR__ . "/class/Cli.php");

EventListener::init();




//require_once("../moncompte/view/whoiam.php");

function notification($msg){
?>
	<div class="modal fade modal_push_info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div data-dismiss="modal" aria-label="Close" class="btn_close_prepapre">
						<span aria-hidden="true" class="btn_close">×</span>
					</div>
					<h2 style="text-align: center;">Information</h2>
					<div>
						<hr class="hr_bar">
					</div>
					<p style="font-size: 25px; text-align: center; color: grey;"><?php echo $msg;?></p>
				</div>
			</div>
		</div>
	</div>
<?php
}

function redirectMonCompte() {
	if (!($dh = Dh::getCurrent()) || (count($dh->getTransaction()) === 0)) {
		header("Location: index.php?p=Portefeuille");
		exit();
	}
}

function checkUser() {

/*
	if (!empty(Dh::getCurrent()) && Dh::getCurrent()->getType() == "origine_contact")
	{
		del_cookie(array('login', 'token'));
		del_all_cookie();
		header('Location: index.php');
}
	*/
	if (!check_token()){
		foreach ($_SESSION as $key => $el)
			unset($_SESSION[$key]);
		del_cookie(array('login', 'token'));
		del_all_cookie();
		header('Location: index.php');
		exit();
	}
	if (!empty($_COOKIE['token']) && check_fraude($_COOKIE['token'])){
		foreach ($_SESSION as $key => $el)
			unset($_SESSION[$key]);
		del_cookie(array('login', 'token'));
		del_all_cookie();
		header('Location: ?security=' . ft_crypt_information($_COOKIE['token']));
		exit();
	}
}

function checkAdminUser() {
//	if (check_adm_token() || (!empty($_post['login']) && !empty($_post['pass']) && !empty(login_adm($_post['login'], $_post['pass']))))
		return (true);
//	return (false);
}

function cleanTokenCsrf() {
	if (empty($_SESSION['csrf']) || !is_array($_SESSION['csrf']) || empty($_SESSION['csrf_time']) || !is_array($_SESSION['csrf_time']))
		return (0);
	$csrf = $_SESSION['csrf'];
	$csrf_time = $_SESSION['csrf_time'];
	for ($i = count($csrf) - 1; $i >= 0; $i--)
	{
		if ($csrf_time[$i] < time() || ($i > NBR_CSRF_TOKEN && NBR_CSRF_TOKEN != -1))
		{
			unset($csrf_time[$i]);
			unset($csrf[$i]);
		}
		else
			break ;
	}
	$_SESSION['csrf'] = $csrf;
	$_SESSION['csrf_time'] = $csrf_time;
}

function generateTokenCsrf() {
	if (empty($_SESSION['csrf']) || !is_array($_SESSION['csrf']))
		$csrf = array();
	else
		$csrf = $_SESSION['csrf'];

	if (empty($_SESSION['csrf_time']) || !is_array($_SESSION['csrf_time']))
		$csrf_time = array();
	else
		$csrf_time = $_SESSION['csrf_time'];
	array_unshift($csrf, generateRandomString());
	array_unshift($csrf_time, time() + TIME_CSRF_TOKEN);
	$_SESSION['csrf'] = $csrf;
	$_SESSION['csrf_time'] = $csrf_time;
}

function check_csrf()
{
	if (
		strpos($_SERVER['HTTP_REFERER'], "http://mscpi.lan/") === false &&
		strpos($_SERVER['HTTP_REFERER'], "http://localhost/") === false &&
		strpos($_SERVER['HTTP_REFERER'], "http://preprod.hvo.ovh/") === false &&
		strpos($_SERVER['HTTP_REFERER'], "https://moncompte.meilleurescpi.com/") === false
	)
		return (-1);
	if (!empty($_SESSION['csrf']) && empty($_POST['token']))
		return (-1);
	foreach ($_SESSION["csrf"] as $k => $v)
	{
		if ($v == $_POST['token'])
		{
			if (!empty($_SESSION['csrf_time'][$k]) && $_SESSION['csrf_time'][$k] > time())
				return (0);
		}
	}
	return (-1);
}

function save_generateTokenCsrf() {
	// On genere un nouveau token csrf uniquement si la page demandee n'est pas de la recuperation de documents.
	{
		// si il n'y a pas de csrf en session ou si ce n'est pas un tableau, alors on prepare un tableau,
		// sinon on le recupere.
		if (empty($_SESSION['csrf']) || !is_array($_SESSION['csrf']))
			$rt = array();
		else
			$rt = $_SESSION['csrf'];

		// on insere un nouveau token au debut du tableau
		array_unshift($rt, generateRandomString());

		// Si i y en a plus que 10 alors on supprime les plus anciens
		if (isset($rt[NBR_CSRF_TOKEN]))
			unset($rt[NBR_CSRF_TOKEN]);

		// On stock en session nos tokens
		$_SESSION['csrf'] = $rt;

		// si on a bien des token csrf, alors on verifie si on a un csrf_time, si oui on le recupere
		if (!empty($_SESSION['csrf']) || is_array($_SESSION['csrf_time']))
			$rt = array();
		else
			$rt = $_SESSION['csrf_time'];

		// on set le csrf time a un time stamp d'une validite de 12 heures.
		array_unshift($rt, time() + TIME_CSRF_TOKEN);
		unset($rt[NBR_CSRF_TOKEN]);

		// on recupere les csrf_time en session.
		$_SESSION['csrf_time'] = $rt;
	}
}

function setOrigine() {
	if (
		isset($_SERVER['HTTP_REFERER']) && !isset($_SESSION['origine']) &&
		strpos($_SERVER['HTTP_REFERER'], "http://mscpi.lan/") === false &&
		strpos($_SERVER['HTTP_REFERER'], "http://localhost/") === false &&
		strpos($_SERVER['HTTP_REFERER'], "http://preprod.hvo.ovh/") === false &&
		strpos($_SERVER['HTTP_REFERER'], "https://moncompte.meilleurescpi.com/") === false
	)
		$_SESSION['origine'] = $_SERVER['HTTP_REFERER'];

	if (isset($_GET['utm']))
		$_SESSION['utm'] = $_GET['utm'];
}

function success($rt) {
	if (is_array($rt))
	{
		$a = json_decode(json_encode($rt), 1);
		$a['token'] = $_SESSION['csrf'][0];
		echo json_encode($a);
		exit();
	}
	echo json_encode($rt);
	exit();
}
function error($str = null) {
	http_response_code(403);
	if (!empty($str))
		echo json_encode(['err' => $str, 'token' => $_SESSION['csrf'][0]]);
	exit();
}

