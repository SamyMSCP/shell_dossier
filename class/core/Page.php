<?php
class Page
{
	public static	$template_path = "class/template/";
	public static	$page_path = "page/";
	public $header = "";
	public $style = "";
	public $body = "";
	public $template = "default";
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
		$this->style .= ob_get_contents();
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
	public function getStyle() {
		$filename = "../cache/style/" . get_called_class() . ".css";
		//$rt = file_get_contents($filename);
		//return ($rt);
		$pi_dir = pathinfo($filename)['dirname'];
		if (!is_dir($pi_dir))
			@mkdir($pi_dir, 0777, true);

		if (ENABLE_CSS_PREFIX_CACHE)
		{
			$rt = file_get_contents($filename);
			if (empty($rt))
			{
				$rt = ($GLOBALS['autoprefixer']->compile($this->style));
				file_put_contents($filename, $rt);
			}
		}
		else
		{
			$rt = ($GLOBALS['autoprefixer']->compile($this->style));
			file_put_contents($filename, $rt);
		}
		return ($rt);
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
	public function getPath() {
		return ( self::$page_path . get_called_class() .  "/");
	}
}
