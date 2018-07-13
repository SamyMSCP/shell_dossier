<?php
class TypeEnumInt extends Type {

	protected static $_errorMsg = "Cette donnée n'est pas valide";

	protected static $_sqlColumn = "int(11)";
	protected $_config = [];
	public function checkData() {
		if (isset($this->_config['notCheck'])  && $this->_config['notCheck'] === true )
			return (true);
		if (isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true && empty($this->getRawValue()))
			return (true);
		$val = $this->get();
		if (in_array($val, $this->_config['datas']))
				return (parent::checkData());
		return (false);
	}

	protected static function beforeSet($val) {
		return (intval($val));
	}

	public static function normalize($val, $config) {
		if ($val === null)
			return (null);
		return (intval($val));
	}


	public function getShowComponent() {
		return ("ComponentTypeEnumSelectShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeEnumSelectEdit");
	}

}
