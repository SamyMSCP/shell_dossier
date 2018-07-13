<?php
function isBackOffice() { return (false); }; 
function isFrontOffice() { return (true); };
require_once("app.php");

setOrigine();
// function verifiant si un token est valide
cleanTokenCsrf();


$p = (!empty($_GET["p"]))? $_GET["p"] : "Index";

// Si il y a des donnees en post, alors on chck si il y a un token csrf de valide.
if (!empty($_POST) && check_csrf())
{
	header("Location: ?p=" . $p);
	exit();
}

if (
	$p != "SetFavorite" &&
	$p != "SetReadDoc" &&
	$p != "GetCodeVille" &&
	$p != "DownloadDocument" &&
	$p != 'ShowValeurIsf' &&
	$p != 'ShowValeurIfi'
)

generateTokenCsrf();

if (onIE() && $p != "Index")
{
	header("Location: index.php");
	exit();
}

$times["BEFORE_PAGE"] = microtime(true);

if ($p == "CreationCompte") {
	require_once("page/CreationCompte/controller.php");
	$page = new CreationCompte();
}
else if ($p == "TableauDeBord") {
//	checkUser();
//	redirectMonCompte();
//	require_once("page/TableauDeBord/controller.php");
//	$page = new TableauDeBord();
	checkUser();
	redirectMonCompte();
	require_once("page/DashboardV2/controller.php");
	$page = new DashboardV2();
}
else if ($p == "Portefeuille") {
	checkUser();
	require_once("page/Portefeuille1_5/controller.php");
	$page = new Portefeuille1_5();
}
else if ($p == "Actu") {
	checkUser();
	redirectMonCompte();
	require_once("page/Actu/controller.php");
	$page = new Actu();
}
else if ($p == "Bibliotheque") {
	checkUser();
	require_once("page/Bibliotheque/controller.php");
	$page = new Bibliotheque();
}
else if ($p == "DownloadDocument") {
	checkUser();
	require_once("page/DownloadDocument/controller.php");
	$page = new DownloadDocument();
}
else if ($p == "SetFavorite") {
	checkUser();
	redirectMonCompte();
	require_once("page/SetFavorite/controller.php");
	$page = new SetFavorite();
}
else if ($p == "SetReadDoc") {
	checkUser();
	require_once("page/SetReadDoc/controller.php");
	$page = new SetReadDoc();
}
else if ($p == "GetCodeVille") {
	checkUser();
	require_once("page/GetCodeVille/controller.php");
	$page = new GetCodeVille();
}

else if ($p == "CreationProjet" && !isProd()) {
	checkUser();
//	redirectMonCompte();
	require_once("page/CreationProjet/controller.php");
	$page = new CreationProjet();
}
else if ($p == "CreationProjet2" && !isProd()) {
	checkUser();
//	redirectMonCompte();
	require_once("page/CreationProjet2/controller.php");
	$page = new CreationProjet2();
}
else if ($p == "ListeProjets" && !isProd()) {
	checkUser();
	require_once("page/ListeProjets/controller.php");
	$page = new ListeProjets();
}
else if ($p == "InfoProjet" && !isProd()) {
	checkUser();
	require_once("page/InfoProjet/controller.php");
	$page = new InfoProjet();
}
else if ($p == "ShowValeurIfi" && ENABLE_VALEUR_ISF)
{
	checkUser();
	require_once("page/ShowValeurIfi/controller.php");
	$page = new ShowValeurIfi();
}
else if ($p == "ShowValeurIsf" && ENABLE_VALEUR_ISF)
{
	checkUser();
	require_once("page/ShowValeurIsf/controller.php");
	$page = new ShowValeurIsf();
}
else if ($p == "ShowPatrimoine")
{
	checkUser();
	require_once("page/ShowPatrimoine/controller.php");
	$page = new ShowPatrimoine();
}
else if ($p == "Opportunity") {
	checkUser();
	if (!Dh::getCurrent()->phoneOk()) {
		header('Location: index.php');
		exit();
	}
	require_once("page/PageOpportunite/controller.php");
	$page = new PageOpportunite();
}
/*
else if ($p == "Opportunite") {
	require_once("page/PageOpportunite/controller.php");
	$page = new PageOpportunite();
}
else if ($p == "Opportunity") {
	require_once("page/PageOpportunity/controller.php");
	$page = new PageOpportunity();
}
*/
else if ($p == "ResetProfil")
{
	checkUser();
	require_once("page/ResetProfil/controller.php");
	$page = new ResetProfil();
}
else if ($p == "Repartitions")
{
	if (!isset($_GET['gdh']))
		checkUser();
	require_once("page/Repartitions/controller.php");
	$page = new Repartitions();
}
else if ($p == "SignatureRec" && !isProd())
{
	require_once("page/SignatureRec/controller.php");
	$page = new SignatureRec();
}
else if ($p == "LandingLinxo") {
	require_once ('page/LandingLinxo/controller.php');
	$page = new LandingLinxo();
}
else if ($p == "LandingF" || $p == "LandingT" || $p == "LandingL") {
	//Landing Social Network
	require_once ('page/LandingRS/controller.php');
	$page = new LandingRS();
}
else if ($p == "SuivreSesScpi") {
	//Landing Suivre Ses Scpi
	require_once ('page/LandingSuivre/controller.php');
	$page = new LandingSuivre();
}

else if ($p == "SimuPdf") {

    require_once ('page/SimuPdf/controller.php');
    $page = new SimuPdf();
}

else if ($p == "SimulateurUsufruit") {

    require_once('page/SimulateurUsufruit/controller.php');
    $page = new SimulateurUsufruit();
}

/*
else if ($p == "Test")
{
	require_once("page/Test/controller.php");
	$page = new Test();
}
*/
else if ($p == "Index")
{
	require_once("page/Index2/controller.php");
	$page = new Index2();
}

else if ($p == "test") {
    require_once("page/test/controller.php");
    $page = new test();}  else if ($p == "ttt") {      require_once("page/ttt/controller.php");	 $page = new ttt();}  //\x0A_AUTOMATIQUE
else
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	exit();
}

$page->render();
Notif::getAll();
