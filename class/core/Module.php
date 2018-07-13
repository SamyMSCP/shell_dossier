<?php
class Module
{
	public static	$module_path = "module/";
	public $header = "";
	public $style = "";
	public $body = "";
	public $scriptHead = "";
	public $scriptBody = "";
	public function __construct($data) {
		foreach($data as $key => $value) {
			$this->$key = $value;
		}
		include( self::$module_path . get_called_class() .  "/model.php");

		ob_start();
		include( self::$module_path . get_called_class() .  "/style.css");
		$this->style .= ob_get_contents();
		ob_end_clean();


		if (file_exists(self::$module_path . get_called_class() .  "/style.scss.css"))
		{
			ob_start();
			include( self::$module_path . get_called_class() .  "/style.scss.css");
			$this->style .= ob_get_contents();
			ob_end_clean();
		}

		ob_start();
		include( self::$module_path . get_called_class() .  "/scriptHead.php");
		$this->scriptHead .= ob_get_contents();
		ob_end_clean();

		ob_start();
		include( self::$module_path . get_called_class() .  "/scriptBody.php");
		$this->scriptBody .= ob_get_contents();
		ob_end_clean();

		ob_start();
		include( self::$module_path . get_called_class() .  "/body.php");
		$this->body .= ob_get_contents();
		ob_end_clean();

		ob_start();
		include( self::$module_path . get_called_class() .  "/header.php");
		$this->header .= ob_get_contents();
		ob_end_clean();

	}
	public function __toString() {
		return ($this->body);
	}
	public function getPath() {
		return ( self::$module_path . get_called_class() .  "/");
	}
	public function loadModule($name, $module_name, $data = [null]) {
		require_once("module/" . $module_name . "/controller.php");
		$this->$name = new $module_name($data);
		$this->scriptBody .= $this->$name->scriptBody;
		$this->scriptHead .= $this->$name->scriptHead;
		$this->header .= $this->$name->header;
		$this->style .= $this->$name->style;
	}
}
