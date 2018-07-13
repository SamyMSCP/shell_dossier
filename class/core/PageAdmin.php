<?php

class PageAdmin
{
	public static	$template_path = "class/template/";
	public static	$page_path = "pageAdmin/";
	public $header = "";
	public $style = "";
	public $body = "";
	public $template = "defaultAdmin";
	public $modules = Array();
	public $title = "Titre";
	public $scriptHead = "";
	public $scriptBody = "";
	public function __construct() {

		include( self::$page_path . get_called_class() .  "/model.php");

		ob_start();
		include( self::$page_path . get_called_class() .  "/scriptHead.php");
		$this->scriptHead .= ob_get_contents();
		ob_end_clean();

		ob_start();
		include( self::$page_path . get_called_class() .  "/scriptBody.php");
		$this->scriptBody .= ob_get_contents();
		ob_end_clean();

		ob_start();
		include( self::$page_path . get_called_class() .  "/style.css");
		$this->style = ob_get_contents() . $this->style;
		ob_end_clean();

		if (file_exists(self::$page_path . get_called_class() .  "/style.scss.css"))
		{
			ob_start();
			include( self::$page_path . get_called_class() .  "/style.scss.css");
			$this->style .= ob_get_contents();
			ob_end_clean();
		}

		ob_start();
		include( self::$page_path . get_called_class() .  "/body.php");
		$this->body .= ob_get_contents();
		ob_end_clean();

		ob_start();
		include( self::$page_path . get_called_class() .  "/header.php");
		$this->header .= ob_get_contents();
		ob_end_clean();
	}
	public function render() {

		$page = $this;
		include(self::$template_path . $this->template . ".php");
	}
	public function loadModule($name, $module_name, $data = [null]) {
		require_once("module/" . $module_name . "/controller.php");
		$this->$name = new $module_name($data);
		$this->scriptBody .= $this->$name->scriptBody;
		$this->scriptHead .= $this->$name->scriptHead;
		$this->header .= $this->$name->header;
		$this->style .= $this->$name->style;
	}
	public function loadModuleAdmin($name, $module_name, $data = [null]) {
		require_once("moduleAdmin/" . $module_name . "/controller.php");
		$this->$name = new $module_name($data);
		$this->scriptBody .= $this->$name->scriptBody;
		$this->scriptHead .= $this->$name->scriptHead;
		$this->header .= $this->$name->header;
		$this->style .= $this->$name->style;
	}
	public function getPath() {
		return ( self::$page_path . get_called_class() .  "/");
	}
}
