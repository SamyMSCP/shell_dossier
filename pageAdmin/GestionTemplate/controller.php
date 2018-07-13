<?php
require_once("class/core/PageAdmin.php");
class GestionTemplate  extends PageAdmin
{
	public $title = "Gestion des template";
	public function saveTemplate() {


//		if (!isset($_POST['id']))
//			Notif::set("setTemplate", "id");
//		else if (!isset($_POST['name']))
//			Notif::set("setTemplate", "name");
//		else if (!isset($_POST['classname']))
//			Notif::set("setTemplate", "classe");
//		else if (!isset($_POST['content']))
//			Notif::set("setTemplate", "content");
//		else if (!isset($_POST['onclientpage']))
//			Notif::set("setTemplate", "onclientpage");


		if (
			!isset($_POST['id']) ||
			!isset($_POST['name']) ||
			!isset($_POST['classname']) ||
			!isset($_POST['content']) ||
			!isset($_POST['onclientpage'])
		)
		{
			Notif::set("saveTemplate", "Le nouveau template n'a pas pu etre ajouté");
			return ;
		}
		$id = intval($_POST['id']);
		$name = htmlspecialchars(trim($_POST['name']));
		$classname = htmlspecialchars(trim($_POST['classname']));
		$onclientpage = htmlspecialchars(trim($_POST['onclientpage']));
		$content = $_POST['content'];

		if ($id == 0)
		{
			$rt = CommunicationTemplate::insertNew(
				$name,
				$content,
				$classname,
				$onclientpage
			);
			if (empty($rt))
			{
				Notif::set("saveTemplate", "Le nouveau template n'a pas pu etre ajouté");
				return ;
			}
			Notif::set("saveTemplate", "Le nouveau template a bien été ajouté");
			return ;
		}
		else
		{
			$temp = CommunicationTemplate::getFromId($id);
			if (empty($temp))
			{
				Notif::set("saveTemplate", "Le nouveau template n'a pas pu etre ajouté");
				return ;
			}
			$temp = $temp[0];
			$temp->updateOneColumnCheckSecurity("name", $name);
			$temp->updateOneColumnCheckSecurity("content", $content);
			$temp->updateOneColumnCheckSecurity("classname", $classname);
			$temp->updateOneColumnCheckSecurity("on_clientpage", $onclientpage);
			Notif::set("saveTemplate", "Le template a bien été mis a jours");
			return ;
		}
	}
}
