<?php
require_once("core/Database.php");
require_once("core/Table.php");
class CRM extends Table {
	protected static	$_name = "CRM";
	protected static	$_primary_key = "id";

	private static function cmptime($a, $b)
	{
		return ($a->getCrmDatef() < $b->getCrmDatef());
	}
	public static function getCrmFromDh($id) {
		$res = parent::getFromKeyValue("id_dh", $id);
		usort($res, array("CRM", "cmptime"));
		return ($res);
	}
	public static function setCrmForDh($id){
		$bdd = new PDO('mysql:host='. SERVERNAME . ';dbname=mscpi_db;charset=utf8', USERNAME, PASSWORD);
		$query = $bdd->prepare("INSERT INTO `CRM` (id_dh, date_r, MOC_R, action_r, lien_proj, commentaire_r, DATE_f, MOC_F, action_f, lien_proj_f, commentaire_f) 
											VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$_POST["date"] = strtotime($_POST["date"]);
		$_POST["date_r"] = strtotime($_POST["date_r"] . $_POST["heure"]);
		$query->execute(array($id, ($_POST['date']), intval($_POST['radios']), ft_crypt_information($_POST['action']), NULL, NULL, $_POST['date_r'], intval($_POST['MOC_F']), ft_crypt_information($_POST['action_r']), NULL, ft_crypt_information($_POST['commentaire_r'] ? $_POST['commentaire_r'] : "Rien") ));
	}
	public function getCrmDate() {
		if (!$this->date_r)
			return (0);
		return (htmlspecialchars(date("d/m/Y", $this->date_r)));
	}
	public static function set_finish_crm($id, $crm){
		if (empty($id) || empty($crm) || !is_numeric($id) || !is_numeric($crm))
			return (-1);
		$id = intval($id);
		$crm = intval($crm);
		$bdd = new PDO('mysql:host='. SERVERNAME . ';dbname=mscpi_db;charset=utf8', USERNAME, PASSWORD);
		$query = $bdd->prepare("UPDATE `CRM` SET `finish` = 1 WHERE `id` = ? AND `id_dh` = ?");
		$query->execute(array($crm, $id));
	}
	public function getCrmRadio() {
		return (htmlspecialchars($this->MOC_R));
	}
	public function getCrmAction() {
		return (htmlspecialchars(ft_decrypt_crypt_information($this->action_r)));
	}
	public function getCrmCommentaire() {
		if (!$this->commentaire_r && !empty($this->commentaire_f))
			return (htmlspecialchars(ft_decrypt_crypt_information($this->commentaire_f)));
		else if ($this->commentaire_r)
			return (htmlspecialchars(ft_decrypt_crypt_information($this->commentaire_r)));
		else
			return (htmlspecialchars("Rien"));
	}
	public function getCrmDatef() {
		return (htmlspecialchars(date("d/m/Y H:i", $this->DATE_f)));
	}
	public function getCrmRadiof() {
		return (htmlspecialchars($this->MOC_F));
	}
	public function getCrmActionf() {
		return (htmlspecialchars(ft_decrypt_crypt_information($this->action_r)));
	}
	public function getCrmCommentairef() {
		return (htmlspecialchars(ft_decrypt_crypt_information($this->commentaire_f)));
	}
}
?>
