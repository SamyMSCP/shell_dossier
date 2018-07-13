<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("core/DocumentTrait.php");
require_once("Dh.php");

class Suggestion extends Table
{
	protected static		$_name = "SUGGESTION";
	protected static		$_primary_key = "id";
	protected static		$_instance = NULL;

	private static function SetAllIsonlyToNull(){
		Database::prepareNoClass(static::$_db, 'UPDATE SUGGESTION set isonline = 0', array());
	}
	public static function insert($pictotitle, $thetitle, $title, $left_val, $right_val, $left_msg, $right_msg, $content, $url, $isonline, $image, $type) {
		if ($isonline)
			self::SetAllIsonlyToNull();
		$req = "INSERT INTO `SUGGESTION`
			(pictoTitle, thetitle, title, left_val, right_val, left_msg, right_msg, content, url, isonline, image, type)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$data = array(
			$pictotitle,
			$thetitle,
			$title,
			$left_val,
			$right_val,
			$left_msg,
			$right_msg,
			$content,
			$url,
			intval($isonline),
			$image,
			$type
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function updateFromIdImage($id, $image, $type) {
		$req = "UPDATE `SUGGESTION` SET image = ?, type = ? where id = " . intval($id);
		$data = array($image, $type);
		return (Database::prepareNoClass(static::$_db, $req, $data));
	}
	public static function updateFromId($id, $titlepicto, $thetitle, $title, $left_val, $right_val, $left_msg, $right_msg, $content, $url, $isonline) {
		if ($isonline)
			self::SetAllIsonlyToNull();
		$req = "UPDATE `SUGGESTION` 
			SET title = ?,
			pictoTitle = ?,
			thetitle = ?,
			left_val = ?,
			right_val = ?,
			left_msg = ?,
			right_msg = ?,
			content = ?,
			url = ?,
			isonline = ?
			WHERE id = " . intval($id);
		$data = array(
			$title,
			$titlepicto,
			$thetitle,
			$left_val,
			$right_val,
			$left_msg,
			$right_msg,
			$content,
			$url,
			intval($isonline)
		);
		return Database::prepareNoClass(static::$_db, $req, $data);
	}
	public static function getSuggestion(){
		if (self::$_instance === NULL)
		{
			self::$_instance = parent::getFromKeyValue("isonline", "1");
			if (count(self::$_instance))
				self::$_instance = self::$_instance[0];
		}
		return (self::$_instance);
	}
	public function getId(){
		return ($this->id);
	}
	public function getTheTitle(){
		return ($this->thetitle);
	}
	public function getTitle(){
		return ($this->title);
	}
	public function getLeft_val(){
		return ($this->left_val);
	}
	public function getRight_val(){
		return ($this->right_val);
	}
	public function getLeft_msg(){
		return ($this->left_msg);
		$this->tab[] = "Diversifiée";
		$this->tab[] = "Murs de magasin";
		$this->tab[] = "Régionale";
		$this->tab[] = "Malraux";
		$this->tab[] = "Déficit Foncier";
		$this->tab[] = "Scellier";
		$this->tab[] = "Duflot";
		$this->tab[] = "Commerces";
		$this->tab[] = "Specialisées";
		$this->tab[] = "Pinel";
		$this->tab[] = "Bureaux";
		$this->tab[] = "Rénovation";
		return ($this->tab[$this->left_msg]);
	}
	public function getRight_msg(){
		return ($this->right_msg);
	}
	public function getContent(){
		return ($this->content);
	}
	public function getTitlePicto(){
		return ($this->pictoTitle);
	}
	public function getUrl(){
		return ($this->url);
	}
	public function getIsonline(){
		return ($this->isonline);
	}
	public function getImage($w = 1, $h = 1){
		if ($w < 1 || $h < 1 || empty($this->type) || empty($this->image))
			return ("Aucune image trouver.");
		if ($w == 1)
			return ('<img id="sizeImageRight" src="data:image/'.$this->type.';base64,'.base64_encode(ft_decode_file($this->image)).'" /><script>
(function() {
			document.getElementById("sizeImageRight").style.width = document.getElementById("sizeImageLeft").offsetWidth + "px"
			})();
			</script>');
		return ('<img style="width: '.$w.'; heigth: '.$h.'"; src="data:image/'.$this->type.';base64,'.base64_encode(ft_decode_file($this->image)).'" />');
	}
	public function getImageData(){
			return ('data:image/'.$this->type.';base64,'.base64_encode(ft_decode_file($this->image)));
	}
}
