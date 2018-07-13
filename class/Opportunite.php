<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("core/DocumentTrait.php");
require_once("Dh.php");

class Opportunite extends Table
{
	protected static		$_name = "OPPORTUNITE";
	protected static		$_primary_key = "id";
	protected static		$_instance = NULL;

	private static function SetAllIsonlyToNull(){
		Database::prepareNoClass(static::$_db, 'UPDATE OPPORTUNITE set isonline = 0', array());
	}
	public static function insert($pictotitle, $thetitle, $title, $left_val, $right_val, $left_msg, $right_msg, $content, $url, $isonline, $image, $type) {
		if ($isonline)
			Self::SetAllIsonlyToNull();
		$req = "INSERT INTO `OPPORTUNITE`
			(titlepicto, thetitle, title, left_val, right_val, left_msg, right_msg, content, url, isonline, image, type)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$data = array(
			$pictotitle,
			$title,
			$thetitle,
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
		$req = "UPDATE `OPPORTUNITE` SET image = ?, type = ? where id = " . intval($id);
		$data = array($image, $type);
		return (Database::prepareNoClass(static::$_db, $req, $data));
	}
	public static function updateFromId($id, $pictotitle, $thetitle, $title, $left_val, $right_val, $left_msg, $right_msg, $content, $url, $isonline) {
		if ($isonline)
			Self::SetAllIsonlyToNull();
		$req = "UPDATE `OPPORTUNITE` 
			SET title = ? ,
			titlepicto = ?,
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
			$pictotitle,
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
	public static function getOpportunite(){
		if (Self::$_instance === NULL)
		{
			Self::$_instance = parent::getFromKeyValue("isonline", "1");
			if (count(Self::$_instance))
				Self::$_instance = Self::$_instance[0];
		}
		return (Self::$_instance);
	}
	public function getId(){
		return ($this->id);
	}
	public function getTitlePicto(){
		return ($this->titlepicto);
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
	}
	public function getRight_msg(){
		return ($this->right_msg);
	}
	public function getContent(){
		return ($this->content);
	}
	public function getUrl(){
		return ($this->url);
	}
	public function getImage($w = 1, $h = 1){
		if ($w < 1 || $h < 1 || empty($this->type) || empty($this->image))
			return ("Aucune image trouver.");
		if ($w == 1)
			return ('<img id="sizeImageLeft" style="width: 100%;" src="data:image/'.$this->type.';base64,'.base64_encode(ft_decode_file($this->image)).'" />');
		return ('<img style="width: '.$w.'; heigth: '.$h.'"; src="data:image/'.$this->type.';base64,'.base64_encode(ft_decode_file($this->image)).'" />');
	}
	public function getImageData(){
		return ('data:image/'.$this->type.';base64,'.base64_encode(ft_decode_file($this->image)));
	}
	public function getIsonline(){
		return ($this->isonline);
	}
}
