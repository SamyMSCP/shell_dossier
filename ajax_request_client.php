<?php
function isBackOffice() { return (false); }; 
function isFrontOffice() { return (true); };
require_once("app.php");
//@session_start();

$curDh = Dh::getCurrent();
if (isset($_GET['req']) && $_GET['req'] == 'RestDocuments')
{
	$req = "RestDocuments";
}
else
{
	cleanTokenCsrf();
	if (check_csrf())
		error("Le jeton de sécurité n'est plus valide, merci de réessayer.");

	if (empty($_POST['req']) || empty($_POST['data']))

		error("La requete est mal formatée !");

	header('Content-Type: application/json');
	$req = $_POST['req'];
}

if ($req == "RestDocuments") {
	require_once("ajax_client/RestDocuments/controller.php");
	$page = new RestDocuments();
	exit();
}
else if ($req == "AjaxPp") {
	require_once("ajax_client/AjaxPp/controller.php");
	$page = new AjaxPp();
	exit();
}
else if ($req == "RestProject") {
	require_once("ajax_client/RestProject/controller.php");
	$page = new RestProject();
	exit();
}
else if ($req == "RestTransaction") {
	require_once("ajax_client/RestTransaction/controller.php");
	$page = new RestTransaction();
	exit();
}
else if ($req == "DhFrontStore") {
	require_once("ajax_client/DhFrontStore/controller.php");
	$page = new DhFrontStore();
	exit();
}
else if ($req == "AjaxContact") {
	require_once("ajax_client/AjaxContact//controller.php");
	$page = new AjaxContact();
	exit();
}
else if ($req == "OpportunitySet") {
	if (!Dh::getCurrent()->phoneOk())
		error("VOus n'avez pas accès à cette page.");
	require_once("ajax_client/AjaxOpportunity/controller.php");
	$page = new AjaxOpportunity();
	exit();
}
else if ($req == "CreationDeCompte") {
	require_once("ajax_client/AjaxCreateAccount/controller.php");
	$page = new AjaxCreateAccount();
	exit();
}
else if ($req == "Transaction") {
	require_once ("ajax_client/AjaxTransaction/controller.php");
	$page =  new AjaxTransaction();
	exit();
}

else if ($req == "TransactionFrontStore") {
	require_once ("ajax_client/AjaxTransactionFrontStore/controller.php");
	$page =  new AjaxTransactionFrontStore();
	exit();
}

http_response_code(400);
echo json_encode([]);
