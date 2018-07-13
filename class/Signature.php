<?php
// 085eec60-75f7-31e7-86bc-7043947f7373
//include("path/to/xmlrpc.inc");
include("class/lib/phpxmlrpc-4.0.0/lib/xmlrpc.inc");
// code
// 73027 => non signe

/*
	phoneNum : format international
*/

class Signature
{
	private static				$_withSignature = true;	

	private static				$_login = LOGIN_UNIVERSIGN;
	private static				$_pass = PASS_UNIVERSIGN;
	private static				$_domain = DOMAIN_UNIVERSIGN;

	private function __construct() { }

	public static function getDocumentById($uni_id) {
		$uni_url = "https://" . self::$_login. ":" . self::$_pass . "@" . self::$_domain;

		//create the request
		$c = new xmlrpc_client($uni_url);
		$f = new xmlrpcmsg('requester.getDocuments', array(new xmlrpcval($uni_id, "string")));
		$r = $c->send($f);
		if (!$r->faultCode()) {
			return ($r->value()->me['array'][0]->me['struct']['content']->me['base64']);
		} else {
			return (false);
		}
	}
	public static function getInfoById($uni_id)
	{
		//used variables
		$uni_url = "https://" . self::$_login. ":" . self::$_pass . "@" . self::$_domain; // address of the universign server with basic authentication

		//create the request
		$c = new xmlrpc_client($uni_url);
		$f = new xmlrpcmsg('requester.getTransactionInfo', array(new xmlrpcval($uni_id, "string")));

		//Send request and analyse response
		$r = $c->send($f);
		if (!$r->faultCode()) {
			//if the request succeeded
//			$doc['name'] = $r->value()->arrayMem(0)->structMem('name')->scalarVal();

			$doc['status'] = $r->value()['status'][0];
			$doc['date_creation'] = DateTime::createFromFormat("Ymd\TH:i:s", $r->value()['creationDate'][0]);
			$doc['signerName'] = $r->value()['signerInfos'][0]->me['struct']['lastName']->me['string'];
			$doc['signerFirstName'] = $r->value()['signerInfos'][0]->me['struct']['firstName']->me['string'];
			$doc['url'] = $r->value()['signerInfos'][0]->me['struct']['url']->me['string'];
			//$doc['email'] = $r->value()['signerInfos'][0]->me['struct']['email']->me['string'];
			return($doc);
		} else {
			return (false);
		}
	}

	public static function createDocumentRec($signer, $doc, $returnPage, $contactSigner = false)
	{
		$uni_url = "https://" . self::$_login. ":" . self::$_pass . "@ws.universign.eu/sign/rpc/";
		$c = new xmlrpc_client($uni_url);
		$language = "fr";
		$signers = array(new xmlrpcval($signer, "struct"));
		$request = array(
			"documents" => new xmlrpcval(array(new xmlrpcval($doc, "struct")), "array"),
			"signers" => new xmlrpcval($signers, "array"),
			"certificateType" =>  new xmlrpcval("simple", "string"),
			"handwrittenSignatureMode" =>  new xmlrpcval(1, "int"),
			"language" => new xmlrpcval($language, "string"),
			"finalDocObserverSent" =>  new xmlrpcval(0, "boolean"),
			"finalDocRequesterSent" =>  new xmlrpcval(0, "boolean"),
			"mustContactFirstSigner" =>  new xmlrpcval(($contactSigner ? 1 : 0), "boolean"),
			"finalDocSent" => new xmlrpcval(0, "boolean"),
		);
		$dhType = Dh::getCurrent()->getType();
		//if ($dhType == null || $dhType == "client")
		if (isFrontOffice())
		{
			$request["successURL"] =  new xmlrpcval($returnPage["success"], "string");
			$request["failURL"] =  new xmlrpcval($returnPage["fail"], "string");
			$request["cancelURL"] =  new xmlrpcval($returnPage["cancel"], "string");
		}
		$f = new xmlrpcmsg('requester.requestTransaction', array(new xmlrpcval($request, "struct")));
		$r = $c->send($f);
		if (!$r->faultCode()) {
			$url = $r->value()->structMem('url')->scalarVal(); //you should redirect the signatory to this url
			$id = $r->value()->structMem('id')->scalarVal(); //you should store this id
			return (array(
				"url" =>$url,
				"id" => $id
			));
		} else {
			return (false);
		}
	}
	public static			function getNewSignatureRec($Pp, $pdf, $contactSigner = false)
	{
		$signatureField = array(
			"page" => new xmlrpcval(1, "int"),
			"x" => new xmlrpcval(330, "int"),
			"y" => new xmlrpcval(60, "int"),
			"signerIndex" => new xmlrpcval(0, "int")
		);

		$returnPage = array (
			"success" => getThisURL() . "&rt=ok", // Page de renseignement de situation.
			"fail" => getThisURL() . "&rt=ko", // Page de message d'erreur
			"cancel" => getThisURL()  . "&rt=cancel" // page tableea de bord ?
		);

		$signer = array(
			"firstname" => new xmlrpcval($Pp->getFirstName(), "string"),
			"lastname" => new xmlrpcval($Pp->getName(), "string"),
			"phoneNum"=> new xmlrpcval($Pp->getPhone(), "string"),
			"emailAddress"=> new xmlrpcval($Pp->getMail(), "string")
		);

		$doc = array(
			"content" => new xmlrpcval($pdf['data'], "base64"),
			"name" => new xmlrpcval($pdf['name'], "string"),
			"displayName" => new xmlrpcval($pdf['type_name'], "string"),
			"signatureFields" => new xmlrpcval(array(new xmlrpcval($signatureField, "struct")), "array")
		);
		return (self::createDocumentRec($signer, $doc, $returnPage, $contactSigner));
	}


	public static function createDocument($signer, $doc, $returnPage, $contactSigner = false)
	{
		$uni_url = "https://" . self::$_login. ":" . self::$_pass . "@ws.universign.eu/sign/rpc/";
		$c = new xmlrpc_client($uni_url);
		$language = "fr";
		$signers = array(new xmlrpcval($signer, "struct"));
		$request = array(
			"documents" => new xmlrpcval(array(new xmlrpcval($doc, "struct")), "array"),
			"signers" => new xmlrpcval($signers, "array"),
			"certificateType" =>  new xmlrpcval("simple", "string"),
			"handwrittenSignatureMode" =>  new xmlrpcval(1, "int"),
			"language" => new xmlrpcval($language, "string"),
			"finalDocObserverSent" =>  new xmlrpcval(0, "boolean"),
			"finalDocRequesterSent" =>  new xmlrpcval(0, "boolean"),
			"mustContactFirstSigner" =>  new xmlrpcval(($contactSigner ? 1 : 0), "boolean"),
			"finalDocSent" => new xmlrpcval(0, "boolean"),
		);
		$dhType = Dh::getCurrent()->getType();
		if ($dhType == null || $dhType == "client")
		{
			$request["successURL"] =  new xmlrpcval($returnPage["success"], "string");
			$request["failURL"] =  new xmlrpcval($returnPage["fail"], "string");
			$request["cancelURL"] =  new xmlrpcval($returnPage["cancel"], "string");
		}
		$f = new xmlrpcmsg('requester.requestTransaction', array(new xmlrpcval($request, "struct")));
		$r = $c->send($f);
		if (!$r->faultCode()) {
			$url = $r->value()->structMem('url')->scalarVal(); //you should redirect the signatory to this url
			$id = $r->value()->structMem('id')->scalarVal(); //you should store this id
			return (array(
				"url" =>$url,
				"id" => $id
			));
		} else {
			return (false);
		}
	}
	public static			function getNewSignature($Pp, $pdf, $contactSigner = false)
	{
		$signatureField = array(
			"page" => new xmlrpcval(1, "int"),
			"x" => new xmlrpcval(330, "int"),
			"y" => new xmlrpcval(60, "int"),
			"signerIndex" => new xmlrpcval(0, "int")
		);

		$returnPage = array (
			"success" => getThisURL() . "&rt=ok", // Page de renseignement de situation.
			"fail" => getThisURL() . "&rt=ko", // Page de message d'erreur
			"cancel" => getThisURL()  . "&rt=cancel" // page tableea de bord ?
		);

		$signer = array(
			"firstname" => new xmlrpcval($Pp->getFirstName(), "string"),
			"lastname" => new xmlrpcval($Pp->getName(), "string"),
			"phoneNum"=> new xmlrpcval($Pp->getPhone(), "string"),
			"emailAddress"=> new xmlrpcval($Pp->getMail(), "string")
		);

		$doc = array(
			"content" => new xmlrpcval($pdf['data'], "base64"),
			"name" => new xmlrpcval($pdf['name'], "string"),
			"displayName" => new xmlrpcval($pdf['type_name'], "string"),
			"signatureFields" => new xmlrpcval(array(new xmlrpcval($signatureField, "struct")), "array")
		);
		return (self::createDocument($signer, $doc, $returnPage, $contactSigner));
	}
}
