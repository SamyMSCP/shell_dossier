<?php
function isBackOffice() { return (true); };
function isFrontOffice() { return (false); };
require_once("app.php");
//@session_start();


// BUG: /!\ TOKEN CSRF IS DISACTIVATED /!\
cleanTokenCsrf();
if (check_csrf())
	error("Le jeton de sécurité n'est plus valide, merci de réessayer.");
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
		$curDh->getType() != "prospecteur" &&
		$curDh->getType() != "chefprojet"
	)
)
{
	exit();
}


// ??? TODO : Faire une la vérification que c'est bien un utilisateur de type collaborateur qui est connecté.
// ??? TODO : Déplacer les requetes pour le front client dans le nouveau fichier !



if (!isset($_POST['req']) || !isset($_POST['data']))
	error("La requete est mal formatée !");


header('Content-Type: application/json');
$req = $_POST['req'];

if ($req == "Crm")
{
	require_once("ajax/AjaxCrm/controller.php");
	$page = new AjaxCrm();
	exit();
}
else if ($req == "UserFinder")
{
	require_once("ajax/UserFinder/controller.php");
	$page = new UserFinder();
	exit();
}
else if ($req == "DelaiJouissance")
{
	require_once("ajax/AjaxDelaiJouissance/controller.php");
	$page = new AjaxDelaiJouissance();
	exit();
}
else if ($req == "ValeurRealisation")
{
	require_once("ajax/UpdateValeurRealisation/controller.php");
	$page = new UpdateValeurRealisation();
	exit();
}
else if ($req == "updatePp")
{
	require_once("ajax/UpdatePp/controller.php");
	$page = new UpdatePp();
	exit();
}
else if ($req == "AjaxDocument")
{
	require_once("ajax/AjaxDocument/controller.php");
	$page = new AjaxDocument();
	exit();
}
else if ($req == "RestTransaction")
{
	require_once("ajax/RestTransaction/controller.php");
	$page = new RestTransaction();
	exit();
}
else if ($req == "RestProject")
{
	require_once("ajax/RestProject/controller.php");
	$page = new RestProject();
	exit();
}
else if ($req == "AjaxObjList")
{
	require_once("ajax/AjaxObjList/controller.php");
	$page = new AjaxObjList();
}
else if ($req == "RestSituation")
{
	require_once("ajax/RestSituation/controller.php");
	$page = new RestSituation();
	exit();
}
else if ($req == "CentreInteretStore")
{
	require_once("ajax/CentreInteretStore/controller.php");
	$page = new CentreInteretStore();
	exit();
}
else if ($req == "MailSender")
{
	require_once("ajax/AjaxMailSender/controller.php");
	$page = new AjaxMailSender();
	exit();
}
else if ($req == "Beneficiaire")
{
	require_once("ajax/AjaxBeneficiaire/controller.php");
	$page = new AjaxBeneficiaire();
}
else if ($req == "OpportunitySet")
{
	require_once("ajax/AjaxOpportunity/controller.php");
	$page = new AjaxOpportunity();
	exit();
}
else if ($req == "AjaxDhAdmin")
{
	require_once("ajax/AjaxDhAdmin/controller.php");
	$page = new AjaxDhAdmin();
	exit();
}
else if ($req == "OrderSet")
{
    require_once("ajax/AjaxOrder/controller.php");
    $page = new AjaxOrder();
    exit();
}
else if ($req == "AdvancedSearch") {
	require_once("ajax/AdvancedSearch/controller.php");
	$page = new AdvancedSearch();
	exit();
}
else if ($req == "ajaxTransaction") {
	require_once ("ajax/AjaxTransaction/controller.php");
	$page = new AjaxTransaction();
	exit();
}
else if ($req == "SendMail") {
	require_once("ajax/MailSend/controller.php");
	$page = new MailSend();
	exit();
}
else if ($req == "EventListener") {
	require_once("ajax/AjaxEventListener/controller.php");
	$page = new AjaxEventListener();
	exit();
}
else if ($req == "AjaxTemplate") {
	require_once("ajax/AjaxTemplate/controller.php");
	$page = new AjaxTemplate();
	exit();
}
else if ($req == "AddBeneficiaireSeul"){
	require_once("ajax/AddBeneficiaireSeul/controller.php");
	$page = new AddBeneficiaireSeul();
	exit();
}

http_response_code(404);
echo json_encode([]);
