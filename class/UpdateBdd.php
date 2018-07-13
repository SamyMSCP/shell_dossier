<?php
require_once("core/Database.php");
require_once("core/Table.php");
class UpdateBdd extends Table
{
	protected static		$_name = "update_bdd";
	protected static		$_primary_key = "id";

	public function __construct() {
	}
	public static function checkExist($name) {
		return (!empty(parent::getFromKeyValue("filename", $name)));
	}
	public static function updateBdd($path) {
		$arraytmp = [];
		$files = scandir($path);
		foreach ($files as $key => $elm) {
			$ext = pathinfo($elm);
			if (self::checkExist($elm) || ($ext['extension'] != "sql" && $ext['extension'] != "php"))
				continue ;
			$arraytmp[] = $elm;
		}
		if (empty($arraytmp))
		{
			echo "Tout est à jours, rien à installer !\n";
			return ;
		}
		echo "\nVoici la liste des mises a jours non installée :\n";
		foreach ($arraytmp as $key => $elm)
			echo "\t- " . $elm . "\n";
		$rt = "";
		echo "\n";
		while ($rt != "oui" && $rt != "non")
			$rt = readStdIn("Etes vous sur de vouloir les installer ??  [oui, non] : ");
		if ($rt == "non")
			return ;
		echo "\n";
		foreach ($arraytmp as $key => $updateFile)
		{
			$content = file_get_contents($path . $updateFile);
			try {
				$ext = pathinfo($updateFile);
				if ($ext['extension'] == "sql")
					Database::exec("mscpi_db", $content);
				else if ($ext['extension'] == "php")
					include($path . $updateFile);
				$req = "INSERT INTO `update_bdd` (filename, content) VALUES('$updateFile', ?)";
				echo "\033[32m$updateFile\033[0m a bien été installé\n";
				Database::prepareNoClass(static::$_db, $req, [$content]);
			} catch (Exception $e) {
				echo "\033[31mLe script : $updateFile n'a pas pu etre installé, la mise a jours est stoppée\n\033[0m";
				echo "\t" . $e->getMessage() . "\n\n";
				exit();
			}
		}
		echo "\n";
	}
}
