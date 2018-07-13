<?php
//@session_start();
function isBackOffice() { return (true); }; 
function isFrontOffice() { return (false); };
require_once("app.php");

//var_dump($_SESSION);
//echo $_SESSION['code_sms'];
cleanTokenCsrf();
if (!empty($_POST) && check_csrf())
{
	Notif::set("Temps expirer", "Le jeton de sécurité n'est pas ou plus valide !");
	if (empty($_GET['p']))
	{
		header("Location: admin_lkje5sjwjpzkhdl42mscpi.php");
		exit();
	}
	header("Location: admin_lkje5sjwjpzkhdl42mscpi.php?p=Accueil");
	exit();
}

if (isset($_GET["p"]))
	$p = $_GET["p"];
else
	$p = "Acceuil";

if (
	$p != "TelechargerRecapGuidePdf" &&
	$p != "DownloadDocument" &&
	$p != 'ShowValeurIsf' &&
	$p != 'ShowValeurIfi' &&
	$p != 'ShowPatrimoine'
)
	generateTokenCsrf();
/*
if (!(isset($_GET['p']) && $_GET['p'] == "DownloadDocument"))
{
	if (empty($_SESSION['csrf']) || !is_array($_SESSION['csrf']))
		$rt = array();
	else
		$rt = $_SESSION['csrf'];
	array_unshift($rt, generateRandomString());
	if (!empty($rt[11]))
	unset($rt[11]);
	$_SESSION['csrf'] = $rt;

	if (!empty($_SESSION['csrf']) || is_array($_SESSION['csrf_time']))
		$rt = array();
	else
		$rt = $_SESSION['csrf_time'];
	array_unshift($rt, time() + (15 * 60 * 60));
	unset($rt[11]);
	$_SESSION['csrf_time'] = $rt;
}
*/

/*if (!(isset($_GET['p'] ) && $_GET['p'] == "DownloadDocument"))
{
	$_SESSION['csrf'] = generateRandomString();
	$_SESSION['csrf_time'] = time() + (15 * 60);
}*/


if (empty($_GET) && empty($_POST) && !empty($_COOKIE['token']) && !check_adm_token(ft_decrypt_crypt_information($_COOKIE['token']))){
	del_all_cookie();
}
if (!empty($_GET['logout']) && !empty(ft_parse_cookie($_GET['logout'])) && check_adm_token($_GET['logout'])){
	del_cookie(array('login', 'token'));
	destroy_token($_GET['logout']);
	$p = "Connexion";
}
else if ((empty($_GET) && check_adm_token()) || (!empty($_POST['login']) && !empty($_POST['pass']) && !empty(login_adm($_POST['login'], $_POST['pass'])))){
	$p = "Accueil";
	if (isset($_POST['login']) && isset($_POST['pass'])){
		header("Location: admin_lkje5sjwjpzkhdl42mscpi.php?p=Accueil");
		exit();
	}
}
else if (!check_adm_token())
	$p = "Connexion";

function strstrinarray($array, $str){
	foreach ($array as $val)
	{
		if (strstr(strtolower($val), strtolower($str)))
			return (1);
	}
	return (NULL);
}
/*
if ($p == "ajax")
{
	if (empty($_COOKIE['token']) || !check_adm_token(ft_decrypt_crypt_information($_COOKIE['token']))){
		del_all_cookie();
		header("Location: admin_lkje5sjwjpzkhdl42mscpi.php");
		exit();
	}
	if (Dh::getCurrent()->getType() === "conseiller")
		$client = Dh::getCurrent()->getMyClients();
	else
		$client = Dh::getClients();
	$tab = NULL;
	foreach($client as $val)
	{
		$ret = NULL;
		$ret["prenom"] = $val->getPersonnePhysique()->getFirstName();
		$ret["nom"] = $val->getPersonnePhysique()->getName();
		$ret["id"] = $val->id_dh;
		if (empty($_GET["pattern"]) || strstrinarray($ret, $_GET["pattern"]))
			$tab[] = $ret;
	}
	if (empty($tab)){
		$ret["nom"] = "No";
		$ret["prenom"] = "Result";
		$ret["id"] = "1";
		$tab[] = $ret;
	}
	echo json_encode($tab);
	exit();
}
*/

/*
if (Scpi::getFromId(260) === null)
{
	echo "Pas de serveur";
	exit();
}
*/

if (check_adm_token() && !isLocal() && anti_fraude_connexion_mvc())
{
	$p = "Index";
}
$curDh = Dh::getCurrent();
if (
	empty($curDh) ||
	(
		!empty($curDh) &&
		$curDh->getType() != "yoda" &&
		$curDh->getType() != "backoffice" &&
		$curDh->getType() != "conseiller" &&
		$curDh->getType() != "communication" &&
		$curDh->getType() != "developpeur" &&
		$curDh->getType() != "assistant" &&
		$curDh->getType() != "chefprojet" &&
		$curDh->getType() != "prospecteur"
	)
)
{
	$p = "Connexion";
}
else
{
	if (!in_array($p, $accesCollaborateurs) && !in_array($p, ${"acces" . UcFirst($curDh->getType())}))
		$p = "Accueil";
}
if ($p == "Index") {
	require_once("pageAdmin/Index/controller.php");
	$page = new Index();
}
else if ($p == "GestionSuggestion") {
	require_once("pageAdmin/GestionSuggestion/controller.php");
	$page = new GestionSuggestion();
}
else if ($p == "ScpiImport") {
	require_once("pageAdmin/ScpiImport/controller.php");
	$page = new ScpiImport();
}
else if ($p == "GestionOpportunite") {
	require_once("pageAdmin/GestionOpportunite/controller.php");
	$page = new GestionOpportunite();
}
else if ($p == "TypeDocumentPage") {
	require_once("pageAdmin/TypeDocumentPage/controller.php");
	$page = new TypeDocumentPage();
} else if ($p == "AbsorptionPage") {
	require_once("pageAdmin/AbsorptionPage/controller.php");
	$page = new AbsorptionPage();
} else if ($p == "Accueil") {
	require_once("pageAdmin/AccueilV3/controller.php");
	$page = new AccueilV3();
} else if ($p == "Clients") {
	require_once("pageAdmin/AccueilV2/controller.php");
	$page = new AccueilV2();
}/* else if ($p == "Synthese") {
	require_once("pageAdmin/Synthese/controller.php");
	$page = new Synthese();
} else if ($p == "Coordonnees"){
	require_once("pageAdmin/Coordonnees/controller.php");
	$page = new Coordonnees();
} else if ($p == "Documents"){
	require_once("pageAdmin/Documents/controller.php");
	$page = new Documents();
} else if ($p == "Suivi"){
	require_once("pageAdmin/Suivi/controller.php");
	$page = new Suivi();
} else if ($p == "PEC"){
	require_once("pageAdmin/PEC/controller.php");
	$page = new PEC();
} else if ($p == "QSLM"){
	require_once("pageAdmin/QSLM/controller.php");
	$page = new QSLM();
}*/
else if ($p == "DownloadDocument") {
	require_once("pageAdmin/DownloadDocument/controller.php");
	$page = new DownloadDocument();
}
else if ($p == "EditionClient") {
	require_once("pageAdmin/EditionClient/controller.php");
	$page = new EditionClient();
}
else if ($p == "CsvImport") {
	require_once("pageAdmin/CsvImport/controller.php");
	$page = new CsvImport();
}
else if ($p == "FrontAccueil") {
	require_once("pageAdmin/FrontAccueil/controller.php");
	$page = new FrontAccueil();
}
else if ($p == "FrontMonPorteFeuille") {
	require_once("pageAdmin/FrontMonPorteFeuille/controller.php");
	$page = new FrontMonPorteFeuille();
}
else if ($p == "FrontActusPublications") {
	require_once("pageAdmin/FrontActusPublications/controller.php");
	$page = new FrontActusPublications();
}
else if ($p == "StatDividendes2") {
	require_once("pageAdmin/StatDividendes2/controller.php");
	$page = new StatDividendes2();
}
else if ($p == "Ajax") {
	require_once("pageAdmin/Ajax/controller.php");
	$page = new Ajax();
}
else if ($p == "UploadDocumentPage") {
	require_once("pageAdmin/UploadDocumentPage/controller.php");
	$page = new UploadDocumentPage();
}
else if ($p == "VoirAvisClients") {
	require_once("pageAdmin/VoirAvisClients/controller.php");
	$page = new VoirAvisClients();
}
else if ($p == "SeeTransaction") {
	require_once("pageAdmin/SeeTransaction/controller.php");
	$page = new SeeTransaction();
}
else if ($p == "SeeTransaction2") {
	require_once("pageAdmin/SeeTransaction2/controller.php");
	$page = new SeeTransaction2();
}
else if ($p == "ExportTransaction") {
	require_once("pageAdmin/ExportTransaction/controller.php");
	$page = new ExportTransaction();
}
else if ($p == "EditTransaction") {
	require_once("pageAdmin/EditTransaction/controller.php");
	$page = new EditTransaction();
}

/*
else if ($p == "ShowClientMscpi") {
	require_once("pageAdmin/ShowClientMscpi/controller.php");
	$page = new ShowClientMscpi();
}
*/
else if ($p == "GestionScpi") {
	require_once("pageAdmin/GestionScpi/controller.php");
	$page = new GestionScpi();
}

else if ($p == "SeeLogs") {
	require_once("pageAdmin/SeeLogs/controller.php");
	$page = new SeeLogs();
}
else if ($p == "StatGeneral") {
	require_once("pageAdmin/StatGeneral/controller.php");
	$page = new StatGeneral();
}
else if ($p == "GestionTemplate") {
	require_once("pageAdmin/GestionTemplate/controller.php");
	$page = new GestionTemplate();
}
else if ($p == "PageMailSender") {
	require_once("pageAdmin/PageMailSender/controller.php");
	$page = new PageMailSender();
}
else if ($p == "AccueilV2") {
	require_once("pageAdmin/AccueilV2/controller.php");
	$page = new AccueilV2();
}
else if ($p == "NotifPage") {
	require_once("pageAdmin/NotifPage/controller.php");
	$page = new NotifPage();
}
else if ($p == "GererValeurRealisation") {
	require_once("pageAdmin/GererValeurRealisation/controller.php");
	$page = new GererValeurRealisation();
}
else if ($p == "ShowValeurIsf")
{
	require_once("pageAdmin/ShowValeurIsf/controller.php");
	$page = new ShowValeurIsf();
}
else if ($p == "ShowValeurIfi")
{
	require_once("pageAdmin/ShowValeurIfi/controller.php");
	$page = new ShowValeurIfi();
}
else if ($p == "NotificationsCrm")
{
	require_once("pageAdmin/NotificationsCrm/controller.php");
	$page = new NotificationsCrm();
}
else if ($p == "VisuDj")
{
	require_once("pageAdmin/VisuDj/controller.php");
	$page = new VisuDj();
}
else if ($p == "EditAdequation")
{
	require_once("pageAdmin/EditAdequation/controller.php");
	$page = new EditAdequation();
}
else if ($p == "EditFourchette")
{
	require_once("pageAdmin/EditFourchette/controller.php");
	$page = new EditFourchette();
}
else if ($p == "EditionObjectifsList")
{
	require_once("pageAdmin/EditionObjectifsList/controller.php");
	$page = new EditionObjectifsList();
}
else if ($p == "ShowPatrimoine")
{
	require_once "pageAdmin/ShowPatrimoine/controller.php";
	$page = new ShowPatrimoine();
}
else if ($p == "CreationProjetAdmin")
{
	require_once("pageAdmin/CreationProjetAdmin/controller.php");
	$page = new CreationProjetAdmin();
}
else if ($p == "InfoProjetAdmin")
{
	require_once("pageAdmin/InfoProjetAdmin/controller.php");
	$page = new InfoProjetAdmin();
}
else if ($p == "OpportunityGest")
{
	require_once "pageAdmin/OpportunityGestion/controller.php";
	$page = new OpportunityGestion();
}
else if ($p == "DividendesTrimestrielsPdf")
{
	require_once "pageAdmin/DividendesTrimestrielsPdf/controller.php";
	$page = new DividendesTrimestrielsPdf();
}
//else if ($p == "ConsultOpportunity")
//{
//	require_once "pageAdmin/ConsultOpportunity/controller.php";
//	$page = new ConsultOpportunity();
//}
else if ($p == "OrderGest")
{
    require_once "pageAdmin/OrderGest/controller.php";
    $page = new OrderGest();
}
else if ($p == "Ordres")
{
    require_once "pageAdmin/Ordres/controller.php";
    $page = new Ordres();
}
else if ($p == "ShowValeurOrdres")
{
    require_once "pageAdmin/ShowValeurOrdres/controller.php";
    $page = new ShowValeurOrdres();
}
else if ($p == "OpportunityViewer")
{
	require_once("pageAdmin/OpportunityView/controller.php");
	$page = new OpportunityView();
}
else if ($p == "MailResearch")
{
	require_once("pageAdmin/MailResearch/controller.php");
	$page = new MailResearch();
}
else if ($p == "Archi2Test" && !isProd())
{
	require_once("pageAdmin/Archi2Test/controller.php");
	$page = new Archi2Test();
}
else if ($p == "PageCreationProjet" && !isProd())
{
	require_once("pageAdmin/PageCreationProjet/controller.php");
	$page = new PageCreationProjet();
}
else if ($p == "TelechargerRecapGuidePdf")
{
	require_once("pageAdmin/TelechargerRecapGuidePdf/controller.php");
	$page = new TelechargerRecapGuidePdf();
}
else if ($p == "TransactViewer")
{
	require_once("pageAdmin/TransactViewer/controller.php");
	$page = new TransactViewer();
}
else if ($p == "GestTemplate") {
	require_once("pageAdmin/GestTemplate/controller.php");
	$page = new GestTemplate();
}
else if ($p == "Courriers") {
	require_once("pageAdmin/ShowCourriers/controller.php");
	$page = new ShowCourriers();
}
else if ($p == "UsersByScpi2") {
	require_once("pageAdmin/UsersByScpi2/controller.php");
	$page = new UsersByScpi2();
}


else if ($p == "SamyTest") {
    require_once("pageAdmin/SamyTest/controller.php");
    $page = new SamyTest();
}


else if ($p == "SimuPdf") {

    require_once ('pageAdmin/SimuPdf/controller.php');
    $page = new SimuPdf();
}

else if ($p == "SimulateurUsufruit") {

    require_once('pageAdmin/SimulateurUsufruit/controller.php');
    $page = new SimulateurUsufruit();
}

else if ($p == "StatInscription") {
    require_once("pageAdmin/StatInscription/controller.php");
    $page = new StatInscription();
}

//ROUTE_AUTOMATIQUE


else {
	require_once("pageAdmin/Connexion/controller.php");
	$page = new Connexion();
}


/*
else if ($p == "TestPage") {
	checkUser();
	redirectMonCompte();
	require_once("page/TestPage/controller.php");
	$page = new TestPage();
} else if ($p == "ActusPublications") {
	checkUser();
	redirectMonCompte();
	require_once("page/ActusPublications/controller.php");
	$page = new ActusPublications();
} else if ($p == "inscription") {
	$select = false;
	$token = NULL;
	if (!empty($_POST['getaccess'])){
		header('Location: .');
		exit();
	}
	if (!empty($_POST['helpme'])){
		addhelp();
		header('Location: .');
		exit();
	}
	if (!empty($_COOKIE['civil']) && ft_decrypt_crypt_information($_COOKIE['civil']) === "Madame"){
		$select = true;
	}
//			require_once("page/Thanks/controller.php");
//			$page = new Thanks();
	if (!empty(check_cookie(array("civil", "nom", "prenom", "num", "mail", "pass", "pass2", "fil")))){
		$res = infor_pers();
		if ($res == 0){
			del_all_cookie();
			require_once("page/Inscription/controller.php");
			$page = new Inscription();
		}
		else{
			info_obj();
			require_once("page/Obj/controller.php");
			$page = new Obj();
		}
	}
	else if (!empty(check_cookie(array("button2id")))){
		$res = info_obj();
		if ($res == -1){
			require_once("page/Inscription/controller.php");
			$page = new Inscription();
		}
		else{
			require_once("page/Obj/controller.php");
			$page = new Obj();
		}
	}
	else{
		if (!$res = send_info()){
			del_cookie(array("civil", "nom", "prenom", "num", "pass2", "fil", "button2id", "sms", "send", "checkboxes"));
			require_once("page/Thanks/controller.php");
			$page = new Thanks();
		}
		else{
			require_once("page/Inscription/controller.php");
			$page = new Inscription();
		}
	}
}


else if ($p == "Accueil") {
	checkUser();
	redirectMonCompte();
	require_once("page/Accueil/controller.php");
	$page = new Accueil();
} else if ($p == "MonPorteFeuille") {
	checkUser();
	require_once("page/MonPorteFeuille/controller.php");
	$page = new MonPorteFeuille();
}
else {
	require_once("page/Index/controller.php");
	$page = new Index();
}
*/


$page->render();
Notif::getAll();
//var_dump($_SESSION['csrf']);
//var_dump($_SESSION['csrf_time']);
